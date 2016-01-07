<?php

function createRepositories($repositoryName, $model, $tableName, $columns)
{
    $columnFilters = "";
    $columnsInEntity = [];
    $columnsWithPlaceHolders = [];
    $columnsToMapForUpdate = [];
    $columnsToMapForInsert = [];
    $columnNamesCommaSeparated = "";
    $onlyPlaceHolders = "";
    foreach ($columns as $column) {
        $columnCapitalized = ucfirst($column);
        if ($column != 'id') {
            $columnsInEntity[] = '$entityInfo[\''.$column.'\']';
            $columnNamesCommaSeparated .= $column . ",";
            $columnsToMapForInsert[] = "':" . $column . "' => " . '$model->get' . $columnCapitalized . '()';
            $columnsWithPlaceHolders[] = $column . "= :$column";
            $onlyPlaceHolders .= ":$column, ";
        }
        $columnsToMapForUpdate[] = "':" . $column . "' => " . '$model->get' . $columnCapitalized . '()';
        $columnFilters .= <<<KUF
    /**
     * @param \$$column
     * @return \$this
     */
    public function filterBy$columnCapitalized(\$$column)
    {
        \$this->where .= " AND $column = ?";
        \$this->placeholders[] = \$$column;
        return \$this;
    }
KUF;
    }
    $columnsInEntity[] = '$entityInfo[\'id\']';
    $columnsImploded = trim($columnNamesCommaSeparated, ",");
    $columnEntityText = implode(",\n", $columnsInEntity);
    $columnsWithPlaceHoldersText = implode(", ", $columnsWithPlaceHolders);
    $columnsUpdate = implode(",\n", $columnsToMapForUpdate);
    $columnsInsert = implode(",\n", $columnsToMapForInsert);
    $onlyPlaceHolders = trim($onlyPlaceHolders, ", ");
    $repositoryFileName = fopen('Repositories/' . $repositoryName . '.php', 'w');
    $content = "";
    $content .= "<?php\n";
    $content .= "namespace Repositories;\n";
    $content .= "\n";
    $content .= "use Core\\Database;\n";
    $content .= "use Models\\$model;\n";
    $content .= "use Collections\\$model" . "Collection" . ";\n\n";
    $content .= "class $repositoryName\n";
    $content .= "{\n";
    $content .= <<<KUF
    private \$query;
    private \$where = " WHERE 1";
    private \$placeholders = [];
    private \$order = '';
    private static \$selectedObjectPool = [];
    private static \$insertObjectPool = [];
    /**
     * @var $repositoryName
     */
    private static \$inst = null;
    private function __construct() { }
    /**
     * @return $repositoryName
     */
    public static function create()
    {
        if (self::\$inst == null) {
        }
        self::\$inst = new self();
        return self::\$inst;
    }

    /**
     * @param \$columnName
     * @param \$value
     * @return \$this
     */
    public function andGet(\$columnName,\$value)
    {
        if(strpos(\$this->where,"AND \$columnName =")){
            \$this->where .= " OR \$columnName = ?";
            \$this->placeholders[] = \$value;
            return \$this;
        }else{
            \$this->where .= " AND \$columnName = ?";
            \$this->placeholders[] = \$value;
            return \$this;
        }

    }
$columnFilters
    /**
     * @param \$column
     * @return \$this
     * @throws \Exception
     */
    public function orderBy(\$column)
    {
        if (!\$this->isColumnAllowed(\$column)) {
            throw new \Exception("Column not found");
        }
        if (!empty(\$this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }
        \$this->order .= " ORDER BY \$column";
        return \$this;
    }
    /**
     * @param \$column
     * @return \$this
     * @throws \Exception
     */
    public function orderByDescending(\$column)
    {
        if (!\$this->isColumnAllowed(\$column)) {
            throw new \Exception("Column not found");
        }
        if (!empty(\$this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }
        \$this->order .= " ORDER BY \$column DESC";
        return \$this;
    }
    /**
     * @param \$column
     * @return \$this
     * @throws \Exception
     */
    public function thenBy(\$column)
    {
        if (empty(\$this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }
        if (!\$this->isColumnAllowed(\$column)) {
            throw new \Exception("Column not found");
        }
        \$this->order .= ", \$column ASC";
        return \$this;
    }
    /**
     * @param \$column
     * @return \$this
     * @throws \Exception
     */
    public function thenByDescending(\$column)
    {
        if (empty(\$this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }
        if (!\$this->isColumnAllowed(\$column)) {
            throw new \Exception("Column not found");
        }
        \$this->order .= ", \$column DESC";
        return \$this;
    }
    /**
     * @return {$model}Collection
     * @throws \Exception
     */
    public function findAll()
    {
        \$db = Database::getInstance('app');
        \$this->query = "SELECT * FROM $tableName" . \$this->where . \$this->order;
        \$result = \$db->prepare(\$this->query);
        \$result->execute(\$this->placeholders);
        \$collection = [];
        foreach (\$result->fetchAll() as \$entityInfo) {
            \$entity = new $model($columnEntityText);
            \$collection[] = \$entity;
            self::\$selectedObjectPool[] = \$entity;
        }
        return new {$model}Collection(\$collection);
    }
    /**
     * @return $model
     * @throws \Exception
     */
    public function findOne()
    {
        \$db = Database::getInstance('app');
        \$this->query = "SELECT * FROM $tableName" . \$this->where . \$this->order . " LIMIT 1";
        \$result = \$db->prepare(\$this->query);
        \$result->execute(\$this->placeholders);
        \$entityInfo = \$result->fetch();
        \$entity = new $model($columnEntityText);
        self::\$selectedObjectPool[] = \$entity;
        return \$entity;
    }
    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        \$db = Database::getInstance('app');
        \$this->query = "DELETE FROM $tableName" . \$this->where;
        \$result = \$db->prepare(\$this->query);
        \$result->execute(\$this->placeholders);
        return \$result->rowCount() > 0;
    }
    public static function add($model \$model)
    {
        if (\$model->getId()) {
            throw new \Exception('This entity is not new');
        }
        self::\$insertObjectPool[] = \$model;
    }
    public static function save()
    {
        foreach (self::\$selectedObjectPool as \$entity) {
            self::update(\$entity);
        }
        foreach (self::\$insertObjectPool as \$entity) {
            self::insert(\$entity);
        }
        return true;
    }
    private static function update($model \$model)
    {
        \$db = Database::getInstance('app');
        \$query = "UPDATE $tableName SET $columnsWithPlaceHoldersText WHERE id = :id";
        \$result = \$db->prepare(\$query);
        \$result->execute(
            [
                $columnsUpdate
            ]
        );
    }
    private static function insert($model \$model)
    {
        \$db = Database::getInstance('app');
        \$query = "INSERT INTO $tableName ($columnsImploded) VALUES ($onlyPlaceHolders);";
        \$result = \$db->prepare(\$query);
        \$result->execute(
            [
                $columnsInsert
            ]
        );
        \$model->setId(\$db->lastId());
    }
    private function isColumnAllowed(\$column)
    {
        \$refc = new \ReflectionClass('\Models\\$model');
        \$consts = \$refc->getConstants();
        return in_array(\$column, \$consts);
    }

    /**
     * @return {$model}Collection
     * @throws \Exception
     */
    public function pagination(\$pageNum,\$count){

        \$param1 = (int)\$pageNum;
        \$param2 = (int)\$count;

        \$this->placeholders[] = \$pageNum;
        \$this->placeholders[] = \$count;
        \$db = Database::getInstance('app');
        \$this->query = "SELECT * FROM $tableName" . \$this->where. " ORDER BY post_date DESC LIMIT \$param1,\$count;";
        \$result = \$db->prepare(\$this->query);
        \$result->execute(\$this->placeholders);
        \$collection = [];
        foreach (\$result->fetchAll() as \$entityInfo) {
            \$entity = new $model($columnEntityText);
            \$collection[] = \$entity;
            self::\$selectedObjectPool[] = \$entity;
        }
        return new {$model}Collection(\$collection);


    }

KUF;

    $content .= "}";

    fwrite($repositoryFileName, $content);
}

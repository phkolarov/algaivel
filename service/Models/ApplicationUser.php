<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 18.12.2015 г.
 * Time: 10:24 ч.
 */

namespace Models;


use Repositories\SessionsRepository;
use Repositories\UserRepository;
use Repositories\UserRolesRepository;

class ApplicationUser
{

    private $username;
    private $password;
    private $session;
    private $loggedDate;
    private $roles = [];

    private $userRepo;
    private $sessionRepo;
    private $rolesRepo;
    private $isLogged;
    private static $inst = null;

    private function __construct($session)
    {

        $this->userRepo = UserRepository::create();
        $this->sessionRepo = SessionsRepository::create();
        $this->rolesRepo = UserRolesRepository::create();

        $this->isLogged = self::checkSessionsForLogging($session);
    }

    /**
     * @return ArticlesRepository
     */
    public static function create($session)
    {
        if (self::$inst == null) {
            self::$inst = new self($session);
        }
        return self::$inst;
    }


    /**
     * @param $session
     * @return bool
     */
    public function checkSessionsForLogging($session)
    {

        $validSession = $this->sessionRepo->filterBySession($session)->findOne();

        if ($validSession->getId() && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $session)) {


            $currentUser = $this->userRepo->filterById($validSession->getUser_id())->findOne();

            if ($currentUser->getId() != null) {


                if ($validSession->getUser_id() != $currentUser->getId()) {

                    return false;
                }

                return true;

            } else {

                header("Content-Type: application/json");
                echo json_encode((object)array("error" => "User Session is not valid!"));
                die;
            }
        } else {
            header("Content-Type: application/json");
            echo json_encode((object)array("error" => "Session is expire!"));
            die;
        }


    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        return $this->isLogged;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getLoggedDate()
    {
        return $this->loggedDate;
    }

    public function getRole()
    {
        return $this->roles;
    }


    public function deleteSession($session){

        $validSession = $this->sessionRepo->filterBySession($session)->findOne();

        if ($validSession->getId() && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $session)) {


            $currentUser = $this->userRepo->filterById($validSession->getUser_id())->findOne();

            if ($currentUser->getId() != null) {


                if ($validSession->getUser_id() != $currentUser->getId()) {

                }

                $this->sessionRepo->filterBySession($session)->delete();
                $this->sessionRepo->save();

                header("Content-Type: application/json");
                echo json_encode((object)array("results" => "success"));
                die;
            } else {

                header("Content-Type: application/json");
                echo json_encode((object)array("error" => "User Session is not valid!"));
                die;
            }
        } else {
            header("Content-Type: application/json");
            echo json_encode((object)array("error" => "Session is expire!"));
            die;
        }



    }


}
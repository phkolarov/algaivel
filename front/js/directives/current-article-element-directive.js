galya.directive('currentArticle', function () {
    return{
        templateUrl: "templates/partials/article-block-element.html",
        controller: "currentArticleController",
        restrict : "A"
    }
});
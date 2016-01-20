galya.directive('pagingNews', function () {
    return{
        templateUrl : "templates/partials/paging-news-block-element.html",
        controller: "pagingNewsController",
        restrict : "A"
    }
});
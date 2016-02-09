galya.directive('editImageDirective', function () {
    return{
        templateUrl: "templates/partials/edit-image.html",
        controller: "loadEditImagesController",
        restrict: "A"
    }
});
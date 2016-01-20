galya.directive('currentImage', function () {
    return{
        templateUrl: "templates/partials/image-block-element.html",
        controller : "imageController",
        restrict: "A"
    }
});
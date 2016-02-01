galya.directive('cart', function () {
    return{
        templateUrl: "templates/partials/cart-block-element.html",
        controller: "cartController",
        restrict: "A"
    }
});
galya.directive('adminPanel', function () {
    return{
        templateUrl: "templates/partials/admin-panel.html",
        controller: "adminController",
        restrict: "A"
    }
});
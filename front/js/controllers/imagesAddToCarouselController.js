galya.controller('imagesAddToCarouselController', ['$scope', 'siteData','$routeParams','$route', function ($scope, siteData,$routeParams,$route) {

    $scope.groups = [];
    $scope.filters = [];

    var categoryArray = [];
    var categoryTempArray = [];
    var filtersArray = [];
    var count = $scope.formPageCount.count;
    var currentPage = $scope.currentPage - 1;
    var countOfAllPages = null;

    sessionStorage.removeItem('categoryArray');
    sessionStorage.removeItem('filtersArray');

    //GET DEFAULT DATA WITHOUT FILTRATION
    siteData.getImages(currentPage, count).then(function (data) {

        $scope.imageData = data.data.results;

    });

    //GET TAG CATEGORIES;
    siteData.getTagCategories().then(function (obj) {

        $scope.filterGroups = obj.data.results;
        $scope.filterElements = [];

    });

    //GET FILTERED DATA;
    $scope.filter = function (groupId, filtersObject) {

        if (countOfAllPages == null) {
            countOfAllPages = $scope.countOfPages;
        }

        var checkCategory = categoryArray.indexOf(groupId);
        var that = this;
        if (checkCategory < 0) {
            categoryArray.push(groupId);
            categoryTempArray[groupId] = []
        }

        if (categoryTempArray[groupId] != null) {

            for (var i in filtersObject[groupId]) {

                //var checkFilterTags = $.inArray([i][0], filtersArray);

                var checkFilter = categoryTempArray[groupId].indexOf([i][0]);


                if (checkFilter < 0) {
                    categoryTempArray[groupId].push([i][0]);
                } else {

                    if (filtersObject[groupId][i]) {

                        categoryTempArray[groupId].push([i][0]);
                    } else {

                        var indexOfCurrentElement = categoryTempArray[groupId].indexOf([i][0]);
                        categoryTempArray[groupId].splice(indexOfCurrentElement, 1)
                    }
                }
                break;
            }

            if (categoryTempArray[groupId].length == 0) {

                var indexOfCategory = categoryArray.indexOf(categoryTempArray[groupId]);
                categoryArray.splice(indexOfCategory, 1);
            }

        }


        var filtersArray = [];

        for (var j = 0; j < categoryArray.length; j++) {

            filtersArray = filtersArray.concat(categoryTempArray[categoryArray[j]]);
        }
        ;

        //
        //$scope.categoryArray = categoryArray;
        //$scope.filtersArray = filtersArray;

        if (categoryArray.length == 0) {
            siteData.getImages(currentPage, $scope.formPageCount.count).then(function (data) {

                var pages = pageCounter(data.data.countOfImages, $scope.formPageCount.count);
                $scope.countOfPages = pages;
                that.$emit("refreshPageCount", pages);
                $scope.imageData = $scope.imageData = data.data.results;

                //sessionStorage.clear();

                sessionStorage.removeItem('categoryArray');
                sessionStorage.removeItem('filtersArray');
            });

        } else {

            siteData.getImages(currentPage, $scope.formPageCount.count, categoryArray, filtersArray).then(function (data) {

                var pages = pageCounter(data.data.countOfImages, $scope.formPageCount.count);
                $scope.countOfPages = pages;
                that.$emit("refreshPageCount", pages);
                $scope.imageData = $scope.imageData = data.data.results;

                sessionStorage.categoryArray = JSON.stringify(categoryArray);
                sessionStorage.filtersArray = JSON.stringify(filtersArray);
                $scope.groups = categoryArray;
                $scope.filters = filtersArray;

            })
        }
    };

    $scope.zoom = function (data) {

        var parent = $(data.currentTarget)[0];

        var image = $(parent).children()[0];
        $(image).css({'max-width': '103%'});
        $(image).css({'max-height': '103%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];
        var showChild = $(child).show();
    };

    $scope.unzoom = function (data) {

        var parent = $(data.currentTarget)[0];
        var image = $(parent).children()[0];
        $(image).css({'max-width': '100%'});
        $(image).css({'max-height': '100%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];
        var showChild = $(child).hide();

    };

    function pageCounter(countOfImages, perPage) {

        var pages = Math.floor(countOfImages / perPage);

        if (countOfImages % perPage > 0) {

            pages++
        }


        return pages;
    }


}]);
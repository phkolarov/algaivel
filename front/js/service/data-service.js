galya.factory("siteData", ['$http', 'serviceURL', '$q', '$routeParams', function ($http, serviceURL, $q, $routeParams) {


    function getImagesWithoutFiltration(currentPage, currentCount) {

        var page = currentPage;
        var count = currentCount;


        if (page == undefined) {
            page = 0;
        }
        if (count == undefined) {
            count = 15;
        }
        var url = serviceURL + "gallery/index/" + page + "/" + count;
        var defer = $q.defer();

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                dataType: "JSON"
            }

        }).success(function (success) {

            defer.resolve(success);
        }).error(function (error) {
            defer.reject(error)
        })

        return defer.promise();
    }

    function getImagesWithFiltration(currentPage, currentCount, filteringObject) {


        var page = currentPage;
        var count = currentCount;


        if (page == undefined) {
            page = 0;
        }
        if (count == undefined) {
            count = 15;
        }
        var url = serviceURL + "gallery/index/" + page + "/" + count;
        var defer = $q.defer();

        return $http({
            url: url,
            method: "POST",
            data: filteringObject,
            headers: {
                "Content-type": "application/json",
                dataType: "JSON"
            }

        }).success(function (success) {

            defer.resolve(success);
        }).error(function (error) {

            defer.reject(error);
        });

        return defer.promise();
    }

    function getPageCount(count) {


        var url = serviceURL + "gallery/pageCounter/" + count;
        var defer = $q.defer();

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                dataType: "JSON"
            }
        }).success(function (success) {

            defer.resolve(success)
        }).error(function (error) {
            defer.reject(error)
        });

        return defer.promise();
    }

    function getTagCategories() {

        var url = serviceURL + "gallery/getTagCategories";
        var defer = $q.defer();

        return $http({

            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        }).success(function (success) {

            defer.resolve(success);
        }).error(function (error) {

            defer.reject(error);
        });

        return defer.promise();
    }

    function getImages(currentPage, currentCount, categoryArray, filtersArray) {

        //{"groups" : ["mountains"], "tags": ["Rila", "Stara planina", "Pirin", "Rodopi","Summer"]}
        if (categoryArray != null) {

            var filteringObject = {

                "groups": categoryArray,
                "tags": filtersArray
            };

            return getImagesWithFiltration(currentPage, currentCount, filteringObject)
        } else {
            return getImagesWithoutFiltration(currentPage, currentCount)
        }
    }

    function getCurrentImage(imageId, categoryArray, filtersArray) {

        var url = serviceURL + "gallery/getCurrentImage/" + imageId;
        var defer = $q.defer();
        var data = {
            groups: categoryArray,
            tags: filtersArray
        };
        $http({
            url: url,
            method: 'POST',
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            },
            data: JSON.stringify(data)
        }).then(function (data) {
            defer.resolve(data)
        });


        return defer.promise;
    }

    function nextImage(id, categoryArray, filtersArray) {
        var url = serviceURL + "gallery/getNextImageWithCustomFiltration/" + id;
        var defer = $q.defer();
        var data = {
            groups: categoryArray,
            tags: filtersArray
        };
        return $http({
            url: url,
            method: 'POST',
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            },
            data: JSON.stringify(data)
        });
    }

    function previousImage(id, categoryArray, filtersArray) {
        var url = serviceURL + "gallery/getPreviousImageWithCustomFiltration/" + id;
        var defer = $q.defer();
        var data = {
            groups: categoryArray,
            tags: filtersArray
        };
        return $http({
            url: url,
            method: 'POST',
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            },
            data: JSON.stringify(data)
        });
    }

    function getArticles(currentPage, year) {

        var url = serviceURL + "article/index/" + currentPage;


        if (year != null) {
            var url = serviceURL + "article/index/" + currentPage + "/" + year
        }


        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataTYpe": "json"
            }
        })
    }


    function getPageNewsCount(year) {
        var url = serviceURL + "article/getNewsPageCount/" + year;

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        });
    }

    function getCurrentArticle(id) {

        var url = serviceURL + "article/getCurrentArticle/" + id;

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        })

    }

    function getFineArtInfo() {

        var url = serviceURL + "fineArt";

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        })
    }

    function getAboutMeInformation() {


        var url = serviceURL + "aboutme";

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        })
    }


    function searchArticles(context, page, lang) {

        var url = serviceURL + "search/searchArticles/" + page + "/" + context;


        if (lang == "BG") {
            url += "/BG"
        } else {
            url += "/EN"
        }

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        })
    }

    function searchImages(context, page, lang) {
        var url = serviceURL + "search/searchImages/" + page + "/" + context;


        if (lang == "BG") {
            url += "/BG"
        } else {
            url += "/EN"
        }

        return $http({
            url: url,
            method: "GET",
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        })
    }

    function setAboutMeInformation(){





    }


    return {
        getImagesWithoutFiltration: getImagesWithoutFiltration,
        getPageCount: getPageCount,
        getTagCategories: getTagCategories,
        getImages: getImages,
        getCurrentImage: getCurrentImage,
        nextImage: nextImage,
        previousImage: previousImage,
        getArticles: getArticles,
        getPageNewsCount: getPageNewsCount,
        getCurrentArticle: getCurrentArticle,
        getFineArtInfo: getFineArtInfo,
        getAboutMeInformation: getAboutMeInformation,
        searchArticles: searchArticles,
        searchImages: searchImages
    }


}]);
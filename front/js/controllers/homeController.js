galya.controller('homeController', ['$scope', '$http','serviceURL', function ($scope, $http,serviceURL) {

	$scope.getImage = function() {

		$http({
            url: serviceURL + 'Gallery/getCarouselImages'
        }).then(function successCallback(response) {
            $scope.setImages(response.data.results);
        }, function errorCallback(response) {
            //console.log(response);
        });

	}

	$scope.setImages = function(images) {

		var string = '',
			arr = [];

		for(var i = 0; i < images.length; i++){
			arr[i] = i;
		}

		Array.prototype.shuffle = function() {
		  var i = this.length, j, temp;
		  if ( i == 0 ) return this;
		  while ( --i ) {
		     j = Math.floor( Math.random() * ( i + 1 ) );
		     temp = this[i];
		     this[i] = this[j];
		     this[j] = temp;
		  }
		  return this;
		}

		images.shuffle();

		images.forEach(function(index, value) {

			if ( value == 0 ) {
				string += "<div class='item active'>";
				string +=   '<div class="fill" style="background-image:url(\'images/'+ images[arr[value]].source +'\');">'+
								'<h1 class="imageTitle">'+ images[arr[value]].title +'</h1>'+
								'<p class="imageDescription">'+ images[arr[value]].description +'</p>'+
							'</div>';
				string += "</div>";
			}else{
				string += "<div class='item'>";
				string +=   '<div class="fill" style="background-image:url(\'images/'+ images[arr[value]].source +'\');">'+
								'<h1 class="imageTitle">'+ images[arr[value]].title +'</h1>'+
								'<p class="imageDescription">'+ images[arr[value]].description +'</p>'+
							'</div>';
				string += "</div>";
			}

		})

		document.getElementById('carousel-inner').innerHTML = string;

		$scope.loadCarousel();

	};

	$scope.loadCarousel = function() {

		$(document).ready(function(){
		  $('.carousel').carousel({
		       interval: 3000,
		       pause: "" //changes the speed
		  })
		})
		
	}

	var active = 0;

	$scope.carouselLeft = function() {

		var carousel = document.getElementsByClassName('item'),
			length = document.getElementsByClassName('item').length;

		for(var i = 1; i < length; i++){
			if( carousel[i].className == 'item active' ) active = i - 1;
		}

		document.getElementsByClassName('active')[0].className = 'item';

		if( active == 0 ){
			carousel[length - 1].className = 'item active';
			active = length - 1;
		}else{
			carousel[active].className = 'item active';
			active -= 1;
		}
		
	};

	$scope.carouselRight = function() {

		var carousel = document.getElementsByClassName('item'),
			length = document.getElementsByClassName('item').length;

		for(var i = 0; i < length; i++){
			if( carousel[i].className == 'item active' ) active = i + 1;
		}

		document.getElementsByClassName('active')[0].className = 'item';

		if( active == length - 1 ){
			carousel[0].className = 'item active';
			active = 0;
		}else{
			carousel[active].className = 'item active';
			active += 1;
		}

	};

	$scope.getImage();

}]);

/*
<div class="item active">
      <!-- Set the first background image using inline CSS below. -->
      <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
    </div>*/
galya.controller('homeController', ['$scope', '$http','serviceURL', function ($scope, $http,serviceURL) {

	$scope.getImage = function() {

		$http({
			url: 'http://localhost:1234/xampp/algaivel/back/Gallery/getCarouselImages'
		}).then(function successCallback(response) {
			$scope.setImages(response.data.results);
		}, function errorCallback(response) {
			console.log(response);
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


			string +=   '<div class="fill" style="background-image:url(\'images/'+ images[arr[value]].source +'\');">'+
					'<h1 class="imageTitle">'+ images[arr[value]].title +'</h1>'+
					'<p class="imageDescription">'+ images[arr[value]].description +'</p>'+
					'</div>';

			if( value == 1 ){
				string += '<div class="fill" ><video controls><source src="videos/video.mp4" type="video/mp4"></video></div>';
			}

		})

		$('.single-item').append(string);

		$scope.loadCarousel();

	};

	$scope.loadCarousel = function() {


		$('.single-item').slick({
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			initialSlide: 1
		});

		$('.slick-next').html('<img src="css/img/arrows.png">');
		$('.slick-prev').html('<img src="css/img/arrows.png">');

		$('video').on('ended',function(){

			$('.slick-next').trigger('click');

		});

		$('video').css({
			'width':$(window).width(),
		})

	}

	//var active = 0;

	/*$scope.carouselLeft = function() {

	 var carousel = document.getElementsByClassName('item'),
	 length = document.getElementsByClassName('item').length;

	 for(var i = 1; i < length; i++){
	 if( carousel[i].className == 'item active' ) active = i - 1;
	 }
	 document.getElementsByClassName('active')[0]
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

	 $('.active').next().addClass('active').css('left','100%');

	 $(function () {
	 $(".active").animate({
	 left: '-100%'
	 }, { duration: 600, queue: false });
	 });*/

	/*$( ".active" ).animate({
	 left: "-100%",
	 }, 600, function() {
	 document.getElementsByClassName('active')[0].className = 'item';

	 if( active == length - 1 ){
	 carousel[0].className = 'item active';
	 active = 0;
	 }else{
	 carousel[active].className = 'item active';
	 active += 1;
	 }
	 });

	 $( ".active" ).animate({
	 left: "-100%",
	 }, 600, function() {

	 });*/


	/*};*/

	$(document).ready(function(){

		$scope.getImage();

		var a = setInterval(changeSlick, 10000);

		function changeSlick(){

			var node = $('.slick-active').children()[0] ? $('.slick-active').children()[0].nodeName : 'image';

			if ( node != 'VIDEO' ) {

				$('.slick-next').trigger('click');

			}else{

				if( $('.slick-active video').ended == true ){

					$('.slick-next').trigger('click');

				}else if( $('.slick-active video').get(0).paused == true ){

				}else{

					$('.slick-active video').get(0).play();

				}

			}

		}

		$('#mainWrapper').on('click', 'video', function(){

			if( $('.slick-active video').get(0).paused == true ){
				$('.slick-active video').get(0).play();
			}else{
				$('.slick-active video').get(0).pause();
			}

		});

		$(window).resize(function(){

			$('video').css({
				'width':$(window).width()
			})

		});

	})



}]);

function pauseSlick(type){

	if( $('.slick-active video').length > 0 ){

		if( type == 'prev' ){

			var video = $('.slick-active video').get(0).pause();

		}else{

			var video = $('.slick-active video').get(0).pause();

		}

	}

}

function playSlick(){

	if( $('.slick-active').children()[0].nodeName == "VIDEO" ){
		$('.slick-active video').get(0).play();
	}

}

/*
 <div class="item active">
 <!-- Set the first background image using inline CSS below. -->
 <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
 </div>*/
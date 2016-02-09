galya.controller('uploadImageController' ,['$scope','siteData','$location','$routeParams', '$http', function ($scope,siteData,$location,$routeParams,$http){

	document.getElementById('session_id').value = userInfo.session;
	document.getElementById('fb_id').value = userInfo.id;

	var _URL = window.URL || window.webkitURL;
	$("#fileToUpload").change(function (e) {
	    var file, img;
	    if ((file = this.files[0])) {
	        img = new Image();
	        img.onload = function () {
	            if ( this.width > 2048 ) {
	            	$('input[name="submit"]').attr('disabled', 'disabled');
	            	$('#imageWarning').text('Снимката е прекалено голяма!');
	            }else{
	            	$('input[name="submit"]').removeAttr('disabled');
	            	$('#imageWarning').text('');
	            }
	        };
	        img.src = _URL.createObjectURL(file);
	    }
	});

}]);
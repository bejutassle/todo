jQuery(document).ready(function($) {

	$('select#weeks').on('change', function (e) {
    	$val = this.value;

    	window.location = window.location.origin+'/'+$val;
	});

});
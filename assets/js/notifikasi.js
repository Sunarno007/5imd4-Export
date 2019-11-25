function notifikasi(type,content){
	Command: toastr[type](content,type.toUpperCase());
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "positionClass": "toast-top-right",
	  "onclick": null,
	  "showDuration": "1000",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
}
jQuery(document).ready(function() {
	$('.modal').on('show', function () {
	   var AutoHeight = $(window).innerHeight() - 200;
	   $(this).find('.auto-height').attr('style','overflow-y:auto !important;');
	   $(this).find('.auto-height').attr('style','max-height:'+AutoHeight+'px !important;');
	   $(this).find('.auto-height').attr('style','height:'+AutoHeight+'px !important;');
	});
});

$(document).ready(function() {

	setInterval('currentTime()', 1000);
  
});
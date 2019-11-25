function notif(type,content){
	Command: toastr[type](content);
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

jQuery(document).ready(function(){
		$("#btn-login").click(function(){
			var formAction = $("#login").attr('action');
			var datalogin = {
				username: $("#username").val(),
				password: $("#password").val()
			};

			if (!$("#username").val() || !$("#password").val()) {
				notif('warning','Username dan Password tidak boleh kosong!');
				return false;
			} else {
				$.ajax({
					type: "POST",
					url: formAction,
					data: datalogin,
					beforeSend: function() {
						$("#btn-login").hide('fast');
						$('#loading').show();
					},
					success: function(result) {
						if(result == 1) {
							notif('success','Halaman akan dialihkan dalam waktu 3 detik!<br>Tidak diarahkan otomatis ? klik <a href="organisasi">disini</a>');
							setTimeout(function() {
								window.location = 'organisasi';
							}, 1000);
						} else {
							$('#loading').hide('fast');
							$("#btn-login").show();
							notif('error','Username/Password salah<br>atau status user tidak aktif!');
							$('#username').val('');
							$('#password').val('');
							return false;
						}
					}
				});
				return false;
			}
		}); 
		
		$.backstretch(backstretch,{fade:1e3,duration:8e3});

	
	
	
});

$(document).ready(function() {

	setInterval('currentTime()', 1000);
  
});
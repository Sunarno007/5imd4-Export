jQuery(document).ready(function() {
 
    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 
function sleep (time) {
	return new Promise((resolve) => setTimeout(resolve, time));
}
 
function edit_profile(id)
{
    $('#form_profile')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "profile/profile_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id_profile"]').val(data.id);
			$('[name="username_profile"]').val(data.username);
            $('[name="display_name_profile"]').val(data.display_name);
			$('[name="email_profile"]').val(data.email);
            $('#modal_form_profile').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Profile'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function save_profile()
{
    $('#btnSave_profile').text('saving...'); //change button text
    $('#btnSave_profile').attr('disabled',true); //set button disable
	var formData = new FormData($('#form_profile')[0]); 
 
    // ajax adding data to database
    $.ajax({
        url : "profile/profile_update",
        type: "POST",
        data: formData,
        dataType: "JSON",
		contentType: false,
		processData: false,
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_profile').modal('hide');
		//		notifikasi(data.ntype,data.ncontent);
		//		sleep(6000).then(() => {
					location.reload();
		//		});				 
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave_profile').text('save'); //change button text
            $('#btnSave_profile').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave_profile').text('save'); //change button text
            $('#btnSave_profile').attr('disabled',false); //set button enable 
 
        }
    });
}
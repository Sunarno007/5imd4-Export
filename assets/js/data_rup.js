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
 
function edit_rup()
{
    $('#form_rup')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "data_rup/data_rup_edit",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="tahun_anggaran"]').val(data.tahun_anggaran);
			$('[name="satker_pemda"]').val(data.satker_pemda);
            $('[name="kode_pemda"]').val(data.kode_pemda);
            $('#modal_form_rup').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Setting Data RUP'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function save_data_rup()
{
    $('#btnSave_data_rup').text('saving...'); //change button text
    $('#btnSave_data_rup').attr('disabled',true); //set button disable
	var formData = new FormData($('#form_rup')[0]); 
 
    // ajax adding data to database
    $.ajax({
        url : "data_rup/data_rup_update",
        type: "POST",
        data: formData,
        dataType: "JSON",
		contentType: false,
		processData: false,
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_rup').modal('hide');
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
            $('#btnSave_data_rup').text('save'); //change button text
            $('#btnSave_data_rup').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave_data_rup').text('save'); //change button text
            $('#btnSave_data_rup').attr('disabled',false); //set button enable 
 
        }
    });
}
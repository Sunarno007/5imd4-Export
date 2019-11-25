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
 
function cek_koneksi()
{
 
    //Ajax Load data from ajax
    $.ajax({
        url : "cek_server_simda",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('#modal_cek_server').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text(''); // Set title to Bootstrap modal title
			if(data.status) //if success close modal and reload ajax table
            {
               
				if(data.pesan=='OK')
				{
					$('#cek_server').text('BERHASIL TERHUBUNG DENGAN DATABASE SIMDA'); //change button text
					$('#cek_server').removeClass('btn-error');
					$('#cek_server').addClass('btn-success');
				}
				else
				{
					$('#cek_server').text('GAGAL TERHUBUNG DENGAN DATABASE SIMDA'); //change button text
					$('#cek_server').removeClass('btn-success');
					$('#cek_server').addClass('btn-danger');
				}
            }
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
<script src="assets/js/organisasi.js" type="text/javascript"></script>
<div class="page-content-inner">					
	<div class="portlet box dark">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-list"></i>
			</div>
			<div class="actions">
				<?=$export_all_simda;?>
				<button class="btn btn-success" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i> </button>
			</div>
			<div class="actions">
				<?=$export_to_pendapatan;?>
				<button class="btn btn-danger" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i> </button>
			</div>
			<div class="actions">
				<?=$export_to_gabung;?>
				<button class="btn btn-danger" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i> </button>
			</div>
			<div class="actions">
				<?=$ambilsatu;?>
				<button class="btn btn-danger" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i> </button>
			</div>			
		</div>
		<div class="portlet-body">
			<table id="table" class="table table-striped table-bordered table-hover order-column">
				<thead>
					<tr>
						<th style="width:10px;">#</th>
						<th>ORGANISASI</th>
						<th style="width:10px;"></th>
						<th style="width:10px;"></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="panel-body">
            <?php //echo validation_errors() ; ?>
            <form method="post" action="<?php echo site_url('organisasi/ambilsatu') ?>">
                <div class="form-group">
                    <label class="control-label">Sasak</label>
                    <input type="text" name="cari" class="form-control"/>
                </div>

                <input type="submit" name="simpan" value="Cari" class="btn btn-success">
            </form>
        </div>
	</div>
</div>
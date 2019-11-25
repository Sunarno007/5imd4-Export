<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?=$title;?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?=$this->config->item('description');?>" name="description" />
        <meta content="<?=$this->config->item('webmaster');?>" name="author" />
		<base href="<?=base_url();?>">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="assets/layouts/css/fonts.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
		<link href="assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="assets/layouts/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/css/themes/default.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/layouts/css/custom.min.css" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="stylesheet" href="assets/global/plugins/jquery-ui/jquery-ui.css" media="screen" />
		<link rel="stylesheet" href="assets/global/plugins/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
		<!-- BEGIN JS APP -->
		<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="assets/global/plugins/jquery-ui/jquery-ui.min.js" charset="UTF-8"></script>
		<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
		<script type="text/javascript" src="assets/global/plugins/plupload/js/plupload.full.min.js"></script>
		<script type="text/javascript" src="assets/global/plugins/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
		<script src="assets/global/plugins/plugins.library.js" type="text/javascript"></script>
		<script src="assets/js/notifikasi.js" type="text/javascript"></script>
		<script type="text/javascript">var license_key = "<?=config_data()['license_key'];?>";</script>
		<!-- END JS APP -->
    <!-- END HEAD -->
	</head>
    <body class="page-container-bg-solid page-header-menu-fixed">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
                            <div class="container-fluid">
                                <!-- BEGIN LOGO -->
                                <div class="page-logo">
                                    <a href="javascript:">
                                        <img src="assets/layouts/img/logo.png" alt="logo" class="logo-default">
                                    </a>
                                </div>
                                <!-- END LOGO -->
                                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <a href="javascript:;" class="menu-toggler"></a>
                                <!-- END RESPONSIVE MENU TOGGLER -->
                                <!-- BEGIN TOP NAVIGATION MENU -->
                                <div class="top-menu">
                                    <ul class="nav navbar-nav pull-right">
                                        <!-- BEGIN USER LOGIN DROPDOWN -->
                                        <li class="dropdown dropdown-user dropdown-dark">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <img src="assets/img/<?=gval('users', 'id', 'foto', $this->session->userdata('id')) == null ? 'user.png' : gval('users', 'id', 'foto', $this->session->userdata('id'));?>" alt="">
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-default">
                                                <li>
                                                    <a href="javascript:">
                                                        <?=strtoupper($this->session->userdata('display_name'));?> </a>
                                                </li>
												<li class="divider"></li>
												
                                                <li>
                                                    <a href="<?=base_url('login/logout');?>">
                                                        <i class="icon-key"></i> Log Out </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END USER LOGIN DROPDOWN -->
                                    </ul>
                                </div>
                                <!-- END TOP NAVIGATION MENU -->
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
                        <!-- BEGIN HEADER MENU -->
						<div id="neu_nav" class="page-header-menu">
                            <?$this->load->view('nav-'.$this->session->userdata('level'));?>
						</div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
            <div id="neu_content" class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container-fluid">
                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title">
                                        <h1><?=$title;?></h1>
                                    </div>
                                    <!-- END PAGE TITLE -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container-fluid">
                                    <!-- BEGIN PAGE BREADCRUMBS -->
                                    <?=isset($breadcrumb) ? $breadcrumb : ''?>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <?php isset($content) ? $this->load->view($content) : ''; ?>
                                    <!-- END PAGE CONTENT INNER -->
                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->
                    </div>
                    <!-- END CONTAINER -->
                </div> 
            </div>
            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                    <!-- BEGIN FOOTER -->
                    <!-- BEGIN INNER FOOTER -->
                    <div class="page-footer">
                        <div class="container-fluid">Copyright &copy; <?=date('Y');?> <span id="copyright"><?=$this->config->item('instansi');?></span><span class="pull-right" id="clock"></span></div>
                    </div>
                    <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                    </div>
                    <!-- END INNER FOOTER -->
                    <!-- END FOOTER -->
                </div>
            </div>
        </div>
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
		<script src="assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/layouts/scripts/layout.min.js" type="text/javascript"></script>
		<script src="assets/js/profile.js" type="text/javascript"></script>
		<script src="assets/js/data_rup.js" type="text/javascript"></script>
		<script src="assets/js/data_simda.js" type="text/javascript"></script>
		<script src="assets/js/cek_koneksi.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
		<div id="ajax-modal" class="modal container fade modal-scroll" tabindex="-1" data-replace="true" data-backdrop="static" data-keyboard="false" data-attention-animation="false" data-focus-on="input:first"> </div>
		<?php isset($modal) ? $this->load->view($modal) : ''; ?>
		<!-- Bootstrap modal -->
		<div id="modal_form_profile" class="modal fade modal-scroll" tabindex="-1" data-replace="true" data-backdrop="static" data-keyboard="false" data-attention-animation="false" data-focus-on="input:first">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title">Form User Profile</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form_profile" class="form-horizontal"> 
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Username</label>
							<div class="col-md-9">
								<input name="username_profile" placeholder="Username" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nama Lengkap</label>
							<div class="col-md-9">
								<input name="display_name_profile" placeholder="Nama Lengkap" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">E-Mail</label>
							<div class="col-md-9">
								<input name="email_profile" placeholder="E-Mail" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Foto</label>
							<div class="col-md-9">
								<img height="90px" src="assets/img/<?=gval('users', 'id', 'foto', $this->session->userdata('id')) == null ? 'user.png' : gval('users', 'id', 'foto', $this->session->userdata('id'));?>" alt="">
								<br><br>
								<input type="file" name="foto_profile">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-9">
								<input name="password_profile" placeholder="Password" class="form-control" type="password">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Konfirmasi Password</label>
							<div class="col-md-9">
								<input name="c_password_profile" placeholder="Konfirmasi Password" class="form-control" type="password">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<input type="hidden" value="" name="id_profile"/>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave_profile" onclick="save_profile()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal -->
		
		<div id="modal_form_rup" class="modal fade modal-scroll" tabindex="-1" data-replace="true" data-backdrop="static" data-keyboard="false" data-attention-animation="false" data-focus-on="input:first">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title">Setting Data RUP</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form_rup" class="form-horizontal"> 
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-6">Tahun Anggaran</label>
							<div class="col-md-3">
								<input name="tahun_anggaran" class="form-control" type="text" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-6">Kode Satker Pemda</label>
							<div class="col-md-3">
								<input name="satker_pemda" class="form-control" type="text" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-6">Kode Pemda</label>
							<div class="col-md-3">
								<input name="kode_pemda" class="form-control" type="text" required>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave_data_rup" onclick="save_data_rup()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal -->
		
		<div id="modal_form_simda" class="modal fade modal-scroll" tabindex="-1" data-replace="true" data-backdrop="static" data-keyboard="false" data-attention-animation="false" data-focus-on="input:first">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title">Setting Database SIMDA</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form_simda" class="form-horizontal"> 
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Hostname</label>
							<div class="col-md-9">
								<input name="hostname" class="form-control" type="text" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Username</label>
							<div class="col-md-9">
								<input name="username" class="form-control" type="text" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-9">
								<input name="password" class="form-control" type="password" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Database</label>
							<div class="col-md-9">
								<input name="database" class="form-control" type="text" required>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave_data_simda" onclick="save_data_simda()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal -->
		
		<div id="modal_cek_server" class="modal fade modal-scroll" tabindex="-1" data-replace="true" data-backdrop="static" data-keyboard="false" data-attention-animation="false" data-focus-on="input:first">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title">Setting Data SIMDA</h3>
			</div>
			<div class="modal-body form">
				<center><button type="button" class="btn" id="cek_server" disabled></button></center>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal -->
		<?=isset($alert) ? $alert : ''?>
    </body>

</html>
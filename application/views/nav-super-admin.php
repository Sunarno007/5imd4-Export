                            <div class="container-fluid">
                                <div class="hor-menu  ">
                                    <ul class="nav navbar-nav">
                                        <li class="menu-dropdown classic-menu-dropdown <?=isset($referensi) ? 'active' : '';?>">
                                            <a href="javascript:;">
                                                <i class="icon-grid "></i> PENGATURAN
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
												<li class="<?=isset($seting) ? 'active' : '';?>">
                                                    <a href="javascript:" onclick="edit_rup()">
                                                        <i class="icon-direction"></i> Setting Data RUP
                                                    </a>
                                                </li>
												<li class="<?=isset($seting) ? 'active' : '';?>">
                                                    <a href="javascript:" onclick="edit_simda()">
                                                        <i class="icon-direction"></i> Setting DB SIMDA
                                                    </a>
                                                </li>
												<li class="<?=isset($seting) ? 'active' : '';?>">
                                                    <a href="javascript:" onclick="cek_koneksi()">
                                                        <i class="icon-direction"></i> Cek Koneksi DB SIMDA
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
										<li class="menu-dropdown classic-menu-dropdown <?=isset($simda) ? 'active' : '';?>">
                                            <a href="javascript:;">
                                                <i class="icon-grid"></i> DATA SIMDA
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
												<li class="<?=isset($organisasi) ? 'active' : '';?>">
                                                    <a href="<?=site_url('organisasi');?>" class="nav-link <?=isset($organisasi) ? 'active' : '';?>" >
                                                        <i class="icon-direction"></i> Organisasi
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Paper Trading by Radical Design</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url('auth/edit_user').'/'.$this->ion_auth->get_user_id();?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href=<?php echo site_url('auth/logout');?>><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
<?php 
$wheelsets = Wheelset::find_all();

?>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                           <a href="#"><i class = "fa fa-dashboard fa-fw"></i>Portfolios<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php //$portfolios= $this->portfolio->find_all();?>
                                <li>
                                    <?php echo anchor('wheels/all_wheels', 'View All');?>
                                </li>
                                <?php foreach($wheelsets as $wheelset_info):?>
                                <li>
                                    <?php echo anchor('wheels/edit_wheelset/'.$wheelset_info->id, $wheelset_info->wheelset_name);?>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <li>
                                <?php echo anchor('auth/index', '<i class = "fa fa-users fa-fw"></i>Users'); ?>
                            </li>
                        </li>


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

    <!-- Left navbar links -->
    <!--ul class="nav navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul !-->

    <!-- Right navbar links -->
    <ul class="nav navbar-nav bg-primary">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-user"></i> My Account</a>
        <div class="dropdown-menu" style="min-width:190px;">
        <i class="fa fa-user fa-2x"></i>
                <p>
                  <?php echo isset($current_user) ? $current_user->username :''; ?>
                </p>
                <div class="pull-left">
                  <a <?php echo check_method( 'profile'); ?> class="btn btn-sm btn-default" href="
                    <?php echo site_url('users/profile'); ?>">
                    <?php e(lang('us_user_settings')); ?>
                  </a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-sm btn-default" href="<?php echo site_url('/admin/check/logout'); ?>">
                    <?php e(lang('us_action_logout')); ?>
                  </a>
                </div>
        </div>
      </li>
      <!--li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="false" href="#"><i class="fa fa-th-large"></i></a>
      </li  !-->
    </ul>


<?php 
$CI = &get_instance();
$CI->load->config('admin');

$adm_url = base_url().'/assets/dist/';
$adm_skincolor = $CI->config->item('adm_skin');
$adm_layout = $CI->config->item('adm_layout');
$adm_layout = $adm_layout!=null?'layout-'.$adm_layout:null;
$adm_logo_use_ttl = $CI->config->item('adm_logo_use_site_title'); 
$adm_brandtext = $CI->config->item('adm_brandtext'); 
$adm_logo = $CI->config->item('adm_logo'); 
$adm_logo_m = $CI->config->item('adm_logo_mini'); // = '<b>I</b>GO';
$adm_footer_right = $CI->config->item('adm_footer_right'); 

/* <!--
OPTIONS, set in admin.config:
=================
Apply one or more of the following
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | layout-fixed                            |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
*/
?><!DOCTYPE html>
<html lang="en">
<?php echo theme_view('header', array('adm_url'=>$adm_url,'adm_skincolor'=>$adm_skincolor)); ?>
<body class="hold-transition skin-<?php echo $adm_skincolor;?> <?php echo $adm_layout;?>">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-sticky-top bg-<?php echo $adm_skincolor;?> navbar-dark">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
    <?php if (!empty($adm_logo)) : ?>
    <img src="<?php echo ($adm_logo); ?>" width="30" height="30" class="d-inline-block align-top" alt="logo">
<?php endif;
echo ($adm_logo_use_ttl && isset($site_title) ? $site_title : (isset($adm_brandtext)?$adm_brandtext:"")); ?>
    </a>  
<?php
    echo theme_view('navbar'); ?>
  </nav>
  <!-- /.navbar -->
<?php
   echo theme_view('sidebar');
?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header container-fluid">
      <div class="row">
        <div class="col-sm-6">
        <h1><strong><?php echo (isset($page_title)?$page_title:'Admin Dashboard'); ?></strong>
        <small><strong><?php echo (isset($page_subtitle)?$page_subtitle:''); ?></strong></small>
      </h1>
      </div><!-- /.col -->
        <div class="col-sm-6">
        <nav aria-label="breadcrumb">
           <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
        <?php if (strpos($_SERVER['REQUEST_URI'], '/dashboard/index') < 1) : ?>
        <li class="breadcrumb-item"><a href="<?php echo base_url().'/admin/dashboard/index'; ?>">Dashboard</a></li>
        <?php endif; ?>
            <li class="breadcrumb-item active"><?php echo (isset($page_breadcrumb)?$page_breadcrumb:(isset($page_title)?$page_title:'Dashboard')); ?></li>
      </ol>
    </nav>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
      		<?php echo Template::message();
    echo isset($content) ? $content : Template::content(); ?>


    </section>
    <!-- /.content -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <?php echo $adm_footer_right; ?>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y').(class_exists('Settings') &&  settings_item('site.company') ? settings_item('site.company').'. ' : ' The Ignition Go Team. '); ?></strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/jquery.powertip.min.js"></script>
<!-- Bootstrap 4.x -->
<script src="<?php echo base_url(); ?>assets/dist/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/adminlte.min.js"></script>
<!-- Custom Admin -->
<script src="<?php echo base_url(); ?>assets/dist/admin.min.js"></script>
<script>
  $('.has-tip').powerTip({
    placement: 'n',
    smartPlacement: true
});
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
  <?php if (Modules::assets() && count(Modules::assets())>0) :
  foreach (Modules::assets() as $asset) {
      if (substr($asset,-3)=='.js') {
          echo '<script src="'.$asset.'"></script>';
      }
  } 
  endif; ?></body>
</html>

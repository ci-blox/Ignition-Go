<?php $adm_url = base_url('components').'/admin-lte/';
$adm_skincolor = 'purple';
$adm_layout = 'layout-boxed';
/* <!--
OPTIONS:
=================
Apply one or more of the following
|---------------------------------------------------------|
| SKIN COLOR    | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
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
 <?php echo Template::message();
    echo isset($content) ? $content : Template::content(); ?>   
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.x -->
<script src="<?php echo $adm_url; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $adm_url; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<!-- AdminLTE App -->
<script src="<?php echo $adm_url; ?>dist/js/app.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>

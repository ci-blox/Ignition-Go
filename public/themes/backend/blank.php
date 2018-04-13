<?php $adm_url = base_url().'/assets/dist/';
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
<script src="<?php echo base_url(); ?>assets/dist/jquery.min.js"></script>
<!-- Bootstrap 3.x -->
<script src="<?php echo base_url(); ?>assets/dist/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/dist/icheck.min.js"></script>
<style>
  .icheckbox_square-blue,.iradio_square-blue{background:url(<?php echo base_url(); ?>assets/img/blue.png) no-repeat;}
  @media only screen and (-webkit-min-device-pixel-ratio:1.5),only screen and (-moz-min-device-pixel-ratio:1.5),only screen and (-o-min-device-pixel-ratio:3/2),only screen and (min-device-pixel-ratio:1.5){
    .icheckbox_square-blue,.iradio_square-blue{background-image:url(<?php echo base_url(); ?>assets/img/blue@2x.png);}
}
</style>
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
<script src="<?php echo base_url(); ?>assets/dist/adminlte.min.js"></script>

</body>
</html>

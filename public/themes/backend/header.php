<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
    <title><?php
        echo isset($page_title) ? "{$page_title} : " : '';
        e(class_exists('Settings') ? settings_item('site.title') : 'Ignition Go');
    ?></title>
  <!-- Bootstrap 4-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/admin.min.css">
  <?php /* the below css files are combined into admin.min.css 
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>components/ionicons/css/ionicons.min.css">
  */ ?>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/skin-<?php echo $adm_skincolor; ?>.min.css">
  <!-- iCheck optional styling -->
  <!--link rel="stylesheet" href="< ?php echo $adm_url; ?>plugins/iCheck/square/blue.css"-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php if (Modules::assets() && count(Modules::assets())>0) :
  foreach (Modules::assets() as $asset) {
      if (substr($asset,-4)=='.css') {
          echo '<link rel="stylesheet" href="'.$asset.'" />';
      }
  } 
  endif; ?>
</head>
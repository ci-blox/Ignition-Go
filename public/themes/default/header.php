  <head>
    <meta charset="utf-8">
    <title><?php
        echo isset($page_title) ? "{$page_title} : " : '';
        e(class_exists('Settings') ? settings_item('site.title') : 'Ignition Go');
    ?></title>
   <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php e(isset($meta_description) ? $meta_description : ''); ?>">
    <meta name="author" content="<?php e(isset($meta_author) ? $meta_author : ''); ?>">
    <!--link rel="stylesheet" href="<?php echo base_url(); ?>components/bootstrap-default/css/bootstrap.css" / -->
	<?php /* Stylesheets - gulp combines all in gulpfile.js/config.js into one */ ?>
	<link href='<?php echo base_url(); ?>assets/dist/app.min.css' rel='stylesheet'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../components/html5shiv/dist/html5shiv.js"></script>
      <script src="../../components/respond/dest/respond.min.js"></script>
    <![endif]-->
  </head>
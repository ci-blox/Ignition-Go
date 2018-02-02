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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/bootstrap.min.css" />
	<?php /* Stylesheets - gulp combines/minifies css as defined in gulpfile.js/config.js into one */ ?>
	<link href='<?php echo base_url(); ?>assets/dist/app.min.css' rel='stylesheet'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
     <![endif]-->
  </head>
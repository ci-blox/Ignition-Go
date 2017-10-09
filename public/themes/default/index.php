<!DOCTYPE html>
<html lang="en">
<?php echo theme_view('header'); ?>
<body id="home">
<div class="splash">
<div class="container">
<?php
    echo theme_view('navbar');
?>
	<section class="content">
		<?php if (isset($enable_breadcrumb) && !empty($enable_breadcrumb)): ?>
			<?php echo theme_view('breadcrumb') ?>
		<?php endif ?>
		<?php echo Template::message();
    echo isset($content) ? $content : Template::content(); ?>
	</section>
</div>
<div class="footer">
	<div class="container">
		<?php if (ENVIRONMENT=='development'): ?>
			<p class="pull-right text-muted">
				CI Version: <strong><?php echo CI_VERSION; ?></strong>, 
				Elapsed: <strong>{elapsed_time}</strong> sec, 
				Memory Usage: <strong>{memory_usage}</strong>
			</p>
		<?php endif; ?>
		<p class="text-muted">&copy; <?php echo date('Y').(class_exists('Settings') &&  settings_item('site.company') ? settings_item('site.company').'. ' : ' The Ignition Go Team. '); ?> All rights reserved.</p>
	</div>
</div>
</div>
<?php /* echo theme_view('footer'); */ ?>
<script src="<?php echo base_url(); ?>assets/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/bootstrap.min.js"></script>
<script src='<?php echo base_url(); ?>assets/dist/app.min.js'></script>
<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', "<?php echo (isset($ga_account) ? $ga_account : 'UA-99999999-1'); ?>"]);
    _gaq.push(['_setDomainName', ""]);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
</body>
</html>

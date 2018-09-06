<?php
$error = false;
if (phpversion() < "5.6") {
	$error = true;
	$requirement1 = "<span class='label label-warning'>Your PHP version is " . phpversion() . "</span>";
} else {
	$requirement1 = "<span class='label label-success'>v." . phpversion() . "</span>";
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/themes/default/index.php')) {
	$error = true;
    echo base_url();
	$requirement2 = "<span class='label label-danger'>Document root is pointed incorrectly. Your root should be the public folder.";
} else {
	$requirement2 = "<span class='label label-success'>OK</span>";
}
/*if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/components/font-awesome/css/font-awesome.min.css')) {
	$error = true;
    echo base_url();
	$requirement2a = "<span class='label label-danger'>Bower was not run. Run <em>bower update</em> at the command line to load dependencies like Font-Awesome.";
} else {
	$requirement2a = "<span class='label label-success'>OK</span>";
}*/

if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/dist/app.min.css')) {
	$error = true;
	$requirement2b = "<span class='label label-danger'>Gulp was not run. Run <em>npm update</em> then <em>gulp</em> at the command line to build Bootstrap CSS.";
} else {
	$requirement2b = "<span class='label label-success'>OK</span>";
}

if (!extension_loaded('mysqli')) {
	$error = true;
	$requirement3 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement3 = "<span class='label label-success'>Enabled</span>";
}

/* if (!extension_loaded('mcrypt')) {
	$error = true;
	$requirement4 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement4 = "<span class='label label-success'>Enabled</span>";
}
*/

if (!extension_loaded('mbstring')) {
	$error = true;
	$requirement5 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement5 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('gd')) {
	$error = true;
	$requirement6 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement6 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('pdo')) {
	$error = true;
	$requirement7 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement7 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('curl')) {
	$error = true;
	$requirement8 = "<span class='label label-warning'>Not enabled</span>";
} else {
	$requirement8 = "<span class='label label-success'>Enabled</span>";
}

if (ini_get('allow_url_fopen') != "1") {
	$error = true;
	$requirement9 = "<span class='label label-danger'>Allow_url_fopen is not enabled!</span>";
} else {
	$requirement9 = "<span class='label label-success'>Enabled</span>";
}

/* if (!extension_loaded('imap')) {
	$error = true;
	$requirement10 = "<span class='label label-danger'>Not enabled</span>";
} else {
	$requirement10 = "<span class='label label-success'>Enabled</span>";
}
*/

if (!is_really_writable(APPPATH . 'logs//')) {
	$error = true;
	$requirement12 = "<span class='label label-danger'>Make application/logs/ writable) - Permissions 755 or 777</span>";
} else {
	$requirement12 = "<span class='label label-success'>Ok</span>";
}
if (!is_really_writable($config_path)){
	$error = true;
	$requirement13 = "<span class='label label-danger'>No (Make application/config.php writable) - Permissions 755 or 777</span>";
} else {
	$requirement13 = "<span class='label label-success'>Ok</span>";
}
if (!is_really_writable(APPPATH . 'config/database.php')){
	$error = true;
	$requirement14 = "<span class='label label-danger'>No (Make application/database.php writable) - Permissions - 755 or 777</span>";
} else {
	$requirement14 = "<span class='label label-success'>Ok</span>";
}
/*if (!is_really_writable(FCPATH . 'temp')){
	$error = true;
	$requirement15 = "<span class='label label-danger'>No (Make temp folder writable) - Permissions 755 or 777</span>";
} else {
	$requirement15 = "<span class='label label-success'>Ok</span>";
}*/

?>
<h3 class='page-heading'>Server Prerequisites</h3>
<table class="table table-hover table-sm">
	<thead>
		<tr>
			<th><b>Requirement</b></th>
			<th><b>Result</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>PHP 5.6.*, 7.1.*, 7.2.* </td>
			<td><?php echo $requirement1; ?></td>
		</tr>
		<tr>
			<td>Document Root Set to Public</td>
			<td><?php echo $requirement2; ?></td>
		</tr>
		<tr>
			<td>Yarn Installed and Gulp Executed</td>
			<td><?php echo $requirement2b; ?></td>
		</tr>
		<tr>
			<td>MySQLi PHP Extension</td>
			<td><?php echo $requirement3; ?></td>
		</tr>
		<tr>
			<td>MBString PHP Extension</td>
			<td><?php echo $requirement5; ?></td>
		</tr>
		<tr>
			<td>GD PHP Extension</td>
			<td><?php echo $requirement6; ?></td>
		</tr>
		<tr>
			<td>PDO PHP Extension</td>
			<td><?php echo $requirement7; ?></td>
		</tr>
		<tr>
			<td>CURL PHP Extension</td>
			<td><?php echo $requirement8; ?></td>
		</tr>
		<tr>
			<td>Allow allow_url_fopen</td>
			<td><?php echo $requirement9; ?></td>
		</tr>
		<tr>
			<td>Log folders writable</td>
			<td><?php echo $requirement12; ?></td>
		</tr>
		<tr>
			<td>config.php writable</td>
			<td><?php echo $requirement13; ?></td>
		</tr>
		<tr>
			<td>database.php writable</td>
			<td><?php echo $requirement14; ?></td>
		</tr>
		<!--tr>
			<td>/temp folder Writable</td>
			<td><?php echo '' /*$requirement15*/; ?></td>
		</tr-->
	</tbody>
</table>
<hr />
<?php if ($error == true){
	echo '<div class="text-center alert alert-danger">Please fix the unmet prerequisites in order to continue.</div>';
} else {
	echo '<div class="text-center">';
	echo form_open($this->uri->uri_string());
	echo form_hidden('requirements_success','true');
	echo '<button type="submit" class="btn btn-primary">Next (Database) &gt;</button>';
	echo form_close();
	echo '</div>';
}

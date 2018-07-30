<?php if ( ! $writable) : ?>
<div class="alert alert-danger">
	<p>
		
		<?php echo lang('mb_not_writable_note'); ?>
	</p>
</div>
<?php endif;?>
<link type="text/css" src="../assets/css/buildablox.css" />
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary admin-box">
			<div class="box-header">
				<h3 class="box-title"><?php echo lang('mb_installed_head'); ?></h3>
				<div class="box-tools">
					<a class='btn btn-success' href="<?php echo site_url('/buildablox/create_module'); ?>">
						<?php echo lang('mb_create_button'); ?>
					</a>
				</div>
				<div class="box-body">
					<?php if (isset($modules) && is_array($modules) && count($modules)) : ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>
									<?php echo lang('mb_table_name'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_version'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_description'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_author'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_dbversion_current_available'); ?>
								</th>
								<th colspan="2">
									<?php echo lang('mb_actions'); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
		foreach ($modules as $module => $config) : ?>
							<tr>
								<td>
									<?php echo $config['name']; ?>
								</td>
								<td>
									<?php e(isset($config['version']) ? $config['version'] : '---'); ?>
								</td>
								<td>
									<?php e(isset($config['description']) ? $config['description'] : '---'); ?>
								</td>
								<td>
									<?php e(isset($config['author']) ? $config['author'] : '---'); ?>
								</td>
								<td>
									<?php if (isset($config['dbversions']))
				{
					$dbv =  $config['dbversions'];
					echo str_pad($dbv['installed'], 3, '0', STR_PAD_LEFT) . ' / ' . str_pad($dbv['latest'], 3, '0', STR_PAD_LEFT); 
					if ($dbv['installed']<$dbv['latest'])
					echo form_open('/buildablox/domigrate/'.(number_format($dbv['installed'],0)+1)); 
					else if ($dbv['installed']==$dbv['latest'])
					echo form_open('/buildablox/domigrate/'.(number_format($dbv['installed'],0)-1)); 
					?>
									<input type="hidden" name="module" value="<?php echo preg_replace(" /[ -]/ ", "_ ", $config['name']); ?>">
									<?php if ($dbv['installed']<$dbv['latest']) { ?>
									<input type="submit" class="btn btn-success btn-xs" onclick="return confirm('<?php e(js_escape(lang('mb_migrate_confirm'))); ?>');"
									    value="<?php e(lang('mb_form_actions_migrate_to').' '.str_pad(number_format($dbv['installed'],0)+1, 3, '0', STR_PAD_LEFT)) ?>"
									/>
									<?php }
				else if ($dbv['installed']==$dbv['latest']) { ?>
									<input type="submit" class="btn btn-danger btn-xs" onclick="return confirm('<?php e(js_escape(lang('mb_migrate_rollback_confirm'))); ?>');"
									    value="<?php e(lang('mb_form_actions_rollback_to').' '.str_pad(number_format($dbv['installed'],0)-1, 3, '0', STR_PAD_LEFT)) ?>"
									/>
									<?php }
				  echo form_close(); 
				} ?>
								</td>
								<td>
									<?php echo form_open('/buildablox/delete'); ?>
									<input type="hidden" name="module" value="<?php echo preg_replace(" /[ -]/ ", "_ ", $config['name']); ?>">
									<input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('<?php e(js_escape(lang('mb_delete_confirm'))) ?>');"
									    value="<?php e(lang('mb_form_actions_delete')) ?>" />
									<?php echo form_close(); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
				<div class="alert alert-warning">
					<p>
						<?php e(lang('mb_no_modules')); ?>
						<a href="<?php echo site_url('/buildablox/create_module') ?>">
							<?php e(lang('mb_create_link')); ?>
						</a>
					</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary admin-box">
			<div class="box-header">
				<h3 class="box-title"><?php echo lang('mb_available_head'); ?></h3>
				<div class="box-tools">
				</div>
				<div class="box-body">
					<?php if (isset($modules) && is_array($modules) && count($modules)) : ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>
									<?php echo lang('mb_table_name'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_version'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_description'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_author'); ?>
								</th>
								<th>
									<?php echo lang('mb_table_dbversion_current_available'); ?>
								</th>
								<th colspan="2">
									<?php echo lang('mb_actions'); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
		foreach ($available_modules as $amodule => $aconfig) : ?>
							<tr>
								<td>
									<?php echo $amodule; /* $aconfig['name']; */ ?>
								</td>
								<td>
									<?php e(isset($aconfig['version']) ? $config['version'] : '---'); ?>
								</td>
								<td>
									<?php e(isset($aconfig['description']) ? $config['description'] : '---'); ?>
								</td>
								<td>
									<?php e(isset($aconfig['author']) ? $config['author'] : '---'); ?>
								</td>
								<td>
									<?php if (isset($aconfig['dbversions']))
				{
				  echo form_close(); 
				} ?>
								</td>
								<td>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
				<div class="alert alert-warning">
					<p>
						<?php e(lang('mb_no_modules')); ?>
						<a href="<?php echo site_url('/buildablox/create_module') ?>">
							<?php e(lang('mb_create_link')); ?>
						</a>
					</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
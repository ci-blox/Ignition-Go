<?php

$num_columns	= 17;
$can_delete	= $this->auth->has_permission('Usermaint.Admin.Delete');
$can_edit		= $this->auth->has_permission('App.Users.Manage');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
<div class="row">
		<div class="col-sm-12">
	<h3>
		<?php echo lang('usermaint_area_title'); ?>
	</h3>
	<a href="/admin/users/create" class="btn btn-sm btn-info btn-flat pull-left">Create User</a>
	</div>
</div>
	<?php echo form_open($this->uri->uri_string()); ?>
	<div class="row">
		<div class="col-sm-12" style="overflow-x:auto;">
         <table class="table table-hover table-condensed">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('usermaint_field_username'); ?></th>
					<th><?php echo lang('usermaint_field_role'); ?></th>
					<th><?php echo lang('usermaint_field_email'); ?></th>
					<th><?php echo lang('usermaint_field_first_name'); ?></th>
					<th><?php echo lang('usermaint_field_last_name'); ?></th>
					<th><?php echo lang('usermaint_field_last_login'); ?></th>
					<!--<th><?php //echo lang('usermaint_field_last_ip'); ?></th>-->
					<!--<th><?php //echo lang('usermaint_field_banned'); ?></th>-->
					<th><?php echo lang('usermaint_field_display_name'); ?></th>
					<!--<th><?php //echo lang('usermaint_field_timezone'); ?></th>-->
					<!--<th><?php //echo lang('usermaint_field_language'); ?></th>-->
					<!--<th><?php //echo lang('usermaint_field_active'); ?></th>-->
					<th><?php echo lang('usermaint_field_created_on'); ?></th>
					<th><?php echo lang('usermaint_field_modified_on'); ?></th>
					<th><?php echo lang('usermaint_field_status'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('app_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('app_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('usermaint_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
				<td>	
				<?php 
				if ($can_edit) :
					echo anchor('/admin/users/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->username); 
				else : 
					e($record->username);
				endif; ?>
					</td>
					<td><?php e($record->role); ?></td>
					<td><?php e($record->email); ?></td>
					<td><?php e($record->first_name); ?></td>
					<td><?php e($record->last_name); ?></td>
					<td><?php e($record->last_login); ?></td>
					<!--<td><?//php e($record->last_ip); ?></td>-->
					<!--<td><?php //e($record->banned); ?></td>-->
					<td><?php e($record->display_name); ?></td>
					<!--<td><?php //e($record->timezone); ?></td>-->
					<!--<td><?//php e($record->language); ?></td>-->
					<!--<td><?php //e($record->active); ?></td>-->
					<!--<td><?php //e($record->activate_hash); ?></td>-->
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
					<!--<td><?php //echo $record->deleted > 0 ? lang('usermaint_true') : lang('usermaint_false'); ?></td>-->
					<td><?php if($record->deleted==1) {echo "Deleted";} else if($record->banned==1){echo "Banned";}else{echo "Active";} ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('usermaint_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		</div>
	</div>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>
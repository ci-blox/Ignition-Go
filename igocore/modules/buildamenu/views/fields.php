	<div class="form-group">
		<label for="menu_group" class="col-md-4 control-label">Menu Group</label>
		<div class="col-md-8">
			<input type="text" name="menu_group" value="<?php echo ($this->input->post('menu_group') ? $this->input->post('menu_group') : $menuitem['menu_group']); ?>" class="form-control" id="menu_group" />
		</div>
	</div>
	<div class="form-group">
		<label for="parent_id" class="col-md-4 control-label">Parent Id</label>
		<div class="col-md-8">
			<input type="text" name="parent_id" value="<?php echo ($this->input->post('parent_id') ? $this->input->post('parent_id') : (!isset($menuitem['parent_id'])?'0':$menuitem['parent_id'])); ?>" class="form-control" id="parent_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-md-4 control-label">Title</label>
		<div class="col-md-8">
			<input type="text" name="title" value="<?php echo ($this->input->post('title') ? $this->input->post('title') : (!isset($menuitem['title'])?'':$menuitem['title'])); ?>" class="form-control" id="title" />
		</div>
	</div>
	<div class="form-group">
		<label for="url" class="col-md-4 control-label">Url</label>
		<div class="col-md-8">
			<input type="text" name="url" value="<?php echo ($this->input->post('url') ? $this->input->post('url') : (!isset($menuitem['url'])?'':$menuitem['url'])); ?>" class="form-control" id="url" />
		</div>
	</div>
	<div class="form-group">
		<label for="menu_order" class="col-md-4 control-label">Menu Order</label>
		<div class="col-md-8">
			<input type="text" name="menu_order" value="<?php echo ($this->input->post('menu_order') ? $this->input->post('menu_order') : (!isset($menuitem['menu_order'])?'1':$menuitem['menu_order'])); ?>" class="form-control" id="menu_order" />
		</div>
	</div>
	<div class="form-group">
			<label for="status" class="col-md-4 control-label">Status</label>
			<div class="col-md-8">
				<select name="status" class="form-control">
					<option value="">select</option>
					<?php 
					$status_values = array(
						'0'=>'Hidden',
						'1'=>'Active',
					);

					foreach($status_values as $value => $display_text)
					{
						$selected = ($value == $menuitem['status']) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					} 
					?>
				</select>
			</div>
		</div>
	<div class="form-group">
			<label for="level" class="col-md-4 control-label">Level</label>
			<div class="col-md-8">
				<select name="level" class="form-control">
					<option value="">select</option>
					<?php 
					$level_values = array(
						'0'=>'Top',
						'1'=>'1',
						'2'=>'2',
						'3'=>'3',
						'4'=>'4',
					);

					foreach($level_values as $value => $display_text)
					{
						$selected = ($value == $menuitem['level']) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					} 
					?>
				</select>
			</div>
		</div>
	<div class="form-group">
		<label for="icon" class="col-md-4 control-label">Icon</label>
		<div class="col-md-8">
			<input type="text" name="icon" value="<?php echo ($this->input->post('icon') ? $this->input->post('icon') : (!isset($menuitem['icon'])?'':$menuitem['icon'])); ?>" class="form-control" id="icon" />
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-md-4 control-label">Description</label>
		<div class="col-md-8">
			<input type="text" name="description" value="<?php echo ($this->input->post('description') ? $this->input->post('description') : (!isset($menuitem['description'])?'':$menuitem['description'])); ?>" class="form-control" id="description" />
		</div>
	</div>

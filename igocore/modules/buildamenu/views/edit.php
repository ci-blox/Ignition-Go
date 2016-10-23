<?php echo validation_errors(); ?>
<?php echo form_open('buildamenu/edit/'.$menuitem['id'],array("class"=>"form-horizontal")); ?>

<?php $this->load->view('fields', array('menuitem'=>$menuitem)); ?>

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>
	
<?php echo form_close(); ?>
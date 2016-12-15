<?php

//------------------------------------------------------------------------------
// Setup the fields to be displayed in the view
//------------------------------------------------------------------------------
$field_prefix = '';
if ($db_required == 'new' && $table_as_field_prefix === true) {
    $field_prefix = "{$module_name_lower}_";
}

$viewFields = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    // Only build on fields that have data entered.
    if (set_value("view_field_label$counter") == null) {
        continue;
    }

    $maxlength = null;
    $validation_rules = $this->input->post("validation_rules{$counter}");
    $field_label = set_value("view_field_label$counter");
    $field_name  = set_value("view_field_name$counter");
    $form_name   = "{$field_prefix}{$field_name}";
    $field_type  = set_value("view_field_type$counter");

    $required = '';
    $required_attribute = false;

    // Validation rules for this fieldset
    if (is_array($validation_rules)) {
        foreach ($validation_rules as $key => $value) {
            if ($value == 'required') {
                $required = " . '*'";
                $required_attribute = true;
            }
        }
    }

    // Type of field
    switch ($field_type) {
        case 'textarea':
            $viewFields .= PHP_EOL . "
            <div class=\"form-group<?php echo form_error('{$field_name}') ? ' error' : ''; ?>\">
                <?php echo form_label(lang('{$module_name_lower}_field_{$field_name}'){$required}, '{$form_name}', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => '{$form_name}', 'id' => '{$form_name}', 'rows' => '5', 'cols' => '80', 'value' => set_value('$form_name', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : '')" . ($required_attribute ? ", 'required' => 'required'" : "") . ")); ?>
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
                </div>
            </div>";
            break;
        case 'radio':
            $viewFields .= PHP_EOL . "
            <div class=\"form-group<?php echo form_error('{$field_name}') ? ' error' : ''; ?>\">
                <?php echo form_label(lang('{$module_name_lower}_field_{$field_name}'){$required}, '', array('class' => 'control-label', 'id' => '{$form_name}_label')); ?>
                <div class='controls' aria-labelled-by='{$form_name}_label'>
                    <label class='radio' for='{$form_name}_option1'>
                        <input id='{$form_name}_option1' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option1' <?php echo set_radio('{$form_name}', 'option1', isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 'option1'); ?> />
                        Radio option 1
                    </label>
                    <label class='radio' for='{$form_name}_option2'>
                        <input id='{$form_name}_option2' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option2' <?php echo set_radio('{$form_name}', 'option2', isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 'option2'); ?> />
                        Radio option 2
                    </label>
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
                </div>
            </div>";
            break;
        case 'select':
            // Use CI form helper here as it makes selects/dropdowns easier
            $select_options = array();
            if (set_value("db_field_length_value$counter") != null) {
                $select_options = explode(',', set_value("db_field_length_value$counter"));
            }
            $viewFields .= PHP_EOL . '
            <?php // Change the values in this array to populate your dropdown as required
                $options = array(';
            foreach ($select_options as $key => $option) {
                $viewFields .= '
                    ' . strip_slashes($option) . ' => ' . strip_slashes($option) . ',';
            }
            $viewFields .= "
                );
                echo form_dropdown(array('name' => '{$form_name}'" . ($required_attribute ? ", 'required' => 'required'" : "") . "), \$options, set_value('{$form_name}', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : ''), lang('{$module_name_lower}_field_{$field_name}'){$required});
            ?>";
            break;
        case 'checkbox':
            $viewFields .= PHP_EOL . "
            <div class=\"form-group<?php echo form_error('{$field_name}') ? ' error' : ''; ?>\">
                <div class='checkbox'>
                    <label for='{$form_name}'>
                        <input type='checkbox' id='{$form_name}' name='{$form_name}' " . ($required_attribute ? "required='required' " : "") . " value='1' <?php echo set_checkbox('{$form_name}', 1, isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 1); ?> />
                        <?php echo lang('{$module_name_lower}_field_{$field_name}'){$required}; ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
                </div>
            </div>";
            break;
        case 'input':
        case 'password':
        default:
            $type = $field_type == 'input' ? 'text' : 'password';
            $db_field_type = set_value("db_field_type$counter");
            $max = set_value("db_field_length_value$counter");
            if ($max != null) {
                if (in_array($db_field_type, $realNumberTypes)) {
                    // Constraints for real number types are expected to be in
                    // the format of 'precision,scale', but the standard allows
                    // 'precision', where a scale of 0 is implied (therefore
                    // no decimal point is used)
                    $len = explode(',', $max);
                    $max = $len[0];
                    if (! empty($len[1])) {
                        ++$max; // Add 1 to allow for the decimal point.
                    }
                }
                $maxlength = "maxlength='{$max}'";
            }

            $viewFields .= PHP_EOL . "
            <div class=\"form-group<?php echo form_error('{$field_name}') ? ' error' : ''; ?>\">
                <?php echo form_label(lang('{$module_name_lower}_field_{$field_name}'){$required}, '{$form_name}', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='{$form_name}' type='{$type}' " . ($required_attribute ? "required='required' " : "") . "name='{$form_name}' {$maxlength} value=\"<?php echo set_value('{$form_name}', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : ''); ?>\" />
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
                </div>
            </div>";
            break;
    }
}
?>
    <div class="container">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
        <h1 style="font-size:20pt">Ajax CRUD with Bootstrap modals and Datatables with Image Upload</h1>
 
        <h3><?php echo lang('{$module_name_lower}_area_title'); ?></h3>
        <br />
        <button class="btn btn-success" onclick="add_<?php echo strtolower($entity_1); ?>()"><i class="glyphicon glyphicon-plus"></i> Add <?php echo $entity_1; ?></button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>Photo</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
 
<script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
 
 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url($module_name_lower); ?>/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -2 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],
 
    });
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 
 
 
function add_<?php echo $entity_1; ?>()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add <?php echo $entity_1; ?>'); // Set Title to Bootstrap modal title
 
    $('#photo-preview').hide(); // hide photo preview modal
 
    $('#label-photo').text('Upload Photo'); // label photo upload
}
 
function edit_<?php echo $entity_1; ?>(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('<?php echo site_url($module_name_lower); ?>/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="firstName"]').val(data.firstName);
            $('[name="lastName"]').val(data.lastName);
            $('[name="gender"]').val(data.gender);
            $('[name="address"]').val(data.address);
            $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit <?php echo $entity_1; ?>'); // Set title to Bootstrap modal title
 
            $('#photo-preview').show(); // show photo preview modal
 
            if(data.photo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Remove photo when saving'); // remove photo
 
            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('<?php echo site_url($module_name_lower); ?>/ajax_add')?>";
    } else {
        url = "<?php echo site_url('<?php echo site_url($module_name_lower); ?>/ajax_update')?>";
    }
 
    // ajax adding data to database
 
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_<?php echo strtolower($entity_1); ?>(id)
{
    if(confirm('Are you sure you want to delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url($module_name_lower.'//ajax_delete'); ?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
 
</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><?php echo $entity_1; ?></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="firstName" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="lastName" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-3">Photo</label>
                            <div class="col-md-9">
                                (No photo)
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
                            <div class="col-md-9">
                                <input name="photo" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<div class="pull-right">
	<a href="<?php echo site_url('buildamenu/add'); ?>" class="btn btn-success"><?php echo lang('mb_create_button'); ?></a> 
</div>

<table class="table table-striped table-bordered">
    <tr>
		<th class=''>ID</th>
		<th>Menu Group</th>
		<th>Parent Id</th>
		<th>Item</th>
		<th>Url</th>
		<th>Level</th>
		<th>Menu Order</th>
		<th>Description</th>
		<th>Status</th>
		<th>Actions</th>
    </tr>
	<?php foreach($menuitems as $i){ ?>
    <tr>
		<td class=''><?php echo $i['id']; ?></td>
		<td><?php echo $i['menu_group']; ?></td>
		<td><?php echo $i['parent_id']; ?></td>
		<td><?php echo $i['icon']?"<i class='".$i['icon']."'></i> ":" &nbsp; "; ?>
		 <?php echo $i['title']; ?></td>
		<td><?php echo $i['url']; ?></td>
		<td><?php echo $i['level']==0?'Top':$i['level']; ?></td>
		<td><?php echo $i['menu_order']; ?></td>
		<td><?php echo $i['description']; ?></td>
		<td><?php echo $i['status']?$i['status']:'X'; ?></td>
		<td>
            <a href="<?php echo site_url('buildamenu/edit/'.$i['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit</a> 
            <a href="<?php echo site_url('buildamenu/remove/'.$i['id']); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
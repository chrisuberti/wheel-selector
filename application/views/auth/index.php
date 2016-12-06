<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class = "page-header"><?php echo lang('index_heading');?></h1>
            <p><?php echo lang('index_subheading');?></p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<div class="row">
	<div class="col-lg-12">
	<div id="infoMessage"><?php echo $message;?></div>
	
	<hr>
	</div>
	
		<div class="col-lg-12 col-md-12">
			
		<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
		
			<table cellpadding=0 cellspacing=10 class = "table table-striped table-bordered table-hover dataTable no-footer">
				<tr>
					<th><?php echo lang('index_fname_th');?></th>
					<th><?php echo lang('index_lname_th');?></th>
					<th><?php echo lang('index_email_th');?></th>
					<th><?php echo lang('index_groups_th');?></th>
					<th><?php echo lang('index_status_th');?></th>
					<th><?php echo lang('index_action_th');?></th>
				</tr>
				<?php foreach ($users as $user):?>
					<tr>
			            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
			            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
			            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
						<td>
							<?php foreach ($user->groups as $group):?>
								<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
			                <?php endforeach?>
						</td>
						<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
						<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
					</tr>
				<?php endforeach;?>
			</table>
			</div>

	</div>
</div>
</div>
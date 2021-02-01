<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

?>

			<div class="content-wrapper">
				<section class="content-header">
					<?php echo $pagetitle; ?>
					<?php echo $breadcrumb; ?>
				</section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							 <div class="box">
								<div class="box-header with-border">
									<?php /*?><h3 class="box-title"><?php echo anchor('admin/users/create', '<i class="fa fa-plus"></i> '. lang('users_create_user'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3><?php */?>
								</div>
								<div class="box-body">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>#ID</th>
												<th>Date</th>
												<th>Title</th>
												<th>Host</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($events as $event):
												$eId = $event['id']; 
											?>
											<tr>
												<td><?php echo htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo date("M d, Y",strtotime($event['event_date'])); ?></td>
                                                <td><?php echo htmlspecialchars($event['event_title'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo $event['host_id']; ?></td>
												<td><?php echo ($event['status']=='1') ? anchor('admin/events/deactivate/'.$eId, '<span class="label label-success">'.lang('users_active').'</span>') : anchor('admin/events/activate/'. $eId, '<span class="label label-default">'.lang('users_inactive').'</span>'); ?></td>
												<td>
													<?php echo anchor('admin/events/edit/'.$eId, lang('actions_edit')); ?>
													<?php echo anchor('admin/events/delete/'.$eId, lang('actions_see')); ?>
												</td>
											</tr>
										<?php endforeach;?>
										</tbody>
									</table>
								</div>
							</div>
						 </div>
					</div>
				</section>
			</div>
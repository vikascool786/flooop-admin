<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#TODO - delete slide feature
?>
<style>
.img-slide{height:100px;width:178px;}
td span{color:#f34e3a}
</style>

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
									<h3 class="box-title"><?php echo anchor('admin/slider/create', '<i class="fa fa-plus"></i> Add', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
								</div>
								<div class="box-body">
									<table id="ans_table" class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Image</th>
												<th>Title</th>
												<?php /*?><th><?php echo lang('subtitle');?></th><?php */?>
												<th>Link</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($slides as $slide):
											$sid = $slide['id'];
											
											// image { 
											$image = $slide['image'];
											$path_http = $path_http_default = APPLICATION_URL.'upload/slider/default_1920x1080.png';
											$path_root = PROJECT_ROOT_PATH.'/upload/slider/'.$image; 
											if(file_exists($path_root) && $image!='')
											{
												$path_http = APPLICATION_URL.'upload/slider/'.$image;
											}
											$html_image = '<img src="'.$path_http.'" class="img-fluid img-slide" >';
											// } 
											
											$status = ($slide['status']=='1')?'Active':'Inactive';
										?>
											<tr>
												<td><?php echo $html_image; ?></td>
												<td><?php echo $slide['title']; ?><br />
												<?php echo $slide['subtitle']; ?></td>
												<?php /*?><td><?php echo htmlspecialchars($slide['subtitle'], ENT_QUOTES, 'UTF-8'); ?></td><?php */?>
												<td><?php echo htmlspecialchars($slide['link_value'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo $status?></td>
												<td>
													<a href="<?php echo APPLICATION_URL.'admin/slider/edit/'.$sid?>" >Edit</a> | 
                                                    &nbsp;<a href="javascript:void(0)" onclick="remove(<?php echo $sid?>)" >Delete</a>
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
<script>
$(document).ready(function(e) {
    $('#ans_table').DataTable();
});

function remove(id)
{
	var res = confirm('Are you sure want to delete?');
	
	if(res)
	{
		$.ajax({
			url:'<?php echo APPLICATION_URL?>admin/slider/delete',
			method:'POST',
			data:{id:id},
			success:function(data)
			{
				data = $.trim(data);
             	if($.trim(data)){
					var datanew1=data.split('||');
					if(datanew1[0]=='SUCCESS')
					{
						toastr.success(datanew1[1]);
						setTimeout(function(){window.location.reload();},3000);
					}
					else { 
						toastr.error(datanew1[1]);
					}
				}		
			}
		});		
	}
}
</script>
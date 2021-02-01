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
                                    <select name="filter_event" id="filter_event" onchange="updateAttendees(this.value)">
                                    	<option value="0">Select Event</option>
                                        <?php
                                        	foreach ($events as $event){
												$eId = $event['id']; 
												echo '<option value="'.$eId.'">'.$event['event_title'].'</option>';
											}
										?>
                                    </select>
                                    
								</div>
								<div class="box-body">
									
								</div>
							</div>
						 </div>
					</div>
				</section>
			</div>
<script>

function updateAttendees(id)
{
	$('.box-body').html('Loading...'); 
	$.ajax({
		url:'<?php echo APPLICATION_URL?>admin/events/getattendees',
		method:'POST',
		data:{eId:id},
		success:function(data)
		{
        	 data = $.trim(data); //alert(data);
             if($.trim(data)){
				var datanew1=data.split('||');
				if(datanew1[0]=='ERROR')
				{
					alert(datanew1[1]);				
				}
				else {
					$('.box-body').html(data); 
				}
			 }		
                         
             $('#btn_assignService1').removeAttr("disabled");
        }
	});
}
</script>            
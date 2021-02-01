<?php
#TODO - form validations

defined('BASEPATH') OR exit('No direct script access allowed');

$Heading = (empty($slide))?'Add Slide':"Edit Slide";
$title=$subtitle=$image=$link_value=$link_title=$status='';
$sid='0';

//$path_http = 'https://via.placeholder.com/178x100.png?text=1920x1080';	
$path_http = $path_http_default = APPLICATION_URL.'upload/slider/default_1920x1080.png';
$html_image = '<img src="'.$path_http.'" class="img-fluid" >';
if(!empty($slide))
{
	$sid=$slide['id'];
	$title = $slide['title'];
	$subtitle = $slide['subtitle'];
	$image = $slide['image'];
	$link_value = $slide['link_value'];
	$link_title = $slide['link_title'];
	$status = $slide['status'];
	
	$path_root = PROJECT_ROOT_PATH.'/upload/slider/'.$image; 
	if(file_exists($path_root) && $image!='')
	{
		$path_http = APPLICATION_URL.'upload/slider/'.$image;
	
	
	$html_image = '<img src="'.$path_http.'" class="img-fluid" ><br><a class="delIcon" href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-remove"></i></a>';
	}
}

?>
<style>
#wrapper_image img{height:100px;width:178px;}
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
                        <h3 class="box-title"><?php echo $Heading; ?></h3>
                    </div>
                    <div class="box-body">
                        <form>
                          <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title?>">
                          </div>
                          <div class="form-group">
                            <label for="subtitle">Sub Title</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Sub Title" value="<?php echo $subtitle?>">
                          </div>
                          <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input type="file" id="file_image" name="file_image">
                            <input type="hidden" id="image" name="image" value="<?php echo $image?>">
                            <p class="help-block">Recommendation: 1920x1080, (jpg/jpeg/png)</p>
                            <div id="queue_image"></div>
                            <div id="wrapper_image"><?php echo $html_image?></div>
                          </div>
                          <div class="form-group">
                            <label for="link_value">Link</label>
                            <input type="text" class="form-control" id="link_value" name="link_value" placeholder="Link" value="<?php echo $link_value?>">
                          </div>
                          <div class="form-group">
                            <label for="link_title">Link Title</label>
                            <input type="text" class="form-control" id="link_title" name="link_title" placeholder="Link Title" value="<?php echo $link_title?>">
                          </div>
                          <div class="form-group">
                            <label for="status">Status</label>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="status" id="status_1" value="1" <?php if($status=='1') echo 'checked';?> > Active
                                </label>
                                <label class="ml-10">
                                  <input type="radio" name="status" id="status_0" value="0" <?php if($status=='0') echo 'checked';?>> In-Active
                                </label>
                              </div>
                          </div>
                          <input id="btn_active" type="button" class="btn btn-primary" value="Save" onclick="save()"  />
                          <input id="btn_inactive" type="button" class="btn btn-default disp_none" value="Processing..."  />
                          <input type="button" class="btn btn-default ml-10" value="Back" onclick="goback()"  />
                          <input type="hidden" name="id" id="id" value="<?php echo $sid?>"  />
                        </form>
                    </div>
                </div>
             </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function(e) {
    <? $timestamp = time();?>
	$('#file_image').uploadifive({
		'auto'             : true,
		'formData'         : {
							   'timestamp' : '<?php echo $timestamp;?>',
							   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
							 },
		'queueID'          : 'queue_image',
		'uploadScript'     : '<?php echo APPLICATION_URL?>uploadifive.php?opt=slider_image',
		'onUploadComplete' : function(file, data) {
			$('#file_image').uploadifive('clearQueue');
			var filename=data;					
			var file1="'"+filename+"'";
			$('#image').val(filename);
			path = '<?=APPLICATION_URL?>upload/slider/'+filename;
			document.getElementById('wrapper_image').innerHTML='<img src="'+path+'" class="img-fluid" /><br><a class="delIcon" href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-remove"></i></a></div>';
			
		 },
		'onError'      : function(errorType) {
			// alert(errorType);
			var msg = errorType;
			errorType =$.trim(errorType);
			
			if(errorType=='FILE_SIZE_LIMIT_EXCEEDED')
			{msg = 'Please upload file upto 5 MB';}
			if(errorType=='FORBIDDEN_FILE_TYPE')
			{msg = 'Please upload valid video files';}
			
			$('.fileinfo').html(msg);	//alert(msg); 
		}
	});
});
function removeImage()
{
	var path_http_default = '<?php echo $path_http_default?>';
	$('#image').val('');
	document.getElementById('wrapper_image').innerHTML='<img src="'+path_http_default+'" class="img-fluid" /></div>';	
}

function save()
{
	$('#btn_active').addClass('disp_none');
	$('#btn_inactive').removeClass('disp_none');
	document.body.style.cursor = 'wait';	
	
	var id = $('#id').val();
	var title = $('#title').val();
	var subtitle = $('#subtitle').val();
	var image = $('#image').val();
	var link_value = $('#link_value').val();
	var link_title = $('#link_title').val();
	//var status = $('#status').val();
	var status = '';
	if(document.getElementById('status_0').checked)
	status = '0';
	if(document.getElementById('status_1').checked)
	status = '1';
	
	$.ajax({
		url:'<?php echo APPLICATION_URL?>admin/slider/save',
		method:'POST',
		data:{id:id,title:title,subtitle:subtitle,image:image,link_value:link_value,link_title:link_title,status:status},
		success:function(data)
		{
			$('#btn_active').removeClass('disp_none');
			$('#btn_inactive').addClass('disp_none');
			document.body.style.cursor = 'default';	
	
        	 data = $.trim(data);
             if($.trim(data)){
				var datanew1=data.split('||');
				if(datanew1[0]=='SUCCESS')
				{
					toastr.success(datanew1[1]);
				}
				else { 
					toastr.error(datanew1[1]);
				}
			 }		
                         
        }
	});
}
function goback()
{
	window.location.assign('<?php echo APPLICATION_URL.'admin/slider'?>');	
}
</script>
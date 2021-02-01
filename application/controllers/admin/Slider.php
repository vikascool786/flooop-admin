<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		/* Load :: Common */
		//$this->lang->load('admin/common');
		
		$this->load->model('admin/slider_model');

		/* Title Page :: Common */
		$this->page_title->push('Manage Slider');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Manage Slider', 'admin/slider');
	}


	public function index()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();

			$slides = $this->slider_model->get_sliders("","","","","",""); //prd($slides);
			$this->data['slides'] = $slides;
			
			/* Load Template */
			$this->template->admin_render('admin/slider/index', $this->data);
		}
	}
	// 8233342900
	
	public function create()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_slider_create'), 'admin/slider/create');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		/* Load Template */
		$this->template->admin_render('admin/slider/edit', $this->data);
		
	}
	public function edit($id)
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_slider_edit'), 'admin/slider/edit');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$dataSider = $this->slider_model->get_sliders($id,'','','','','');
		$this->data['slide'] = $dataSider[0]; //prd($dataSider);
		
		/* Load Template */
		$this->template->admin_render('admin/slider/edit', $this->data);
		
	}
	public function save()
	{
		$postData = $_POST;
		//$postData = formfilter($postData);
		
		$id = $postData['id'];
		$title = $postData['title'];
		$subtitle = $postData['subtitle'];
		$link_value = $postData['link_value'];
		$link_title = $postData['link_title'];
		$image = $postData['image'];
		$status = $postData['status'];
		
		if($id=='0')
		{
			$dataInsert = ['title'=>$title,'subtitle'=>$subtitle,'link_value'=>$link_value,'link_title'=>$link_title,'image'=>$image,'status'=>$status,'addDate'=>date('Y-m-d H:i:s')];	
			$sid = $this->slider_model->save($dataInsert);
		}	
		else
		{
			$dataUpdate = ['title'=>$title,'subtitle'=>$subtitle,'link_value'=>$link_value,'link_title'=>$link_title,'image'=>$image,'status'=>$status];	
			$result = $this->slider_model->update($id,$dataUpdate);	
		}
		
		echo 'SUCCESS||Record saved successfully';
		exit;
	}
	public function delete()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$postData = $_POST;	
			$id = $postData['id'];
			$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
			
			$res = $this->slider_model->delete($id);
			echo 'SUCCESS||Record deleted successfully';
			exit;
		}
	}
		
}

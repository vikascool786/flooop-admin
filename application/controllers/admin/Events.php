<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/events_model');

		/* Load :: Common */
		$this->lang->load('admin/users');

		/* Title Page :: Common */
		$this->page_title->push('Events');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_events'), 'admin/events');
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

			/* Get all users */
			/*$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}*/
			
			$order_type = 'Desc';
			$limit_start = '0'; //'100';
			$limit_end = '0'; 
			$this->data['events'] = $this->events_model->get_events('', '', '', $order_type, $limit_start,$limit_end); 
			
			/* Load Template */
			$this->template->admin_render('admin/events/index', $this->data);
		}
	}
	
	public function attendees()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->page_title->push('Attendees');
			$this->data['pagetitle'] = $this->page_title->show();
		
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
			$order_type = 'Desc';
			$limit_start = '0'; //'100';
			$limit_end = '0'; 
			$this->data['events'] = $this->events_model->get_events('', '', '', $order_type, $limit_start,$limit_end); 
			
			/* Load Template */
			$this->template->admin_render('admin/events/attendees', $this->data);
		}
	}
	
	public function getattendees()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			echo 'ERROR||Invalid Request';
			exit;
		}
		else
		{	
			$postData = $_POST;
			$eId = $postData['eId'];
			$eId = filter_var($eId,FILTER_SANITIZE_NUMBER_INT);
			
			$order_type = 'Desc';
			$limit_start = '0'; //'100';
			$limit_end = '0'; 
			$this->data['attendees'] = $this->events_model->get_attendees($eId, '', '', $order_type, $limit_start,$limit_end); 
			
			$this->load->view('admin/events/getattendees',$this->data);
		}
	}
}
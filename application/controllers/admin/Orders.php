<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/events_model');

		/* Load :: Common */
		$this->lang->load('admin/users');

		/* Title Page :: Common */
		$this->page_title->push('Orders');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_orders'), 'admin/orders');
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
			//$this->data['events'] = $this->events_model->get_events('', '', '', $order_type, $limit_start,$limit_end); 
			$this->data['orders'] = array();
			
			/* Load Template */
			$this->template->admin_render('admin/orders/index', $this->data);
		}
	}

}
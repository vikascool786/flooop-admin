<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
    }


	public function index()
	{
		if ( ! $this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            redirect('/admin', 'refresh');
        }
		$this->load->view('public/home', $this->data);
	}
}

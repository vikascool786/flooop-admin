<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hour_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        //$this->load->database(); 	// AMD
		parent::__construct();
    }

}
?>
<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Exceptions extends CI_Controller {

	
	public function index()
	{
            exit();	
	}
        public function custom_404(){
            $data['title'] = 'Access Denied';
            $this->load->view('header',$data);
            $this->load->view('access-denied',$data);
           
        }
}

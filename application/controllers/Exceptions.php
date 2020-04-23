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
            echo "Access Denied!!";  
        }
}

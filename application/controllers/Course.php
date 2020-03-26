<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Dashboard.
    |
    */
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('auth');
        //$this->auth->route_access();
        $this->load->model('course_model');
        $this->load->helper('url_helper');
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $data['courses'] = $this->course_model->all();
        $data['title'] = 'Course';
        $this->load->view('header',$data);
        $this->load->view('course',$data);
    }
}
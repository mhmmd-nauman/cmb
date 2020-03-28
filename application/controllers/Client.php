<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller
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
       // $this->auth->route_access();
        $this->load->model('cmb_model');
        $this->load->model('department_model');
        $this->load->model('course_model');
        $this->load->model('user');
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $cmbs = $this->cmb_model->all();
        $d = 0;
        foreach($cmbs as $cmb){
            $d = $d+$cmb->downloaded;
        }
        $visits = $this->db->get_where("visits")->result();
        $v = count($visits);
        $data['visits'] = $v;
        $data['downloaded'] = $d;
        $data['departments'] = $this->department_model->all();
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        $data['cmbs'] = $cmbs;
        $data['title'] = 'Home';
        $this->load->view('header_client',$data);
        $this->load->view('client',$data);
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
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
        $this->load->library('auth');
        $this->auth->route_access();
        //print_r($this->session->userdata['roles']);
        if(in_array("2", $this->session->userdata['roles'])){
            //echo "could be teacher";
        }
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
        $data['departments'] = $this->user->all();
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        $data['title'] = 'Home';
        $this->load->view('header',$data);
        $this->load->view('home',$data);
    }
}
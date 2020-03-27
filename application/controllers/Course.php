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
        $this->load->model('department_model');
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $data['courses'] = $this->course_model->all();
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
       
        $data['departments'] = $data_dpt;
        $data['title'] = 'Course';
        $this->load->view('header',$data);
        $this->load->view('course',$data);
    }
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Enter new course information';

        $this->form_validation->set_rules('course_title', 'Title', 'required');
        $this->form_validation->set_rules('deptID', 'deptID', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['departments'] = $this->department_model->all();
            $this->load->view('header', $data);
            $this->load->view('create_course',$data);
            

        }
        else
        {
            $this->course_model->set_course();
            $this->load->view('header', $data);
            $this->load->view('success');
        }
    }
}
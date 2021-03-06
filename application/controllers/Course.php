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
        $this->load->database();
        $this->load->library('auth');
        $user_permissions=$this->auth->userPermissions();
        if(!in_array('admin-admin', $user_permissions)){
            $this->auth->route_access();
        }
        $this->load->model('course_model');
        $this->load->helper('url_helper');
        $this->load->model('department_model');
        $this->load->model('user');
        
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        if(in_array('admin-admin', $this->auth->userPermissions())){
            $data['courses'] = $this->course_model->all();
        }else{
            //print_r($this->session->userdata);
            $data['courses'] = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        }
        //$data['courses'] = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        $users = $this->user->all();
        foreach($users as $usr){
            $data_usr[$usr->id] = $usr->name;
            
        }
       
        $data['users'] = $data_usr;
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
       // $this->form_validation->set_rules('deptID', 'deptID', 'required');

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
    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Update course information';

        $this->form_validation->set_rules('course_title', 'Title', 'required');
       // $this->form_validation->set_rules('deptID', 'deptID', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['course'] = $this->course_model->find($id);
            //$data['departments'] = $this->department_model->all();
            $this->load->view('header', $data);
            $this->load->view('edit_course',$data);
            

        }
        else
        {
            $update_data['course_id'] = $id;
            $update_data['course_title'] = $this->input->post('course_title');   
            $this->course_model->edit($update_data);
            $this->load->view('header', $data);
            $this->load->view('success');
        }
    }
}
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
        
       
        $data['users'] = $this->user->all();
        $user_data = array();
        $cmb_data = array();
        $courses_data = array();
        $course_title_data = array();
        foreach($data['users'] as $user){
         // print_r($user->id);
          
          if(in_array("3", $this->user->userWiseRoles($user->id))){
              $user_data[] = $user;
              $cmb_data[$user->id] = $this->cmb_model->findby_user($user->id);
              foreach($cmb_data[$user->id] as $cmb){
                  $course_title_data = $this->course_model->find($cmb->course_id);
                 // print_r($course_title_data);
                  $courses_data[$user->id][$cmb->course_id] = $course_title_data->course_title;
              }
          }
          
        }
        $data['cmb_data'] =$cmb_data;
        $data['courses_data'] =$courses_data;
        //print_r($cmb_data);
        //print_r($courses_data);
        $data['users'] =$user_data;
        //
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        $cmbs = $this->cmb_model->all();
        foreach($cmbs as $cmb){
            
        }
        $data['cmbs'] = $cmbs;
        $data['title'] = 'Home';
        $this->load->view('header_client',$data);
        $this->load->view('client',$data);
    }
}
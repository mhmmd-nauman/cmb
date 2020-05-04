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
        //$this->auth->route_access();
        //print_r($this->session->userdata['roles']);
        if(in_array("2", $this->session->userdata['roles'])){
            //echo "could be teacher";
        }
        $this->load->model('cmb_model');
        $this->load->model('department_model');
        $this->load->model('course_model');
        $this->load->model('user');
        if(empty($this->auth->userID())){
            redirect("/login");
        }
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $cmb_version = array();
        $cmbs = $this->cmb_model->all();
        $data['number_of_bandels'] = count($cmbs);
        $d = 0;
        foreach($cmbs as $cmb){
            $d = $d+$cmb->downloaded;
            
        }
        
        $visits = $this->db->get_where("visits")->result();
        $v = count($visits);
        $data['visits'] = $v;
        $data['downloaded'] = $d;
        $data['departments'] = $this->user->all();
        $total_department = 0;
        foreach($data['departments'] as $login){
            foreach($this->user->userWiseRoleDetails($login->id) as $role_data){
                //print_r($role_data);
                if($role_data->name == "hod"){
                    $total_department = $total_department + 1;
                }
                //exit;
            }
        }
        //echo $total_department;
        $data['departments'] = $total_department;
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        //// start of graph
        $data['users'] = $this->user->all();
        $user_data = array();
        $cmb_data = array();
        $courses_data = array();
        $cmb_downloaded = array();
        $cmb_count = 0;
        $cmb_revised = 0;
        foreach($data['users'] as $user){
         // print_r($user->id);
           $cmb_count = 0;
           $cmb_revised = 0;
          if(in_array("3", $this->user->userWiseRoles($user->id))){
              $user_data[] = $user;
              $cmb_data[$user->id] = $this->cmb_model->findby_user($user->id);
              $courses_data[$user->id] = $this->course_model->find_by_dpt($user->id);
              foreach($cmb_data[$user->id] as $cmb){
                  $cmb_count = $cmb_count+$cmb->downloaded;
                  $cmb_revised = $cmb_revised + count($this->cmb_model->findby_versions($this->session->userdata['userID'],$cmb->cmb_id));
                 // $courses_data[$user->id][$cmb->course_id] = $course_title_data->course_title;
              }
              $cmb_downloaded[$user->id] = round(($cmb_count>0)?$cmb_count/15:0);
              $cmb_version[$user->id] = $cmb_revised;
          }
          
        }
        $data['cmb_data'] =$cmb_data;
        $data['courses_data'] =$courses_data;
        $data['cmb_downloaded'] = $cmb_downloaded;
        $data['cmb_version'] = $cmb_version;
        //echo "<pre>";
        //print_r($cmb_downloaded);
        //echo "</pre>";
        //print_r($courses_data);
        $data['users'] =$user_data;
        //
        $data['courses'] = $courses;
        
        $data['cmbs'] = $cmbs;
        
        ///// end of graph
        $data['title'] = 'Home';
        $this->load->view('header',$data);
        $this->load->view('home',$data);
    }
}
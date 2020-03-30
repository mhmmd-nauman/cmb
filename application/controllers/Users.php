<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
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
        $this->load->model('user');
        $this->load->model('role');
        $this->load->helper('url_helper');
        $this->load->model('department_model');
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    function outputCSV($data) {
        $output = fopen("php://output", "w");
        foreach ($data as $row) {
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        fclose($output);
    }
    public function changepassword(){
        $csvFile = fopen("users.csv", 'r');
        while(($line = fgetcsv($csvFile)) !== FALSE){
            //print_r($line);
            $user_data['id'] = $line[0];
            $password = $line[5];
            $user_data["password"] = password_hash($password, PASSWORD_BCRYPT);
            $this->user->edit($user_data);
           // break;
        }
        
    }
    public function index()
    {
        $data['users'] = $this->user->all();
       // print_r($data['users']);
        $user_roles_data = array();
        foreach($data['users'] as $user){
            //print_r($user->id);
            
           // print_r($user_data);
            //$roles = array("3"); // add teacher role by default for now
           // $this->user->addRoles($user->id, $roles);
            $user_roles = $this->user->userWiseRoles($user->id);
            //print_r($user_roles);
            foreach($user_roles as $role){
                $user_roles_data[$user->id][]=$this->role->find($role)->display_name;
            }
        }
       // print_r($user_roles[1]);
        $data['user_roles'] = $user_roles_data;
        // departments
        
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
       
        $data['departments'] = $data_dpt;
        
        $data['title'] = 'Departments';
        $this->load->view('header',$data);
        $this->load->view('user',$data);
    }
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Enter department information';

        $this->form_validation->set_rules('email', 'Email', 'required');
       // $this->form_validation->set_rules('deptID', 'deptID', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        
        
        $user_data['email'] = $this->input->post('email');
       // $user_data['deptID'] = $this->input->post('deptID');
        $user_data['name'] = $this->input->post('name');
        $user_data['username'] = $this->input->post('username');
        $user_data['password'] = $this->input->post('password');
        
        if ($this->form_validation->run() === FALSE)
        {
            $data['departments'] = $this->department_model->all();
            
            
            $data['users'] = $this->user->all();
            $this->load->view('header', $data);
            $this->load->view('create_users',$data);
            

        }
        else
        {
            $this->user->add($user_data);
            $user_data = $this->user->find_with_email($this->input->post('email'));
           // print_r($user_data);
            $roles = array("3"); // add teacher role by default for now
            
            $this->user->addRoles($user_data->id, $roles);
            $this->load->view('header', $data);
            $this->load->view('success_user');
        }
    }
}
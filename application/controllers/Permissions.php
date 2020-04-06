<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller
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
        
        $this->load->model('user');
        $this->load->model('role');
        $this->load->model('permission');
        $this->load->helper('url_helper');
        $this->load->library('auth');
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
        
        $data['permissions'] = $this->permission->all();
       
        
        $this->load->view('header',$data);
        $this->load->view('permission',$data);
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
    public function role()
    {
       $data['role'] = $this->role->all();
       //print_r($data['role']);
       $this->load->view('header', $data);
       $this->load->view('role',$data);
    } 
}
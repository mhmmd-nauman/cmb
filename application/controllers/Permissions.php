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
       
        // test the code
        /*
        add is function, roles is controller
        $this->permission->add([
                    'name' => 'add-roles',
                    'display_name' => 'Create Role',
                    'status' => 1,
                ]);
        */
        //$permissions will be a permission id or an array of permission id
       // $this->role->addPermissions(4, 1);
        //$permissions_data=$this->role->roleWisePermissionDetails(4);
        //print_r($permissions_data);
        $this->load->view('header',$data);
        $this->load->view('permission',$data);
    }
    public function create()
    {
        // this will be latter updated to handle permissions
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Enter Permission information';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('display_name', 'display_name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
       
       
        
        if ($this->form_validation->run() === FALSE)
        {
            
            
            $this->load->view('header', $data);
            $this->load->view('create_permissions',$data);
            

        }
        else
        {
            $user_data['name'] = $this->input->post('name');
            $user_data['display_name'] = $this->input->post('display_name');
            $user_data['description'] = $this->input->post('description');
            $user_data['status'] = $this->input->post('status');
            
            $this->permission->add($user_data);
            
            $this->load->view('header', $data);
            $this->load->view('success_permissions');
        }
    }
    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Update permission information';
        //print_r($data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('display_name', 'display_name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        

        if ($this->form_validation->run() === FALSE)
        {
            
            $data["permission"] = $this->permission->find($id);
            
            $this->load->view('header', $data);
            $this->load->view('edit_permissions',$data);
            
            
        }
        else
        {
            
            $user_data['id'] = $id;
            $user_data['name'] = $this->input->post('name');
            $user_data['display_name'] = $this->input->post('display_name');
            $user_data['description'] = $this->input->post('description');
            $user_data['status'] = $this->input->post('status');
            
            $this->permission->edit($user_data);
            $this->load->view('header', $data);
            $this->load->view('success_permissions',$data);
            
        }
    }
     
}
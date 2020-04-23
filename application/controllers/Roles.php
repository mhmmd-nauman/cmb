<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller
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
        $this->load->helper('url_helper');
        $this->load->model('permission');
        $this->load->library('auth');
        if(empty($this->auth->userID())){
            redirect("/login");
        }
        
    }

   
    
    public function index()
    {
        
        $data['role'] = $this->role->all();
        foreach($data['role'] as $role){
            $permissions_data[$role->id]=$this->role->roleWisePermissionDetails($role->id);
        }
        //print_r($permissions_data);
        $data['permissions_data'] = $permissions_data;
        //print_r($data['role']);
        $this->load->view('header', $data);
        $this->load->view('role',$data);
       
    }
    public function create()
    {
        // this will be latter updated to handle permissions
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Enter role information';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('display_name', 'display_name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
       
       
        
        if ($this->form_validation->run() === FALSE)
        {
            
            
            $this->load->view('header', $data);
            $this->load->view('create_roles',$data);
            

        }
        else
        {
            $user_data['name'] = $this->input->post('name');
            $user_data['display_name'] = $this->input->post('display_name');
            $user_data['description'] = $this->input->post('description');
            $user_data['status'] = $this->input->post('status');
            
            $this->role->add($user_data);
            
            $this->load->view('header', $data);
            $this->load->view('success_roles');
        }
    }
    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Update role information';
        //print_r($data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('display_name', 'display_name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        

        if ($this->form_validation->run() === FALSE)
        {
            
            $data["role"] = $this->role->find($id);
            
            $this->load->view('header', $data);
            $this->load->view('edit_roles',$data);
            
            
        }
        else
        {
            
            $user_data['id'] = $id;
            $user_data['name'] = $this->input->post('name');
            $user_data['display_name'] = $this->input->post('display_name');
            $user_data['description'] = $this->input->post('description');
            $user_data['status'] = $this->input->post('status');
            
            $this->role->edit($user_data);
            $this->load->view('header', $data);
            $this->load->view('success_roles',$data);
            
        }
    }
    public function allowed_permissions($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['permissions'] = $this->permission->all();
        //print_r($data['permissions']);
        $controller = array();
       
        foreach($data['permissions'] as $permissions){
            $permission_data = explode("-", $permissions->name);
            $controller[$permission_data[1]][$permission_data[0]] = $permissions->id;
            
        }
       // print_r($controller);
       
        $data['controller'] = $controller;
        
        $data['title'] = 'Manage role permissions';
        //print_r($data);
        $this->form_validation->set_rules('action', 'Actions', 'required');
        
        $existing_permissions = array();
        $permissions_data = $this->role->roleWisePermissionDetails($id);
        foreach($permissions_data as $permissions_row){
            $existing_permissions[] = $permissions_row->id;
        }

        if ($this->form_validation->run() === FALSE)
        {
            
            $data["role"] = $this->role->find($id);
            
            $data["existing_permissions"] = $existing_permissions;
            $this->load->view('header', $data);
            $this->load->view('edit_roles_permissions',$data);
            
            
        }
        else
        {
            
            $user_data['id'] = $id;
            $user_data['actions'] = $this->input->post('actions');
            //print_r($user_data['actions']);
            $new_permissions = array();
            foreach((array)$user_data['actions'] as $controller_name => $actions){
               // print_r($actions);
                foreach($actions as $permission_id){
                    $new_permissions[] = $permission_id;
                    if(!in_array($permission_id, $existing_permissions)){
                        $this->role->addPermissions($id, $permission_id); 
                    }
                }
            }
            // remove permissions that was unchecked
            foreach($existing_permissions as $permission_id){
                if(!in_array($permission_id, $new_permissions)){
                        $this->role->deletePermission($id, $permission_id); 
                    }
            }
           // $this->role->edit($user_data);
            $this->index();
            
        }
    }
     
}
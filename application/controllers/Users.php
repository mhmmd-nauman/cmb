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
        
        $this->load->model('user');
        $this->load->model('role');
        $this->load->helper('url_helper');
        $this->load->model('department_model');
        $this->load->library('auth');
        $user_permissions=$this->auth->userPermissions();
        if(!in_array('admin-admin', $user_permissions)){
            $this->auth->route_access();
        }
        
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
    public function password_check($oldpass)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $id = $this->auth->userID();
        $user = $this->user->find($id);
      //  echo $id;
       // echo $oldpass;
       // echo $user->password;
       // echo "<br>";
       // echo password_hash($oldpass, PASSWORD_BCRYPT);
       
        if( password_verify($oldpass, $user->password)) {
            $this->form_validation->set_message('password_check', 'The {field} does not match');
            return false;
        }

        return true;
    }
    public function changepassword($id=0){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Change password';

       // $this->form_validation->set_rules('oldpassword', 'Old Password', 'callback_password_check');
       // $this->form_validation->set_rules('deptID', 'deptID', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
       // $this->form_validation->set_rules('password', 'password', 'required');
        
        
        $oldpassword = $this->input->post('oldpassword');
       // $user_data['deptID'] = $this->input->post('deptID');
        $user_data['password'] = $this->input->post('password');
       $confirmpassword = $this->input->post('confirmpassword');
       // $user_data['password'] = $this->input->post('password');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() === FALSE )
        {
            //$data['departments'] = $this->department_model->all();
            
            
           // $data['users'] = $this->user->all();
            
            $data['id'] = $id;
            $this->load->view('header', $data);
            $this->load->view('change_password',$data);
            

        }
        else
        {
            if(empty($id)){
                $user_data['id'] = $this->auth->userID();
            }else{
                $user_roles = $this->user->userWiseRoles($this->auth->userID());
               // print_r($user_roles);
                if(in_array("1", $user_roles)){
                    $user_data['id'] = $id;
                }else{
                    exit();
                }
            }
            $this->user->edit($user_data);
            
            $this->load->view('header', $data);
            $this->load->view('success_change_password');
        }
       // exit();
       // $csvFile = fopen("users.csv", 'r');
       // while(($line = fgetcsv($csvFile)) !== FALSE){
            //print_r($line);
       //     $user_data['id'] = $line[0];
       //     $password = $line[5];
       //     $user_data["password"] = password_hash($password, PASSWORD_BCRYPT);
       //     $this->user->edit($user_data);
           // break;
       // }
        
    }
    public function index()
    {
        if(in_array('admin-admin', $this->auth->userPermissions())){
            $data['users'] = $this->user->all();
        }else{
            $data['users'] = $this->user->find_all_children_by_parent($this->session->userdata['userID']);
        }
        $data['users_parents'] = $this->user->find_all_parents();
        $user_parents_data = array();
        $user_parents_data[0]="No Parent";
        foreach($data['users_parents'] as $parent){
            $user_parents_data[$parent->id] = $parent->name;
        }
        $data['user_parents_data'] = $user_parents_data;
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
        //print_r($this->auth->userPermissions());
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

        $data['title'] = 'Enter login information';

        $this->form_validation->set_rules('email', 'Email', 'required');
       // $this->form_validation->set_rules('deptID', 'deptID', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        
        
        $user_data['email'] = $this->input->post('email');
        $user_data['parent_id'] = $this->input->post('parent_id');
        $user_data['name'] = $this->input->post('name');
        $user_data['username'] = $this->input->post('username');
        $user_data['password'] = $this->input->post('password');
        
        if ($this->form_validation->run() === FALSE)
        {
            $data['roles'] = $this->role->all();
            // get all roles
            
            $data['users'] = $this->user->find_all_parents();
            $this->load->view('header', $data);
            $this->load->view('create_users',$data);
            

        }
        else
        {
            $this->user->add($user_data);
            $user_data = $this->user->find_with_email($this->input->post('email'));
           // print_r($user_data);
            $roles = array($this->input->post('role_id')); // 
            
            $this->user->addRoles($user_data->id, $roles);
            $this->load->view('header', $data);
            $this->load->view('success_user');
        }
    }
    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Update login information';
        //print_r($data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Login', 'required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        

        if ($this->form_validation->run() === FALSE)
        {
            //echo "sss".$id;
            $data['users'] = $this->user->find_all_parents();
            $user_roles = $this->user->userWiseRoles($id);
           // print_r($user_roles);
            $data['roles'] = $this->role->all();
            $data["user"] = $this->user->find($id);
            $data["user_roles"] = $user_roles;
            //print_r($data["user_roles"]);
            $this->load->view('header', $data);
            $this->load->view('edit_users',$data);
            
            
        }
        else
        {
            
            $updated_data['id'] = $id;
            $updated_data['name'] = $this->input->post('name');
            $updated_data['email'] = $this->input->post('email');
            $updated_data['username'] = $this->input->post('username');
            $updated_data['parent_id'] = $this->input->post('parent_id');
            // first revoke all roles
            
            $roles = array($this->input->post('role_id')); // 
            $this->user->editRoles($id, $roles);

            $this->user->edit($updated_data);
            $this->load->view('header', $data);
            $this->load->view('success_user',$data);
            
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
<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmb extends CI_Controller
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
        $this->load->model('cmb_model');
        $this->load->helper('url_helper');
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
        //user_id = $this->session->userdata['userID']
        $data['cmbs'] = $this->cmb_model->findby_user($this->session->userdata['userID']);
        $data['title'] = 'CMB';
        
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
        $data['departments'] = $data_dpt;
        if(in_array("1", $this->session->userdata['roles'])){
           $courses = $this->course_model->all();
        }else{
            //print_r($this->session->userdata);
            $courses = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        }
        //$courses = $this->course_model->all();
        $data['courses'] = $courses;
        $data_crt = array();
        foreach($courses as $crt){
            $data_crt[$crt->course_id] = $crt->course_title;
        }
        $data['courses_array'] = $data_crt;
        // we need teacher info
        $users = $this->user->all();
        foreach($users as $usr){
            $data_usr[$usr->id] = $usr->name;
        }
        $data['users_array'] = $data_usr;
        $data['title'] = 'Upload Course Material Bundle';
        //print_r($data);
        
        $this->load->view('header',$data);
        $this->load->view('cmb',$data);
    }
    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
        $data['departments'] = $data_dpt;
        if(in_array("1", $this->session->userdata['roles'])){
           $courses = $this->course_model->all();
        }else{
            //print_r($this->session->userdata);
            $courses = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        }
        $data['courses'] = $courses;
        
        $data['title'] = 'Upload Revised Course Material Bundle';
        //print_r($data);
        $this->form_validation->set_rules('cmb_title', 'Teacher', 'required');
        $this->form_validation->set_rules('course_id', 'course_id', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            //$data['departments'] = $this->department_model->all();
            $data["cmb"] = $this->cmb_model->find($id);
            $this->load->view('header', $data);
            $this->load->view('edit_cmb',$data);
            
            
        }
        else
        {
            
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'zip|rar';
            $config['max_size']             = 0;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('userfile'))
            {
                    $type=explode("/", $this->input->post('file_type'));
                    $updated_data['cmb_id'] = $id;
                    $updated_data['cmb_title'] = $this->input->post('cmb_title').".".$type[1];
                    $updated_data['course_id'] = $this->input->post('course_id');
                    $this->cmb_model->edit($updated_data);
                    $this->load->view('header', $data);
                    $this->load->view('success_cmb',$data);
            }
            else
            {
                    $data_upload = array('upload_data' => $this->upload->data());
                    // $this->input->post('cmb_title')
                    $file_name = "uploads/".$this->input->post('course_id')."-".time()."-".$this->input->post('cmb_title').$data_upload['upload_data']['file_ext'];
                    rename( "./uploads/".$data_upload['upload_data']['file_name'], "./".$file_name);
                    //print_r($data_upload);
                    $updated_data['cmb_id'] = $id;
                    $updated_data['cmb_title'] = $this->input->post('cmb_title').$data_upload['upload_data']['file_ext'];
                    $updated_data['file_type'] = $data_upload['upload_data']['file_type'];
                    $updated_data['user_id'] = $this->session->userdata['userID'];
                    $updated_data['course_id'] = $this->input->post('course_id');
                    $updated_data['file_path'] = $file_name;
                    $this->cmb_model->edit($updated_data);
                    $this->load->view('header', $data);
                    $this->load->view('success_cmb', $data);
                    
            }
            
            
            //
            //$this->load->view('header', $data);
           // $this->load->view('success');
        }
    }
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
        $data['departments'] = $data_dpt;
        if(in_array("1", $this->session->userdata['roles'])){
           $courses = $this->course_model->all();
        }else{
            //print_r($this->session->userdata);
            $courses = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        }
        $data['courses'] = $courses;
        
        $data['title'] = 'Upload Course Material Bundle';
        //print_r($data);
        $this->form_validation->set_rules('cmb_title', 'Teacher', 'required');
        $this->form_validation->set_rules('course_id', 'course_id', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            //$data['departments'] = $this->department_model->all();
            
            $this->load->view('header', $data);
            $this->load->view('create_cmb',$data);
            
            
        }
        else
        {
            
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'zip|rar';
            $config['max_size']             = 0;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('userfile'))
            {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    $this->load->view('header', $data);
                    $this->load->view('create_cmb', $error);
            }
            else
            {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $file_name = "uploads/".$this->input->post('course_id')."-".time()."-".$this->input->post('cmb_title').$data_upload['upload_data']['file_ext'];
                    rename( "./uploads/".$data_upload['upload_data']['file_name'], "./".$file_name);
                    //print_r($data_upload);
                    $data_upload['upload_data']['file_path'] = $file_name;
                    $this->cmb_model->set_cmb($data_upload);
                    $this->load->view('header', $data);
                    $this->load->view('success_cmb', $data);
                    
            }
            
            
            //
            //$this->load->view('header', $data);
           // $this->load->view('success');
        }
    }
    
    public function download($id)
    {
        $file=$this->cmb_model->find($id);
        //print_r($file);
       // exit();
        // increament the counter downloaded
       // downloaded
        $this->cmb_model->edit(array("downloaded"=>$file->downloaded+1,"cmb_id"=>$id));
        $this->load->helper('download');
        $data = file_get_contents(base_url($file->file_path));
        redirect(base_url($file->file_path));
        //print($data);
        exit();
        //force_download($file->cmb_title, $data);
        force_download($file->cmb_title, $data);
        
        
       // echo "i need to download ".$id;
    }
}
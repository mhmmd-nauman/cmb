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
        $data['cmbs'] = $this->cmb_model->all();
        $data['title'] = 'CMB';
        
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
        $data['departments'] = $data_dpt;
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
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
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $departments = $this->department_model->all();
        foreach($departments as $dpt){
            $data_dpt[$dpt->department_id] = $dpt->department_title;
        }
        $data['departments'] = $data_dpt;
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        
        $data['title'] = 'Upload Course Material Bundle';
        //print_r($data);
        //$this->form_validation->set_rules('userfile', 'Title', 'required');
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
            $config['allowed_types']        = 'zip|rar|pdf';
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
                    rename( "./uploads/".$data_upload['upload_data']['file_name'], "./uploads/".$this->input->post('course_id')."-".$this->session->userdata['username'].$data_upload['upload_data']['file_ext']);
                    //print_r($data_upload);
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
        // increament the counter downloaded
       // downloaded
        $this->cmb_model->edit(array("downloaded"=>$file->downloaded+1,"cmb_id"=>$id));
        $this->load->helper('download');
        $data = file_get_contents(base_url("./".$file->file_path));
        force_download($file->cmb_title, $data);
        
        
       // echo "i need to download ".$id;
    }
}
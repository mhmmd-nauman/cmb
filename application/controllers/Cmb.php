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
        $this->load->library('auth');
        
        $this->load->model('cmb_model');
        $this->load->helper('url_helper');
        $this->load->model('department_model');
        $this->load->model('course_model');
        $this->load->model('user');
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
    public function search_by_dpt(){
        $data['title'] = 'CMB';
        
        if(in_array('admin-admin', $this->auth->userPermissions()) || in_array("4", $this->session->userdata['roles'])){
            $data['cmbs'] = $this->cmb_model->all();
        }else{
            $data['cmbs'] = $this->cmb_model->findby_user($this->session->userdata['userID']);
        }
        
        
        $this->load->view('header',$data);
        $this->load->view('cmb',$data);
    }
    public function index($searchbydpt="")
    {
        //user_id = $this->session->userdata['userID']
        $data['searched_dpt'] = 0;
        if(in_array('admin-admin', $this->auth->userPermissions()) || in_array("4", $this->session->userdata['roles'])){
            if(empty($searchbydpt)){
               // $data['cmbs'] = $this->cmb_model->all();
                $data['cmbs'] = $this->cmb_model->findby_user(0);
            }else{
                $data['cmbs'] = $this->cmb_model->findby_user($this->input->post('dpt_id'));
                $data['searched_dpt'] = $this->input->post('dpt_id');
            }
        }else{
            $data['cmbs'] = $this->cmb_model->findby_user($this->session->userdata['userID']);
        }
        //$data['cmbs'] = $this->cmb_model->findby_user($this->session->userdata['userID']);
        //print_r($data['cmbs']);
        $data['title'] = 'CMB';
        
        // cmb versions count
        $cmb_version = array();
        $cmb_ratings = array();
        foreach($data['cmbs'] as $cmb_id){
            $cmb_version[$cmb_id->cmb_id] = count($this->cmb_model->findby_versions($this->session->userdata['userID'],$cmb_id->cmb_id));
            $cmb_ratings[$cmb_id->cmb_id] = $this->cmb_model->findby_ratings($cmb_id->cmb_id);
            $cmb_ratings[$cmb_id->cmb_id] = $cmb_ratings[$cmb_id->cmb_id][0];
        }
        //print_r($cmb_version);
        $data['cmb_version'] = $cmb_version;
        $data['cmb_ratings'] = $cmb_ratings;
        
        if(in_array("1", $this->session->userdata['roles']) || in_array("4", $this->session->userdata['roles'])){
           $courses = $this->course_model->all();
        }else{
            //print_r($this->session->userdata);
            $courses = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        }
        $courses = $this->course_model->all();
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
            if(in_array("3", $this->user->userWiseRoles($usr->id))){
                $data_usr_dpt[$usr->id] = $usr->name;
            }
        }
        $data['users_array'] = $data_usr;
        $data['dpts_array'] = $data_usr_dpt;
        //print_r($data_usr_dpt);
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
        
        $this->form_validation->set_rules('major_update', 'major_update', 'required');
        $this->form_validation->set_rules('change_log', 'change_log', 'required');

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
            $config['max_size']             = 104857600;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('userfile'))
            {
                    $type=explode("/", $this->input->post('file_type'));
                    $updated_data['cmb_id'] = $id;
                    $updated_data['cmb_title'] = $this->input->post('cmb_title').".".$type[1];
                    $updated_data['course_id'] = $this->input->post('course_id');
                    $updated_data['change_log'] = $this->input->post('change_log');
                    
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
                    
                    $updated_data['major_update'] = $this->input->post('major_update');
                    $updated_data['change_log'] = $this->input->post('change_log');
                    $updated_data['version_number'] = $this->input->post('version_number');
                    $version_data=explode(".", $updated_data['version_number']);
                    
                    if($updated_data['major_update']){
                        $version_number = $version_data[0]+1;
                        $updated_data['version_number'] = $version_number.".0";
                    }else{
                        $version_number = $version_data[1]+1;
                        $updated_data['version_number'] = $version_data[0].".".$version_number;
                    }
                    // create a revision 
                   // print($updated_data['version_number']);
                   // exit;
                    $current_cmb = $this->cmb_model->find($id);
                    $version_copy = array();
                    $version_copy['cmb_id'] = $id;
                    $version_copy['cmb_title'] = $current_cmb->cmb_title;    
                    $version_copy['deptID'] = $current_cmb->deptID;
                    $version_copy['file_type'] = $current_cmb->file_type;
                    $version_copy['user_id'] = $current_cmb->user_id;
                    
                    $version_copy['course_id'] = $current_cmb->course_id;
                    $version_copy['file_path'] = $current_cmb->file_path;
                    $version_copy['downloaded'] = $current_cmb->downloaded;
                    $version_copy['major_update'] = $current_cmb->major_update;
                    $version_copy['remarks'] = $current_cmb->remarks;
                    
                    $version_copy['version_number'] = $current_cmb->version_number;
                    $version_copy['change_log'] = $current_cmb->change_log;
                    $version_copy['upload_time'] = $current_cmb->upload_time;
         
                    $this->cmb_model->set_cmb_version($version_copy);
                    
                    
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
            $config['max_size']             = 104857600;
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
    public function delete($id){
        // soft delete will deal with it later
        $updated_data['cmb_id'] = $id;
        $updated_data['user_id'] = 2;
        
        $this->cmb_model->edit($updated_data);
        redirect('cmb');
    }
    public function download_revision($id,$file_path)
    {
        $file=$this->cmb_model->findby_versions_filepath($id,$file_path);
       // print_r($file);
       // exit();
        // increament the counter downloaded
       // downloaded
       // $this->cmb_model->edit(array("downloaded"=>$file->downloaded+1,"cmb_id"=>$id));
        $this->load->helper('download');
        $data = file_get_contents(base_url($file->file_path));
        redirect(base_url($file->file_path));
        //print($data);
        exit();
        //force_download($file->cmb_title, $data);
        force_download($file->cmb_title, $data);
        
        
       // echo "i need to download ".$id;
    }
    public function download($id)
    {
        $file=$this->cmb_model->find($id);
        //print_r($file);
       // exit();
        // increament the counter downloaded
       // downloaded
       // $this->cmb_model->edit(array("downloaded"=>$file->downloaded+1,"cmb_id"=>$id));
        $this->load->helper('download');
        $data = file_get_contents(base_url($file->file_path));
        redirect(base_url($file->file_path));
        //print($data);
        exit();
        //force_download($file->cmb_title, $data);
        force_download($file->cmb_title, $data);
        
        
       // echo "i need to download ".$id;
    }
    public function view_revisions($id)
    {
       // $courses = $this->course_model->find_by_dpt($this->session->userdata['userID']);
        
        $courses = $this->course_model->all();
        $data['courses'] = $courses;
        $data_crt = array();
        foreach($courses as $crt){
            $data_crt[$crt->course_id] = $crt->course_title;
        }
        $data['courses_array'] = $data_crt;
        $users = $this->user->all();
        foreach($users as $usr){
            $data_usr[$usr->id] = $usr->name;
        }
        $data['users_array'] = $data_usr;
        
        $data['cmbs_versions'] = $this->cmb_model->findby_versions($this->session->userdata['userID'],$id);
       // print_r($data['cmbs_versions']);
       
        $data['title'] = 'Course Material Bundle Versiosn';
        //print_r($data);
        
        $this->load->view('header',$data);
        $this->load->view('cmb_versions',$data);
    }
    public function edit_ratings($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Remarks & Ratings - Course Material Bundle';
        //print_r($data);
        $this->form_validation->set_rules('ratings', 'Ratings', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');
        
        if ($this->form_validation->run() === FALSE)
        {
            //$data['departments'] = $this->department_model->all();
            $data["cmb"] = $this->cmb_model->findby_ratings($id);
            $data["cmb_data"] = $this->cmb_model->find($id);
            $data["cmb"] = $data["cmb"][0];
            
            $this->load->view('header', $data);
            $this->load->view('edit_cmb_ratings',$data);
            
            
        }
        else
        {
                    $updated_data['cmb_id'] = $id;
                    $updated_data['ratings'] = $this->input->post('ratings');
                    $updated_data['remarks'] = $this->input->post('remarks');
                    $updated_data['user_id'] = $this->session->userdata['userID'];
                    $updated_data['created_at'] = date("Y-m-d h:i:s");
                    $this->cmb_model->edit_cmb_ratings($updated_data);
                    $this->load->view('header', $data);
                    $this->load->view('success_ratings',$data);
            
            
            
            //
            //$this->load->view('header', $data);
           // $this->load->view('success');
        }
    }
}
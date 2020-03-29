<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller
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
        $this->load->model('department_model');
        $this->load->helper('url_helper');
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $data['departments'] = $this->department_model->all();
        $data['title'] = 'Departments';
        $this->load->view('header',$data);
        $this->load->view('department',$data);
    }
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Enter new department information';

        $this->form_validation->set_rules('course_title', 'Title', 'required');
        $this->form_validation->set_rules('deptID', 'deptID', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['departments'] = $this->department_model->all();
            $this->load->view('header', $data);
            $this->load->view('create_department',$data);
            

        }
        else
        {
            $dpt_data[''] = $this->input->post('course_title');
            $this->department_model->add($dpt_data);
            $this->load->view('header', $data);
            $this->load->view('success');
        }
    }
}
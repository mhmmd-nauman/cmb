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
        $this->auth->route_access();
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $data['title'] = 'Course';
        $this->load->view('header',$data);
        $this->load->view('home');
    }
}
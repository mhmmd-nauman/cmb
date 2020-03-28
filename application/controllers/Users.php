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
    }

    /**
     * Display a Dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $data['users'] = $this->user->all();
        $user_roles_data = array();
        foreach($data['users'] as $user){
            //print_r($user->id);
            $user_roles = $this->user->userWiseRoles($user->id);
            //print_r($user_roles);
            foreach($user_roles as $role){
                $user_roles_data[$user->id][]=$this->role->find($role)->display_name;
            }
        }
       // print_r($user_roles[1]);
        $data['user_roles'] = $user_roles_data;
        $data['title'] = 'Users';
        $this->load->view('header',$data);
        $this->load->view('user',$data);
    }
}
<?php
/**
 * Author: Firoz Ahmad Likhon <likh.deshi@gmail.com>
 * Website: https://github.com/firoz-ahmad-likhon
 *
 * Copyright (c) 2018 Firoz Ahmad Likhon
 * Released under the MIT license
 *       ___            ___  ___    __    ___      ___  ___________  ___      ___
 *      /  /           /  / /  /  _/ /   /  /     /  / / _______  / /   \    /  /
 *     /  /           /  / /  /_ / /    /  /_____/  / / /      / / /     \  /  /
 *    /  /           /  / /   __|      /   _____   / / /      / / /  / \  \/  /
 *   /  /_ _ _ _ _  /  / /  /   \ \   /  /     /  / / /______/ / /  /   \    /
 *  /____________/ /__/ /__/     \_\ /__/     /__/ /__________/ /__/     /__/
 * Likhon the hackman, who claims himself as a hacker but really he isn't.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a library
    | to conveniently provide its functionality to your applications.
    |
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['auth', 'form_validation']);
        $this->load->helper('captcha');
        
    }

    /**
     * handle the login.
     */
    public function index()
    {
        if($this->auth->userID()>0){
            redirect("/home");
        }
        //echo password_hash("1234", PASSWORD_BCRYPT);
        // check if there is remember me cookie
        //ECHO "dd";
        //$cookieData = get_cookie("login_data");
        //PRINT_R($cookieData);
        
        
        
       // print_r($cookieData);
        //if(isset($cookieData)){
           //print_r($cookieData); 
       //}
        
        $data = array();
        $this->db->insert('visits', array("ip"=>$_SERVER['REMOTE_ADDR'],"visit_date"=>date("Y-m-d h:i:s")));
        if($_POST) {
            $data = $this->auth->login($_POST);
        }
        $vals = array(
               // 'word'          => 'Random word',
                'img_path'      => './captcha/',
                'img_url'       => base_url().'captcha/',
                'font_path'     => '/ttf/DejaVuSansMono-Bold.ttf',
                'img_width'     => '150',
                'img_height'    => 40,
                'expiration'    => 7200,
                'word_length'   => 4,
                'font_size'     => 40,
                'img_id'        => 'Imageid',
                'pool'          => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',

                // White background and border, black text and red grid
                'colors'        => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(255, 40, 40)
                )
        );

        $cap = create_captcha($vals);
        $data = array(
        'captcha_time'  => $cap['time'],
        'ip_address'    => $this->input->ip_address(),
        'word'          => $cap['word']
        );
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        $data['captcha_image'] = $cap['image'];
        return $this->auth->showLoginForm($data);
    }

    /**
     * Logout.
     */
    public function logout()
    {
        if($this->auth->logout())
            return redirect('login');

        return false;
    }
}

<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmb_model extends CI_Model
{
    /**
     * Course constructor.
     */
    public function __construct()
    {
		
        parent::__construct();
		$this->load->database();
    }

    /**
     * Find data.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->db->get_where("cmb", array("cmb_id" => $id))->row(0);
    }

    /**
     * Find all data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->db->get_where("cmb")->result();
		//$query = $this->db->get_where('courses');
        //return $query->row_array();
    }

    /**
     * Insert data.
     *
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        

        return $this->db->insert('cmb', $data);
    }

    /**
     * Edit data.
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->update('cmb', $data, array('cmb_id' => $data['cmb_id']));
    }

    /**
     * Delete data.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        

        return $this->find($id) ? $this->db->update('cmb', $data, array('cmb_id' => $id)) : 0;
    }
    public function set_cmb($data_upload)
    {
        $this->load->helper('url');

        

        $data = array(
            'cmb_title' => $this->session->userdata['username'],
            'deptID' => 0,
            'file_type'=>$data_upload['upload_data']['file_type'],
            'user_id' => $this->session->userdata['userID'],
            'course_id' => $this->input->post('course_id'),
            'file_path' => "uploads/".$this->input->post('course_id')."-".$this->session->userdata['username'].$data_upload['upload_data']['file_ext']
        );

        return $this->db->insert('cmb', $data);
    }
}
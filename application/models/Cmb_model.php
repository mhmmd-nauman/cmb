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
    public function findby_user($id)
    {
        return $this->db->get_where("cmb", array("user_id" => $id))->result();
    }
    public function findby_versions($user_id,$id)
    {
        return $this->db->get_where("cmb_versions", array("cmb_id" => $id))->result();
    }
    public function findby_versions_filepath($id,$file_path)
    {
       // echo "$id,$file_path";
        $file_path_data=explode("-", $file_path);
        //print_r($file_path_data);
        //return $this->db->like("cmb_versions", array("file_path"=>"uploads/".$file_path))->row(0);
        $this->db->where(" `file_path` LIKE '%".$file_path_data[0]."-".$file_path_data[1]."%'");
        return $this->db->get('cmb_versions')->row(0);
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
            'cmb_title' => $this->input->post('cmb_title').$data_upload['upload_data']['file_ext'],
            'deptID' => 0,
            'file_type'=>$data_upload['upload_data']['file_type'],
            'user_id' => $this->session->userdata['userID'],
            'course_id' => $this->input->post('course_id'),
            'file_path' => $data_upload['upload_data']['file_path']
        );

        return $this->db->insert('cmb', $data);
    }
    public function set_cmb_version($data_upload)
    {
        $data = array(
            'cmb_id' => $data_upload['cmb_id'],
            'cmb_title' => $data_upload['cmb_title'],
            'deptID' => $data_upload['deptID'],
            'file_type' => $data_upload['file_type'],
            'user_id' => $data_upload['user_id'],
            'course_id' => $data_upload['course_id'],
            'file_path' => $data_upload['file_path'],
            'downloaded' => $data_upload['downloaded'],
            'major_update' => $data_upload['major_update'],
            'remarks' => $data_upload['remarks'],
            'version_number' => $data_upload['version_number'],
            'change_log' => $data_upload['change_log'],
            'upload_time' => $data_upload['upload_time']
        );

        return $this->db->insert('cmb_versions', $data);
    }
}
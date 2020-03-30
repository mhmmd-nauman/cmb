<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model
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
        return $this->db->get_where("courses", array("course_id" => $id))->row(0);
    }
    
    public function find_by_dpt($id)
    {
        return $this->db->get_where("courses", array("user_id" => $id))->result();
    }

    /**
     * Find all data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->db->get_where("courses")->result();
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
        

        return $this->db->insert('courses', $data);
    }

    /**
     * Edit data.
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->update('courses', $data, array('course_id' => $data['course_id']));
    }

    /**
     * Delete data.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        

        return $this->find($id) ? $this->db->update('courses', $data, array('course_id' => $id)) : 0;
    }
    public function set_course()
    {
        $this->load->helper('url');

        

        $data = array(
            'course_title' => $this->input->post('course_title'),
            'user_id' => $this->session->userdata['userID']
        );

        return $this->db->insert('courses', $data);
    }
}
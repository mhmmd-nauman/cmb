<?php
/**
 * Author: Muhammad Nauman <mhmmd.nauman@gmail.com>

 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model
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
        return $this->db->get_where("departments", array("department_id" => $id))->row(0);
    }

    /**
     * Find all data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->db->get_where("departments")->result();
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
        

        return $this->db->insert('departments', $data);
    }

    /**
     * Edit data.
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->update('departments', $data, array('department_id' => $data['department_id']));
    }

    /**
     * Delete data.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        

        return $this->find($id) ? $this->db->update('departments', $data, array('department_id' => $id)) : 0;
    }
}
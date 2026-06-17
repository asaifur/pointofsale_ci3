<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

    protected $table = 'contacts';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_all($limit=100)
    {
        return $this->db->order_by('created_at','DESC')->get($this->table, $limit)->result();
    }
}

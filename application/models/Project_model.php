<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
    protected $table = 'projects';
    protected $img_table = 'project_images';

    public function __construct(){ parent::__construct(); }

    public function get_all($limit = 20, $offset = 0)
    {
        $this->db->where('status','published');
        $this->db->order_by('year','DESC');
        return $this->db->get($this->table, $limit, $offset)->result();
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug',$slug)->limit(1)->get($this->table)->row();
    }

    public function get_images($project_id)
    {
        return $this->db->where('project_id',$project_id)->order_by('position','ASC')->get($this->img_table)->result();
    }

    public function search($q, $limit=20)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like('title', $q);
        $this->db->or_like('summary', $q);
        $this->db->or_like('content', $q);
        $this->db->where('status','published');
        return $this->db->get()->result();
    }
}

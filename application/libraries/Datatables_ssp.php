<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatables_ssp
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function get_table($table, $column_order, $column_search, $order, $where = array())
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order, $where);

        if ($_POST['length'] != -1) {
            $this->ci->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->ci->db->get();
        return $query->result();
    }

    private function _get_datatables_query($table, $column_order, $column_search, $order, $where)
    {
        $this->ci->db->from($table);
        if (!empty($where))
            $this->ci->db->where($where);

        $i = 0;
        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->ci->db->group_start();
                    $this->ci->db->like($item, $_POST['search']['value']);
                } else {
                    $this->ci->db->or_like($item, $_POST['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->ci->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->ci->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $this->ci->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_all($table, $where = array())
    {
        $this->ci->db->from($table);
        if (!empty($where))
            $this->ci->db->where($where);
        return $this->ci->db->count_all_results();
    }

    public function count_filtered($table, $column_order, $column_search, $order, $where = array())
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order, $where);
        $query = $this->ci->db->get();
        return $query->num_rows();
    }
}
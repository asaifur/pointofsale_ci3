<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('user')) {
        redirect('auth');
    } else {
        $user = $ci->session->userdata('user');
        $username = $user['username'];
        $uri = $ci->uri->segment(1);
        $admin = $user['role'];
        if ($admin == 0 || $admin == 2) {
            $ci->db->select('*');
            $ci->db->from('menu_pos');
            $ci->db->where('level', 0);
            $ci->db->where('active', '1');
            $ci->db->where('rincian', '0');
        } else {
            $ci->db->select('*, b.modul');
            $ci->db->from('menu_pos a');
            $ci->db->join('master_akses b', 'a.modul=b.modul', 'LEFT');
            $ci->db->where('a.level', 0);
            $ci->db->where('a.active', '1');
            $ci->db->where('a.rincian', '0');
            $ci->db->where('b.userid', $username);
            $ci->db->where('b.del', '0');
        }
        $query = $ci->db->get();
        $sql = $query->num_rows();
        if ($sql < 1) {
            redirect('auth/blocked');
        }
    }



    function check_access($role_id, $menu_id)
    {
        $ci = get_instance();

        $ci->db->where('role_id', $role_id);
        $ci->db->where('menu_id', $menu_id);
        $result = $ci->db->get('user_access_menu');

        if ($result->num_rows() > 0) {
            return "checked='checked'";
        }
    }


}

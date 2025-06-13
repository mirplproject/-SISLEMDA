<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_users() {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('user_roles', 'user_roles.user_id = users.id', 'left');
        $this->db->join('roles', 'user_roles.role_id = roles.id', 'left');
        $this->db->order_by('users.id', 'ASC');
        return $this->db->get()->result();
    }
    public function getUserWithRoles()
{
    $this->db->select('user.id_user, user.nama, role.nama_role');
    $this->db->from('user');
    $this->db->join('user_role', 'user.id_user = user_role.id_user');
    $this->db->join('role', 'user_role.id_role = role.id_role');
    return $this->db->get()->result_array();
}
}
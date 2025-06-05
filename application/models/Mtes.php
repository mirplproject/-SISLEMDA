<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtes extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_film() {
        $query = $this->db->get('tbfilm');
        return $query;
    }

    public function simpan_film($table,$data) {
        $insert=$this->db->insert($table, $data);
        return $insert;
    }

    function edit_film($where,$table)
    {
        return $this->db->get_where($table,$where);
    }

    public function update_film($id_film) {
        $this->db->where('id_film', $id_film);
        $this->db->update('tbfilm');
    }

    public function delete_film($id_film) {
        $this->db->where('id_film', $id_film);
        $this->db->delete('tbfilm');
    }
}
?>
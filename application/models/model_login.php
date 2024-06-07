<?php

class Model_login extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        // $this->load->database();
        // $this->db->select('a.*, b.nm_perusahaan, b.alloc, b.language');
        // $this->db->from('ref_user a');
        // $this->db->join('ref_perusahaan b', ' a.id_perusahaan = b.id_perusahaan', 'left');
        // $this->db->where('a.username', $username);
        // $str = do_hash($password, 'md5');
        // $this->db->where('a.password', $str);
        // $this->db->where('a.active', 1);
        // $this->db->limit(1);


        $this->db->select('a.id_user, a.nm_user, a.username, a.id_perusahaan,a.id_bu,d.nm_bu, a.active, a.cdate, a.cuser, a.developer,a.password, b.nm_perusahaan, b.alloc, b.language, c.id_level');
        $this->db->from('sso.ref_user a');
        $this->db->join('sso.ref_perusahaan b', ' a.id_perusahaan = b.id_perusahaan', 'left');
        $this->db->join('sso.ref_bu d', ' a.id_bu = d.id_bu', 'left');
        $this->db->join('sso.ref_user_aplikasi c', ' a.id_user = c.id_user', 'left');
        $this->db->where('a.username', $username);
        $this->db->where('c.kd_aplikasi', 'eanggaran');
        $str = do_hash($password, 'md5');
        $this->db->where('a.password', $str);
        $this->db->where('a.active', 1);
        $this->db->limit(1);


        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $result = $query->result();

            return $result;
        } else {
            return false;
        }
    }
}

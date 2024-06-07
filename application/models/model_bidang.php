<?php
class Model_bidang extends CI_Model
{
	public function getAllbidang($show = null, $start = null, $cari = null)
	{
		$this->db->select("a.id_bidang, a.nm_bidang, a.active");
		$this->db->from("ref_bidang a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.nm_bidang  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_bidang($search = null)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_bidang) as recordsFiltered ");
		$this->db->from("ref_bidang");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->like("nm_bidang ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_bidang) as recordsTotal ");
		$this->db->from("ref_bidang");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllbidangaccess($show = null, $start = null, $cari = null, $id_bidang)
	{
		$this->db->select("a.id_bidang_access, a.id_user, b.nm_user, a.active");
		$this->db->from("ref_bidang_access a");
		$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.id_bidang', $id_bidang);
		$this->db->where("(b.nm_user  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function insert_bidang($data)
	{
		$this->db->insert('ref_bidang', $data);
		return $this->db->insert_id();
	}

	public function insert_bIDANG_access($data)
	{
		$this->db->insert('ref_bidang_access', $data);
		return $this->db->insert_id();
	}

	public function delete_bidang($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bidang', $data['id_bidang']);
		$this->db->update('ref_bidang', array('active' => '2'));
		return $data['id_bidang'];
	}

	public function delete_bidang_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bidang_access', $data['id_bidang_access']);
		$this->db->delete('ref_bidang_access');
		return $data['id_bidang_access'];
	}

	public function update_bidang($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bidang', $data['id_bidang']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_bidang', $data);
		return $data['id_bidang'];
	}

	public function update_bidang_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bidang_access', $data['id_bidang_access']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_bidang_access', $data);
		return $data['id_bidang_access'];
	}

	public function get_bidang_by_id($id_bidang)
	{
		if (empty($id_bidang)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("ref_bidang a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_bidang', $id_bidang);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_bidang_access_by_id($id_bidang_access)
	{
		if (empty($id_bidang_access)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("a.id_bidang_access, a.id_bidang, a.id_user, b.nm_user, a.active");
			$this->db->from("ref_bidang_access a");
			$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_bidang_access', $id_bidang_access);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function combobox_user()
	{
		$this->db->from("sso.ref_user");
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('active', 1);
		return $this->db->get();
	}
}

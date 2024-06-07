<?php
class Model_masa extends CI_Model
{
	public function getAllmasa($show = null, $start = null, $cari = null)
	{
		$this->db->select("a.*");
		$this->db->from("ref_masa a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.nm_masa  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_masa($search = null)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_masa) as recordsFiltered ");
		$this->db->from("ref_masa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->like("nm_masa ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_masa) as recordsTotal ");
		$this->db->from("ref_masa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllmasaaccess($show = null, $start = null, $cari = null, $id_masa)
	{
		$this->db->select("a.id_masa_access, a.id_user, b.nm_user, a.active");
		$this->db->from("ref_masa_access a");
		$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.id_masa', $id_masa);
		$this->db->where("(b.nm_user  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function insert_masa($data)
	{
		$this->db->insert('ref_masa', $data);
		return $this->db->insert_id();
	}

	public function insert_bIDANG_access($data)
	{
		$this->db->insert('ref_masa_access', $data);
		return $this->db->insert_id();
	}

	public function delete_masa($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_masa', $data['id_masa']);
		$this->db->update('ref_masa', array('active' => '2'));
		return $data['id_masa'];
	}

	public function delete_masa_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_masa_access', $data['id_masa_access']);
		$this->db->delete('ref_masa_access');
		return $data['id_masa_access'];
	}

	public function update_masa($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_masa', $data['id_masa']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_masa', $data);
		return $data['id_masa'];
	}

	public function update_masa_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_masa_access', $data['id_masa_access']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_masa_access', $data);
		return $data['id_masa_access'];
	}

	public function get_masa_by_id($id_masa)
	{
		if (empty($id_masa)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("ref_masa a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_masa', $id_masa);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_masa_access_by_id($id_masa_access)
	{
		if (empty($id_masa_access)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("a.id_masa_access, a.id_masa, a.id_user, b.nm_user, a.active");
			$this->db->from("ref_masa_access a");
			$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_masa_access', $id_masa_access);
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

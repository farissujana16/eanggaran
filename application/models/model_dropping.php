<?php
class Model_dropping extends CI_Model
{
	public function getAlldropping($show = null, $start = null, $cari = null, $id_bu, $bulan, $tahun)
	{
		$str = "";

		if ($id_bu != 0) {
			$str .= " and a.id_bu = ".$id_bu."";
		}
		if ($bulan != "" && $tahun != "") {
			$str .= " and a.bulan = '".$bulan."' and a.tahun = ".$tahun."";
		}


		$this->db->select("a.id_permohonan, a.bulan, a.tahun, coalesce(a.total_anggaran, 0) as total_anggaran, b.nm_bu,  a.active, (select COALESCE(sum(nominal_dropping),0) from tr_dropping where id_permohonan = a.id_permohonan and active = 1) as total_dropping");
		$this->db->from("tr_permohonan a");
		$this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(b.nm_bu  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ".$str."");
		$this->db->where("a.approval", 7);
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_dropping($search = null, $id_bu, $bulan, $tahun)
	{

		$str = "";

		if ($id_bu != 0) {
			$str .= " and a.id_bu = ".$id_bu."";
		}
		if ($bulan != "" && $tahun != "") {
			$str .= " and a.bulan = '".$bulan."' and a.tahun = ".$tahun."";
		}


		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan a");
		$this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ".$str."");
		$this->db->where("a.approval", 7);
		$this->db->like("b.nm_bu ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(a.id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ".$str." ");
		$this->db->where("a.approval", 7);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAlldropping_detail($show = null, $start = null, $cari = null, $id_permohonan)
	{

		$this->db->select("a.*");
		$this->db->from("tr_dropping a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.nominal_dropping  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1)");
		$this->db->where("a.id_permohonan", $id_permohonan);
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_dropping_detail($search = null, $id_permohonan)
	{

		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_dropping) as recordsFiltered ");
		$this->db->from("tr_dropping a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2'");
		$this->db->where("a.id_permohonan", $id_permohonan);
		$this->db->like("a.nominal_dropping ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(a.id_dropping) as recordsTotal ");
		$this->db->from("tr_dropping a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where("a.id_permohonan", $id_permohonan);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function insert_dropping($data)
	{
		$this->db->insert('tr_dropping', $data);
		return $this->db->insert_id();
	}

	public function insert_dropping_access($data)
	{
		$this->db->insert('ref_dropping_access', $data);
		return $this->db->insert_id();
	}

	public function delete_dropping($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_dropping', $data['id_dropping']);
		$this->db->update('tr_dropping', array('active' => '2'));
		return $data['id_dropping'];
	}

	public function delete_dropping_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_dropping_access', $data['id_dropping_access']);
		$this->db->delete('ref_dropping_access');
		return $data['id_dropping_access'];
	}

	public function update_dropping($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_dropping', $data['id_dropping']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_dropping', $data);
		return $data['id_dropping'];
	}

	public function update_dropping_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_dropping_access', $data['id_dropping_access']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_dropping_access', $data);
		return $data['id_dropping_access'];
	}

	public function get_dropping_by_id($id_dropping)
	{
		if (empty($id_dropping)) {
			return array();
		} else {
			$this->db->select("a.*");
			$this->db->from("tr_dropping a");
			$session = $this->session->userdata('login');
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where("a.active IN (0, 1) ");
			$this->db->where("a.id_dropping", $id_dropping);
			return $this->db->get()->row_array();
		}
	}

	public function get_dropping_access_by_id($id_dropping_access)
	{
		if (empty($id_dropping_access)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("a.id_dropping_access, a.id_dropping, a.id_user, b.nm_user, a.active");
			$this->db->from("ref_dropping_access a");
			$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_dropping_access', $id_dropping_access);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_periode_permohonan($id_bu)
	{
			$session = $this->session->userdata('login');
			$this->db->select("a.bulan, a.tahun");
			$this->db->from("tr_permohonan a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_bu', $id_bu);
			$this->db->where("a.active != '2' ");
			$this->db->where('a.approval', 7);
			return $this->db->get()->result_array();
	}

	public function combobox_user()
	{
		$this->db->from("sso.ref_user");
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('active', 1);
		return $this->db->get();
	}


	public function combobox_bu()
	{
		$this->db->from("sso.ref_bu");
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('active', 1);
		return $this->db->get()->result_array();
	}
}

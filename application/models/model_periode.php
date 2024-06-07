<?php
class Model_periode extends CI_Model
{
	public function getAllperiode($show = null, $start = null, $cari = null)
	{
		$this->db->select("a.*");
		$this->db->from("tr_permohonan a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.bulan  LIKE '%" . $cari . "%' or a.tahun LIKE '%" . $cari . "%') ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_periode($search = null)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->like("(a.bulan  LIKE '%" . $search . "%' or a.tahun LIKE '%" . $search . "%') ");
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(a.id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllperiode_details($show = null, $start = null, $cari = null, $id_periode)
	{
		$this->db->select("a.id_periode_details, a.tanggal, b.nm_periode, a.active");
		$this->db->from("ref_periode_details a");
		$this->db->join("ref_periode b", "a.id_periode = b.id_periode", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.id_periode", $id_periode);
		$this->db->where("(a.tanggal  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_periode_details($search = null, $id_periode)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_periode_details) as recordsFiltered ");
		$this->db->from("ref_periode_details");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("id_periode", $id_periode);
		$this->db->where("active != '2' ");
		$this->db->like("tanggal ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_periode_details) as recordsTotal ");
		$this->db->from("ref_periode_details");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("id_periode", $id_periode);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function insert_periode($data)
	{
		$this->db->insert('tr_permohonan', $data);
		return $this->db->insert_id();
	}

	public function insert_periode_details($data)
	{
		$this->db->insert('tr_permohonan_details', $data);
		return $this->db->insert_id();
	}

	public function delete_periode($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->update('tr_permohonan', array('active' => '2'));
		return $data['id_permohonan'];
	}

	public function delete_periode_details($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan_details', $data['id_permohonan_details']);
		$this->db->update('tr_permohonan', array('active' => '2'));
		return $data['id_permohonan_details'];
	}

	public function update_periode($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan', $data);
		return $data['id_permohonan'];
	}

	public function update_periode_details($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan_details', $data['id_permohonan_details']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_details', $data);
		return $data['id_permohonan'];
	}

	public function get_periode_by_id($id_permohonan)
	{
		if (empty($id_permohonan)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("tr_permohonan a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_permohonan', $id_permohonan);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_periode_by_id_details($id_permohonan_details)
	{
		if (empty($id_permohonan_details)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("tr_permohonan_details a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_permohonan_details', $id_permohonan_details);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}
}

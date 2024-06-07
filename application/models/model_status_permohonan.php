<?php
class Model_status_permohonan extends CI_Model
{
	public function getAllstatus_permohonan($show = null, $start = null, $cari = null, $id_bu, $filter)
	{
		$this->db->select("a.*, coalesce((select sum(permohonan_total) from tr_permohonan_dana where id_permohonan = a.id_permohonan and kategori = 2),0) as total");
		$this->db->from("tr_permohonan a");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		if ($filter == 0) {
			$this->db->where("a.approval", $filter);
		} else {
			$this->db->where_in("a.approval", [1,2,3,7]);
			// $this->db->or_where("a.approval", 2);
			// $this->db->or_where("a.approval", 3);
		}
		$this->db->where('a.id_bu', $id_bu);
		// $this->db->where("(a.bulan  LIKE '%" . $cari . "%' ) or (a.tahun LIKE '%" . $cari . "%') ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_status_permohonan($search = null, $id_bu, $filter)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		if ($filter == 0) {
			$this->db->where("approval", $filter);
		} else {
			$this->db->where("approval", 1);
			$this->db->or_where("approval", 2);
			$this->db->or_where("approval", 3);
		}
		$this->db->where('id_bu', $id_bu);

		$this->db->where("active != '2' ");
		$this->db->like("bulan ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		if ($filter == 0) {
			$this->db->where("approval", $filter);
		} else {
			$this->db->where("approval", 1);
			$this->db->or_where("approval", 2);
			$this->db->or_where("approval", 3);
		}
		$this->db->where('id_bu', $id_bu);

		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}


	public function getAllstatus_permohonan_details($show = null, $start = null, $cari = null, $approve, $id_periode, $id_bu, $kategori)
	{
		$session = $this->session->userdata('login');
		if ($cari != null) {
			$find = "and t.kd_coa like '%" . $cari . "%'";
		}

		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT sum(a.permohonan_1) from tr_permohonan_dana a where a.id_bu = " . $id_bu . " and a.id_permohonan = " . $id_periode . " and a.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_1,
			COALESCE((SELECT sum(b.permohonan_2) from tr_permohonan_dana b where b.id_bu = " . $id_bu . " and b.id_permohonan = " . $id_periode . " and b.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_2,
			COALESCE((SELECT sum(c.permohonan_3) from tr_permohonan_dana c where c.id_bu = " . $id_bu . " and c.id_permohonan = " . $id_periode . " and c.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_3,
			COALESCE((SELECT sum(d.permohonan_total) from tr_permohonan_dana d where d.id_bu = " . $id_bu . " and d.id_permohonan = " . $id_periode . " and d.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_total
			from(SELECT y.id_coa, y.kd_coa, x.nm_bidang, y.nm_coa, y.id_bidang from ref_coa y left join ref_bidang x on y.id_bidang = x.id_bidang where y.jenis in(0,1) and y.parent = 1 and y.active = 1 and y.kategori = ".$kategori.")z
			)t order by t.id_bidang, t.kd_coa");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_status_permohonan_details($search = null, $approve, $id_periode, $id_bu, $kategori)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_coa) as recordsFiltered ");
		$this->db->from("ref_coa a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where_in("a.jenis", [0,1]);
		$this->db->where("a.kategori", $kategori);
		$this->db->where("a.parent", 1);
		$this->db->like("a.kd_coa ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_coa) as recordsTotal ");
		$this->db->from("ref_coa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->where_in("jenis", [0,1]);
		$this->db->where("kategori", $kategori);
		$this->db->where("parent", 1);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function update_status_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan', $data);
		return $data['id_permohonan'];
	}


	public function insert_anggaran_log($data)
	{
		$this->db->insert('tr_anggaran_log', $data);
		return $this->db->insert_id();
	}

	public function cek_log($id_bu, $id_permohonan, $approve_level, $id_bidang)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_anggaran_log");
		$this->db->where("id_bu", $id_bu);
		$this->db->where("id_permohonan", $id_permohonan);
		$this->db->where("approve_level", $approve_level);
		$this->db->where("id_bidang", $id_bidang);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		return $this->db->get()->row_array();
	}

	public function update_log($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_anggaran_log', $data['id_anggaran_log']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_anggaran_log', $data);
		return $data['id_anggaran_log'];
	}

	public function delete_status_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_status_permohonan', $data['id_status_permohonan']);
		$this->db->update('tr_status_permohonan', array('active' => '2'));
		return $data['id_status_permohonan'];
	}

	// public function update_status_permohonan($data)
	// {
	// 	$session = $this->session->userdata('login');
	// 	$this->db->where('id_perusahaan', $session['id_perusahaan']);
	// 	$this->db->where('id_permohonan_dana', $data['id_permohonan_dana']);
	// 	$this->db->where("active != '2' ");
	// 	$this->db->update('tr_permohonan_dana', $data);
	// 	return $data['id_permohonan_dana'];
	// }

	public function get_permohonan_by_id($id_permohonan)
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

	public function get_permohonan($id_permohonan)
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

	public function get_permohonan_detail($id_permohonan)
	{
		if (empty($id_permohonan)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("coalesce(sum(a.permohonan_total),0) as total");
			$this->db->from("tr_permohonan_dana a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_permohonan', $id_permohonan);
			$this->db->where('a.kategori', 2);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_permohonan_sum($kd_coa, $id_bu, $id_permohonan)
	{
		$session = $this->session->userdata('login');
		$this->db->select("a.id_permohonan, a.id_bu, b.id_coa, sum(a.permohonan_1) as dana_1, SUM(a.permohonan_2) as dana_2, SUM(a.permohonan_3) as dana_3");
		$this->db->from("tr_permohonan_dana a");
		$this->db->join("ref_coa b", "a.kd_coa = b.kd_coa", "left");
		$this->db->where('a.id_bu', $id_bu);
		$this->db->where('a.id_permohonan', $id_permohonan);
		$this->db->like("a.kd_coa", $kd_coa);
		$this->db->where("a.active != '2' ");
		return $this->db->get()->row_array();
	}

	public function get_data_permohonan($kd_coa, $id_bu, $id_permohonan)
	{
		$session = $this->session->userdata('login');
		$this->db->select("id_permohonan_dana, id_permohonan, id_bu");
		$this->db->from("tr_permohonan_dana");
		$this->db->where("id_bu", $id_bu);
		$this->db->where("id_permohonan", $id_permohonan);
		$this->db->like("kd_coa", $kd_coa);
		return $this->db->get()->result_array();
	}

	public function update_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_dana', $data);
		return $data['id_permohonan'];
	}

	public function combobox_bu()
	{
		$session = $this->session->userdata('login');
		$this->db->select("a.*,b.nm_bu");
		$this->db->from("ref_bu_access a");
		$this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$this->db->where("b.active", 1);
		$this->db->where("a.id_user", $session['id_user']);
		$this->db->where("b.id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}
}

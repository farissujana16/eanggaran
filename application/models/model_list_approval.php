<?php
class Model_list_approval extends CI_Model
{
	public function getAlllist_approval($show = null, $start = null, $cari = null, $id_bu, $filter)
	{
		$this->db->select("a.*, coalesce((select sum(permohonan_total) from tr_permohonan_dana where id_permohonan = a.id_permohonan and kategori = 2),0) as total");
		$this->db->from("tr_permohonan a");
		$this->db->where('a.id_bu', $id_bu);
		if ($filter == 1) {
			$this->db->where("a.approval", $filter);
		}else{
			$this->db->where_in("a.approval",[2,3,4,7]);
		}
		// $this->db->where('a.approval != ', 0);
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active IN (0, 1) ");
		$this->db->like('a.bulan', $cari);
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_list_approval($search = null, $id_bu, $filter)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bu', $id_bu);
		if ($filter == 1) {
			$this->db->where("approval", $filter);
		}else{
			$this->db->where_in("approval",[2,3,4,7]);
		}
		// $this->db->where('approval != ', 0);
		$this->db->where("active != '2' ");
		$this->db->like('bulan', $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_bu', $id_bu);
		if ($filter == 1) {
			$this->db->where("approval", $filter);
		}else{
			$this->db->where_in("approval",[2,3,4,7]);
		}
		// $this->db->where('approval != ', 0);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAlllist_approval_details($show = null, $start = null, $cari = null, $id_bu, $id_periode, $id_bidang, $kategori)
	{
		$session = $this->session->userdata('login');
		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT sum(a.permohonan_1) from tr_permohonan_dana a where a.id_bu = " . $id_bu . " and a.id_permohonan = " . $id_periode . " and a.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_1,
			COALESCE((SELECT sum(b.permohonan_2) from tr_permohonan_dana b where b.id_bu = " . $id_bu . " and b.id_permohonan = " . $id_periode . " and b.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_2,
			COALESCE((SELECT sum(c.permohonan_3) from tr_permohonan_dana c where c.id_bu = " . $id_bu . " and c.id_permohonan = " . $id_periode . " and c.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_3,
			COALESCE((SELECT sum(d.permohonan_total) from tr_permohonan_dana d where d.id_bu = " . $id_bu . " and d.id_permohonan = " . $id_periode . " and d.kd_coa like CONCAT(z.kd_coa,'%')),'0') as permohonan_total

			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis in(0,1) and y.parent = 1 and y.active = 1 and y.kategori = ".$kategori.")z
			)t where t.id_bidang = " . $id_bidang . "");

		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_list_approval_details($search = null, $id_bu, $id_periode, $id_bidang, $kategori)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_coa) as recordsFiltered ");
		$this->db->from("ref_coa a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where_in("jenis", [0,1]);
		$this->db->where("a.parent", 1);
		$this->db->where("a.id_bidang", $id_bidang);
		$this->db->where("a.kategori", $kategori);
		$this->db->like("a.kd_coa ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_coa) as recordsTotal ");
		$this->db->from("ref_coa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->where_in("jenis", [0,1]);
		$this->db->where("parent", 1);
		$this->db->where("id_bidang", $id_bidang);
		$this->db->where("kategori", $kategori);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
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

	public function get_permohonan_bidang($id_permohonan)
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

	public function update_list_approval($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan', $data);

		$this->db->from("tr_permohonan");
		$this->db->where("id_permohonan", $data['id_permohonan']);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		return $this->db->get()->result_array();
		// return $data['id_permohonan'];
	}


	public function get_anggaran_data($id_anggaran)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_anggaran");
		$this->db->where("id_anggaran", $id_anggaran);
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);

		return $this->db->get()->row_array();
	}

	public function combobox_bu()
	{
		$session = $this->session->userdata('login');
		$this->db->from("sso.ref_bu");
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		return $this->db->get()->result_array();
	}

	public function combobox_bidang()
	{
		$session = $this->session->userdata('login');
		$this->db->select("a.*,b.nm_bidang");
		$this->db->from("ref_bidang_access a");
		$this->db->join("ref_bidang b", "a.id_bidang = b.id_bidang", "left");
		$this->db->where("b.active", 1);
		$this->db->where("a.id_user", $session['id_user']);
		$this->db->where("b.id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}

	public function insert_anggaran_log($data)
	{
		$this->db->insert('tr_anggaran_log', $data);
		return $this->db->insert_id();
	}

	public function cek_log($id_bu, $id_permohonan, $approval_level, $id_bidang)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_anggaran_log");
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->where("id_bu", $id_bu);
		$this->db->where("id_permohonan", $id_permohonan);
		$this->db->where("approve_level", $approval_level);
		$this->db->where("id_bidang", $id_bidang);
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

	public function update_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where('id_bidang', $data['id_bidang']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_dana', $data);
		return $data['id_permohonan'];
	}

	public function update_approval_dana($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan', $data);
		return $data['id_permohonan'];
	}

	public function update_permohonan_keuangan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_dana', $data);
		return $data['id_permohonan'];
	}

	public function cek_permohonan($id_permohonan)
	{
		$session = $this->session->userdata('login');
		$this->db->select("*");
		$this->db->from("tr_permohonan");
		$this->db->where('id_permohonan', $id_permohonan);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
	}








	public function insert_divre($data)
	{
		$this->db->insert('ref_divre', $data);
		return $this->db->insert_id();
	}

	public function delete_divre($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_divre', $data['id_divre']);
		$this->db->update('ref_divre', array('active' => '2'));
		return $data['id_divre'];
	}

	public function update_divre($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_divre', $data['id_divre']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_divre', $data);
		return $data['id_divre'];
	}

	public function get_divre_by_id($id_divre)
	{
		if (empty($id_divre)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("ref_divre a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_divre', $id_divre);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}
}

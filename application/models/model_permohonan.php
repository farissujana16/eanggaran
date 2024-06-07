<?php
class Model_permohonan extends CI_Model
{
	public function getAllpermohonan($show = null, $start = null, $cari = null, $bu)
	{
		$this->db->select("a.*, coalesce((select sum(permohonan_total) from tr_permohonan_dana where id_permohonan = a.id_permohonan and kategori = 2),0) as pendapatan");
		$this->db->from("tr_permohonan a");
		$this->db->where("a.id_bu", $bu);
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		// $this->db->where("(a.bulan  LIKE '%" . $cari . "%' ) or (a.tahun LIKE '%" . $cari . "%') ");
		$this->db->like("a.bulan", $cari);
		$this->db->where("a.active IN (0, 1) ");
		$this->db->order_by("a.id_permohonan asc");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_permohonan($search = null, $bu)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_bu', $bu);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->like("bulan ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_bu', $bu);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllpermohonan_details($show = null, $start = null, $cari = null, $id_permohonan)
	{
		$this->db->select("a.id_permohonan_masa, a.id_periode ,b.nm_periode, a.active");
		$this->db->from("tr_permohonan_masa a");
		$this->db->join("ref_periode b", "a.id_periode = b.id_periode", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(b.nm_periode  LIKE '%" . $cari . "%' )");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_permohonan_details($search = null, $id_permohonan)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan_masa a");
		$this->db->join("ref_periode b", "a.id_periode = b.id_periode", "left");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->like("b.nm_periode ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan_masa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllpermohonan_request($show = null, $start = null, $cari = null, $id_permohonan, $bidang, $id_bu, $kategori)
	{
		$session = $this->session->userdata('login');

		if ($session['id_level'] == 14) {
			$filter = "and y.id_bidang ='" . $bidang . "'";
		} else {
			$filter = "and y.id_bidang ='" . $bidang . "'";
		}

		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT a.id_permohonan_dana from tr_permohonan_dana a where a.id_coa = z.id_coa and a.id_bu = " . $id_bu . " and a.id_permohonan = " . $id_permohonan . "),'0') as id_permohonan_dana,
			COALESCE((SELECT d.id_permohonan from tr_permohonan_dana d where d.id_coa = z.id_coa and d.id_bu = " . $id_bu . " and d.id_permohonan = " . $id_permohonan . "),'0') as id_permohonan,
			COALESCE((SELECT e.id_bu from tr_permohonan_dana e where e.id_coa = z.id_coa and e.id_bu = " . $id_bu . " and e.id_permohonan = " . $id_permohonan . "),'0') as id_bu,
			COALESCE((SELECT b.permohonan_1 from tr_permohonan_dana b where b.id_coa = z.id_coa and b.id_bu = " . $id_bu . " and b.id_permohonan = " . $id_permohonan . "),'0') as permohonan_1,
			COALESCE((SELECT f.permohonan_2 from tr_permohonan_dana f where f.id_coa = z.id_coa and f.id_bu = " . $id_bu . " and f.id_permohonan = " . $id_permohonan . "),'0') as permohonan_2,
			COALESCE((SELECT g.permohonan_3 from tr_permohonan_dana g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = " . $id_permohonan . "),'0') as permohonan_3,
			COALESCE((SELECT g.permohonan_total from tr_permohonan_dana g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = " . $id_permohonan . "),'0') as permohonan_total,
			COALESCE((SELECT h.approval from tr_permohonan_dana h where h.id_coa = z.id_coa and h.id_bu = " . $id_bu . " and h.id_permohonan = " . $id_permohonan . "),'0') as approval
			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis = 0 " . $filter . " and y.active = 1 and y.kategori = ".$kategori.")z
		)t
		where t.id_permohonan = " . $id_permohonan . " or t.id_permohonan = 0");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_permohonan_request($search = null, $id_permohonan, $bidang, $id_bu, $kategori)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_coa) as recordsFiltered ");
		$this->db->from("ref_coa a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where("a.id_bidang", $bidang);
		$this->db->where("a.jenis", 0);
		$this->db->like("a.nm_coa ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_coa) as recordsTotal ");
		$this->db->from("ref_coa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->where("id_bidang", $bidang);
		$this->db->where("jenis", 0);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}


	public function getAllpermohonan_realisasi($show = null, $start = null, $cari = null, $id_permohonan, $bidang, $id_bu)
	{
		$session = $this->session->userdata('login');

		if ($session['id_level'] == 14) {
			$filter = "and y.id_bidang ='" . $bidang . "'";
		} else {
			$filter = "and y.id_bidang ='" . $bidang . "'";
		}

		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT a.id_permohonan_dana from tr_permohonan_dana a where a.id_coa = z.id_coa and a.id_bu = " . $id_bu . " and a.id_permohonan = ".$id_permohonan."),'0') as id_permohonan_dana,
			COALESCE((SELECT d.id_permohonan from tr_permohonan_dana d where d.id_coa = z.id_coa and d.id_bu = " . $id_bu . " and d.id_permohonan = ".$id_permohonan."),'0') as id_permohonan,
			COALESCE((SELECT e.id_bu from tr_permohonan_dana e where e.id_coa = z.id_coa and e.id_bu = " . $id_bu . " and e.id_permohonan = ".$id_permohonan."),'0') as id_bu,
			COALESCE((SELECT b.permohonan_1 from tr_permohonan_dana b where b.id_coa = z.id_coa and b.id_bu = " . $id_bu . " and b.id_permohonan = ".$id_permohonan."),'0') as permohonan_1,
			COALESCE((SELECT f.permohonan_2 from tr_permohonan_dana f where f.id_coa = z.id_coa and f.id_bu = " . $id_bu . " and f.id_permohonan = ".$id_permohonan."),'0') as permohonan_2,
			COALESCE((SELECT g.permohonan_3 from tr_permohonan_dana g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = ".$id_permohonan."),'0') as permohonan_3,
			COALESCE((SELECT g.permohonan_total from tr_permohonan_dana g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = ".$id_permohonan."),'0') as permohonan_total,
			COALESCE((SELECT aa.realisasi_1 from tr_permohonan_dana aa where aa.id_coa = z.id_coa and aa.id_bu = " . $id_bu . " and aa.id_permohonan = ".$id_permohonan."),'0') as realisasi_1,
			COALESCE((SELECT bb.realisasi_2 from tr_permohonan_dana bb where bb.id_coa = z.id_coa and bb.id_bu = " . $id_bu . " and bb.id_permohonan = ".$id_permohonan."),'0') as realisasi_2,
			COALESCE((SELECT cc.realisasi_3 from tr_permohonan_dana cc where cc.id_coa = z.id_coa and cc.id_bu = " . $id_bu . " and cc.id_permohonan = ".$id_permohonan."),'0') as realisasi_3,
			COALESCE((SELECT cc.realisasi_total from tr_permohonan_dana cc where cc.id_coa = z.id_coa and cc.id_bu = " . $id_bu . " and cc.id_permohonan = ".$id_permohonan."),'0') as realisasi_total,
			COALESCE((SELECT h.approval from tr_permohonan_dana h where h.id_coa = z.id_coa and h.id_bu = " . $id_bu . " and h.id_permohonan = ".$id_permohonan."),'0') as approval
			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis = 0 " . $filter . " and y.active = 1)z
		)t
		where t.id_permohonan = " . $id_permohonan . " or t.id_permohonan = 0");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_permohonan_realisasi($search = null, $id_permohonan, $bidang, $id_bu)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_coa) as recordsFiltered ");
		$this->db->from("ref_coa a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where("a.id_bidang", $bidang);
		$this->db->where("a.jenis", 0);
		$this->db->like("a.nm_coa ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_coa) as recordsTotal ");
		$this->db->from("ref_coa");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->where("id_bidang", $bidang);
		$this->db->where("jenis", 0);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function insert_permohonan($data)
	{
		$this->db->insert('tr_permohonan', $data);
		return $this->db->insert_id();
	}

	public function insert_permohonan_log($data)
	{
		$this->db->insert('tr_permohonan_log', $data);
		return $this->db->insert_id();
	}

	public function delete_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->update('tr_permohonan', array('active' => '2'));
		return $data['id_permohonan'];
	}

	public function update_permohonan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan', $data);
		return $data['id_permohonan'];
	}


	public function update_permohonan_rincian($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_dana', $data);
		return $data['id_permohonan'];
	}

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

	public function get_permohonan_dana_by_id($id_permohonan_dana)
	{
		if (empty($id_permohonan_dana)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("id_permohonan_dana, id_permohonan, id_coa, COALESCE(permohonan_1,0) as permohonan_1, 
								COALESCE(permohonan_2,0) as permohonan_2, COALESCE(permohonan_3,0) as permohonan_3,
								COALESCE(realisasi_1,0) as realisasi_1, COALESCE(realisasi_2,0) as realisasi_2, COALESCE(realisasi_3,0) as realisasi_3,
								approval,active, id_perusahaan");
			$this->db->from("tr_permohonan_dana");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where('id_permohonan_dana', $id_permohonan_dana);
			$this->db->where("active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_periode()
	{

		$session = $this->session->userdata('login');
		$this->db->from("ref_periode a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		return $this->db->get()->result_array();
	}

	public function insert_permohonan_masa($data)
	{
		$this->db->insert('tr_permohonan_masa', $data);
		return $this->db->insert_id();
	}

	public function get_permohonan($id_permohonan)
	{

		$session = $this->session->userdata('login');
		$this->db->from("tr_permohonan a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where("a.id_permohonan", $id_permohonan);
		return $this->db->get()->row_array();
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

	public function get_realisasi_dana($id_permohonan)
	{
		$session = $this->session->userdata('login');
		$this->db->select("nm_bidang, coalesce((sum(realisasi_1) + sum(realisasi_2) + sum(realisasi_3)),0) as beban");
		$this->db->from("tr_permohonan_dana");
		$this->db->where("id_permohonan", $id_permohonan);
		$this->db->where("active", 1);
		$this->db->where("approval", 1);
		$this->db->where("kategori", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->group_by("nm_bidang");
		$this->db->order_by("id_bidang", "asc");

		return $this->db->get()->result_array();
	}

	public function get_realisasi_dana_pendapatan($id_permohonan)
	{
		$session = $this->session->userdata('login');
		$this->db->select("nm_bidang, coalesce((sum(realisasi_1) + sum(realisasi_2) + sum(realisasi_3)),0) as beban");
		$this->db->from("tr_permohonan_dana");
		$this->db->where("id_permohonan", $id_permohonan);
		$this->db->where("active", 1);
		$this->db->where("approval", 1);
		$this->db->where("kategori", 2);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->group_by("nm_bidang");
		$this->db->order_by("id_bidang", "asc");

		return $this->db->get()->row_array();
	}

	public function insert_permohonan_dana($data)
	{
		$this->db->insert('tr_permohonan_dana', $data);
		return $this->db->insert_id();
	}

	public function update_permohonan_dana($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan_dana', $data['id_permohonan_dana']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_dana', $data);
		return $data['id_permohonan_dana'];
	}

	public function update_permohonan_log($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_permohonan_log', $data['id_permohonan_dana']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_permohonan_log', $data);
		return $data['id_permohonan_dana'];
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

	public function combobox_pusat()
	{
		$session = $this->session->userdata('login');
		$this->db->from("sso.ref_bu");
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
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

	public function insert_anggaran_log($data)
	{
		$this->db->insert('tr_anggaran_log', $data);
		return $this->db->insert_id();
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

	public function get_masa($tanggal)
	{
		$session = $this->session->userdata('login');

		$this->db->select("id_masa from ref_masa where ".$tanggal." between tgl_awal and tgl_akhir");

		return $this->db->get()->row_array();
	}
}

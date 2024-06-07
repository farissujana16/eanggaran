<?php
class Model_laporan extends CI_Model
{
	public function getAlllaporan($show = null, $start = null, $cari = null, $id_bu)
	{
		$this->db->select("a.id_permohonan, a.bulan, a.tahun, a.active");
		$this->db->from("tr_permohonan a");
		$this->db->where('id_bu', $id_bu);
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.approval', 7);
		$this->db->where("(a.bulan  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_laporan($search = null, $id_bu)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_permohonan) as recordsFiltered ");
		$this->db->from("tr_permohonan");
		$this->db->where("id_bu", $id_bu);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('approval', 7);
		$this->db->where("active != '2' ");
		$this->db->like("bulan ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_permohonan) as recordsTotal ");
		$this->db->from("tr_permohonan");
		$this->db->where("id_bu", $id_bu);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('approval', 7);
		$this->db->where("active != '2' ");
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}


	public function insert_laporan($data)
	{
		$this->db->insert('ref_laporan', $data);
		return $this->db->insert_id();
	}

	public function delete_laporan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_laporan', $data['id_laporan']);
		$this->db->update('ref_laporan', array('active' => '2'));
		return $data['id_laporan'];
	}


	public function update_laporan($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_laporan', $data['id_laporan']);
		$this->db->where("active != '2' ");
		$this->db->update('ref_laporan', $data);
		return $data['id_laporan'];
	}


	public function get_laporan_by_id($id_laporan)
	{
		if (empty($id_laporan)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("ref_laporan a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_laporan', $id_laporan);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
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

	public function get_bidang()
	{
		$this->db->select("*");
		$this->db->from("ref_bidang");
		$this->db->where("active", 1);
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}

	public function get_coa($id_permohonan, $id_bu)
	{
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
			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis = 0 and y.active = 1)z
		)t
		where t.id_permohonan = " . $id_permohonan . " or t.id_permohonan = 0");

		return $this->db->get()->result_array();
	}

	public function get_coa_perbaikan($id_permohonan, $id_bu)
	{
		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT a.id_permohonan_dana from tr_permohonan_log a where a.id_coa = z.id_coa and a.id_bu = " . $id_bu . " and a.id_permohonan = ".$id_permohonan."),'0') as id_permohonan_dana,
			COALESCE((SELECT d.id_permohonan from tr_permohonan_log d where d.id_coa = z.id_coa and d.id_bu = " . $id_bu . " and d.id_permohonan = ".$id_permohonan."),'0') as id_permohonan,
			COALESCE((SELECT e.id_bu from tr_permohonan_log e where e.id_coa = z.id_coa and e.id_bu = " . $id_bu . " and e.id_permohonan = ".$id_permohonan."),'0') as id_bu,
			COALESCE((SELECT b.permohonan_1 from tr_permohonan_log b where b.id_coa = z.id_coa and b.id_bu = " . $id_bu . " and b.id_permohonan = ".$id_permohonan."),'0') as permohonan_1,
			COALESCE((SELECT f.permohonan_2 from tr_permohonan_log f where f.id_coa = z.id_coa and f.id_bu = " . $id_bu . " and f.id_permohonan = ".$id_permohonan."),'0') as permohonan_2,
			COALESCE((SELECT g.permohonan_3 from tr_permohonan_log g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = ".$id_permohonan."),'0') as permohonan_3,
			COALESCE((SELECT b.perbaikan_1 from tr_permohonan_log b where b.id_coa = z.id_coa and b.id_bu = " . $id_bu . " and b.id_permohonan = ".$id_permohonan."),'0') as perbaikan_1,
			COALESCE((SELECT f.perbaikan_2 from tr_permohonan_log f where f.id_coa = z.id_coa and f.id_bu = " . $id_bu . " and f.id_permohonan = ".$id_permohonan."),'0') as perbaikan_2,
			COALESCE((SELECT g.perbaikan_3 from tr_permohonan_log g where g.id_coa = z.id_coa and g.id_bu = " . $id_bu . " and g.id_permohonan = ".$id_permohonan."),'0') as perbaikan_3
			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis = 0 and y.active = 1)z
		)t
		where t.id_permohonan = " . $id_permohonan . " or t.id_permohonan = 0");

		return $this->db->get()->result_array();
	}

	public function get_coa_resume($id_permohonan, $id_bu)
	{
		$this->db->select("t.* from(
			SELECT z.*,
			COALESCE((SELECT sum(a.permohonan_1) from tr_permohonan_dana a where a.id_bu = " . $id_bu . " and a.id_permohonan = " . $id_permohonan . " and a.kd_coa like CONCAT(z.kd_coa,'%') and a.id_bidang=z.id_bidang),'0') as permohonan_1,
			COALESCE((SELECT sum(b.permohonan_2) from tr_permohonan_dana b where b.id_bu = " . $id_bu . " and b.id_permohonan = " . $id_permohonan . " and b.kd_coa like CONCAT(z.kd_coa,'%') and b.id_bidang=z.id_bidang),'0') as permohonan_2,
			COALESCE((SELECT sum(c.permohonan_3) from tr_permohonan_dana c where c.id_bu = " . $id_bu . " and c.id_permohonan = " . $id_permohonan . " and c.kd_coa like CONCAT(z.kd_coa,'%') and c.id_bidang=z.id_bidang),'0') as permohonan_3,
			COALESCE((SELECT sum(d.permohonan_total) from tr_permohonan_dana d where d.id_bu = " . $id_bu . " and d.id_permohonan = " . $id_permohonan . " and d.kd_coa like CONCAT(z.kd_coa,'%') and d.id_bidang=z.id_bidang),'0') as permohonan_total
			from(SELECT y.id_coa, y.kd_coa, y.nm_coa, y.id_bidang from ref_coa y where y.jenis in(0,1) and y.parent = 1 and y.active = 1 order by y.id_bidang, y.kd_coa)z
			)t");

		return $this->db->get()->result_array();
	}


	public function get_permohonan($id_permohonan, $id_bu)
	{
		$this->db->select("a.*, b.nm_bu");
		$this->db->from("tr_permohonan a");
		$this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$this->db->where("a.id_permohonan", $id_permohonan);
		$this->db->where("a.id_bu", $id_bu);
		$this->db->where("a.active", 1);
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		return $this->db->get()->row_array();
	}

	public function get_permohonan_rincian($id_permohonan, $id_bu)
	{
		$this->db->select("a.bulan, a.tahun, b.nm_bu");
		$this->db->from("tr_permohonan a");
		$this->db->join("sso.ref_bu", "a.id_bu = b.id_bu", "left");
		$this->db->where("a.id_permohonan", $id_permohonan);
		$this->db->where("a.id_bu", $id_bu);
		$this->db->where("a.active", 1);
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->get()->result_array();
	}
}

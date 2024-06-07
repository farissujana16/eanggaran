<?php
class Model_home extends CI_Model
{
	public function UpdateUser($id_user, $data)
	{
		$this->db->where('id_user', $id_user);
		$this->db->update('ref_user', $data);
	}

	public function datapaketchartweek()
	{
		$session = $this->session->userdata('login');
		$get =  $this->db->query("SELECT date(datetime_in) waktu,count(id_logistics) totalpaket
										FROM tr_masuk_logistics
										WHERE origin = " . $this->db->escape($session['id_point']) . " and
										datetime_in >= (CURDATE() - INTERVAL 7 DAY)
										GROUP BY
											date(datetime_in)
										ORDER BY date(datetime_in) DESC
										LIMIT 7
										");

		$record = $get->result();

		return json_encode($record);
	}

	public function datarevenuechartmonth()
	{
		$session = $this->session->userdata('login');
		$get =  $this->db->query("SELECT date(cdate) wakturevenue,sum(nilai_revenue) totalrevenue
										FROM tr_rekonsiliasi
										WHERE id_bu = " . $this->db->escape($session['id_bu']) . " and
										cdate >= (CURDATE() - INTERVAL 7 DAY)
										GROUP BY
											date(cdate)
										ORDER BY date(cdate) DESC
										LIMIT 7
										");

		$record = $get->result();

		return json_encode($record);
	}

	public function get_count_masuk()
	{

		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_masuk) as JmlBarangMasuk ");
		$this->db->from("tr_masuk a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.tgl_masuk', date('Y-m-d'));
		$this->db->where('a.active', '2');

		return $this->db->get();
	}

	public function get_count_keluar()
	{

		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_keluar) as JmlBarangKeluar");
		$this->db->from("tr_keluar a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.tgl_keluar', date('Y-m-d'));
		$this->db->where('a.active', '2');

		return $this->db->get();
	}

	public function get_count_pengiriman()
	{

		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_pengiriman) as JmlPengiriman");
		$this->db->from("tr_pengiriman a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.tgl_pengiriman', date('Y-m-d'));
		$this->db->where('a.active', '2');

		return $this->db->get();
	}

	public function get_count_retur()
	{

		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_retur) as JmlRetur");
		$this->db->from("tr_retur a");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		// $this->db->where('a.tgl_retur', date('Y-m-d'));
		$this->db->where('a.active', '2');

		return $this->db->get();
	}

	public function get_id_permohonan($bulan, $tahun, $id_bu)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_permohonan");
		$this->db->where("bulan", $bulan);
		$this->db->where("tahun", $tahun);
		$this->db->where("id_bu", $id_bu);
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->row_array();
	}

	public function get_log_cabang($id)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_anggaran_log");
		$this->db->where("id_permohonan", $id);
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->order_by("approve_level", "asc");
		return $this->db->get()->result_array();
	}

	public function get_log_pusat($id)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_anggaran_log");
		$this->db->where("id_permohonan", $id);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}



	public function get_data_permohonan($id_bu)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_permohonan");
		$this->db->where("id_bu", $id_bu);
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		$this->db->order_by("id_permohonan","desc");
		return $this->db->get()->result_array();
	}

	public function get_count()
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(id_permohonan) as total ");
		$this->db->from("tr_permohonan");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['total'] = $this->db->get()->row_array()['total'];

		$this->db->select(" COUNT(id_permohonan) as setuju ");
		$this->db->from("tr_permohonan");
		$this->db->where("approval", 3);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['setuju'] = $this->db->get()->row_array()['setuju'];

		$this->db->select(" COUNT(id_permohonan) as pending ");
		$this->db->from("tr_permohonan");
		$this->db->where("approval !=", 3);
		// $this->db->or_where("approval !=", 4);
		// $this->db->or_where("approval !=", 7);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['pending'] = $this->db->get()->row_array()['pending'];

		$this->db->select(" COUNT(id_permohonan) as tolak ");
		$this->db->from("tr_permohonan");
		$this->db->where("approval", 5);
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$count['tolak'] = $this->db->get()->row_array()['tolak'];

		return $count;
	}

	public function get_permohonan_by_bu($id_bu)
	{
		$session = $this->session->userdata('login');
		$this->db->from("tr_permohonan");
		$this->db->where("id_bu", $id_bu);
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}

	public function combobox_bu()
	{
		$session = $this->session->userdata('login');
		$this->db->from("sso.ref_bu");
		$this->db->where("active", 1);
		$this->db->where("id_perusahaan", $session['id_perusahaan']);
		return $this->db->get()->result_array();
	}
}

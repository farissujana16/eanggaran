<?php
class Model_cashpooling extends CI_Model
{
	public function getAllcashpooling($show = null, $start = null, $cari = null, $id_bu, $bulan, $tahun)
	{
		$str = "";

		if ($id_bu != 0) {
			$str .= " and a.id_bu = ".$id_bu."";
		}
		if ($bulan != "" && $tahun != "") {
			$str .= " and a.bulan = '".$bulan."' and a.tahun = ".$tahun."";
		}

		$this->db->select("a.id_permohonan, a.bulan, a.tahun,  b.nm_bu, a.active, (select COALESCE(sum(nominal_pooling),0) from tr_cashpooling where id_permohonan = a.id_permohonan and active = 1 and DAY(tanggal_pooling) BETWEEN (select tgl_awal from ref_masa where id_masa = 1) and (select tgl_akhir from ref_masa where id_masa = 1)) as masa_1,
		(select COALESCE(sum(nominal_pooling),0) from tr_cashpooling where id_permohonan = a.id_permohonan and active = 1 and DAY(tanggal_pooling) BETWEEN (select tgl_awal from ref_masa where id_masa = 2) and (select tgl_akhir from ref_masa where id_masa = 2)) as masa_2,
		(select COALESCE(sum(nominal_pooling),0) from tr_cashpooling where id_permohonan = a.id_permohonan and active = 1 and DAY(tanggal_pooling) BETWEEN (select tgl_awal from ref_masa where id_masa = 3) and (select tgl_akhir from ref_masa where id_masa = 3)) as masa_3,
		(select COALESCE(sum(nominal_tiketing),0) from tr_cashpooling where id_permohonan = a.id_permohonan and active = 1) as total_tiketing");
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

	public function get_count_cashpooling($search = null, $id_bu, $bulan, $tahun)
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
		$this->db->where("a.active != '2' ".$str."");
		$this->db->where("a.approval", 7);
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}


	public function getAllcashpooling_id($show = null, $start = null, $cari = null, $id_permohonan, $bank)
	{
		$this->db->select("a.*");
		$this->db->from("tr_cashpooling a");
		// $this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("(a.bank  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		$this->db->where("a.id_permohonan", $id_permohonan);
		if ($bank != '0') {
			$this->db->where('a.bank', $bank);
		}
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function get_count_cashpooling_id($search = null, $id_permohonan, $bank)
	{
		$count = array();
		$session = $this->session->userdata('login');

		$this->db->select(" COUNT(a.id_cashpooling) as recordsFiltered ");
		$this->db->from("tr_cashpooling a");
		// $this->db->join("sso.ref_bu b", "a.id_bu = b.id_bu", "left");
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where("a.active != '2' ");
		$this->db->where("a.id_permohonan", $id_permohonan);
		if ($bank != '0') {
			$this->db->where('a.bank', $bank);
		}
		$this->db->like("a.bank ", $search);
		$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];

		$this->db->select(" COUNT(id_cashpooling) as recordsTotal ");
		$this->db->from("tr_cashpooling");
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where("active != '2' ");
		$this->db->where("id_permohonan", $id_permohonan);
		if ($bank != '0') {
			$this->db->where('bank', $bank);
		}
		$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];

		return $count;
	}

	public function getAllcashpoolingaccess($show = null, $start = null, $cari = null, $id_cashpooling)
	{
		$this->db->select("a.id_cashpooling_access, a.id_user, b.nm_user, a.active");
		$this->db->from("tr_cashpooling_access a");
		$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
		$session = $this->session->userdata('login');
		$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
		$this->db->where('a.id_cashpooling', $id_cashpooling);
		$this->db->where("(b.nm_user  LIKE '%" . $cari . "%' ) ");
		$this->db->where("a.active IN (0, 1) ");
		if ($show == null && $start == null) {
		} else {
			$this->db->limit($show, $start);
		}

		return $this->db->get();
	}

	public function insert_cashpooling($data)
	{
		$this->db->insert('tr_cashpooling', $data);
		return $this->db->insert_id();
	}

	public function insert_cashpooling_access($data)
	{
		$this->db->insert('tr_cashpooling_access', $data);
		return $this->db->insert_id();
	}

	public function delete_cashpooling($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_cashpooling', $data['id_cashpooling']);
		$this->db->update('tr_cashpooling', array('active' => '2'));
		return $data['id_cashpooling'];
	}

	public function delete_cashpooling_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_cashpooling_access', $data['id_cashpooling_access']);
		$this->db->delete('tr_cashpooling_access');
		return $data['id_cashpooling_access'];
	}

	public function update_cashpooling($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_cashpooling', $data['id_cashpooling']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_cashpooling', $data);
		return $data['id_cashpooling'];
	}

	public function update_cashpooling_access($data)
	{
		$session = $this->session->userdata('login');
		$this->db->where('id_perusahaan', $session['id_perusahaan']);
		$this->db->where('id_cashpooling_access', $data['id_cashpooling_access']);
		$this->db->where("active != '2' ");
		$this->db->update('tr_cashpooling_access', $data);
		return $data['id_cashpooling_access'];
	}

	public function get_cashpooling_by_id($id_cashpooling)
	{
		if (empty($id_cashpooling)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->from("tr_cashpooling a");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_cashpooling', $id_cashpooling);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_cashpooling_access_by_id($id_cashpooling_access)
	{
		if (empty($id_cashpooling_access)) {
			return array();
		} else {
			$session = $this->session->userdata('login');
			$this->db->select("a.id_cashpooling_access, a.id_cashpooling, a.id_user, b.nm_user, a.active");
			$this->db->from("tr_cashpooling_access a");
			$this->db->join("sso.ref_user b", "a.id_user = b.id_user", "left");
			$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
			$this->db->where('a.id_cashpooling_access', $id_cashpooling_access);
			$this->db->where("a.active != '2' ");
			return $this->db->get()->row_array();
		}
	}

	public function get_pendapatan_bank($id_permohonan){
		$session = $this->session->userdata('login');
		$this->db->select("( SELECT coalesce(sum( nominal_pooling ),0) FROM tr_cashpooling WHERE id_permohonan = ".$id_permohonan." AND active = 1 AND bank = 'Mandiri' ) AS mandiri,
		( SELECT coalesce(sum( nominal_pooling ),0) FROM tr_cashpooling WHERE id_permohonan = ".$id_permohonan." AND active = 1 AND bank = 'BRI' ) AS bri,
		( SELECT coalesce(sum( nominal_pooling ),0) FROM tr_cashpooling WHERE id_permohonan = ".$id_permohonan." AND active = 1 AND bank = 'BNI' ) AS bni ");
		return $this->db->get()->row_array();
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

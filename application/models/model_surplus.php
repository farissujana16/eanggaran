<?php
class Model_surplus extends CI_Model
{
	public function get_data($bulan, $tahun)
	{
		$this->db->select("
		z.*,
		COALESCE(m1.masa_1, 0) AS masa_1,
		COALESCE(m1.masa_2, 0) AS masa_2,
		COALESCE(m1.masa_3, 0) AS masa_3,
		COALESCE(d1.drop_1, 0) AS drop_1,
		COALESCE(d2.drop_2, 0) AS drop_2,
		COALESCE(d3.drop_3, 0) AS drop_3,
		COALESCE(c1.cash_1, 0) AS cash_1,
		COALESCE(c2.cash_2, 0) AS cash_2,
		COALESCE(c3.cash_3, 0) AS cash_3,
		COALESCE(t1.tiket_1, 0) AS tiket_1,
		COALESCE(t2.tiket_2, 0) AS tiket_2,
		COALESCE(t3.tiket_3, 0) AS tiket_3
	FROM (
		SELECT
			a.id_bu,
			b.nm_bu,
			COALESCE((
				SELECT id_permohonan
				FROM tr_permohonan
				WHERE id_bu = a.id_bu
					AND active = 1
					AND bulan = '".$bulan."'
					AND tahun = ".$tahun."
				), 0) AS id_permohonan
		FROM tr_permohonan a
		LEFT JOIN sso.ref_bu b USING (id_bu)
		WHERE a.active = 1
			AND a.id_perusahaan = 77
		GROUP BY a.id_bu
	) z
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(permohonan_1) AS masa_1,
			SUM(permohonan_2) AS masa_2,
			SUM(permohonan_3) AS masa_3
		FROM tr_permohonan_dana
		WHERE active = 1
		GROUP BY id_permohonan
	) m1 ON z.id_permohonan = m1.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_dropping) AS drop_1
		FROM tr_dropping
		WHERE active = 1
			AND DAY(tanggal_dropping) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 1) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 1)
		GROUP BY id_permohonan
	) d1 ON z.id_permohonan = d1.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_dropping) AS drop_2
		FROM tr_dropping
		WHERE active = 1
			AND DAY(tanggal_dropping) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 2) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 2)
		GROUP BY id_permohonan
	) d2 ON z.id_permohonan = d2.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_dropping) AS drop_3
		FROM tr_dropping
		WHERE active = 1
			AND DAY(tanggal_dropping) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 3) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 3)
		GROUP BY id_permohonan
	) d3 ON z.id_permohonan = d3.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_pooling) AS cash_1
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 1) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 1)
		GROUP BY id_permohonan
	) c1 ON z.id_permohonan = c1.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_pooling) AS cash_2
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 2) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 2)
		GROUP BY id_permohonan
	) c2 ON z.id_permohonan = c2.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_pooling) AS cash_3
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 3) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 3)
		GROUP BY id_permohonan
	) c3 ON z.id_permohonan = c3.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_tiketing) AS tiket_1
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 1) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 1)
		GROUP BY id_permohonan
	) t1 ON z.id_permohonan = t1.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_tiketing) AS tiket_2
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 2) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 2)
		GROUP BY id_permohonan
	) t2 ON z.id_permohonan = t2.id_permohonan
	LEFT JOIN (
		SELECT
			id_permohonan,
			SUM(nominal_tiketing) AS tiket_3
		FROM tr_cashpooling
		WHERE active = 1
			AND DAY(tanggal_pooling) BETWEEN (SELECT tgl_awal FROM ref_masa WHERE id_masa = 3) AND (SELECT tgl_akhir FROM ref_masa WHERE id_masa = 3)
		GROUP BY id_permohonan
	) t3 ON z.id_permohonan = t3.id_permohonan;
	");
		return $this->db->get()->result_array();
	}
}

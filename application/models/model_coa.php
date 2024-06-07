<?php
    class Model_coa extends CI_Model
    {
        public function getAllcoa($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_coa, a.nm_coa, a.kd_coa, a.active, b.nm_bidang");
            $this->db->from("ref_coa a");
            $this->db->join("ref_bidang b", "a.id_bidang = b.id_bidang",'left');
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_coa  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
			$this->db->order_by("a.id_bidang asc, a.id_coa asc");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_coa($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_coa) as recordsFiltered ");
			$this->db->from("ref_coa");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_coa ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_coa) as recordsTotal ");
			$this->db->from("ref_coa");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_coa($data)
        {
            $this->db->insert('ref_coa', $data);
			return $this->db->insert_id();
        }

        public function delete_coa($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_coa', $data['id_coa']);
            $this->db->update('ref_coa', array('active' => '2'));
			return $data['id_coa'];
        }
		
        public function update_coa($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_coa', $data['id_coa']);
			$this->db->where("active != '2' ");
            $this->db->update('ref_coa', $data);
			return $data['id_coa'];
        }
		
		public function get_coa_by_id($id_coa)
		{
			if(empty($id_coa))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("ref_coa a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_coa', $id_coa);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }

<?php
    class Model_approval extends CI_Model
    {
        public function getAllapproval($show=null, $start=null, $cari=null)
        {
            $this->db->select("a.id_approval, a.nm_approval, a.active");
            $this->db->from("tr_approval a");
            $session = $this->session->userdata('login');
            $this->db->where('a.id_perusahaan', $session['id_perusahaan']);
            $this->db->where("(a.nm_approval  LIKE '%".$cari."%' ) ");
            $this->db->where("a.active IN (0, 1) ");
            if ($show == null && $start == null) {
            } else {
                $this->db->limit($show, $start);
            }

            return $this->db->get();
        }
		
		public function get_count_approval($search = null)
		{
			$count = array();
			$session = $this->session->userdata('login');
			
			$this->db->select(" COUNT(id_approval) as recordsFiltered ");
			$this->db->from("tr_approval");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$this->db->like("nm_approval ", $search);
			$count['recordsFiltered'] = $this->db->get()->row_array()['recordsFiltered'];
			
			$this->db->select(" COUNT(id_approval) as recordsTotal ");
			$this->db->from("tr_approval");
			$this->db->where('id_perusahaan', $session['id_perusahaan']);
			$this->db->where("active != '2' ");
			$count['recordsTotal'] = $this->db->get()->row_array()['recordsTotal'];
			
			return $count;
		}
		
		public function insert_approval($data)
        {
            $this->db->insert('tr_approval', $data);
			return $this->db->insert_id();
        }

        public function delete_approval($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_approval', $data['id_approval']);
            $this->db->update('tr_approval', array('active' => '2'));
			return $data['id_approval'];
        }
		
        public function update_approval($data)
        {
            $session = $this->session->userdata('login');
            $this->db->where('id_perusahaan', $session['id_perusahaan']);
            $this->db->where('id_approval', $data['id_approval']);
			$this->db->where("active != '2' ");
            $this->db->update('tr_approval', $data);
			return $data['id_approval'];
        }
		
		public function get_approval_by_id($id_approval)
		{
			if(empty($id_approval))
			{
				return array();
			}
			else
			{
				$session = $this->session->userdata('login');
				$this->db->from("tr_approval a");
				$this->db->where('a.id_perusahaan', $session['id_perusahaan']);
				$this->db->where('a.id_approval', $id_approval);
				$this->db->where("a.active != '2' ");
				return $this->db->get()->row_array();
			}
		}

		

    }

<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class periode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_periode");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['tahun'] = range(2020, strftime("%Y", time()));
                $this->load->view('periode/index', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function details($id_periode)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['id_periode'] = $id_periode;
                $this->load->view('periode/details', $data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }



    public function ax_data_periode()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_periode->getAllperiode($length, $start, $cari['value'])->result_array();
                $count = $this->model_periode->get_count_periode($cari['value']);

                echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_data_periode_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode = $this->input->post('id_periode');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_periode->getAllperiode_details($length, $start, $cari['value'], $id_periode)->result_array();
                $count = $this->model_periode->get_count_periode_details($cari['value'], $id_periode);

                echo json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_set_data()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $bulan = $this->input->post('bulan');
                $tahun = $this->input->post('tahun');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );

                if (empty($id_permohonan))
                    $data['id_permohonan'] = $this->model_periode->insert_periode($data);
                else
                    $data['id_permohonan'] = $this->model_periode->update_periode($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_set_data_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode = $this->input->post('id_periode');
                $id_periode_details = $this->input->post('id_periode_details');
                $tanggal = $this->input->post('tanggal');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_periode_details' => $id_periode_details,
                    'id_periode' => $id_periode,
                    'tanggal' => $tanggal,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan']
                );

                if (empty($id_periode_periode))
                    $data['id_periode'] = $this->model_periode->insert_periode_details($data);
                else
                    $data['id_periode'] = $this->model_periode->update_periode_details($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_unset_data()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode = $this->input->post('id_periode');

                $data = array('id_periode' => $id_periode);

                if (!empty($id_periode))
                    $data['id_periode'] = $this->model_periode->delete_periode($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_unset_data_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode_details = $this->input->post('id_periode_details');

                $data = array('id_periode_details' => $id_periode_details);

                if (!empty($id_periode_details))
                    $data['id_periode_details'] = $this->model_periode->delete_periode_details($data);

                echo json_encode(array('status' => 'success', 'data' => $data));
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_get_data_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode = $this->input->post('id_periode');

                if (empty($id_periode))
                    $data = array();
                else
                    $data = $this->model_periode->get_periode_by_id($id_periode);

                echo json_encode($data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }

    public function ax_get_data_by_id_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_periode_details = $this->input->post('id_periode_details');

                if (empty($id_periode_details))
                    $data = array();
                else
                    $data = $this->model_periode->get_periode_by_id_details($id_periode_details);

                echo json_encode($data);
            } else {
                echo "<script>alert('Anda tidak mendapatkan access menu ini');window.location.href='javascript:history.back(-1);'</script>";
            }
        } else {
            if ($this->uri->segment(1) != null) {
                $url = $this->uri->segment(1);
                $url = $url . ' ' . $this->uri->segment(2);
                $url = $url . ' ' . $this->uri->segment(3);
                redirect('welcome/relogin/?url=' . $url . '', 'refresh');
            } else {
                redirect('welcome/relogin', 'refresh');
            }
        }
    }
}

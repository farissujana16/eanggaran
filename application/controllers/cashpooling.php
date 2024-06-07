<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class cashpooling extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_cashpooling");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['combobox_bu'] = $this->model_cashpooling->combobox_bu();
                $this->load->view('cashpooling/index', $data);
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

    public function access($id_cashpooling)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['combobox_user'] = $this->model_cashpooling->combobox_user();
                $data['id_cashpooling'] = $id_cashpooling;
                $this->load->view('cashpooling/access', $data);
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



    public function ax_data_cashpooling()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);

                $id_bu = $this->input->post('id_bu');
                $periode = explode('-', $this->input->post('periode'));
                $bulan = $periode[0];
                $tahun = $periode[1];

                $data = $this->model_cashpooling->getAllcashpooling($length, $start, $cari['value'], $id_bu, $bulan, $tahun)->result_array();
                $count = $this->model_cashpooling->get_count_cashpooling($cari['value'], $id_bu, $bulan, $tahun);

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

    public function ax_data_cashpooling_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $id_permohonan = $this->input->post('id_permohonan');
                $bank = $this->input->post('bank');
                $data = $this->model_cashpooling->getAllcashpooling_id($length, $start, $cari['value'], $id_permohonan, $bank)->result_array();
                $count = $this->model_cashpooling->get_count_cashpooling_id($cari['value'], $id_permohonan, $bank);

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

    public function ax_data_cashpooling_access($id_cashpooling)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {


                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_cashpooling->getAllcashpoolingaccess($length, $start, $cari['value'], $id_cashpooling)->result_array();
                $count = $this->model_cashpooling->getAllcashpoolingaccess(null, null, $cari['value'], $id_cashpooling)->num_rows();

                echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $cari['value'], 'data' => $data));
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
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_cashpooling = $this->input->post('id_cashpooling');
                $tanggal_pooling = $this->input->post('tanggal_pooling');
                $bank = $this->input->post('bank');
                $no_transaksi = $this->input->post('no_transaksi');
                $nominal_pooling = $this->input->post('nominal_pooling');
                $nominal_tiketing = $this->input->post('nominal_tiketing');
                $active = 1;
                $session = $this->session->userdata('login');
                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'id_cashpooling' => $id_cashpooling,
                    'tanggal_pooling' => $tanggal_pooling,
                    'bank' => $bank,
                    'no_transaksi' => $no_transaksi,
                    'nominal_pooling' => str_replace(',','.',$nominal_pooling),
                    'nominal_tiketing' => $nominal_tiketing,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan'],
                   
                );

                if (empty($id_cashpooling))
                    $data['id_cashpooling'] = $this->model_cashpooling->insert_cashpooling($data);
                else
                    $data['id_cashpooling'] = $this->model_cashpooling->update_cashpooling($data);

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

    public function ax_set_data_access()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling = $this->input->post('id_cashpooling');
                $id_cashpooling_access = $this->input->post('id_cashpooling_access');
                $id_user = $this->input->post('id_user');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_cashpooling' => $id_cashpooling,
                    'id_cashpooling_access' => $id_cashpooling_access,
                    'id_user' => $id_user,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan']
                );

                if (empty($id_cashpooling_access))
                    $data['id_cashpooling_access'] = $this->model_cashpooling->insert_cashpooling_access($data);
                else
                    $data['id_cashpooling_access'] = $this->model_cashpooling->update_cashpooling_access($data);

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
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling = $this->input->post('id_cashpooling');

                $data = array('id_cashpooling' => $id_cashpooling);

                if (!empty($id_cashpooling))
                    $data['id_cashpooling'] = $this->model_cashpooling->delete_cashpooling($data);

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

    public function ax_unset_data_access()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling_access = $this->input->post('id_cashpooling_access');

                $data = array('id_cashpooling_access' => $id_cashpooling_access);

                if (!empty($id_cashpooling_access))
                    $data['id_cashpooling_access'] = $this->model_cashpooling->delete_cashpooling_access($data);

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
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling = $this->input->post('id_cashpooling');

                if (empty($id_cashpooling))
                    $data = array();
                else
                    $data = $this->model_cashpooling->get_cashpooling_by_id($id_cashpooling);

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


    public function ax_get_data_cash_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling = $this->input->post('id_cashpooling');

                if (empty($id_cashpooling))
                    $data = array();
                else
                    $data = $this->model_cashpooling->get_cashpooling_by_id($id_cashpooling);

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

    public function ax_get_data_access_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_cashpooling_access = $this->input->post('id_cashpooling_access');

                if (empty($id_cashpooling_access))
                    $data = array();
                else
                    $data = $this->model_cashpooling->get_cashpooling_access_by_id($id_cashpooling_access);

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

    public function ax_get_pooling()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');

                if (empty($id_permohonan))
                    $data = array();
                else
                    $data = $this->model_cashpooling->get_pendapatan_bank($id_permohonan);

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

    public function ax_get_periode()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "T01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_bu = $this->input->post('id_bu');
                $data = $this->model_cashpooling->get_periode_permohonan($id_bu);

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

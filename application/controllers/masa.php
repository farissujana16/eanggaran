<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class masa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_masa");
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
                $this->load->view('masa/index', $data);
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

    public function access($id_masa)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['combobox_user'] = $this->model_masa->combobox_user();
                $data['id_masa'] = $id_masa;
                $this->load->view('masa/access', $data);
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



    public function ax_data_masa()
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
                $data = $this->model_masa->getAllmasa($length, $start, $cari['value'])->result_array();
                $count = $this->model_masa->get_count_masa($cari['value']);

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

    public function ax_data_masa_access($id_masa)
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
                $data = $this->model_masa->getAllmasaaccess($length, $start, $cari['value'], $id_masa)->result_array();
                $count = $this->model_masa->getAllmasaaccess(null, null, $cari['value'], $id_masa)->num_rows();

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
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_masa = $this->input->post('id_masa');
                $nm_masa = $this->input->post('nm_masa');
                $tgl_awal = $this->input->post('tgl_awal');
                $tgl_akhir = $this->input->post('tgl_akhir');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_masa' => $id_masa,
                    'nm_masa' => $nm_masa,
                    'tgl_awal' => $tgl_awal,
                    'tgl_akhir' => $tgl_akhir,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );

                if (empty($id_masa))
                    $data['id_masa'] = $this->model_masa->insert_masa($data);
                else
                    $data['id_masa'] = $this->model_masa->update_masa($data);

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
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_masa = $this->input->post('id_masa');
                $id_masa_access = $this->input->post('id_masa_access');
                $id_user = $this->input->post('id_user');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_masa' => $id_masa,
                    'id_masa_access' => $id_masa_access,
                    'id_user' => $id_user,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan']
                );

                if (empty($id_masa_access))
                    $data['id_masa_access'] = $this->model_masa->insert_masa_access($data);
                else
                    $data['id_masa_access'] = $this->model_masa->update_masa_access($data);

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

                $id_masa = $this->input->post('id_masa');

                $data = array('id_masa' => $id_masa);

                if (!empty($id_masa))
                    $data['id_masa'] = $this->model_masa->delete_masa($data);

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
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_masa_access = $this->input->post('id_masa_access');

                $data = array('id_masa_access' => $id_masa_access);

                if (!empty($id_masa_access))
                    $data['id_masa_access'] = $this->model_masa->delete_masa_access($data);

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

                $id_masa = $this->input->post('id_masa');

                if (empty($id_masa))
                    $data = array();
                else
                    $data = $this->model_masa->get_masa_by_id($id_masa);

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
            $menu_kd_menu_details = "M03";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_masa_access = $this->input->post('id_masa_access');

                if (empty($id_masa_access))
                    $data = array();
                else
                    $data = $this->model_masa->get_masa_access_by_id($id_masa_access);

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

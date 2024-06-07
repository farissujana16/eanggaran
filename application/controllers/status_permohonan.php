<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class status_permohonan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_status_permohonan");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['bu'] = $this->model_status_permohonan->combobox_bu();
                $this->load->view('status_permohonan/index', $data);
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

    public function detail($id_permohonan)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['id_bu'] = $this->input->get('id_bu');
                // $data['permohonan'] = $id_permohonan;
                $data['permohonan'] = $this->model_status_permohonan->get_permohonan($id_permohonan);

                $data['operasional'] = $data['permohonan']['total_bidang1_permohonan1'] + $data['permohonan']['total_bidang1_permohonan2'] + $data['permohonan']['total_bidang1_permohonan3'];
                $data['teknik'] = $data['permohonan']['total_bidang2_permohonan1'] + $data['permohonan']['total_bidang2_permohonan2'] + $data['permohonan']['total_bidang2_permohonan3'];
                $data['sdm'] = $data['permohonan']['total_bidang3_permohonan1'] + $data['permohonan']['total_bidang3_permohonan2'] + $data['permohonan']['total_bidang3_permohonan3'];
                $data['umum'] = $data['permohonan']['total_bidang4_permohonan1'] + $data['permohonan']['total_bidang4_permohonan2'] + $data['permohonan']['total_bidang4_permohonan3'];
                $data['keuangan'] = $data['permohonan']['total_bidang5_permohonan1'] + $data['permohonan']['total_bidang5_permohonan2'] + $data['permohonan']['total_bidang5_permohonan3'];
                $data['pendapatan'] = $this->model_status_permohonan->get_permohonan_detail($id_permohonan);
                $this->load->view('status_permohonan/detail', $data);
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



    public function ax_data_status_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_bu = $this->input->post('id_bu');
                $filter = $this->input->post('filter');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_status_permohonan->getAllstatus_permohonan($length, $start, $cari['value'], $id_bu, $filter)->result_array();
                $count = $this->model_status_permohonan->get_count_status_permohonan($cari['value'], $id_bu, $filter);

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

    public function ax_data_status_permohonan_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $approve = $this->input->post('approve');
                $id_periode = $this->input->post('id_permohonan');
                $kategori = $this->input->post('kategori');
                $id_bu = $this->model_status_permohonan->get_permohonan_by_id($id_periode)['id_bu'];
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_status_permohonan->getAllstatus_permohonan_details($length, $start, $cari['value'], $approve, $id_periode, $id_bu, $kategori)->result_array();
                $count = $this->model_status_permohonan->get_count_status_permohonan_details($cari['value'], $approve, $id_periode, $id_bu, $kategori);

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
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $id_status_permohonan = $this->input->post('id_status_permohonan');
                $nm_status_permohonan = $this->input->post('nm_status_permohonan');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_status_permohonan' => $id_status_permohonan,
                    'nm_status_permohonan' => $nm_status_permohonan,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );

                if (empty($id_status_permohonan))
                    $data['id_status_permohonan'] = $this->model_status_permohonan->insert_status_permohonan($data);
                else
                    $data['id_status_permohonan'] = $this->model_status_permohonan->update_status_permohonan($data);

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
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_status_permohonan = $this->input->post('id_status_permohonan');

                $data = array('id_status_permohonan' => $id_status_permohonan);

                if (!empty($id_status_permohonan))
                    $data['id_status_permohonan'] = $this->model_status_permohonan->delete_status_permohonan($data);

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

    public function ax_approve_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->input->post('id_bu');

                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 1
                );
                $data['id_permohonan'] = $this->model_status_permohonan->update_status_permohonan($data);
                $this->model_status_permohonan->update_permohonan($data);

                $cek = $this->model_status_permohonan->cek_log($id_bu, $id_permohonan, 1, 0);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_status_permohonan->update_log($replace);
                }

                $log = array(
                    'id_bu' => $id_bu,
                    'id_permohonan' => $id_permohonan,
                    'id_bidang' => 0,
                    'keterangan' => "Permohonan Anggaran Diterima",
                    'approve_level' => 1,
                    'status' => 1,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_status_permohonan->insert_anggaran_log($log);

                $bidang = $this->model_status_permohonan->get_permohonan_by_id($id_permohonan);
                if ($bidang['approval_1'] == 2 || $bidang['approval_2'] == 2 || $bidang['approval_3'] == 2 || $bidang['approval_4'] == 2) {
                    if ($bidang['approval_1'] == 2) {
                        $app = array(
                            'id_permohonan' => $id_permohonan,
                            'approval_1' => 0
                        );
                    } else if ($bidang['approval_2'] == 2) {
                        $app = array(
                            'id_permohonan' => $id_permohonan,
                            'approval_2' => 0
                        );
                    } else if ($bidang['approval_3'] == 2) {
                        $app = array(
                            'id_permohonan' => $id_permohonan,
                            'approval_3' => 0
                        );
                    } else if ($bidang['approval_4'] == 2) {
                        $app = array(
                            'id_permohonan' => $id_permohonan,
                            'approval_4' => 0
                        );
                    }
                    $this->model_status_permohonan->update_status_permohonan($app);
                }

                echo json_encode(array('status' => 'success', 'data' => $data['id_permohonan']));
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

    public function ax_reject_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $revisi = $this->input->post('revisi');
                $id_bu = $this->input->post('id_bu');

                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 5,
                );
                $data['id_permohonan'] = $this->model_status_permohonan->update_status_permohonan($data);

                $app = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 2,
                );
                $this->model_status_permohonan->update_permohonan($app);

                $cek = $this->model_status_permohonan->cek_log($id_bu, $id_permohonan, 1, 0);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_status_permohonan->update_log($replace);
                }

                $log = array(
                    'id_bu' => $id_bu,
                    'id_permohonan' => $id_permohonan,
                    'keterangan' => $revisi,
                    'id_bidang' => 0,
                    'approve_level' => 1,
                    'status' => 2,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_status_permohonan->insert_anggaran_log($log);


                echo json_encode(array('status' => 'success', 'data' => $data['id_permohonan']));
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

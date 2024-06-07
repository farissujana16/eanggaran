<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class list_approval extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_list_approval");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['bu'] = $this->model_list_approval->combobox_bu();
                $this->load->view('list_approval/index', $data);
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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['permohonan'] = $this->model_list_approval->get_permohonan($id_permohonan);
                $data['id_bu'] = $this->input->get('id_bu');
                $data['bidang'] = $this->model_list_approval->combobox_bidang();
                $data['pendapatan'] = $this->model_list_approval->get_permohonan_detail($id_permohonan);


                // $data['operasional'] = $data['permohonan']['total_bidang1_permohonan1'] + $data['permohonan']['total_bidang1_permohonan2'] + $data['permohonan']['total_bidang1_permohonan3'];
                // $data['teknik'] = $data['permohonan']['total_bidang2_permohonan1'] + $data['permohonan']['total_bidang2_permohonan2'] + $data['permohonan']['total_bidang2_permohonan3'];
                // $data['sdm'] = $data['permohonan']['total_bidang3_permohonan1'] + $data['permohonan']['total_bidang3_permohonan2'] + $data['permohonan']['total_bidang3_permohonan3'];
                // $data['umum'] = $data['permohonan']['total_bidang4_permohonan1'] + $data['permohonan']['total_bidang4_permohonan2'] + $data['permohonan']['total_bidang4_permohonan3'];
                $this->load->view('list_approval/detail', $data);
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



    public function ax_data_list_approval()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_bu = $this->input->post('id_bu');
                $filter = $this->input->post('filter');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_list_approval->getAlllist_approval($length, $start, $cari['value'], $id_bu, $filter)->result_array();
                $count = $this->model_list_approval->get_count_list_approval($cari['value'], $id_bu, $filter);

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

    public function ax_data_list_approval_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_bidang = $this->input->post('id_bidang');
                $id_periode = $this->input->post('id_permohonan');
                $id_bu = $this->input->post('id_bu');
                $kategori = $this->input->post('kategori');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_list_approval->getAlllist_approval_details($length, $start, $cari['value'], $id_bu, $id_periode, $id_bidang, $kategori)->result_array();
                $count = $this->model_list_approval->get_count_list_approval_details($cari['value'], $id_bu, $id_periode, $id_bidang, $kategori);

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

    public function ax_approve_permohonan_keuangan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->input->post('id_bu');
                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 3
                );
                $data['id_permohonan'] = $this->model_list_approval->update_approval_dana($data);

                $app = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 1
                );
                $this->model_list_approval->update_permohonan_keuangan($app);

                $cek = $this->model_list_approval->cek_log($id_bu, $id_permohonan, 3, 0);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_list_approval->update_log($replace);
                }

                $log = array(
                    'id_permohonan' => $id_permohonan,
                    'keterangan' => "Permohonan Anggaran Diterima",
                    'id_bu' => $id_bu,
                    'approve_level' => 3,
                    'id_bidang' => 0,
                    'status' => 1,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_list_approval->insert_anggaran_log($log);

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

    public function ax_reject_permohonan_keuangan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $revisi = $this->input->post('revisi');
                $id_bu = $this->input->post('id_bu');

                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 5
                );
                $data['id_permohonan'] = $this->model_list_approval->update_approval_dana($data);

                $app = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 2
                );
                $this->model_list_approval->update_permohonan_keuangan($app);

                $cek = $this->model_list_approval->cek_log($id_bu, $id_permohonan, 3, 0);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_list_approval->update_log($replace);
                }

                $log = array(
                    'id_permohonan' => $id_permohonan,
                    'keterangan' => $revisi,
                    'id_bu' => $id_bu,
                    'id_bidang' => 0,
                    'approve_level' => 3,
                    'status' => 2,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_list_approval->insert_anggaran_log($log);

                echo json_encode(array('status' => 'success', 'data' => $data['id_anggaran']));
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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bidang = $this->input->post('id_bidang');
                $id_bu = $this->input->post('id_bu');


                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval_' . $id_bidang . '' => 1
                );
                $data['approval_' . $id_bidang] = $this->model_list_approval->update_list_approval($data)['approval_' . $id_bidang];

                $app = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 1,
                    'id_bidang' => $id_bidang
                );
                $this->model_list_approval->update_permohonan($app);

                $cek = $this->model_list_approval->get_permohonan($id_permohonan);
                if ($cek['approval_1'] == 1 && $cek['approval_2'] == 1 && $cek['approval_3'] == 1 && $cek['approval_4'] == 1 && $cek['approval_5'] == 1) {
                    $info = array(
                        'id_permohonan' => $id_permohonan,
                        'approval' => 2
                    );
                    $this->model_list_approval->update_list_approval($info);
                }

                $data_log = $this->model_list_approval->cek_log($id_bu, $id_permohonan, 2, $id_bidang);
                if (!empty($data_log)) {
                    $replace = array(
                        'id_anggaran_log' => $data_log['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_list_approval->update_log($replace);
                }

                $log = array(
                    'id_bu' => $id_bu,
                    'id_permohonan' => $id_permohonan,
                    'keterangan' => "Permohonan Anggaran Diterima",
                    'approve_level' => 2,
                    'status' => 1,
                    'id_bidang' => $id_bidang,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $this->model_list_approval->insert_anggaran_log($log);

                echo json_encode(array('status' => 'success', 'data' => $data['approval_' . $id_bidang]));
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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $revisi = $this->input->post('revisi');
                $id_bidang = $this->input->post('id_bidang');
                $id_bu = $this->input->post('id_bu');


                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval_' . $id_bidang . '' => 2,
                    'approval' => 5,
                );
                $data['approval_' . $id_bidang] = $this->model_list_approval->update_list_approval($data)['approval_' . $id_bidang];

                $app = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 2,
                    'id_bidang' => $id_bidang
                );
                $this->model_list_approval->update_permohonan($app);

                $cek = $this->model_list_approval->cek_log($id_bu, $id_permohonan, 2, $id_bidang);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_list_approval->update_log($replace);
                }

                $log = array(
                    'id_bu' => $id_bu,
                    'id_permohonan' => $id_permohonan,
                    'keterangan' => $revisi,
                    'approve_level' => 2,
                    'status' => 2,
                    'id_bidang' => $id_bidang,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_list_approval->insert_anggaran_log($log);

                echo json_encode(array('status' => 'success', 'data' => $data['approval' . $id_bidang]));
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

    public function ax_data_approval_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bidang = $this->input->post('id_bidang');

                $data = $this->model_list_approval->get_permohonan_bidang($id_permohonan);


                echo json_encode(array('status' => 'success', 'data' => $data['approval_' . $id_bidang]));
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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_divre = $this->input->post('id_divre');
                $nm_divre = $this->input->post('nm_divre');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_divre' => $id_divre,
                    'nm_divre' => $nm_divre,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan']
                );

                if (empty($id_divre))
                    $data['id_divre'] = $this->model_divre->insert_divre($data);
                else
                    $data['id_divre'] = $this->model_divre->update_divre($data);

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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_divre = $this->input->post('id_divre');

                $data = array('id_divre' => $id_divre);

                if (!empty($id_divre))
                    $data['id_divre'] = $this->model_divre->delete_divre($data);

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
            $menu_kd_menu_details = "A02";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_divre = $this->input->post('id_divre');

                if (empty($id_divre))
                    $data = array();
                else
                    $data = $this->model_divre->get_divre_by_id($id_divre);

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

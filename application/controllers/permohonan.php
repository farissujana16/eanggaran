<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class permohonan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_permohonan");
        $this->load->model("model_menu");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $tahun = strftime("%Y", time()) + 1;
                $data['tahun'] = range(2020, $tahun);
                if ($session['id_level'] == 17) {
                    $data['bu'] = $this->model_permohonan->combobox_pusat();
                } else {
                    $data['bu'] = $this->model_permohonan->combobox_bu();
                }
                $this->load->view('permohonan/index', $data);
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
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['permohonan'] = $this->model_permohonan->get_permohonan($id_permohonan);

                $this->load->view('permohonan/detail', $data);
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

    public function request($id_permohonan)
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['permohonan'] = $this->model_permohonan->get_permohonan($id_permohonan);
                $data['bidang'] = $this->model_permohonan->combobox_bidang();
                $info = $data['permohonan'];

                $data['operasional'] = $info['total_bidang1_permohonan1'] + $info['total_bidang1_permohonan2'] + $info['total_bidang1_permohonan3'];
                $data['teknik'] = $info['total_bidang2_permohonan1'] + $info['total_bidang2_permohonan2'] + $info['total_bidang2_permohonan3'];
                $data['sdm'] = $info['total_bidang3_permohonan1'] + $info['total_bidang3_permohonan2'] + $info['total_bidang3_permohonan3'];
                $data['umum'] = $info['total_bidang4_permohonan1'] + $info['total_bidang4_permohonan2'] + $info['total_bidang4_permohonan3'];
                $data['keuangan'] = $info['total_bidang5_permohonan1'] + $info['total_bidang5_permohonan2'] + $info['total_bidang5_permohonan3'];
                $data['pendapatan'] = $this->model_permohonan->get_permohonan_detail($id_permohonan)['total'];
                $data['realisasi'] = $this->model_permohonan->get_realisasi_dana($id_permohonan);
                $data['realisasi_pendapatan'] = $this->model_permohonan->get_realisasi_dana_pendapatan($id_permohonan);


                if( $data['permohonan']['approval'] == NULL){
                    $data['app'] = 8;
                }else{
                    $data['app'] = $data['permohonan']['approval'];
                }
                // var_dump($tanggal);
                $this->load->view('permohonan/request', $data);
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

    public function realisasi($id_permohonan)
    {
        // $tanggal = date("d");
        // $rentang = $this->model_permohonan->get_masa($tanggal);
        // var_dump($rentang);die();
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {
                $data['id_user'] = $session['id_user'];
                $data['nm_user'] = $session['nm_user'];
                $data['session_level'] = $session['id_level'];
                $data['permohonan'] = $this->model_permohonan->get_permohonan($id_permohonan);
                $data['bidang'] = $this->model_permohonan->combobox_bidang();

                $tanggal = date("d");
                $bulan = date("m");
                $tahun = date("Y");

                $data_bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                                    );

                $index = array_search($data['permohonan']['bulan'], $data_bulan) + 1;

                
                

                $rentang = $this->model_permohonan->get_masa($tanggal)["id_masa"];

                // if ($bulan == $index && $tahun == $data['permohonan']['tahun']) {
                //     if ($rentang == 1) {
                //         $data['masa_1'] = '';
                //         $data['masa_2'] = 'disabled';
                //         $data['masa_3'] = 'disabled';
                //     } elseif($rentang == 2){
                //         $data['masa_1'] = 'disabled';
                //         $data['masa_2'] = '';
                //         $data['masa_3'] = 'disabled';
                //     }elseif ($rentang == 3){
                //         $data['masa_1'] = 'disabled';
                //         $data['masa_2'] = 'disabled';
                //         $data['masa_3'] = '';
                //     }
                // }else{
                //     $data['masa_1'] = 'disabled';
                //     $data['masa_2'] = 'disabled';
                //     $data['masa_3'] = 'disabled';
                // }

                    $data['masa_1'] = '';
                    $data['masa_2'] = '';
                    $data['masa_3'] = '';
                
                
                $this->load->view('permohonan/realisasi', $data);
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



    public function ax_data_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $bu = $this->input->post('id_bu');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_permohonan->getAllpermohonan($length, $start, $cari['value'], $bu)->result_array();
                $count = $this->model_permohonan->get_count_permohonan($cari['value'], $bu);

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

    public function ax_data_permohonan_details()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_$id_permohonan');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_permohonan->getAllpermohonan_details($length, $start, $cari['value'], $id_permohonan)->result_array();
                $count = $this->model_permohonan->get_count_permohonan_details($cari['value'], $id_permohonan);

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

    public function ax_data_permohonan_request()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->model_permohonan->get_permohonan_by_id($id_permohonan)['id_bu'];
                // $masa = $this->input->post('masa');
                $bidang = $this->input->post('bidang');
                $kategori = $this->input->post('kategori');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_permohonan->getAllpermohonan_request($length, $start, $cari['value'], $id_permohonan, $bidang, $id_bu, $kategori)->result_array();
                $count = $this->model_permohonan->get_count_permohonan_request($cari['value'], $id_permohonan, $bidang, $id_bu, $kategori);

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

    public function ax_data_permohonan_realisasi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->model_permohonan->get_permohonan_by_id($id_permohonan)['id_bu'];
                // $masa = $this->input->post('masa');
                $bidang = $this->input->post('bidang');
                $start = $this->input->post('start');
                $draw = $this->input->post('draw');
                $length = $this->input->post('length');
                $cari = $this->input->post('search', true);
                $data = $this->model_permohonan->getAllpermohonan_realisasi($length, $start, $cari['value'], $id_permohonan, $bidang, $id_bu)->result_array();
                $count = $this->model_permohonan->get_count_permohonan_realisasi($cari['value'], $id_permohonan, $bidang, $id_bu);

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
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->input->post('id_bu');
                $bulan = $this->input->post('bulan');
                $tahun = $this->input->post('tahun');
                $active = $this->input->post('active');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'id_bu' => $id_bu,
                    'active' => $active,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );

                if (empty($id_permohonan)) {
                    $data['id_permohonan'] = $this->model_permohonan->insert_permohonan($data);
                } else {
                    $data['id_permohonan'] = $this->model_permohonan->update_permohonan($data);
                }

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


    public function ax_send_data()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->input->post('id_bu');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 0
                );

                $rincian = array(
                    'id_permohonan' => $id_permohonan,
                    'approval' => 3
                );

                if (empty($id_permohonan)) {
                    $data['id_permohonan'] = $this->model_permohonan->insert_permohonan($data);
                } else {
                    $data['id_permohonan'] = $this->model_permohonan->update_permohonan($data);
                    $this->model_permohonan->update_permohonan_rincian($rincian);
                }

                $cek = $this->model_permohonan->cek_log($id_bu, $id_permohonan, 0, 0);
                if (!empty($cek)) {
                    $replace = array(
                        'id_anggaran_log' => $cek['id_anggaran_log'],
                        'active' => 2
                    );
                    $this->model_permohonan->update_log($replace);
                }

                $log = array(
                    'id_bu' => $id_bu,
                    'id_permohonan' => $id_permohonan,
                    'id_bidang' => 0,
                    'keterangan' => "Permohonan diajukan",
                    'approve_level' => 0,
                    'status' => 0,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user']
                );
                $data['id_anggaran_log'] = $this->model_permohonan->insert_anggaran_log($log);

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


    public function ax_set_data_dana()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan_dana = $this->input->post('id_permohonan_dana');
                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->model_permohonan->get_permohonan_by_id($id_permohonan)['id_bu'];
                $id_coa = $this->input->post('id_coa');
                $money_1 = $this->input->post('money_1');
                $money_2 = $this->input->post('money_2');
                $money_3 = $this->input->post('money_3');
                $session = $this->session->userdata('login');

                if (empty($money_1)) {
                    $dana_1 = 0;
                }else{
                    $dana_1 = $money_1;
                }
                if (empty($money_2)) {
                    $dana_2 = 0;
                }else{
                    $dana_2 = $money_2;
                }
                if (empty($money_3)) {
                    $dana_3 = 0;
                }else{
                    $dana_3 = $money_3;
                }
                $data = array(
                    'id_permohonan_dana' => $id_permohonan_dana,
                    'id_permohonan' => $id_permohonan,
                    'id_coa' => $id_coa,
                    'id_bu' => $id_bu,
                    'permohonan_1' => $dana_1,
                    'permohonan_2' => $dana_2,
                    'permohonan_3' => $dana_3,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user'],
                    'approval' => 0
                );
                
                if (empty($id_permohonan_dana)) {
                    $data['id_permohonan_dana'] = $this->model_permohonan->insert_permohonan_dana($data);
                    $log = array(
                    'id_permohonan_dana' => $data['id_permohonan_dana'],
                    'id_permohonan' => $id_permohonan,
                    'id_coa' => $id_coa,
                    'id_bu' => $id_bu,
                    'permohonan_1' => $money_1,
                    'permohonan_2' => $money_2,
                    'permohonan_3' => $money_3,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan']
                );
                    $this->model_permohonan->insert_permohonan_log($log);
                } else {
                    $permohonan = $this->model_permohonan->get_permohonan_dana_by_id($id_permohonan_dana);
                    if ($permohonan['approval'] == 2) {
                        $update = array(
                            'id_permohonan_dana' => $id_permohonan_dana,
                            'permohonan_1' => $permohonan['permohonan_1'],
                            'permohonan_2' => $permohonan['permohonan_2'],
                            'permohonan_3' => $permohonan['permohonan_3'],
                            'perbaikan_1' => $money_1,
                            'perbaikan_2' => $money_2,
                            'perbaikan_3' => $money_3,
                        );
                        $this->model_permohonan->update_permohonan_log($update);
                    }
                    $data['id_permohonan_dana'] = $this->model_permohonan->update_permohonan_dana($data);
                }


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


    public function ax_set_data_dana_realisasi()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan_dana = $this->input->post('id_permohonan_dana');
                $id_permohonan = $this->input->post('id_permohonan');
                $id_bu = $this->model_permohonan->get_permohonan_by_id($id_permohonan)['id_bu'];
                $id_coa = $this->input->post('id_coa');
                $money_1 = $this->input->post('money_1');
                $money_2 = $this->input->post('money_2');
                $money_3 = $this->input->post('money_3');
                $session = $this->session->userdata('login');
                $data = array(
                    'id_permohonan_dana' => $id_permohonan_dana,
                    'id_permohonan' => $id_permohonan,
                    'id_coa' => $id_coa,
                    'id_bu' => $id_bu,
                    'realisasi_1' => $money_1,
                    'realisasi_2' => $money_2,
                    'realisasi_3' => $money_3,
                    'active' => 1,
                    'id_perusahaan' => $session['id_perusahaan'],
                    'cuser' => $session['id_user'],
                    'approval' => 0
                );

                if (empty($id_permohonan_dana))
                    $data['id_permohonan_dana'] = $this->model_permohonan->insert_permohonan_dana($data);
                else
                    $data['id_permohonan_dana'] = $this->model_permohonan->update_permohonan_dana($data);


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
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');

                $data = array('id_permohonan' => $id_permohonan);

                if (!empty($id_permohonan))
                    $data['id_permohonan'] = $this->model_permohonan->delete_permohonan($data);

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
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan = $this->input->post('id_permohonan');

                if (empty($id_permohonan))
                    $data = array();
                else
                    $data = $this->model_permohonan->get_permohonan_by_id($id_permohonan);

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

    public function ax_get_dana_by_id()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $menu_kd_menu_details = "S01";  //custom by database
            $access = $this->model_menu->selectaccess($session['id_level'], $menu_kd_menu_details);
            if (!empty($access['id_menu_details'])) {

                $id_permohonan_dana = $this->input->post('id_permohonan_dana');

                if (empty($id_permohonan_dana))
                    $data = array();
                else
                    $data = $this->model_permohonan->get_permohonan_dana_by_id($id_permohonan_dana);

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

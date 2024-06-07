<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model_menu");
        $this->load->model("model_home");
        ///constructor yang dipanggil ketika memanggil ro.php untuk melakukan pemanggilan pada model : ro.php yang ada di folder models
    }

    public function index()
    {
        // $session = $this->session->userdata('login');
        // $bulan = $this->getBulan(date("m"));
        // $tahun = date('Y');
        // $id = $this->model_home->get_id_permohonan($bulan, $tahun, $session['id_bu'])['id_permohonan'];

        // var_dump($this->model_home->get_log_cabang($id));

        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $data['nm_user'] = $session['nm_user'];
            $data['keterangan'] = $session['keterangan'];
            $data['id_user'] = $session['id_user'];
            $data['session_level'] = $session['id_level'];
            // $data['JmlBarangMasuk'] = $this->model_home->get_count_masuk()->row()->JmlBarangMasuk;
            // $data['JmlBarangKeluar'] = $this->model_home->get_count_keluar()->row()->JmlBarangKeluar;
            // $data['JmlPengiriman'] = $this->model_home->get_count_pengiriman()->row()->JmlPengiriman;
            // $data['JmlRetur'] = $this->model_home->get_count_retur()->row()->JmlRetur;

            $data['total'] = $this->model_home->get_count()['total'];
            $data['setuju'] = $this->model_home->get_count()['setuju'];
            $data['pending'] = $this->model_home->get_count()['pending'];
            $data['tolak'] = $this->model_home->get_count()['tolak'];

            $data['cabang'] = $this->model_home->get_data_permohonan($session['id_bu']);
            $data['combobox_bu'] = $this->model_home->combobox_bu();

            if (in_array($session['id_level'], [1,16,17,18,19])) {
                $this->load->view('home', $data);
            } else {
                $this->load->view('home_cabang', $data);
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function dashboard()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');
            $data['nm_user'] = $session['nm_user'];
            $data['keterangan'] = $session['keterangan'];
            $data['id_user'] = $session['id_user'];
            $data['session_level'] = $session['id_level'];
            $data['JmlBarangMasuk'] = $this->model_home->get_count_masuk()->row()->JmlBarangMasuk;
            $data['JmlBarangKeluar'] = $this->model_home->get_count_keluar()->row()->JmlBarangKeluar;
            $data['JmlPengiriman'] = $this->model_home->get_count_pengiriman()->row()->JmlPengiriman;
            $data['JmlRetur'] = $this->model_home->get_count_retur()->row()->JmlRetur;



            $this->load->view('home', $data);
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }


    public function Update()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $a = $this->input->post('password_lama');
            $b = $this->input->post('password_baru');
            if (empty($a) or empty($b)) {
                echo "<script>alert('Data Masih Ada Yang Kosong');window.location.href='javascript:history.back(-1);'</script>";
            } else {
                $c = do_hash($this->input->post('password_lama'), 'md5');
                $d = $session['password'];
                if ($d != $c) {
                    echo "<script>alert('Password Lama Salah');window.location.href='javascript:history.back(-1);'</script>";
                } else {
                    $id_user = $session['id_user'];
                    $data = array(

                        'password' => do_hash($this->input->post('password_baru'), 'md5'),

                    );
                    $this->model_home->UpdateUser($id_user, $data);
                    redirect('welcome/logout');
                }
            }
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function get_data_dashboard()
    {

        $count = $this->model_home->countdata();
        $data = $this->model_home->getdata()->result_array();

        echo json_encode(array('ccheckin' => $count['ccheckin'], 'cwloading' => $count['cwloading'], 'cloading' => $count['cloading'], 'cdelivery' => $count['cdelivery'], 'data' => $data, 'recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => 1, 'search' => ''));
    }

    public function ax_get_timeline()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $id_permohonan = $this->input->post('id_permohonan');
            $cabang = $this->model_home->get_log_cabang($id_permohonan);
            $html = '';
            foreach ($cabang as $key) {
                $time = strtotime($key['cdate']);
                $jam = date('H:i', $time);
                if ($key['approve_level'] == 1) {
                    $level = "General Manager";
                    $bidang = "";
                } elseif ($key['approve_level'] == 2) {
                    $level = 'Bidang';
                    if ($key['id_bidang'] == 1) {
                        $bidang = "Operasional";
                    } elseif ($key['id_bidang'] == 2) {
                        $bidang = "Teknik";
                    } elseif ($key['id_bidang'] == 3) {
                        $bidang = "SDM";
                    } elseif ($key['id_bidang'] == 4) {
                        $bidang = "Umum";
                    } else if($key['id_bidang'] == 5){
                        $bidang = "Keuangan";
                    }
                } elseif ($key['approve_level'] == 3) {
                    $level = "Kadiv Keuangan";
                    $bidang = "";
                } elseif ($key['approve_level'] == 4) {
                    $level = "Direktur Keuangan";
                    $bidang = "";
                }

                if ($key['status'] == 1) {
                    $logo = '<i class="fa fa-check bg-olive"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Disetujui oleh ' . $level . ' ' . $bidang . '</b></h3>';
                } else if ($key['status'] == 2) {
                    $logo = '<i class="fa fa-times bg-orange"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Ditolak oleh ' . $level . ' ' . $bidang . '</b></h3>';
                } else if ($key['status'] == 0) {
                    $logo = '<i class="fa fa-send label-primary"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Permohonan diajukan</b></h3>';
                }

                $html .= '<li>
                ' . $logo . '
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> ' . $jam . '</span>
                  ' . $hasil . '
                  <div class="timeline-body">
                    ' . $key['keterangan'] . '
                  </div>
                </div>
              </li>';
            }

            echo json_encode(array('data' => $html));
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function ax_get_timeline_pusat()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $id_permohonan = $this->input->post('id_permohonan');
            $cabang = $this->model_home->get_log_pusat($id_permohonan);
            $html = '';
            foreach ($cabang as $key) {
                $time = strtotime($key['cdate']);
                $jam = date('H:i', $time);
                if ($key['approve_level'] == 1) {
                    $level = "General Manager";
                    $bidang = "";
                } elseif ($key['approve_level'] == 2) {
                    $level = 'Bidang';
                    if ($key['id_bidang'] == 1) {
                        $bidang = "Operasional";
                    } elseif ($key['id_bidang'] == 2) {
                        $bidang = "Teknik";
                    } elseif ($key['id_bidang'] == 3) {
                        $bidang = "SDM";
                    } elseif ($key['id_bidang'] == 4) {
                        $bidang = "Umum";
                    } elseif ($key['id_bidang'] == 5) {
                        $bidang = "Keuangan";
                    }
                } elseif ($key['approve_level'] == 3) {
                    $level = "Kadiv Keuangan";
                    $bidang = "";
                } elseif ($key['approve_level'] == 4) {
                    $level = "Direktur Keuangan";
                    $bidang = "";
                }

                if ($key['status'] == 1) {
                    $logo = '<i class="fa fa-check bg-olive"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Disetujui oleh ' . $level . ' ' . $bidang . '</b></h3>';
                } else if ($key['status'] == 2) {
                    $logo = '<i class="fa fa-times bg-orange"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Ditolak oleh ' . $level . ' ' . $bidang . '</b></h3>';
                } else if ($key['status'] == 0) {
                    $logo = '<i class="fa fa-send label-primary"></i>';
                    $hasil = '<h3 class="timeline-header"><b id="hasil">Permohonan diajukan</b></h3>';
                }

                $html .= '<li>
                ' . $logo . '
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> ' . $jam . '</span>
                  ' . $hasil . '
                  <div class="timeline-body">
                    ' . $key['keterangan'] . '
                  </div>
                </div>
              </li>';
            }

            echo json_encode(array('data' => $html));
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }

    public function ax_get_permohonan()
    {
        if ($this->session->userdata('login')) {
            $session = $this->session->userdata('login');

            $id_bu = $this->input->post('id_bu');

            $data = $this->model_home->get_permohonan_by_bu($id_bu);

            echo json_encode($data);
        } else {
            redirect('welcome/relogin', 'refresh');
        }
    }


    function getBulan($bln)
    {
        switch ($bln) {
            case  1:
            case  "01":
                return  "Januari";
                break;
            case  2:
            case  "02":
                return  "Februari";
                break;
            case  3:
            case  "03":
                return  "Maret";
                break;
            case  4:
            case  "04":
                return  "April";
                break;
            case  5:
            case  "05":
                return  "Mei";
                break;
            case  6:
            case  "06":
                return  "Juni";
                break;
            case  7:
            case  "07":
                return  "Juli";
                break;
            case  8:
            case  "08":
                return  "Agustus";
                break;
            case  9:
            case  "09":
                return  "September";
                break;
            case  "10":
                return  "Oktober";
                break;
            case  "11":
                return  "November";
                break;
            case  "12":
                return  "Desember";
                break;
        }
    }
}

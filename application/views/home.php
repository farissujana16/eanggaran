<!DOCTYPE html>
<html>

<head>
  <?= $this->load->view('head'); ?>
</head>


<body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color') ?>">

  <div class="wrapper">

    <?= $this->load->view('nav'); ?>
    <?= $this->load->view('menu_groups'); ?>


    <div class="content-wrapper">
      <section class="content-header">

      </section>

      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?= $total; ?></h3>
                <p>Pengajuan</p>
              </div>
              <div class="icon">
                <i class="ion ion-clipboard"></i>
              </div>
              <?php
                $session = $this->session->userdata('login');
                
                if ($session['id_level'] == 16) {
                  echo '<a href="'.base_url().'list_approval" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>';
                } else if($session['id_level'] == 17){
                  echo '<a href="'.base_url().'approval_dana" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>';
                }
              ?>
              <!-- <a href="<?= base_url() ?>/" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?= $setuju; ?><sup style="font-size: 20px"></sup></h3>
                <p>Disetujui</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-checkmark"></i>
              </div>
              <a href="#" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?= $pending; ?><sup style="font-size: 20px"></sup></h3>
                <p>Proses</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-stopwatch"></i>
              </div>
              <a href="#" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?= $tolak; ?><sup style="font-size: 20px"></sup></h3>
                <p>Ditolak</p>
              </div>
              <div class="icon">
                <i class="ion ion-close-round"></i>
              </div>
              <a href="#" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div><!-- ./col -->
        </div><!-- /.row -->
        <br>
        <ul class="timeline">

          <!-- timeline time label -->
          <li class="time-label">
            <!-- <span class="bg-navy">
                Permohonan November 2022
              </span> -->
            <div class="form-group">
              <select class="form-control select2" style="width: 30%;" name="id_bu" id="id_bu">
                <option value="0">--Bussiness Unit--</option>
                <?php foreach ($combobox_bu as $key) { ?>
                  <option value="<?= $key['id_bu'] ?>"><?= $key['nm_bu']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control select2" style="width: 30%;" name="id_permohonan" id="id_permohonan" disabled>
                <option value="0">--Periode--</option>
              </select>
            </div>
          </li>
          <!-- /.timeline-label -->

          <!-- timeline item -->
          <div id="tampil">

          </div>

          <!-- END timeline item -->

        </ul>


      </section>



    </div>
  </div>

  <?= $this->load->view('basic_js'); ?>

  <script type='text/javascript'>
    $(document).ready(function() {});

    $('#id_bu').on('change', function() {
      var url = '<?= base_url() ?>home/ax_get_permohonan';
      var data = {
        id_bu: $('#id_bu').val()
      };
      $.ajax({
        url: url,
        method: 'POST',
        data: data
      }).done(function(data, textStatus, jqXHR) {
        var data = JSON.parse(data);
        var html = '';
        var i;
        html = '<option value="0">--Periode--</option>';
        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id_permohonan + '">' + data[i].bulan + ' ' + data[i].tahun + '</option>'

        }
        $("#id_permohonan").html(html);
        $("#id_permohonan").attr('disabled', false);


      });
    });

    $('#id_permohonan').on('change', function() {
      var url = '<?= base_url() ?>home/ax_get_timeline_pusat';
      var data = {
        id_permohonan: $('#id_permohonan').val()
      };
      $.ajax({
        url: url,
        method: 'POST',
        data: data
      }).done(function(data, textStatus, jqXHR) {
        var data = JSON.parse(data);
        $('#tampil').html(data['data']);

      });
      console.log($('#id_permohonan').val());
    });
  </script>
</body>

</html>
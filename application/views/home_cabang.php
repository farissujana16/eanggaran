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
        <ul class="timeline">

          <!-- timeline time label -->
          <li class="time-label">
            <!-- <span class="bg-navy">
              Permohonan November 2022
            </span> -->
            <div class="form-group">
              <select class="form-control select2" style="width: 30%;" name="id_permohonan" id="id_permohonan">
                <?php foreach ($cabang as $key) { ?>
                  <option value="<?= $key['id_permohonan'] ?>"><?= $key['bulan'] . ' ' . $key['tahun']; ?></option>
                <?php } ?>
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
    var url = '<?= base_url() ?>home/ax_get_timeline';
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



    $('#id_permohonan').on('change', function() {
      var url = '<?= base_url() ?>home/ax_get_timeline';
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
    });
  </script>
</body>

</html>
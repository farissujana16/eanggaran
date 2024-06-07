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
				<h1>Approval Anggaran <b><?= $permohonan['bulan'] . " " . $permohonan['tahun'] ?></b></h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">

								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-primary" onclick="kembali()"><i class="fa fa-arrow-left"></i> Kembali</button>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<table width="100%">
											<tr>
												<th style="padding-bottom:7px;" width="20%"></th>
												<th style="padding-bottom:7px;" width="20%"></th>
												<th style="padding-bottom:7px;" width="30%" id="">PENGAJUAN</th>
												<th style="padding-bottom:7px;" width="30%" id="">REALISASI</th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="20%">Total Pendapatan</th>
												<th style="padding-bottom:7px;" width="20%"><span class="label" id="pendapatan_1"><?= $permohonan['approval_1']; ?></span></th>
												<th style="padding-bottom:7px;" width="30%" id="pendapatan"> <?= $pendapatan ?> </th>
												<th style="padding-bottom:7px;" width="30%" id="realisasi_0"> <?= $realisasi_pendapatan['beban'] ?> </th>
											</tr>
										</table>
									</div>
									<div class="col-md-6">
										<table width="100%">
											<tr>
												<th style="padding-bottom:7px;" ></th>
												<th style="padding-bottom:7px;" ></th>
												<th style="padding-bottom:7px;" >PENGAJUAN</th>
												<th style="padding-bottom:7px;" >REALISASI</th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="25%">Beban OPERASIONAL</th>
												<th style="padding-bottom:7px;" width="25%"><span class="label" id="label-1"><?= $permohonan['approval_1']; ?></span></th>
												<th style="padding-bottom:7px;" width="25%" id="nilai1"> <?= $operasional ?> </th>
												<th style="padding-bottom:7px;" width="25%" id="realisasi_1"> <?= $realisasi[0]['beban'] ?> </th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="25%">Beban TEKNIK</th>
												<th style="padding-bottom:7px;" width="25%"><span class="label" id="label-2"><?= $permohonan['approval_2']; ?></span></th>
												<th style="padding-bottom:7px;" width="25%" id="nilai2"> <?= $teknik ?> </th>
												<th style="padding-bottom:7px;" width="25%" id="realisasi_2"> <?= $realisasi[1]['beban'] ?> </th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="25%">Beban SDM</th>
												<th style="padding-bottom:7px;" width="25%"><span class="label" id="label-3"><?= $permohonan['approval_3']; ?></span></th>
												<th style="padding-bottom:7px;" width="25%" id="nilai3"> <?= $sdm ?> </th>
												<th style="padding-bottom:7px;" width="25%" id="realisasi_3"> <?= $realisasi[2]['beban'] ?> </th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="25%">Beban UMUM</th>
												<th style="padding-bottom:7px;" width="25%"><span class="label" id="label-4"><?= $permohonan['approval_4']; ?></span></th>
												<th style="padding-bottom:7px;" width="25%" id="nilai4"> <?= $umum ?> </th>
												<th style="padding-bottom:7px;" width="25%" id="realisasi_4"> <?= $realisasi[3]['beban'] ?> </th>
											</tr>
											<tr>
												<th style="padding-bottom:7px;" width="25%">Beban Keuangan</th>
												<th style="padding-bottom:7px;" width="25%"><span class="label" id="label-5"><?= $permohonan['approval_5']; ?></span></th>
												<th style="padding-bottom:7px;" width="25%" id="nilai5"> <?= $keuangan ?> </th>
												<th style="padding-bottom:7px;" width="25%" id="realisasi_5"> <?= $realisasi[4]['beban'] ?> </th>
											</tr>
											<tr>
												<th style="color:white; background-color:#4CBB17;" width ="25%">Total</th>
												<th style="color:white; background-color:#4CBB17;" width ="25%"></th>
												<th id="nilai6" style="color:white; background-color:#4CBB17;" width ="25%"><?= $operasional + $teknik + $sdm + $umum + $keuangan; ?> </th>
												<th id="realisasi_total" style="color:white; background-color:#4CBB17;" width ="25%"> </th>
											</tr>
										</table>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-12">
										<label>Kategori COA</label>
										<select class="form-control select2" style="width: 100%;" name="kategori" id="kategori">
											<option value="1">Beban</option>
											<option value="2">Pendapatan</option>
										</select>
									</div>
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Catatan Revisi Anggaran</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_anggaran" name="id_anggaran" value='' />

												<div class="form-group">
													<label>Keterangan</label>
													<input type="text" id="revisi" name="revisi" class="form-control" placeholder="Keterangan">
												</div>


												<div class="form-group">
													<label>Active</label>
													<select class="form-control" id="active" name="active">
														<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
														<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
													</select>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary" id='btnSave'>Save</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>Kode COA</th>
												<th>Nama Bidang</th>
												<th>COA</th>
												<th>Masa I</th>
												<th>Masa II</th>
												<th>Masa III</th>
												<th>Total</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?= $this->load->view('basic_js'); ?>
	<script type='text/javascript'>
		var groupColumn = 1;
		var buTable = $('#buTable').DataTable({
			"columnDefs": [{
				visible: false,
				targets: groupColumn
			}],
			"ordering": false,
			"scrollX": true,
			"lengthMenu": [500],
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>approval_dana/ax_data_approval_dana_details/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": <?= $permohonan['id_permohonan']; ?>,
						"id_bu": <?= $id_bu; ?>,
						"kategori": $('#kategori').val()

					});
				}
			},
			columns: [
				{
					data: "kd_coa"
				},
				{
					data: "nm_bidang"
				},
				{
					data: "nm_coa"
				},
				{
					data: "permohonan_1",
					render: function(data, type, full, meta) {
						return "Rp. " + addKoma(data);
					}
				},
				{
					data: "permohonan_2",
					render: function(data, type, full, meta) {
						return "Rp. " + addKoma(data);
					}
				},
				{
					data: "permohonan_3",
					render: function(data, type, full, meta) {
						return "Rp. " + addKoma(data);
					}
				},
				{
					data: "permohonan_total",
					render: function(data, type, full, meta) {
						return "Rp. " + addKoma(data);
					}
				}
			],
			drawCallback: function(settings) {
				var api = this.api();
				var rows = api.rows({
					page: 'current'
				}).nodes();
				var last = null;

				api.column(groupColumn, {
						page: 'current'
					})
					.data()
					.each(function(group, i) {
						if (last !== group) {
							$(rows)
								.eq(i)
								.before('<tr class="group"><td colspan="7" style="background: #a8dede;"><b>' + group + '</b></td></tr>');

							last = group;
						}
					});
			}
		});


		function ApproveDana(id_anggaran) {
			console.log(<?= $id_bu; ?>)
			// var url = '<?= base_url() ?>approval_dana/ax_approve_permohonan';
			// var data = {
			// 	id_anggaran: id_anggaran,
			// 	id_bu: <?= $id_bu; ?>
			// };

			// $.ajax({
			// 	url: url,
			// 	method: 'POST',
			// 	data: data
			// }).done(function(data, textStatus, jqXHR) {
			// 	var data = JSON.parse(data);
			// 	buTable.ajax.reload();
			// 	alertify.success('Anggaran disetujui.');
			// });

		}

		function RejectDana(id_anggaran) {
			$('#addModal').modal('show');
			$('#id_anggaran').val(id_anggaran);
		}

		$('#btnSave').on('click', function() {
			// console.log($('#id_anggaran').val());
			if ($('#revisi').val() == '') {
				alertify.alert("Warning", "Silakan isi keterangan revisi anggaran.");
			} else {
				var url = '<?= base_url() ?>approval_dana/ax_reject_permohonan';
				var data = {
					id_anggaran: $('#id_anggaran').val(),
					revisi: $('#revisi').val(),
					id_bu: <?= $id_bu; ?>

				};
				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModal').modal('hide');
					buTable.ajax.reload();
					alertify.error('Anggaran tidak disetujui.');
				});
			}
		});

		function DeleteData(id_status_permohonan) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>status_permohonan/ax_unset_data';
					var data = {
						id_status_permohonan: id_status_permohonan
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('status_permohonan data deleted.');
					});
				},
				function() {}
			);
		}

		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}

		$('#approve').on('change', function() {
			buTable.ajax.reload();
		});

		$('#kategori').on('change', function() {
			buTable.ajax.reload();
		});

		function kembali() {
			window.location.href = "<?= base_url(); ?>approval_dana";
		}


		$('#pendapatan').html(": Rp. " + addKoma($('#pendapatan').text()));
		$('#nilai1').html(": Rp. " + addKoma($('#nilai1').text()));
		$('#nilai2').html(": Rp. " + addKoma($('#nilai2').text()));
		$('#nilai3').html(": Rp. " + addKoma($('#nilai3').text()));
		$('#nilai4').html(": Rp. " + addKoma($('#nilai4').text()));
		$('#nilai5').html(": Rp. " + addKoma($('#nilai5').text()));
		$('#nilai6').html(": Rp. " + addKoma($('#nilai6').text()));

		for (let index = 0; index <= 5; index++) {
			$('#realisasi_'+index).html(" Rp. " + addKoma($('#realisasi_'+index).text()));
		}

		<?php 
		for ($i=1; $i <= 5 ; $i++) { 
			$total += $realisasi[$i]['beban'];
		}
		?>
		$('#realisasi_total').html("Rp. " + addKoma(<?= $total ?>))

		$('#pendapatan_1').addClass(labelClass($('#pendapatan_1').text())).html(labelText($('#pendapatan_1').text()));
		$('#label-1').addClass(labelClass($('#label-1').text())).html(labelText($('#label-1').text()));
		$('#label-2').addClass(labelClass($('#label-2').text())).html(labelText($('#label-2').text()));
		$('#label-3').addClass(labelClass($('#label-3').text())).html(labelText($('#label-3').text()));
		$('#label-4').addClass(labelClass($('#label-4').text())).html(labelText($('#label-4').text()));
		$('#label-5').addClass(labelClass($('#label-5').text())).html(labelText($('#label-5').text()));

		function labelClass(nilai) {
			var label = '';
			if (nilai == 0) {
				label = 'label-default';
			} else if (nilai == 1) {
				label = 'label-warning';
			} else {
				label = 'label-danger';
			}
			return label;
		}

		function labelText(nilai) {
			var text = '';
			if (nilai == 0) {
				text = 'Mengunggu persetujuan';
			} else if (nilai == 1) {
				text = 'Disetujui';
			} else {
				text = 'Ditolak';
			}
			return text;
		}
	</script>
</body>

</html>
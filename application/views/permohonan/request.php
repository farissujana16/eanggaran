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
				<h1>Details Permohonan # <b><?= $permohonan['bulan'] . " " . $permohonan['tahun']; ?></b></h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='BackPage()'>
									<i class='fa fa-arrow-left'></i> Kembali
								</button> Permohonan
								<br><br>
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
									<div class="col-md-6">
										<div class="form-group">
											<label>Bidang</label>
											<select class="form-control select2" style="width: 100%;" name="bidang" id="bidang">
												<option value="0">--Bidang--</option>
												<?php foreach ($bidang as $key) { ?>
													<option value="<?= $key['id_bidang'] ?>"><?= $key['nm_bidang'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Jenis Input</label>
											<select class="form-control select2" style="width: 100%;" name="kategori" id="kategori">
												<option value="1">Beban</option>
												<option value="2">Pendapatan</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Permohonan</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan_dana" name="id_permohonan_dana" value='0' />
												<input type="hidden" id="id_coa" name="id_coa" value='' />
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Masa 1</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_1" id="money_1" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label>Masa 2</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_2" id="money_2" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label>Masa 3</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_3" id="money_3" class="form-control">
															</div>
														</div>
														<div id="catatan">

														</div>
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
							</div>
							<div class="panel-body">
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>Action</th>
												<th>#</th>
												<th>KD COA</th>
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
			</section>
		</div>
	</div>
	<?= $this->load->view('basic_js'); ?>
	<script src="<?= base_url() ?>/assets/js/jquery-maskmoney.js"></script>

	<script type='text/javascript'>
		
		$('#kategori').prop('disabled', true);

		$("#money_1").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 0
		});
		$("#money_2").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 0
		});
		$("#money_3").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 0
		});
		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"lengthMenu": [500],
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			oLanguage: {sProcessing: $('.loader').hide()},
			ajax: {
				url: "<?= base_url() ?>permohonan/ax_data_permohonan_request/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": <?= $permohonan['id_permohonan']; ?>,
						// "masa": $('#masa').val(),
						"bidang": $('#bidang').val(),
						"kategori" : $('#kategori').val()

					});
				}
			},
			// "createdRow": function(row, data, dataIndex) {
			// 	if (data['id_periode'] == 2) {
			// 		$(row).css('background-color', '#a8dede');
			// 	}
			// },
			columns: [{
					data: "id_permohonan_dana",
					render: function(data, type, full, meta) {
						var str = '';
						var dis = '';
						var approve = <?= $app ?>;
						var bidang_1 = <?= $permohonan['approval_1'] ?>;
						var bidang_2 = <?= $permohonan['approval_2'] ?>;
						var bidang_3 = <?= $permohonan['approval_3'] ?>;
						var bidang_4 = <?= $permohonan['approval_4'] ?>;
						var bidang_5 = <?= $permohonan['approval_5'] ?>;

						if (<?= $this->session->userdata('login')['id_level'] ?> == 19) {
							dis = 'disabled';
						}else{
							if (approve == 8 || approve == 5) {
								dis = '';
							}else{
								dis = 'disabled';
	
								// if (full.approval == 2) {
								// 	dis = '';
								// }
							}
						}

						
						str += '<button class="btn btn-warning" onclick="ViewData(' + data + ',' + full.id_coa + ',`' + full.kd_coa + '`)" ' + dis + '><i class="fa fa-pencil"></i></button>';

						return str;
					}
				},
				{
					data: "id_coa"
				},
				{
					data: "kd_coa"
				},
				{
					data: "nm_coa"
				},
				{
					data: "permohonan_1",
					render: function(data, type, full, meta) {
						var str = '';
						str += 'Rp. ' + addKoma(data) + '';
						return str;
					}
				},
				{
					data: "permohonan_2",
					render: function(data, type, full, meta) {
						var str = '';
						str += 'Rp. ' + addKoma(data) + '';
						return str;
					}
				},
				{
					data: "permohonan_3",
					render: function(data, type, full, meta) {
						var str = '';
						str += 'Rp. ' + addKoma(data) + '';
						return str;
					}
				},
				{
					data: "permohonan_total",
					render: function(data, type, full, meta) {
						var str = '';
						str += 'Rp. ' + addKoma(data) + '';
						return str;
					}
				}
			]
		});

		$('#btnSave').on('click', function() {
			$('#btnSave').prop('disabled', true);
			$('.loader').show();

			// if ($('#money_1').val() == '0' || $('#money_2').val() == '0' || $('#money_3').val() == '0') {
			// 	alertify.alert("Warning", "Silahkan isi nominal anggaran terlebih dahulu.");
			// } else {
				var url = '<?= base_url() ?>permohonan/ax_set_data_dana';
				var data = {
					id_permohonan_dana: $('#id_permohonan_dana').val(),
					id_permohonan: <?= $permohonan['id_permohonan'] ?>,
					// masa: $('#masa').val(),
					id_coa: $('#id_coa').val(),
					money_1: $('#money_1').val().replace(/\s|[.]/g, ''),
					money_2: $('#money_2').val().replace(/\s|[.]/g, ''),
					money_3: $('#money_3').val().replace(/\s|[.]/g, ''),
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data,
					statusCode: {
						500: function() {
							alertify.alert("Warning", "Data Duplicate");
						}
					}
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("permohonan data saved.");
						$('#btnSave').prop('disabled', false);
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			// }
		});

		function ViewData(id_permohonan_dana, id_coa, kd_coa) {
			// console.log(id_permohonan_dana);
			// var masa = $('#masa').val();
			// console.log(id_coa);
			if (id_permohonan_dana == 0) {
				$('#addModalLabel').html('Add Anggaran <b>' + kd_coa + '</b>');
				$('#id_permohonan_dana').val('0');
				$('#money_1').val('0');
				$('#money_2').val('0');
				$('#money_3').val('0');
				$('#id_coa').val(id_coa);
				$('#catatan').html("");
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>permohonan/ax_get_dana_by_id';
				var data = {
					id_permohonan_dana: id_permohonan_dana
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit Anggaran <b>' + kd_coa + '</b>');
					$('#id_permohonan_dana').val(data['id_permohonan_dana']);
					$('#money_1').val(data['permohonan_1'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#money_2').val(data['permohonan_2'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#money_3').val(data['permohonan_3'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#id_coa').val(id_coa);
					$('#addModal').modal('show');
				});
			}
		}

		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}

		// function DeleteData(id_permohonan) {
		// 	alertify.confirm(
		// 		'Confirmation',
		// 		'Are you sure you want to delete this data?',
		// 		function() {
		// 			var url = '<?= base_url() ?>permohonan/ax_unset_data';
		// 			var data = {
		// 				id_permohonan: id_permohonan
		// 			};

		// 			$.ajax({
		// 				url: url,
		// 				method: 'POST',
		// 				data: data
		// 			}).done(function(data, textStatus, jqXHR) {
		// 				var data = JSON.parse(data);
		// 				buTable.ajax.reload();
		// 				alertify.error('permohonan data deleted.');
		// 			});
		// 		},
		// 		function() {}
		// 	);
		// }

		function BackPage() {
			window.location.href = "<?= base_url(); ?>permohonan";
		}

		// $('#masa').on('change', function() {
		// 	buTable.ajax.reload();
		// });

		$('#bidang').on('change', function() {
			if ($('#bidang').val() == 1) {
				$('#kategori').prop('disabled', false);
			}else{
				$('#kategori').prop('disabled', true);
			}
			$('.loader').show();
			buTable.ajax.reload();
		});

		$('#kategori').on('change', function() {
			$('.loader').show();
			buTable.ajax.reload();
		});


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
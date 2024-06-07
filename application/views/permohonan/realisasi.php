<!DOCTYPE html>
<html>

<head>
	<?= $this->load->view('head'); ?>
</head>

<body class="sidebar-mini wysihtml5-supported sidebar-collapse <?= $this->config->item('color') ?>">
	<div class="wrapper">
		<?= $this->load->view('nav'); ?>
		<?= $this->load->view('menu_groups'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Details Permohonan dan Realisasi # <b><?= $permohonan['bulan'] . " " . $permohonan['tahun']; ?></b></h1>
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
									<div class="col-md-12">
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
									<!-- <div class="col-md-6">
										<div class="form-group">
											<label>Pilih Masa</label>
											<select class="form-control select2" style="width: 100%;" name="masa" id="masa">
												<option value="1">Masa 1</option>
												<option value="2">Masa 2</option>
												<option value="3">Masa 3</option>
											</select>
										</div>
									</div> -->
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Permohonan</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan_dana" name="id_permohonan_dana" value='' />
												<input type="hidden" id="id_coa" name="id_coa" value='' />
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Masa 1</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_1" id="money_1" class="form-control" <?= $masa_1?>>
															</div>
														</div>
														<div class="form-group">
															<label>Masa 2</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_2" id="money_2" class="form-control" <?= $masa_2?>>
															</div>
														</div>
														<div class="form-group">
															<label>Masa 3</label>
															<div class="input-group">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="money_3" id="money_3" class="form-control" <?= $masa_3?>>
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
										<thead class="text-center">
											<tr>
												<th rowspan="2">Action</th>
												<th rowspan="2">KD COA</th>
												<th rowspan="2">COA</th>
												<th colspan="2">Masa I</th>
												<th colspan="2">Masa II</th>
												<th colspan="2">Masa III</th>
												<th colspan="2">Total</th>
											</tr>
											<tr>
												<th>Permohonan</th>
												<th>Realisasi</th>
												<th>Permohonan</th>
												<th>Realisasi</th>
												<th>Permohonan</th>
												<th>Realisasi</th>
												<th>Permohonan</th>
												<th>Realisasi</th>
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
			// columnDefs: [
			// 	{
			// 		className: 'dt-head-center'
			// 	}
			// ],
			oLanguage: {sProcessing: $('.loader').hide()},
			ajax: {
				url: "<?= base_url() ?>permohonan/ax_data_permohonan_realisasi/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": <?= $permohonan['id_permohonan']; ?>,
						// "masa": $('#masa').val(),
						"bidang": $('#bidang').val(),

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
						// if (full.approval == 1 || full.approval == 3) {
						// 	dis = 'disabled';
						// } else {
						// 	dis = '';
						// }

						if (data == 0) {
							dis = 'disabled';
						}else{
							dis = '';
						}
						str += '<button class="btn btn-warning" onclick="ViewData(' + data + ',' + full.id_coa + ',' + full.kd_coa + ')" ' + dis + '><i class="fa fa-pencil"></i></button>';

						return str;
					}
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
					data: "realisasi_1",
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
					data: "realisasi_2",
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
					data: "realisasi_3",
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
				},
				{
					data: "realisasi_total",
					render: function(data, type, full, meta) {
						var str = '';
						str += 'Rp. ' + addKoma(data) + '';
						return str;
					}
				}
			]
		});

		$('#btnSave').on('click', function() {

			if ($('#money_1').val() == '0' && $('#money_2').val() == '0' && $('#money_3').val() == '0') {
				alertify.alert("Warning", "Silahkan isi nominal anggaran terlebih dahulu.");
			} else {
				var url = '<?= base_url() ?>permohonan/ax_set_data_dana_realisasi';
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
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("permohonan data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_permohonan_dana, id_coa, kd_coa) {
			// console.log(id_permohonan_dana);
			// var masa = $('#masa').val();
			// console.log(id_coa);
			if (id_permohonan_dana == 0) {
				$('#addModalLabel').html('Add Realisasi <b>' + kd_coa + '</b>');
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
					$('#addModalLabel').html('Edit Realisasi <b>' + kd_coa + '</b>');
					$('#id_permohonan_dana').val(data['id_permohonan_dana']);
					$('#money_1').val(data['realisasi_1'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#money_2').val(data['realisasi_2'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#money_3').val(data['realisasi_3'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
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
			$('.loader').show();
			buTable.ajax.reload();
		});
	</script>
</body>

</html>
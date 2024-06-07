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
				<h1>Permohonan</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<?php if ($this->session->userdata('login')['id_level'] == 17 || $this->session->userdata('login')['id_level'] == 1 || $this->session->userdata('login')['id_level'] == 14) { ?>
									<button id="btnTambah" class="btn btn-primary" onclick='ViewData(0)'>
										<i class='fa fa-plus'></i> Add Permohonan
									</button>
								<?php } ?>
								<br><br>
								<div class="form-group">
									<label>Bussines Unit</label>
									<select class="form-control select2" style="width: 100%;" name="id_bu" id="id_bu">
										<option value="0">--Bussiness Unit--</option>
										<?php foreach ($bu as $key) { ?>
											<option value="<?php echo $key['id_bu'] ?>"><?php echo $key['nm_bu'] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Permohonan</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan" name="id_permohonan" value='0' />
												<input type="hidden" id="active" name="active" value='1' />
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>Bulan</label>
															<select class="form-control select2" style="width: 100%;" name="bulan" id="bulan">
																<option value="0">--Bulan--</option>
																<option value="Januari">Januari</option>
																<option value="Februari">Februari</option>
																<option value="Maret">Maret</option>
																<option value="April">April</option>
																<option value="Mei">Mei</option>
																<option value="Juni">Juni</option>
																<option value="Juli">Juli</option>
																<option value="Agustus">Agustus</option>
																<option value="September">September</option>
																<option value="Oktober">Oktober</option>
																<option value="November">November</option>
																<option value="Desember">Desember</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Tahun</label>
															<select class="form-control select2" style="width: 100%;" name="tahun" id="tahun">
																<option value="0">--Tahun--</option>
																<?php foreach ($tahun as $year) { ?>
																	<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>


												<!-- <div class="form-group">
													<label>Active</label>
													<select class="form-control" id="active" name="active">
														<option value="1" <?php echo set_select('myselect', '1', TRUE); ?>>Active</option>
														<option value="0" <?php echo set_select('myselect', '0'); ?>>Not Active</option>
													</select>
												</div> -->
												<!-- <div class="form-group">
													<label>Nominal</label>
													<div class="input-group">
														<span class="input-group-addon">Rp</span>
														<input type="text" name="money" id="money" class="form-control">
													</div>
												</div> -->
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
												<th>Options</th>
												<th>#</th>
												<th>Permohonan</th>
												<th>Beban</th>
												<th>Pendapatan</th>
												<th>Status</th>
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
	<!-- <script src="<?= base_url() ?>/assets/js/jquery-maskmoney.js"></script> -->
	<script type='text/javascript'>
		// $("#money").maskMoney({
		// 	thousands: '.',
		// 	decimal: ',',
		// 	affixesStay: false,
		// 	precision: 0
		// });
		$('#tahun').select2({
			dropdownParent: $('#addModal')
		});
		$('#bulan').select2({
			dropdownParent: $('#addModal')
		});

		var tanggal = new Date();
		var date = String(tanggal.getDate());
		var level = <?= $session_level; ?>;

		// if (level == 17) {
		// 	$('#btnTambah').prop('disabled', false);
		// } else {
		// 	if (date >= '15' && date <= '21') {
		// 		$('#btnTambah').prop('disabled', false);
		// 	} else {
		// 		$('#btnTambah').prop('disabled', true);
		// 	}
		// }

		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>permohonan/ax_data_permohonan/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_bu": $('#id_bu').val()

					});
				}
			},
			columns: [{
					data: "id_permohonan",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						<?php if (in_array($this->session->userdata('login')['id_level'], [13,14,1,19])) { ?>
							str += '<li><a href="<?= base_url() ?>permohonan/request/' + data + '"><i class="fa fa-list"></i> Details</a></li>';
						<?php } ?>
						
						if (full.approval == 7 && <?= in_array($this->session->userdata('login')['id_level'], [13,14,1,19]) ?>) {
							str += '<li><a href="<?= base_url() ?>permohonan/realisasi/' + data + '"><i class="fa fa-money"></i> Realisasi</a></li>';
						}
						if (full.approval == null || full.approval == 5) {
							<?php if (!in_array($this->session->userdata('login')['id_level'],[13,19])) { ?>
								str += '<li><a onclick="SendData(' + data + ')"><i class="fa fa-send"></i> Send Anggaran</a></li>';
								str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
								str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
							<?php } ?>
						}
						// if (numberMonth(full.bulan) >= bulan() && full.tahun == new Date().getFullYear()) {
							
						// }
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_permohonan"
				},
				{
					data: "bulan",
					render: function(data, type, full, meta) {
						return data + " " + full.tahun
					}
				},
				{
					data: "total_anggaran",
					render: function(data, type, full, meta) {
						var total;
						if (data == null) {
							total = 0;
						}else{
							total = data;
						}
						return "Rp. "+addKoma(total);
					}
					
				},
				{
					data: "pendapatan",
					render: function(data, type, full, meta) {
						return "Rp. "+addKoma(data);
					}
					
				},

				{
					data: "approval",
					render: function(data, type, full, meta) {
						var str = '';
						if (data == 7) {
							str += '<span style="font-size: 9pt;" class="label label-success"><i class="fa fa-check"></i> Disetujui</span>';
						} else if (data == 1) {
							str += '<span style="font-size: 9pt;" class="label label-warning"><i class="fa fa-check"></i> Disetujui GM</span>';
						} else if (data == 2) {
							str += '<span style="font-size: 9pt;" class="label label-warning"><i class="fa fa-check"></i> Persetujuan KADIV</span>';
						} else if (data == 3) {
							str += '<span style="font-size: 9pt;" class="label label-success"><i class="fa fa-check"></i> Disetujui KADIV</span>';
						} else if (data == 4) {
							str += '<span style="font-size: 9pt;" class="label label-success"><i class="fa fa-check"></i> Disetujui DIRKU</span>';
						} else if (data == 5) {
							str += '<span style="font-size: 9pt;" class="label label-danger"><i class="fa fa-times"></i> Rejected</span>';
						} else if (data == null) {
							str += '<span style="font-size: 9pt;" class="label label-default"><i class="fa fa-clock-o"></i> Proses Input</span>';
						} else {
							str += '<span style="font-size: 9pt;" class="label label-default"><i class="fa fa-clock-o"></i> Persetujuan GM</span>';
						}
						if (numberMonth(full.bulan) >= bulan() && full.tahun == new Date().getFullYear()) {
						}else{
							str += '<span style="font-size: 9pt;" class="label label-default"><i class="fa fa-lock-o"></i> Locked</span>';
						}
						return str;
					}
				}
			]
		});

		$('#btnSave').on('click', function() {
			$(".loader").show();
			if ($('#nm_permohonan').val() == '') {
				alertify.alert("Warning", "Please fill bu Name.");
			} else {
				var url = '<?= base_url() ?>permohonan/ax_set_data';
				var data = {
					id_permohonan: $('#id_permohonan').val(),
					id_kota: $('#id_kota').val(),
					id_bu: $('#id_bu').val(),
					bulan: $('#bulan').val(),
					tahun: $('#tahun').val(),
					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data,
					statusCode: {
							500: function() {
								swal('error', 'Gagal', 'Data Duplicate.');
								$(".loader").hide();
							}
						}
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("permohonan data saved.");
						$('#addModal').modal('hide');
						$(".loader").hide();
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_permohonan) {
			if ($('#id_bu').val() == 0) {
				alertify.alert("Warning", "Pilih Bussiness Unit terlebih dahulu");
			} else {

				if (id_permohonan == 0) {
					$('#addModalLabel').html('Add Permohonan');
					$('#id_permohonan').val('0');
					$('#select2-bulan-container').html('--Bulan--');
					$('#select2-tahun-container').html('--Tahun--');
					$('#active').val('1');
					$('#addModal').modal('show');
				} else {
					var url = '<?= base_url() ?>permohonan/ax_get_data_by_id';
					var data = {
						id_permohonan: id_permohonan
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						$('#addModalLabel').html('Edit Permohonan');
						$('#id_permohonan').val(data['id_permohonan']);
						$('#bulan').val(data['bulan']).trigger('--Bulan--');
						$('#tahun').val(data['tahun']).trigger('--Tahun--');
						$('#active').val(data['active']);
						$('#addModal').modal('show');
					});
				}
			}
		}

		function DeleteData(id_permohonan) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>permohonan/ax_unset_data';
					var data = {
						id_permohonan: id_permohonan
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('permohonan data deleted.');
					});
				},
				function() {}
			);
		}

		function SendData(id_permohonan) {
			alertify.confirm(
				'Confirmation',
				'Apakah anda yakin mengirimkan data ini?',
				function() {
					var url = '<?= base_url() ?>permohonan/ax_send_data';
					var data = {
						id_permohonan: id_permohonan,
						id_bu: $('#id_bu').val()
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.success('Permohonan data sended.');
					});
				},
				function() {}
			);
		}

		$('#id_bu').on("change", function() {
			buTable.ajax.reload();
			console.log($('#id_bu').val());
		});

		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}

		function bulan(){
			const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
			"Juli", "Agustus", "September", "Oktober", "November", "Desember"
			];

			const d = new Date();
			return d.getMonth();
		}

		function numberMonth(bulan){
			const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
			"Juli", "Agustus", "September", "Oktober", "November", "Desember"
			];

			return monthNames.indexOf(bulan);
		}

		

	console.log(bulan());
	</script>
</body>

</html>
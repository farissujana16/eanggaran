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
				<h1>List Approval Anggaran <b><?= $permohonan['bulan'] . " " . $permohonan['tahun'] ?></b></h1>
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
										<table>
										<tr>
												<th>Pendapatan Masa I</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai_1"></th>
											</tr>
											<tr>
												<th>Pendapatan Masa II</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai_2"></th>
											</tr>
											<tr>
												<th>Pendapatan Masa III</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai_3"></th>
											</tr>
											<tr>
												<th style="color:white; background-color:#4CBB17;">Total Pendapatan</th>
												<th style="color:white; background-color:#4CBB17;">: Rp.</th>
												<th id="nilai_5" style="color:white; background-color:#4CBB17;" width="13%"></th>
											</tr>
											<!-- <tr>
												<th>Total Pendapatan</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="pendapatan"></th>
											</tr> -->
										</table>
									</div>
									<div class="col-md-6">
										<table>
											<tr>
												<th>Beban Masa I</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai1"></th>
											</tr>
											<tr>
												<th>Beban Masa II</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai2"></th>
											</tr>
											<tr>
												<th>Beban Masa III</th>
												<th>: Rp.</th>
												<th width="30%" style="text-align:right;" id="nilai3"></th>
											</tr>
											<tr>
												<th style="color:white; background-color:#4CBB17;">Total Beban</th>
												<th style="color:white; background-color:#4CBB17;">: Rp.</th>
												<th id="nilai5" style="color:white; background-color:#4CBB17;" width="13%"></th>
											</tr>
										</table>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col col-md-5">
										<div class="form-group">
											<label>Bidang</label>
											<select name="id_bidang" id="id_bidang" class="form-control select2" style="width: 100%;">
												<option value="0">--Bidang--</option>
												<?php foreach ($bidang as $key) { ?>
													<option value="<?= $key['id_bidang'] ?>"><?= $key['nm_bidang'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-5">
										<label>Kategori COA</label>
										<select class="form-control select2" style="width: 100%;" name="kategori" id="kategori">
											<option value="1">Beban</option>
											<option value="2">Pendapatan</option>
										</select>
									</div>
									<div class="col col-md-1">
										<label>Approve</label>
										<button id="terima" onclick="ApproveDana(<?= $permohonan['id_permohonan'] ?>)" disabled class="btn btn-success"><i class="fa fa-check"></i></button>
									</div>
									<div class="col col-md-1">
										<label>Reject</label>
										<button id="tolak" onclick="RejectDana(<?= $permohonan['id_permohonan'] ?>)" disabled class="btn btn-danger"><i class="fa fa-times"></i></button>
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
												<input type="hidden" id="id_permohonan" name="id_permohonan" value='' />

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
		let masa1 = 0;
		let masa2 = 0;
		let masa3 = 0;
		let pendapatan = 0;
		let total = 0;
		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"lengthMenu": [500],
			"processing": true,
			"serverSide": true,
			oLanguage: {sProcessing: $('.loader').hide()},
			ajax: {
				url: "<?= base_url() ?>list_approval/ax_data_list_approval_details/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": <?= $permohonan['id_permohonan']; ?>,
						"id_bu": <?= $id_bu; ?>,
						"id_bidang": $('#id_bidang').val(),
						"kategori": $('#kategori').val(),

					});
				}
			},
			"createdRow": function(row, data, index) {
				
					masa1 += parseInt(data['permohonan_1']);
					masa2 += parseInt(data['permohonan_2']);
					masa3 += parseInt(data['permohonan_3']);
				
				totalSemua(masa1, masa2, masa3);
			},

			columns: [

				{
					data: "kd_coa"
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
			]
		});


		function ApproveDana(id_permohonan) {
			console.log(id_permohonan);
			var url = '<?= base_url() ?>list_approval/ax_approve_permohonan';
			var data = {
				id_permohonan: id_permohonan,
				id_bidang: $('#id_bidang').val(),
				id_bu: <?= $id_bu; ?>

			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				buTable.ajax.reload();
				masa1 = 0;
				masa2 = 0;
				masa3 = 0;
				alertify.success('Anggaran disetujui.');
				if (data.data != 0) {
					$('#terima').prop("disabled", true);
					$('#tolak').prop("disabled", true);
				} else {
					$('#terima').prop("disabled", false);
					$('#tolak').prop("disabled", false);
				}
			});

		}

		function RejectDana(id_permohonan) {
			$('#addModal').modal('show');
			$('#id_permohonan').val(id_permohonan);
		}

		$('#btnSave').on('click', function() {
			// console.log($('#id_anggaran').val());
			if ($('#revisi').val() == '') {
				alertify.alert("Warning", "Silakan isi keterangan revisi anggaran.");
			} else {
				var url = '<?= base_url() ?>list_approval/ax_reject_permohonan';
				var data = {
					id_permohonan: $('#id_permohonan').val(),
					revisi: $('#revisi').val(),
					id_bidang: $('#id_bidang').val(),
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
					masa1 = 0;
					masa2 = 0;
					masa3 = 0;
					alertify.error('Anggaran tidak disetujui.');
					if (data.data != 0) {
						$('#terima').prop("disabled", true);
						$('#tolak').prop("disabled", true);
					} else {
						$('#terima').prop("disabled", false);
						$('#tolak').prop("disabled", false);
					}
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

		$('#id_bidang').on('change', function() {
			$('.loader').show();
			buTable.ajax.reload();
			// console.log(masa1);
			masa1 = 0;
			masa2 = 0;
			masa3 = 0;

			if ($('#id_bidang').val() == 1) {
				$('#kategori').prop("disabled", false);
			}else{
				$('#kategori').prop("disabled", true);
			}


			if ($('#id_bidang').val() == 0) {
				$('#terima').prop("disabled", true);
				$('#tolak').prop("disabled", true);
			}else{
				var url = '<?= base_url() ?>list_approval/ax_data_approval_permohonan';
				var data = {
					id_permohonan: <?= $permohonan['id_permohonan'] ?>,
					id_bidang: $('#id_bidang').val()
	
				};
				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
	
					if (data.data == 1) {
						$('#terima').prop("disabled", true);
						$('#tolak').prop("disabled", true);
					} else {
						$('#terima').prop("disabled", false);
						$('#tolak').prop("disabled", false);
					}
					// console.log(data);
					// console.log(data.data.id_permohonan);
				});
			}
		});

		$('#kategori').on('change', function(){
			$('.loader').show();
			buTable.ajax.reload();
			masa1 = 0;
			masa2 = 0;
			masa3 = 0;
			if ($('#kategori').val() == 1) {
				$('#nilai_1').html(0);
				$('#nilai_2').html(0);
				$('#nilai_3').html(0);
				$('#nilai_5').html(0);
			}else{
				$('#nilai1').html(0);
				$('#nilai2').html(0);
				$('#nilai3').html(0);
				$('#nilai5').html(0);

			}
		});

		function totalSemua(a, b, c) {
			if ($('#kategori').val() == 1) {
				$('#nilai1').html(addKoma(a));
				$('#nilai2').html(addKoma(b));
				$('#nilai3').html(addKoma(c));
				$('#nilai5').html(addKoma(a + b + c));
			}else{
				$('#nilai_1').html(addKoma(a));
				$('#nilai_2').html(addKoma(b));
				$('#nilai_3').html(addKoma(c));
				$('#nilai_5').html(addKoma(a + b + c));

			}
		}
		
		function kembali() {
			window.location.href = "<?= base_url(); ?>list_approval";
		}
		
		$('#pendapatan').html(addKoma(<?= $pendapatan['total'];?>));
		$('#kategori').prop("disabled", true);

	</script>
</body>

</html>
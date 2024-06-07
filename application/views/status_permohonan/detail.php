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
				<h1>Status Pengajuan <b><?= $permohonan['bulan'] . " " . $permohonan['tahun'] ?></b></h1>
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
									<div class="col-md-4">
										<table>
											<tr>
												<th style="color:white; background-color:#4CBB17;">Total Pendapatan</th>
												<th style="color:white; background-color:#4CBB17;" width="35%" id="pendapatan"> <?= $pendapatan['total']; ?> </th>
											</tr>
										</table>
									</div>
									<div class="col-md-4">
										<table>
											
											<tr>
												<th>Beban OPERASIONAL</th>
												<th width="35%" id="nilai1"> <?= $operasional ?> </th>
											</tr>
											<tr>
												<th>Beban TEKNIK</th>
												<th width="35%" id="nilai2"> <?= $teknik ?> </th>
											</tr>
											<tr>
												<th>Beban SDM</th>
												<th width="35%" id="nilai3"> <?= $sdm ?> </th>
											</tr>
											<tr>
												<th>Beban UMUM</th>
												<th width="35%" id="nilai4"> <?= $umum ?> </th>
											</tr>
											<tr>
												<th>Beban KEUANGAN</th>
												<th width="35%" id="nilai5"> <?= $keuangan ?> </th>
											</tr>
											<tr>
												<th style="color:white; background-color:#4CBB17;">Total Beban</th>
												<th id="nilai6" style="color:white; background-color:#4CBB17;" width="13%"><?= $operasional + $teknik + $sdm + $umum + $keuangan; ?> </th>
											</tr>
										</table>
									</div>
									<div class="col-md-4">
										<table>
											<tr>
												<th>Total Pendapatan</th>
												<th width="40%" id="tot_pendapatan"><?= $pendapatan['total']; ?> </th>
											</tr>
											<tr>
												<th>Total Beban</th>
												<th width="40%" id="tot_beban"><?= $operasional + $teknik + $sdm + $umum + $keuangan; ?> </th>
											</tr>
										</table>
										<div class="row">
											<div class="col-md-10">
												<hr style="height:1px;border:none;color:#333;background-color:#333;">
											</div>
											<div class="col-md-2">
												<hr style="width: 10px; height:1px;border:none;color:#333;background-color:#333;">
											</div>
										</div>
										<table>
											<tr>
												<th>Margin Anggaran</th>
												<th width="40%" id="margin"> </th>
											</tr>
										</table>
									</div>
								</div>
								<br>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Catatan Revisi Anggaran</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan" name="id_permohonan" value='' />
												<input type="hidden" id="kd_coa" name="kd_coa" value='' />
												<input type="hidden" id="id_coa" name="id_coa" value='' />
												<input type="hidden" id="id_bu" name="id_bu" value='' />


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
								<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Kateori COA</label>
										<select class="form-control select2" style="width: 100%;" name="kategori" id="kategori">
											<option value="1">Beban</option>
											<option value="2">Pendapatan</option>
										</select>
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
		var groupColumn = 2;
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
				url: "<?= base_url() ?>status_permohonan/ax_data_status_permohonan_details/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": <?= $permohonan['id_permohonan']; ?>,
						"kategori": $('#kategori').val(),
						"approve": $('#approve').val()

					});
				}
			},
			columns: [{
					data: "id_anggaran",
					render: function(data, type, full, meta) {
						var str = '';
						var non = '';
						if (data != 0) {
							non = 'disabled';
						}
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' + non + '>Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ApproveDana(' + full.kd_coa + ',' + full.id_coa + ',<?= $id_bu; ?>,<?= $permohonan['id_permohonan']; ?>)"><i class="fa fa-check" style="color: #00a65a;"></i> Approve</a></li>';
						str += '<li><a onClick="RejectDana(' + full.kd_coa + ',' + full.id_coa + ',<?= $id_bu; ?>,<?= $permohonan['id_permohonan']; ?>)"><i class="fa fa-times" style="color: #f56954;"></i> Reject</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

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

		function ApproveDana(kd_coa, id_coa, id_bu, id_permohonan) {
			console.log(id_bu);
			var url = '<?= base_url() ?>status_permohonan/ax_approve_permohonan';
			var data = {
				kd_coa: kd_coa,
				id_coa: id_coa,
				id_bu: id_bu,
				id_permohonan: id_permohonan
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				buTable.ajax.reload();
				alertify.success('Anggaran disetujui.');
			});

		}

		function RejectDana(kd_coa, id_coa, id_bu, id_permohonan) {
			$('#addModal').modal('show');
			$('#kd_coa').val(kd_coa);
			$('#id_coa').val(id_coa);
			$('#id_bu').val(id_bu);
			$('#id_permohonan').val(id_permohonan);
		}

		$('#btnSave').on('click', function() {
			if ($('#revisi').val() == '') {
				alertify.alert("Warning", "Mohon untuk mengisi catatan revisi anggaran.");
			} else {
				var url = '<?= base_url() ?>status_permohonan/ax_reject_permohonan';
				var data = {
					kd_coa: $('#kd_coa').val(),
					id_coa: $('#id_coa').val(),
					id_bu: $('#id_bu').val(),
					id_permohonan: $('#id_permohonan').val(),
					revisi: $('#revisi').val()
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
			console.log($('#kategori').val());
		});

		function kembali() {
			window.location.href = "<?= base_url(); ?>status_permohonan";
		}

		var dapat = parseInt($('#pendapatan').text());
		var beban = parseInt($('#nilai6').text());
		var hasil = dapat-beban;
		$('#margin').html(": Rp. " + addKoma(hasil))
		$('#pendapatan').html(": Rp. " + addKoma($('#pendapatan').text()));
		$('#nilai1').html(": Rp. " + addKoma($('#nilai1').text()));
		$('#nilai2').html(": Rp. " + addKoma($('#nilai2').text()));
		$('#nilai3').html(": Rp. " + addKoma($('#nilai3').text()));
		$('#nilai4').html(": Rp. " + addKoma($('#nilai4').text()));
		$('#nilai5').html(": Rp. " + addKoma($('#nilai5').text()));
		$('#nilai6').html(": Rp. " + addKoma($('#nilai6').text()));
		$('#tot_beban').html(": Rp. " + addKoma($('#tot_beban').text()));
		$('#tot_pendapatan').html(": Rp. " + addKoma($('#tot_pendapatan').text()));

	</script>
</body>

</html>
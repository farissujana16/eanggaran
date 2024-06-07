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
								<!-- <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Permohonan</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan" name="id_permohonan" value='' />
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
								</div> -->
							</div>
							<div class="panel-body">
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover" id="buTable">
										<thead>
											<tr>
												<th>Options</th>
												<th>#</th>
												<th>Masa</th>
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
	<script type='text/javascript'>
		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>permohonan/ax_data_permohonan_details/",
				type: 'POST',
				data: {
					id_permohonan: <?= $permohonan['id_permohonan'] ?>
				}
			},
			// "createdRow": function(row, data, dataIndex) {
			// 	if (data['id_periode'] == 2) {
			// 		$(row).css('background-color', '#a8dede');
			// 	}
			// },
			columns: [{
					data: "id_permohonan_masa",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a href="<?= base_url() ?>permohonan/request/' + data + '"><i class="fa fa-plus"></i> Add Anggaran</a></li>';
						// str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-plus"></i> Add Anggaran</a></li>';
						// str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_permohonan_masa"
				},
				{
					data: "nm_periode"
				},

				{
					data: "active",
					render: function(data, type, full, meta) {
						if (data == 1)
							return "Active";
						else return "Not Active";
					}
				}
			]
		});

		// $('#btnSave').on('click', function() {
		// 	if ($('#nm_permohonan').val() == '') {
		// 		alertify.alert("Warning", "Please fill bu Name.");
		// 	} else {
		// 		var url = '<?= base_url() ?>permohonan/ax_set_data';
		// 		var data = {
		// 			id_permohonan: $('#id_permohonan').val(),
		// 			id_kota: $('#id_kota').val(),
		// 			bulan: $('#bulan').val(),
		// 			tahun: $('#tahun').val(),
		// 			active: $('#active').val()
		// 		};

		// 		$.ajax({
		// 			url: url,
		// 			method: 'POST',
		// 			data: data
		// 		}).done(function(data, textStatus, jqXHR) {
		// 			var data = JSON.parse(data);
		// 			if (data['status'] == "success") {
		// 				alertify.success("permohonan data saved.");
		// 				$('#addModal').modal('hide');
		// 				buTable.ajax.reload();
		// 			}
		// 		});
		// 	}
		// });

		// function ViewData(id_permohonan) {
		// 	if (id_permohonan == 0) {
		// 		$('#addModalLabel').html('Add Permohonan');
		// 		$('#id_permohonan').val('');
		// 		$('#select2-bulan-container').html('--Bulan--');
		// 		$('#select2-tahun-container').html('--Tahun--');
		// 		$('#active').val('1');
		// 		$('#addModal').modal('show');
		// 	} else {
		// 		var url = '<?= base_url() ?>permohonan/ax_get_data_by_id';
		// 		var data = {
		// 			id_permohonan: id_permohonan
		// 		};

		// 		$.ajax({
		// 			url: url,
		// 			method: 'POST',
		// 			data: data
		// 		}).done(function(data, textStatus, jqXHR) {
		// 			var data = JSON.parse(data);
		// 			$('#addModalLabel').html('Edit Permohonan');
		// 			$('#id_permohonan').val(data['id_permohonan']);
		// 			$('#bulan').val(data['bulan']).trigger('--Bulan--');
		// 			$('#tahun').val(data['tahun']).trigger('--Tahun--');
		// 			$('#active').val(data['active']);
		// 			$('#addModal').modal('show');
		// 		});
		// 	}
		// }

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
	</script>
</body>

</html>
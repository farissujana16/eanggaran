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
				<h1>Dropping</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<!-- <button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Dropping
								</button> -->
								<div class="row">
									<div class="col-md-6">
										<label>Cabang</label>
										<select name="filter_cabang" id="filter_cabang" class="form-control select2" style="width: 100%;">
											<option value="0">--ALL CABANG--</option>
											<?php foreach($combobox_bu as $bu): ?>
												<option value="<?= $bu['id_bu'] ?>"><?= $bu['nm_bu'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-6">
										<label>Periode</label>
										<select name="filter_periode" id="filter_periode" class="form-control select2" style="width: 100%;">
											
										</select>
									</div>
								</div>

								<!-- MODAL DATATABLE -->
								<div class="modal fade" id="dropModal" tabindex="-1" role="dialog" aria-labelledby="dropModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="dropModalLabel">Data Dropping</h4>
												<button class="btn btn-primary" onclick="viewDropping(0)"><i class="fa fa-plus"></i> Add Dropping</button>
											</div>
											<div class="modal-body">
											<input type="hidden" id="id_permohonan" name="id_permohonan" value='' />
											<div class="dataTable_wrapper">
												<table class="table table-striped table-bordered table-hover" id="dropTable">
													<thead>
														<tr>
															<th>Options</th>
															<th>#</th>
															<th>Tanggal</th>
															<th>Bank</th>
															<th>Nominal Dropping</th>
															<!-- <th>Dropping</th> -->
														</tr>
													</thead>
												</table>
											</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<!-- <button type="button" class="btn btn-primary" id='btnSave'>Save</button> -->
											</div>
										</div>
									</div>
								</div>


								<!-- MODAL INPUT -->
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Dropping</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_dropping" name="id_dropping" value='' />
												

												<div class="form-group">
													<label>Tanggal</label>
													<input type="text" class="form-control" id="tanggal_dropping">
												</div>
												<div class="form-group">
													<label>Bank</label>
													<select name="bank_dropping" id="bank_dropping" class="form-control select2" style="width: 100%;">
														<option value="0">--Pilih Bank--</option>
														<option value="Mandiri">Mandiri</option>
														<option value="BRI">BRI</option>
														<option value="BNI">BNI</option>
													</select>
												</div>
												<div class="form-group">
													<label>Nominal Dropping</label>
													<input type="text" class="form-control" id="nominal_dropping">
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
												<th>Options</th>
												<th>#</th>
												<th>Cabang</th>
												<th>Periode</th>
												<th>Pengajuan</th>
												<th>Dropping</th>
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
	<script src="<?= base_url() ?>/assets/js/jquery-maskmoney.js"></script>
	<script type='text/javascript'>

		$("#total_anggaran").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 0
		});
		$("#nominal_dropping").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 2
		});
		$("#tanggal_dropping").datepicker({
			dateFormat: "yy-mm-dd ",
		});

		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>dropping/ax_data_dropping/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_bu": $('#filter_cabang').val(),
						"periode": $('#filter_periode').val(),

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
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-arrow-down"></i> Add Dropping</a></li>';
						// str += '<li><a href="<?= base_url() ?>dropping/access/' + data + '"><i class="fa fa-users"></i> Access</a></li>';
						// str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_permohonan"
				},
				{
					data: "nm_bu"
				},
				{
					data: "bulan",
					render: function(data, type, full, meta) {
						return data+" "+full.tahun;
					}
				},
				{
					data: "total_anggaran",
					render: function(data, type, full, meta) {
						return "Rp. "+addKoma(data);
						// return data;
					}
				},
				{
					data: "total_dropping",
					render: function(data, type, full, meta) {
						return "Rp. "+addKoma(data);
						// return data;
					}
				},
				{
					data: "id_permohonan",
					render: function(data, type, full, meta) {
						var str;
						if (full.total_dropping >= full.total_anggaran) {
							str = '<b style="color:green">Selesai</b>'
						}else if (full.total_dropping < full.total_anggaran) {
							str = '<b style="color:orange">Proses</b>'
						}
						return str;
						// return data;
					}
				},
			]
		});

		

		function ViewData(id_permohonan) {
				$('#dropModal').modal('show');
				$('#id_permohonan').val(id_permohonan);
				dropTable.ajax.reload();
		}

		function DeleteData(id_dropping) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>dropping/ax_unset_data';
					var data = {
						id_dropping: id_dropping
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('Dropping data deleted.');
					});
				},
				function() {}
			);
		}


		// ACTIVITY OF DROPPING TABLE

		var dropTable = $('#dropTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>dropping/ax_data_dropping_detail/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": $('#id_permohonan').val(),

					});
				}
			},
			columns: [{
					data: "id_dropping",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="viewDropping(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_dropping"
				},
				{
					data: "tanggal_dropping"
				},
				{
					data: "bank_dropping"
				},
				{
					data: "nominal_dropping",
					render: function(data, type, full, meta) {
						return "Rp. "+addKoma(data);
					}
				}
			]
		});

		function viewDropping(id_dropping) {
			if (id_dropping == 0) {
				$('#tanggal_dropping').val('');
				$('#id_dropping').val(0);
				$('#bank_dropping').val('');
				$('#nominal_dropping').val('');
				$('#addModal').modal('show');
			}else{
				var url = '<?= base_url() ?>dropping/ax_get_data_by_id';
				var data = {
					id_dropping: id_dropping
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					var nominal = data['nominal_dropping'].toString().replace(/\s|[.]/g, ',')
					$('#addModalLabel').html('Edit Dropping');
					$('#id_dropping').val(data['id_dropping']);
					$('#id_permohonan').val(data['id_permohonan']);
					$('#tanggal_dropping').val(data['tanggal_dropping']);
					$('#bank_dropping').val(data['bank_dropping']).trigger('change');
					$('#nominal_dropping').val(nominal.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#active').val(data['active']);
					$('#addModal').modal('show');
					console.log(data);
				});
			}
				
		}

		$('#btnSave').on('click', function() {
			if ($('#tanggal_dropping').val() == '' || $('#tanggal_dropping').val() == 0) {
				alertify.alert("Warning", "Please fill nominal dropping.");
			}else if ($('#bank_dropping').val() == '' || $('#bank_dropping').val() == 0) {
				alertify.alert("Warning", "Please fill nominal dropping.");
			}else if ($('#nominal_dropping').val() == '' || $('#nominal_dropping').val() == 0) {
				alertify.alert("Warning", "Please fill nominal dropping.");
			} else {
				var url = '<?= base_url() ?>dropping/ax_set_data';
				var data = {
					id_permohonan: $('#id_permohonan').val(),
					id_dropping: $('#id_dropping').val(),
					nominal_dropping : $('#nominal_dropping').val().replace(/\s|[.]/g, ''),
					bank_dropping : $('#bank_dropping').val(),
					tanggal_dropping : $('#tanggal_dropping').val(),
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("Dropping data saved.");
						$('#addModal').modal('hide');
						dropTable.ajax.reload();
						buTable.ajax.reload();
					}
				});
			}
		});

		function DeleteData(id_dropping) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>dropping/ax_unset_data';
					var data = {
						id_dropping: id_dropping
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						dropTable.ajax.reload();
						buTable.ajax.reload();
						alertify.error('Dropping data deleted.');
					});
				},
				function() {}
			);
		}



		$('#filter_cabang').on('change', function(){
			buTable.ajax.reload();


			var url = '<?= base_url() ?>dropping/ax_get_periode';
			var data = {
				id_bu : $('#filter_cabang').val()
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				var str = "";
				str += '<option value="0">--ALL PERIODE--</option>'
				$.each(data, function( index, value ) {
					str += '<option value="'+value['bulan']+'-'+value['tahun']+'">'+value['bulan']+' '+value['tahun']+'</option>'
				});
				$('#filter_periode').html(str);
				$('#filter_periode').val(0).trigger('change');
			});
		});

		$('#filter_periode').on('change', function(){
			buTable.ajax.reload();
		});



		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	</script>
</body>

</html>
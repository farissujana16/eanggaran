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
				<h1>Cashpooling</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<!-- <button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Cashpooling
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
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Cashpooling Data</h4>
												<div class="row">
													<div class="col-md-4">
														<button class="btn btn-primary" onclick='ViewData(0)'>
															<i class='fa fa-plus'></i> Add Cashpooling
														</button>
													</div>
													<div class="col-md-4"></div>
													<div class="col-md-4">
														<table width="100%">
															<tr>
																<th width="35%">Mandiri</th>
																<td width="15%">: Rp.</td>
																<td width="50%" align="right" id="bank_mandiri"></td>
															</tr>
															<tr>
																<th width="35%">BRI</th>
																<td width="15%">: Rp.</td>
																<td width="50%" align="right" id="bank_bri"></td>
															</tr>
															<tr>
																<th width="35%">BNI</th>
																<td width="15%">: Rp.</td>
																<td width="50%" align="right" id="bank_bni"></td>
															</tr>
														</table>
													</div>
												</div>
												
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Bank</label>
															<select name="filter_bank" id="filter_bank" class="form-control select2" style="width: 100%;">
																<option value="0">--BANK--</option>
																<option value="Mandiri">Mandiri</option>
																<option value="BRI">BRI</option>
																<option value="BNI">BNI</option>
															</select>
														</div>
													</div>
												</div>
												<input type="hidden" name="id_permohonan" id="id_permohonan" value="0">
												<div class="dataTable_wrapper">
													<table class="table table-striped table-bordered table-hover" id="cashTable">
														<thead>
															<tr>
																<th>Options</th>
																<th>#</th>
																<th>Tanggal</th>
																<th>Bank</th>
																<th>No Transaksi</th>
																<th>Nominal Pooling</th>
																<th>Tiketing</th>
																<!-- <th>Status</th> -->
															</tr>
														</thead>
													</table>
												</div>
											</div>
											<!-- <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary" id='btnSave'>Save</button>
											</div> -->
										</div>
									</div>
								</div>


								<div class="modal fade" id="cashModal" tabindex="-1" role="dialog" aria-labelledby="cashModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="cashModalLabel">Cashpooling Data</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" name="id_cashpooling" id="id_cashpooling">

												<div class="form-group">
													<label>Tanggal</label>
													<input type="text" name="tanggal_pooling" id="tanggal_pooling" class="form-control">
												</div>
												
												<div class="form-group">
													<label>Bank</label>
													<select name="bank" id="bank" class="form-control select2" style="width: 100%;">
														<option value="0">--Pilih Bank--</option>
														<option value="Mandiri">Mandiri</option>
														<option value="BRI">BRI</option>
														<option value="BNI">BNI</option>
													</select>
												</div>
												<div class="form-group">
													<label>No Transaksi</label>
													<input type="number" name="no_transaksi" id="no_transaksi" min="0" class="form-control">
												</div>
												<div class="form-group">
													<label>Nominal Pooling</label>
													<input type="text" name="nominal_pooling" id="nominal_pooling" class="form-control">
												</div>
												<div class="form-group">
													<label>Tiketing</label>
													<input type="text" name="nominal_tiketing" id="nominal_tiketing" class="form-control">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
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
												<th style="vertical-align : middle;text-align:center;" rowspan="2">Options</th>
												<th style="vertical-align : middle;text-align:center;" rowspan="2">#</th>
												<th style="vertical-align : middle;text-align:center;" rowspan="2">Cabang</th>
												<th style="vertical-align : middle;text-align:center;" rowspan="2">Periode</th>
												<th style="vertical-align : middle;text-align:center;" colspan="3">Masa</th>
												<th style="vertical-align : middle;text-align:center;" rowspan="2">Total Tiketing</th>
												<th style="vertical-align : middle;text-align:center;" rowspan="2">Status</th>
											</tr>
											<tr>
												<th style="vertical-align : middle;text-align:center;">Masa 1</th>
												<th style="vertical-align : middle;text-align:center;">Masa 2</th>
												<th style="vertical-align : middle;text-align:center;">Masa 3</th>
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


		$("#nominal_pooling").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 2
		});
		$("#nominal_tiketing").maskMoney({
			thousands: '.',
			decimal: ',',
			affixesStay: false,
			precision: 0
		});

		$("#tanggal_pooling").datepicker({
			dateFormat: "yy-mm-dd ",
		});

		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>cashpooling/ax_data_cashpooling/",
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
						str += '<li><a onclick="poolingData(' + data + ')"><i class="fa fa-credit-card"></i> Cash Pooling</a></li>';
						// str += '<li><a href="<?= base_url() ?>cashpooling/access/' + data + '"><i class="fa fa-users"></i> Access</a></li>';
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
					data: "masa_1",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				},
				{
					data: "masa_2",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				},
				{
					data: "masa_3",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				},
				{
					data: "total_tiketing",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				},
				{
					data: "active",
					render: function(data, type, full, meta) {
						if (data == 1)
							return "Active";
						else return "Not Active";
					}
				},
			]
		});


		//CASHTABLE
		function poolingData(id_permohonan) {
			$('#addModal').modal('show');
			$('#id_permohonan').val(id_permohonan);
			getTotalPooling(id_permohonan);
			cashTable.ajax.reload();
		}
		var cashTable = $('#cashTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>cashpooling/ax_data_cashpooling_by_id/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_permohonan": $('#id_permohonan').val(),
						"bank": $('#filter_bank').val(),
					});
				}
			},
			columns: [{
					data: "id_cashpooling",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_cashpooling"
				},
				{
					data: "tanggal_pooling"
				},
				{
					data: "bank"
				},
				{
					data: "no_transaksi"
				},
				{
					data: "nominal_pooling",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				},
				{
					data: "nominal_tiketing",
					render: function(data, type, full, meta) {
						return "Rp."+ addKoma(data);
					}
				}
			]
		});

		function ViewData(id_cashpooling){
			$('#addModal').modal('hide');
			if (id_cashpooling == 0) {
				$('#id_cashpooling').val(0);
				$('#tanggal_pooling').val('');
				$('#bank').val(0).trigger('change');
				$('#no_transaksi').val(0);
				$('#nominal_pooling').val('');
				$('#nominal_tiketing').val(0);
				$('#cashModal').modal('show');
			}else{
				var url = '<?= base_url() ?>cashpooling/ax_get_data_cash_by_id';
				var data = {
					id_cashpooling: id_cashpooling
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					// var nominal = data['nominal_pooling'].toString()
					var nominal = data['nominal_pooling'].toString().replace(/\s|[.]/g, ',')
					$('#addModalLabel').html('Edit Dropping');
					$('#id_cashpooling').val(data['id_cashpooling']);
					$('#tanggal_pooling').val(data['tanggal_pooling']);
					$('#bank').val(data['bank']).trigger('change');
					$('#no_transaksi').val(data['no_transaksi']);
					$('#nominal_pooling').val(nominal.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					$('#nominal_tiketing').val(data['nominal_tiketing'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
					// $('#active').val(data['active']);
					$('#cashModal').modal('show');
				});
			}
		}

		$('#btnSave').on('click', function() {
			if ($('#tanggal_pooling').val() == "") {
				alertify.alert("Warning", "Please fill date cashpooling.");
			} else if ($('#no_transaksi').val() == 0) {
				alertify.alert("Warning", "Please fill transaction number.");
			} else if($('#nominal_pooling').val() == 0 || $('#nominal_pooling').val() == ""){
				alertify.alert("Warning", "Please fill nominal pooling.");
			} 
			// else if($('#nominal_tiketing').val() == 0 || $('#nominal_tiketing').val() == ""){
			// 	alertify.alert("Warning", "Please fill nominal tiketing.");
			// }
			else {
				var url = '<?= base_url() ?>cashpooling/ax_set_data';
				var data = {
					id_permohonan : $('#id_permohonan').val(),
					id_cashpooling : $('#id_cashpooling').val(),
					tanggal_pooling : $('#tanggal_pooling').val(),
					bank : $('#bank').val(),
					no_transaksi : $('#no_transaksi').val(),
					nominal_pooling : $('#nominal_pooling').val().replace(/\s|[.]/g, ''),
					nominal_tiketing : $('#nominal_tiketing').val().replace(/\s|[.]/g, ''),
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("Dropping data saved.");
						$('#cashModal').modal('hide');
						$('#addModal').modal('show');
						cashTable.ajax.reload();
						buTable.ajax.reload();
						getTotalPooling($('#id_permohonan').val());
					}
				});
			}
		});

		function DeleteData(id_cashpooling) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>cashpooling/ax_unset_data';
					var data = {
						id_cashpooling: id_cashpooling
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						cashTable.ajax.reload();
						buTable.ajax.reload();
						alertify.error('Dropping data deleted.');
						getTotalPooling($('#id_permohonan').val());
					});
				},
				function() {}
			);
		}
		function getTotalPooling(id_permohonan){
			
			var url = '<?= base_url() ?>cashpooling/ax_get_pooling';
			var data = {
				id_permohonan: id_permohonan
			};

			$.ajax({
				url: url,
				method: 'POST',
				data: data
			}).done(function(data, textStatus, jqXHR) {
				var data = JSON.parse(data);
				$('#bank_mandiri').html(addKoma(data['mandiri']));
				$('#bank_bri').html(addKoma(data['bri']));
				$('#bank_bni').html(addKoma(data['bni']));
			});
		}

		$('#btnClose').on('click', function(){
			$('#addModal').modal('show');
		});


		$('#filter_cabang').on('change', function(){
			buTable.ajax.reload();


			var url = '<?= base_url() ?>cashpooling/ax_get_periode';
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


		$('#filter_bank').on('change', function(){
			cashTable.ajax.reload();
		});

		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	</script>
</body>

</html>
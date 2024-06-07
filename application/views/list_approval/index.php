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
				<h1>List Approval</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Bussiness Unit</label>
											<select style="width: 100%;" class="form-control select2" name="id_bu" id="id_bu">
												<option value="0">--Bussiness Unit--</option>
												<?php foreach ($bu as $key) { ?>
													<option value="<?= $key['id_bu'] ?>"><?= $key['nm_bu'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Filter</label>
											<select style="width: 100%;" class="form-control select2" name="filter" id="filter">
												<option value="1">Draft</option>
												<option value="2">Approve</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Penolakan Anggaran</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_permohonan" name="id_permohonan" value='' />

												<div class="form-group">
													<label>Keterangan</label>
													<input type="text" id="revisi" name="revisi" class="form-control" placeholder="Name">
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
	<script type='text/javascript'>
		var buTable = $('#buTable').DataTable({
			"ordering": false,
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>list_approval/ax_data_list_approval/",
				type: 'POST',
				data: function(d) {
					return $.extend({}, d, {
						"id_bu": $('#id_bu').val(),
						"filter": $('#filter').val()

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
						str += '<li><a href="<?= base_url() ?>list_approval/detail/' + data + '?id_bu=' + $('#id_bu').val() + '"><i class="fa fa-list"></i> Details</a></li>';
						// if (full.approval_1 != 1 || full.approval_2 != 1 || full.approval_3 != 1 || full.approval_4 != 1) {

						// } else if (full.approval == 1 || full.approval == 2) {
						// 	str += '<li><a onClick="terimaDana(' + data + ')"><i class="fa fa-check"></i> Approve</a></li>';
						// 	str += '<li><a onClick="tolakDana(' + data + ')"><i class="fa fa-times"></i> Reject</a></li>';
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
						return data + " " + full.tahun;
					}
				},
				{
					data: "total_anggaran",
					render: function(data, type, full, meta) {
						var nilai = 0;
						if (data == null) {
							nilai = 0;
						} else {
							nilai = data
						}
						return "Rp. " + addKoma(nilai);
					}
				},
				{
					data: "total",
					render: function(data, type, full, meta) {
						return "Rp. " + addKoma(data);
					}
				},
				{
					data: "approval",
					render: function(data, type, full, meta) {
						var str = '';
						if (data == 1) {
							str += '<span style="font-size:10pt;" class="label label-default"><i class="fa fa-clock-o"></i> Persetujuan Kadiv Bidang</span>';
						} else if (data == 2) {
							str += '<span style="font-size:10pt;" class="label label-default"><i class="fa fa-clock-o"></i> Persetujuan Kadiv Keuangan</span>';
						} else if (data == 3) {
							str += '<span style="font-size:10pt;" class="label label-warning"><i class="fa fa-check"></i> Disetujui Kadiv Keuangan</span>';
						} else if (data == 5) {
							str += '<span style="font-size:10pt;" class="label label-danger"><i class="fa fa-times"></i> Ditolak</span>';
						} else if (data == 7) {
							str += '<span style="font-size:10pt;" class="label label-success"><i class="fa fa-check"></i> Disetujui</span>';
						} 
						return str;
					}
				}
			]
		});

		function terimaDana(id_permohonan) {
			var url = '<?= base_url() ?>list_approval/ax_approve_permohonan_keuangan';
			var data = {
				id_permohonan: id_permohonan,
				id_bu: $('#id_bu').val(),
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

		function tolakDana(id_permohonan) {
			$('#addModal').modal('show');
			$('#id_permohonan').val(id_permohonan);
		}

		$('#btnSave').on('click', function() {
			// console.log($('#id_permohonan').val());
			if ($('#revisi').val() == '') {
				alertify.alert("Warning", "Silakan isi keterangan revisi anggaran.");
			} else {
				var url = '<?= base_url() ?>list_approval/ax_reject_permohonan_keuangan';
				var data = {
					id_permohonan: $('#id_permohonan').val(),
					revisi: $('#revisi').val(),
					id_bu: $('#id_bu').val(),

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

		$('#id_bu').on("change", function() {
			buTable.ajax.reload();
		});

		$('#filter').on("change", function() {
			buTable.ajax.reload();
		});

		function addKoma(uang) {
			return uang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}
	</script>
</body>

</html>
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
				<h1>Laporan Realisasi</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<!-- <button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-arrow-left'></i> Add Bidang
								</button> -->
								<div class="row">
									<div class="col col-md-12">
										<label>Bussiness Unit</label>
										<select class="form-control select2" name="id_bu" id="id_bu" style="width: 100%;">
											<option value="0">--Bussiness Unit--</option>
											<?php foreach ($bu as $key) { ?>
												<option value="<?= $key['id_bu'] ?>"><?= $key['nm_bu'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Bidang</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_bidang" name="id_bidang" value='' />

												<div class="form-group">
													<label>Name</label>
													<input type="text" id="nm_bidang" name="nm_bidang" class="form-control" placeholder="Name">
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
												<th>Options</th>
												<th>#</th>
												<th>Permohonan</th>
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
				url: "<?= base_url() ?>realisasi/ax_data_realisasi/",
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
						str += '<li><a onclick="printRincian(' + data + ')"><i class="fa fa-copy"></i> Rincian Realisasi</a></li>';
						str += '<li><a onclick="printResume(' + data + ')"><i class="fa fa-file-o"></i> Resume Realisasi</a></li>';
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
				}
			]
		});


		$('#id_bu').on('change', function() {
			buTable.ajax.reload();
		});

		function printRincian(id_permohonan) {
			var url = "<?= base_url() ?>realisasi/print_rincian/";
			var id_bu = $("#id_bu").val();
			var id_permohonan = id_permohonan;

			window.open(url + "?id=" + id_permohonan + "&id_bu=" + id_bu, '_blank');

			window.focus();

		}

		function printResume(id_permohonan) {
			var url = "<?= base_url() ?>realisasi/print_resume/";
			var id_bu = $("#id_bu").val();
			var id_permohonan = id_permohonan;

			window.open(url + "?id=" + id_permohonan + "&id_bu=" + id_bu, '_blank');

			window.focus();

		}
	</script>
</body>

</html>
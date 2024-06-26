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
				<h1>Masa</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Masa
								</button>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Masa</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_masa" name="id_masa" value='' />

												<div class="form-group">
													<label>Name</label>
													<input type="text" id="nm_masa" name="nm_masa" class="form-control" placeholder="Name">
												</div>
												<div class="form-group">
													<label>Tanggal Awal</label>
													<input type="number" id="tgl_awal" name="tgl_awal" class="form-control" min="0">
												</div>
												<div class="form-group">
													<label>Tanggal Akhir</label>
													<input type="number" id="tgl_akhir" name="tgl_akhir" class="form-control" min="0">
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
												<th>Masa</th>
												<th>Awal</th>
												<th>Akhir</th>
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
				url: "<?= base_url() ?>masa/ax_data_masa/",
				type: 'POST'
			},
			columns: [{
					data: "id_masa",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						// str += '<li><a href="<?= base_url() ?>masa/access/' + data + '"><i class="fa fa-users"></i> Access</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_masa"
				},
				{
					data: "nm_masa"
				},
				{
					data: "tgl_awal"
				},
				{
					data: "tgl_akhir"
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

		$('#btnSave').on('click', function() {
			if ($('#nm_masa').val() == '') {
				alertify.alert("Warning", "Please fill bu Name.");
			} else {
				var url = '<?= base_url() ?>masa/ax_set_data';
				var data = {
					id_masa: $('#id_masa').val(),
					id_kota: $('#id_kota').val(),
					nm_masa: $('#nm_masa').val(),
					tgl_awal: $('#tgl_awal').val(),
					tgl_akhir: $('#tgl_akhir').val(),

					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("Masa data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_masa) {
			if (id_masa == 0) {
				$('#addModalLabel').html('Add Masa');
				$('#id_masa').val('');
				$('#nm_masa').val('');
				$('#tgl_awal').val(0);
				$('#tgl_akhir').val(0);
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>masa/ax_get_data_by_id';
				var data = {
					id_masa: id_masa
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit Masa');
					$('#id_masa').val(data['id_masa']);
					$('#nm_masa').val(data['nm_masa']);
					$('#tgl_awal').val(data['tgl_awal']);
					$('#tgl_akhir').val(data['tgl_akhir']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_masa) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>masa/ax_unset_data';
					var data = {
						id_masa: id_masa
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('Masa data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>
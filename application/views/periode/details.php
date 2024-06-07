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
				<h1>Periode Details # <?= $id_periode; ?></h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Periode Details
								</button>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add Periode</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_periode_details" name="id_periode_details" value='' />

												<div class="form-group">
													<label>Tanggal</label>
													<input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal">
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
												<th>Tanggal</th>
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
				url: "<?= base_url() ?>periode/ax_data_periode_details/",
				type: 'POST',
				data: {
					id_periode: <?= $id_periode; ?>
				}
			},
			columns: [{
					data: "id_periode_details",
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
					data: "id_periode_details"
				},
				{
					data: "tanggal"
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

		$('#btnSave').on('click', function() {
			if ($('#tanggal').val() == '') {
				alertify.alert("Warning", "Please fill tanggal field.");
			} else {
				var url = '<?= base_url() ?>periode/ax_set_data_details';
				var data = {
					id_periode_details: $('#id_periode_details').val(),
					id_periode: <?= $id_periode; ?>,
					tanggal: $('#tanggal').val(),
					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("periode data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
						$('#tanggal').val('');
					}
				});
			}
		});

		function ViewData(id_periode_details) {
			if (id_periode_details == 0) {
				$('#addModalLabel').html('Add Periode Details');
				$('#id_periode_details').val('');
				$('#tanggal').val('');
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>periode/ax_get_data_by_id_details';
				var data = {
					id_periode_details: id_periode_details
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit Periode');
					$('#id_periode').val(data['id_periode']);
					$('#tanggal').val(data['tanggal']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_periode) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>periode/ax_unset_data_details';
					var data = {
						id_periode_details: id_periode_details
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('periode data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>
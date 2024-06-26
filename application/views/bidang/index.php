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
				<h1>Bidang</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add Bidang
								</button>
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
												<th>Bidang</th>
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
				url: "<?= base_url() ?>bidang/ax_data_bidang/",
				type: 'POST'
			},
			columns: [{
					data: "id_bidang",
					render: function(data, type, full, meta) {
						var str = '';
						str += '<div class="btn-group">';
						str += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>';
						str += '<ul class="dropdown-menu">';
						str += '<li><a onclick="ViewData(' + data + ')"><i class="fa fa-pencil"></i> Edit</a></li>';
						str += '<li><a href="<?= base_url() ?>bidang/access/' + data + '"><i class="fa fa-users"></i> Access</a></li>';
						str += '<li><a onClick="DeleteData(' + data + ')"><i class="fa fa-trash"></i> Delete</a></li>';
						str += '</ul>';
						str += '</div>';
						return str;
					}
				},

				{
					data: "id_bidang"
				},
				{
					data: "nm_bidang"
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
			if ($('#nm_bidang').val() == '') {
				alertify.alert("Warning", "Please fill bu Name.");
			} else {
				var url = '<?= base_url() ?>bidang/ax_set_data';
				var data = {
					id_bidang: $('#id_bidang').val(),
					id_kota: $('#id_kota').val(),
					nm_bidang: $('#nm_bidang').val(),

					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("Bidang data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_bidang) {
			if (id_bidang == 0) {
				$('#addModalLabel').html('Add Bidang');
				$('#id_bidang').val('');
				$('#nm_bidang').val('');
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>bidang/ax_get_data_by_id';
				var data = {
					id_bidang: id_bidang
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit Bidang');
					$('#id_bidang').val(data['id_bidang']);
					$('#nm_bidang').val(data['nm_bidang']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_bidang) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>bidang/ax_unset_data';
					var data = {
						id_bidang: id_bidang
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('Bidang data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>
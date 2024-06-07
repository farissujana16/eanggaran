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
				<h1>COA</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" onclick='ViewData(0)'>
									<i class='fa fa-plus'></i> Add coa
								</button>
								<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="Form-add-bu" id="addModalLabel">Form Add coa</h4>
											</div>
											<div class="modal-body">
												<input type="hidden" id="id_coa" name="id_coa" value='' />

												<div class="form-group">
													<label>Kode</label>
													<input type="text" id="kd_coa" name="kd_coa" class="form-control" placeholder="Kode">
												</div>

												<div class="form-group">
													<label>Name</label>
													<input type="text" id="nm_coa" name="nm_coa" class="form-control" placeholder="Name">
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
												<th>Kode</th>
												<th>COA</th>
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
		var groupColumn = 2;
		var buTable = $('#buTable').DataTable({
			"columnDefs": [{
				visible: false,
				targets: groupColumn
			}],
			"ordering": false,
			"lengthMenu": [500],
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?= base_url() ?>coa/ax_data_coa/",
				type: 'POST'
			},
			columns: [{
					data: "id_coa",
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
					data: "id_coa"
				},
				{
					data: "nm_bidang"
				},
				{
					data: "kd_coa"
				},
				{
					data: "nm_coa"
				},

				{
					data: "active",
					render: function(data, type, full, meta) {
						if (data == 1)
							return "Active";
						else return "Not Active";
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
								.before('<tr class="group"><td colspan="6" style="background: #a8dede;"><b>' + group + '</b></td></tr>');

							last = group;
						}
					});
			},
		});

		$('#btnSave').on('click', function() {
			if ($('#nm_coa').val() == '') {
				alertify.alert("Warning", "Please fill bu Name.");
			} else {
				var url = '<?= base_url() ?>coa/ax_set_data';
				var data = {
					id_coa: $('#id_coa').val(),
					id_kota: $('#id_kota').val(),
					kd_coa: $('#kd_coa').val(),
					nm_coa: $('#nm_coa').val(),

					active: $('#active').val()
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					if (data['status'] == "success") {
						alertify.success("coa data saved.");
						$('#addModal').modal('hide');
						buTable.ajax.reload();
					}
				});
			}
		});

		function ViewData(id_coa) {
			if (id_coa == 0) {
				$('#addModalLabel').html('Add coa');
				$('#id_coa').val('');
				$('#kd_coa').val('');
				$('#nm_coa').val('');
				$('#select2-id_kota-container').html('---Kota--');
				$('#id_kota').val('0');
				$('#active').val('1');
				$('#addModal').modal('show');
			} else {
				var url = '<?= base_url() ?>coa/ax_get_data_by_id';
				var data = {
					id_coa: id_coa
				};

				$.ajax({
					url: url,
					method: 'POST',
					data: data
				}).done(function(data, textStatus, jqXHR) {
					var data = JSON.parse(data);
					$('#addModalLabel').html('Edit coa');
					$('#id_coa').val(data['id_coa']);
					$('#kd_coa').val(data['kd_coa']);
					$('#nm_coa').val(data['nm_coa']);
					$('#select2-id_kota-container').html(data['nm_kota']);
					$('#id_kota').val(data['id_kota']);
					$('#active').val(data['active']);
					$('#addModal').modal('show');
				});
			}
		}

		function DeleteData(id_coa) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>coa/ax_unset_data';
					var data = {
						id_coa: id_coa
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('coa data deleted.');
					});
				},
				function() {}
			);
		}
	</script>
</body>

</html>
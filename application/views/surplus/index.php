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
				<h1>Surplus</h1>
			</section>
			<section class="invoice">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-8">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-md-2 control-label">Bulan</label>
												<div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" name="filter_bulan" id="filter_bulan">
														<option value="0">--Pilih Bulan--</option>
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
										</div>
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-md-2 control-label">Tahun</label>
												<div class="col-md-10">
													<select class="form-control select2" style="width: 100%;" name="filter_tahun" id="filter_tahun">
														<option value="0">--Pilih Tahun--</option>
														<?php foreach($tahun as $thn): ?>
															<option value="<?= $thn ?>"><?= $thn ?></option>
														<?php endforeach ?>
													</select>
												</div>
											</div>
										</div>
										<div id="buttonCetak" class="form-horizontal" hidden>
                                                <div class="form-group text-center">
                                                    <a onclick="cetak()" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</a>
                                                </div>
                                            </div>
									</div>
									<div class="col-md-3"></div>
								</div>
							</div>
							<!-- <div class="panel-body">
								
							</div> -->
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?= $this->load->view('basic_js'); ?>
	<script type='text/javascript'>
		

		function DeleteData(id_surplus) {
			alertify.confirm(
				'Confirmation',
				'Are you sure you want to delete this data?',
				function() {
					var url = '<?= base_url() ?>surplus/ax_unset_data';
					var data = {
						id_surplus: id_surplus
					};

					$.ajax({
						url: url,
						method: 'POST',
						data: data
					}).done(function(data, textStatus, jqXHR) {
						var data = JSON.parse(data);
						buTable.ajax.reload();
						alertify.error('Surplus data deleted.');
					});
				},
				function() {}
			);
		}

		$("#filter_tahun").on('change', function(){
			if ($("#filter_bulan").val() == 0 || $('#filter_tahun').val() == 0) {
				$('#buttonCetak').prop('hidden', true);
			}else{
				$('#buttonCetak').prop('hidden', false);
			}
		});
		$("#filter_bulan").on('change', function(){
			if ($("#filter_tahun").val() == 0 || $('#filter_bulan').val() == 0) {
				$('#buttonCetak').prop('hidden', true);
			}else{
				$('#buttonCetak').prop('hidden', false);
			}
		});

		function cetak(){
                var url = "<?= base_url() ?>surplus/cetak_laporan";
                var tahun = $("#filter_tahun").val();
                var bulan = $("#filter_bulan").val();
				var id = btoa(bulan + "-" + tahun);

				// console.log(id);

                window.open(url + "?tahun=" + tahun + "&bulan=" + bulan + "&id=" + id, '_blank');

                // window.focus();
            }
	</script>
</body>

</html>
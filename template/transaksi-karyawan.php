<?php
	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}
	global $wpdb;
	$karyawan = get_user_laundry (array('role' => 'pekerja'));
	$customers = get_user_laundry (array('role' => 'customer'));
	$tipe = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'tipe_laundry', ARRAY_A );
	//$tipe_kerja = $wpdb->get_result( 'SELECT * FROM'.$wpdb->prefix.'transaksi_pekerja_laundry');
	$lama_service = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'lama_service_laundry', ARRAY_A );
	//$default_pekerja_laundry = get_option('pekerja_laundry',false);
	$default_tipe_laundry = get_option('tipe_laundry', false);
	$default_lama_laundry = get_option('lama_laundry', false);
?>

<div>
	<div><h1>Transaksi Karyawan Laundry</h1></div>
		<div class="panel-group" id="accordin-laundry" role="talibast" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="ac-header-transaksi-karyawan">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="ac-transaksi-karyawan" aria-expanded="true" aria controls="ac-transaksi-karyawan">
							Transaksi Karyawan
						</a>
					</h4>
				</div>
			<div id="ac-transaksi-karyawan" class="panel-collapse in" role="tabpanel" aria-labelledby="ac-header-transaksi-karyawan">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form method="POST">
								<div class="form-group">
							  		<label for="waktu-laundry">Waktu Laundry</label>
							  		 <div class='input-group date' id='datetimepicker1'>
					                    <input type='text' class="form-control" id="waktu-laundry" placeholder="Waktu Pengerjaan Laundry"/>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
								</div>
								<div class="form-group">
									<label for="karyawan-laundry">Nama Karyawan</label>
									<select id="karyawan-laundry" class="form-control chosen-select">
										<option value="">Pilih Karyawan</option>
									<?php
										foreach ($karyawan as $pekerja) {
											echo '<option value="'.$pekerja['id'].'">'.$pekerja['display_name'].' | '.$pekerja['alamat'].' | '.$pekerja['no_hp'].'</option>';
										}
									?>	
									</select>
									<br>
									<a href='<?php echo admin_url(); ?>user-new.php'>Tambah</a>
								</div>
								<div class="form-group">
									<label for="costumer-laundry">Nama Customer</label>
									<select id="customer-laundry" class="form-control chosen-select">
										<option value="">Pilih Customer</option>
									<?php
										foreach ($customers as $customer) {
											echo '<option value="'.$customer['id'].'">'.$customer['display_name'].' | '.$customer['alamat'].' | '.$customer['no_hp'].'</option>';
										}
									?>
									</select>
								</div>
								<div class="form-group">
									<label for="lama-laundry">Lama Laundry</label>
									<select class="form-control" id="lama-laundry">
										<option value="">Select Lama Laundry</option>
									<?php
										if(!empty($lama_service)){
											foreach ($lama_service as $k => $v){
												$selected = '';
												if($default_lama_laundry == $v['id']){
													$selected = 'selected';
												}
												echo '<option value="'.$v['id'].'" '.$selected.'>'.$v['nama'].'</option>';
											}
								    	}
									?>									
									</select>
								</div>
								<div class="form-group">
								    <label for="tipe-laundry">Tipe Laundry</label>
								    <select class="form-control" id="tipe-laundry">
								    	<option value="">Select Tipe Laundry</option>
								 	<?php
								    	if(!empty($tipe)){
											foreach ($tipe as $k => $v){
												$selected = '';
												if($default_tipe_laundry == $v['id']){
													$selected = 'selected';
												}
												echo '<option value="'.$v['id'].'" '.$selected.'>'.$v['nama'].'</option>';
											}
								    	}
									?>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary" id="input-transaksi-karyawan">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var lama_service = <?php echo json_encode($lama_service); ?>;
</script>
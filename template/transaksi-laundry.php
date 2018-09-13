<?php
	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}
	global $wpdb;
	$customers = get_user_laundry(array( 'role' => 'customer' ));
	$pekerja = get_user_laundry(array( 'role' => array('pekerja', 'administrator') ));
	$parfum_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'parfum_laundry', ARRAY_A );
	$diskon_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'diskon_laundry', ARRAY_A );
	$tipe = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'tipe_laundry', ARRAY_A );
	$lama_service = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'lama_service_laundry', ARRAY_A );
	$user = wp_get_current_user();
	$default_lama_laundry = get_option('lama_laundry', false);
	$default_tipe_laundry = get_option('tipe_laundry', false);
	$default_parfum_laundry = get_option('parfum_laundry', false);
    // echo "<pre>".print_r($tipe, 1)."</pre>";
?>
<div class="container">
	<div class="row"><h1>Transaksi Customer Laundry</h1></div>
	<div class="panel-group row" id="accordion-laundry" role="tablist" aria-multiselectable="true">
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-transkasi-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-transkasi-laundry" aria-expanded="true" aria-controls="ac-transkasi-laundry">
			          Buat Transaksi Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-transkasi-laundry" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="ac-header-transkasi-laundry">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form method="POST">
							  	<div class="form-group">
								    <label for="customer-laundry">Nama Customer</label>
								    <select id="customer-laundry" class="form-control chosen-select">
								    	<option value="">Pilih Customer</option>
								    <?php
								    	foreach ($customers as $customer) {
								    		echo '<option value="'.$customer['id'].'">'.$customer['display_name'].' | '.$customer['alamat'].' | '.$customer['no_hp'].'</option>';
								    	}
								    ?>
								    </select>
								    <br>
								    <a href='<?php echo admin_url(); ?>user-new.php'>Tambah</a>
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
								    <label for="lama-service-laundry">Lama Service Laundry</label>
								    <select class="form-control" id="lama-service-laundry">
								    	<option value="">Select Lama Service Laundry</option>
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
								    <label for="berat-laundry">Berat Laundry</label>
								    <input type="number" class="form-control" id="berat-laundry" placeholder="Berat Laundry" value="0">
							  	</div>
							  	<div class="form-group">
								    <label for="parfum-laundry">Parfum Laundry</label>
								    <select class="form-control" id="parfum-laundry">
								    	<option value="">Select Parfum Laundry</option>
								    <?php
								    	if(!empty($parfum_laundry)){
											foreach ($parfum_laundry as $k => $v){
												$selected = '';
												if($default_parfum_laundry == $v['id']){
													$selected = 'selected';
												}
												echo '<option value="'.$v['id'].'" '.$selected.'>'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="waktu-masuk-laundry">Waktu Masuk</label>
					                <div class='input-group date' id='datetimepicker1'>
					                    <input type='text' class="form-control" id="waktu-masuk-laundry" placeholder="Waktu Masuk Laundry"/>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
								</div>
							  	<div class="form-group">
								    <label for="waktu-keluar-laundry">Waktu Keluar</label>
					                <div class='input-group date' id='datetimepicker2'>
					                    <input type='text' class="form-control" id="waktu-keluar-laundry" placeholder="Waktu Keluar Laundry"/>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
							  	</div>
							  	<div class="form-group">
								    <label for="tambahan-harga-laundry">Tambahan Harga Laundry</label>
								    <input type="number" class="form-control" id="tambahan-harga-laundry" placeholder="0" value="0">
							  	</div>
							  	<div class="form-group">
								    <label for="keterangan-laundry">Keterangan Laundry</label>
								    <input type="text" class="form-control" id="keterangan-laundry" placeholder="Keterangan Laundry">
							  	</div>
							  	<div class="form-group">
								    <label for="diskon-laundry">Diskon Laundry</label>
								    <select class="form-control" id="diskon-laundry">
								    	<option value="">Select Diskon Laundry</option>
								    <?php
								    	if(!empty($diskon_laundry)){
											foreach ($diskon_laundry as $k => $v){
												$satuan = '';
												if($v['tipe'] == 'persen'){
													$satuan = '%';
												}
												echo '<option value="'.$v['id'].'" data-value="'.$v['nilai_diskon'].'" data-type="'.$v['tipe'].'">'.$v['nilai_diskon'].$satuan.' ('.$v['keterangan'].')</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="pekerja-laundry">Pekerja Laundry</label>
								    <select id="pekerja-laundry" class="form-control chosen-select">
								    	<option>Pilih Pekerja</option>
								    <?php
								    	foreach ($pekerja as $karyawan) {
								    		$selected = '';
								    		if($user->ID == $karyawan['id']){
								    			$selected = 'selected';
								    		}
								    		echo '<option value="'.$karyawan['id'].'" '.$selected.'>'.$karyawan['display_name'].' | '.$karyawan['alamat'].' | '.$karyawan['no_hp'].'</option>';
								    	}
								    ?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="status-laundry">Status Laundry</label>
								    <select class="form-control" id="status-laundry">
								    	<option value="proses">Proses</option>
								    	<option value="selesai">Selesai</option>
								    </select>
							  	</div>
							  	<div class="form-group" style="display:none">
								    <label for="total-harga-laundry">Total Harga Laundry</label>
								    <input type="number" class="form-control" id="total-harga-laundry" placeholder="Total Harga Laundry" value="0">
							  	</div>
							</form>
						</div>
						<div class="col-md-6">
							<div id="layout-transaksi-laundry" class="text-center">
								<h3>Total</h3>
								<h3 id="total-laundry">Rp 0</h3>
								<br>
								<br>
							  	<button type="submit" class="btn btn-primary" id="input-transaksi-customer">Submit</button>
							</div>
						</div>
					</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>
<?php
	$harga_service_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'harga_service_laundry', ARRAY_A );
?>
<script>
	var lama_service = <?php echo json_encode($lama_service); ?>;
	var diskon_laundry = <?php echo json_encode($diskon_laundry); ?>;
	var harga_service_laundry = <?php echo json_encode($harga_service_laundry); ?>;
	var add_new_user = "<?php echo get_admin_url(); ?>user-new.php";
</script>
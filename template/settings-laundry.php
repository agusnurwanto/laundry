<?php
	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}
	global $wpdb;
	$parfum_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'parfum_laundry', ARRAY_A );
	$diskon_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'diskon_laundry', ARRAY_A );
	$lama_service = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'lama_service_laundry', ARRAY_A );
	//$tipe_kerja = $wpdb->get_result( 'SELECT * FROM'.$wpdb->prefix.'transaksi_pekerja_laundry', ARRAY_A);
	$tipe = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'tipe_laundry', ARRAY_A );
	$default_lama_laundry = get_option('lama_laundry', false);
	$default_tipe_laundry = get_option('tipe_laundry', false);
	$default_parfum_laundry = get_option('parfum_laundry', false);
	//$default_kerja_laundry = get_option('pekerja_laundry',false);
?>
<div class="container">
	<div class="row"><h1>Settings Laundry</h1></div>
	<div class="panel-group" id="accordion-laundry" role="tablist" aria-multiselectable="true">
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-general-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-general-laundry" aria-expanded="true" aria-controls="ac-general-laundry">
			          Manage General Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-general-laundry" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="ac-header-general-laundry">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<form>
							  	<div class="form-group">
								    <label for="exampleInputEmail1">Set default tipe laundry</label>
								    <select class="form-control" id="default-tipe-laundry">
								    	<option value="">Select</option>
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
								    <label for="default-lama-laundry">Set default lama laundry</label>
								    <select class="form-control" id="default-lama-laundry">
								    	<option value="">Select</option>
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
								    <label for="default-parfum-laundry">Set default parfum laundry</label>
								    <select class="form-control" id="default-parfum-laundry">
								    	<option value="">Select</option>
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
							  	<button type="submit" class="btn btn-primary" id="input-general-setting-laundry">Save</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-parfum-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-parfum-laundry" aria-expanded="false" aria-controls="ac-parfum-laundry">
			          Manage Parfum Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-parfum-laundry" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-parfum-laundry">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="exampleInputEmail1">Parfum Laundry yang ada</label>
								    <select class="form-control">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($parfum_laundry)){
											foreach ($parfum_laundry as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="tambah-parfum-laundry">Tambah baru</label>
								    <input type="text" class="form-control" id="tambah-parfum-laundry" placeholder="Parfum Laundry Baru">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="input-parfum-laundry">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-diskon-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-diskon-laundry" aria-expanded="false" aria-controls="ac-diskon-laundry">
			          Manage Diskon Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-diskon-laundry" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-diskon-laundry">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<h2 style="text-align: center;">Diskon Laundry</h2>				
							<table class="table table-bordered table-striped table-hover table-condensed" id="table-diskon-laundry">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nilai Diskon</th>
										<th class="text-center">Tipe Diskon</th>
										<th class="text-center">Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if(!empty($diskon_laundry)){
											foreach ($diskon_laundry as $k => $diskon) {
												echo '<tr><td class="text-center">'.($k+1).'</td><td class="text-center">'.$diskon['nilai_diskon'].'</td><td class="text-center">'.$diskon['tipe'].'</td><td>'.$diskon['keterangan'].'</td></tr>';
											}
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h2 style="text-align: center">Input Diskon Laundry</h2>
							<form>
							  	<div class="form-group">
								    <label for="nilai-diskon-laundry">Nilai Diskon</label>
								    <input type="text" class="form-control" id="nilai-diskon-laundry" placeholder="10 / 15 / 10000 / 5000">
							  	</div>
							  	<div class="form-group">
								    <label for="tipe-diskon">Tipe Diskon</label>
								    <select class="form-control" id="tipe-diskon">
								    	<option value="">Select</option>
								    	<option value="persen">Persen</option>
								    	<option value="potongan">Potongan</option>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="keterangan-diskon-laundry">Keterangan</label>
								    <input type="text" class="form-control" id="keterangan-diskon-laundry" placeholder="Untuk agen">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="input-diskon-laundry">Save</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>
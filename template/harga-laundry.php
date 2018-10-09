<?php
	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}
	loading_ajax();
	global $wpdb;
	$tipe = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'tipe_laundry', ARRAY_A );
	$lama_service = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'lama_service_laundry', ARRAY_A );
	$jenis_pekerjaan = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'jenis_pekerjaan_laundry', ARRAY_A );
	$harga_service_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'harga_service_laundry', ARRAY_A );
	$persentase_laundry = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'persentase_laundry', ARRAY_A );
	$bagi_hasil = get_option('rumus_dasar_bagi_hasil');
?>
<div>
	<div><h1>Harga Laundry</h1></div>
	<div class="panel-group" id="accordion-laundry" role="tablist" aria-multiselectable="true">
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-tipe-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-tipe-laundry" aria-expanded="false" aria-controls="ac-tipe-laundry">
			          Manage Tipe Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-tipe-laundry" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-tipe-laundry">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="exampleInputEmail1">Tipe Laundry yang ada</label>
								    <select class="form-control">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($tipe)){
											foreach ($tipe as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="tambah-tipe-laundry">Tambah baru</label>
								    <input type="text" class="form-control" id="tambah-tipe-laundry" placeholder="Tipe Laundry Baru">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="input-tipe-laundry">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-lama-service">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-lama-service" aria-expanded="" aria-controls="ac-lama-service">
			          Manage Lama Service
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-lama-service" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-lama-service">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="exampleInputEmail1">Lama Service yang ada</label>
								    <select class="form-control">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($lama_service)){
											foreach ($lama_service as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="tambah-lama-service">Tambah baru</label>
								    <input type="text" class="form-control" id="tambah-lama-service" placeholder="Lama Service Baru">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="input-lama-service">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-jenis-pekerjaan">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-jenis-pekerjaan" aria-expanded="" aria-controls="ac-jenis-pekerjaan">
			          Manage Jenis Pekerjaan
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-jenis-pekerjaan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-jenis-pekerjaan">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="exampleInputEmail1">Jenis Pekerjaan yang ada</label>
								    <select class="form-control">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($jenis_pekerjaan)){
											foreach ($jenis_pekerjaan as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="tambah-jenis-pekerjaan">Tambah baru</label>
								    <input type="text" class="form-control" id="tambah-jenis-pekerjaan" placeholder="Jenis Pekerjaan Baru">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="input-jenis-pekerjaan">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-harga-service">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-harga-service" aria-expanded="" aria-controls="ac-harga-service">
			          Input Harga Service Laundry
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-harga-service" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-harga-service">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form action="?page=harga_laundry" type="post">
							  	<div class="form-group">
								    <label for="ac-harga-service-tipe-laundry">Tipe Laundry</label>
								    <select class="form-control" id="ac-harga-service-tipe-laundry">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($tipe)){
											foreach ($tipe as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="ac-harga-service-lama-laundry">Lama Service</label>
								    <select class="form-control" id="ac-harga-service-lama-laundry">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($lama_service)){
											foreach ($lama_service as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="tambah-harga-service">Harga Service</label>
								    <input type="number" class="form-control" id="tambah-harga-service" placeholder="10000">
							  	</div>
							  	<div class="form-group">
								    <label for="ac-harga-laundry-satuan">Satuan</label>
								    <select class="form-control" id="ac-harga-laundry-satuan">
								    	<option value="kg">kg</option>
								    	<option value="pcs">pcs</option>
								    	<option value="meter">meter</option>
								    </select>
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="ac-input-harga-service">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	  	<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-persentase">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-persentase" aria-expanded="" aria-controls="ac-persentase">
			          Input Persentase Bagi Hasil Karyawan
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-persentase" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ac-header-harga-service">
		      	<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="ac-rumus-dasar-bagi-hasil">Rumus Dasar Bagi Hasil</label>
								    <input class="form-control" type="number" min="1" max="100" id="ac-rumus-dasar-bagi-hasil" value="<?php echo $bagi_hasil; ?>" placeholder="1-100">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="ac-input-bagi-hasil">Update</button>
							</form>
						</div>
						<div class="col-md-6">
							<form>
							  	<div class="form-group">
								    <label for="ac-persentase-tipe-laundry">Tipe Laundry</label>
								    <select class="form-control" id="ac-persentase-tipe-laundry">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($tipe)){
											foreach ($tipe as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="ac-persentase-jenis-pekerjaan">Jenis Pekerjaan</label>
								    <select class="form-control" id="ac-persentase-jenis-pekerjaan">
								    	<option value="">Select</option>
								    <?php
								    	if(!empty($jenis_pekerjaan)){
											foreach ($jenis_pekerjaan as $k => $v){
												echo '<option value="'.$v['id'].'">'.$v['nama'].'</option>';
											}
								    	}
									?>
								    </select>
							  	</div>
							  	<div class="form-group">
								    <label for="ac-persentase-laundry">Persentase</label>
								    <input type="number" min="0" max="100" class="form-control" id="ac-persentase-laundry" placeholder="1-100">
							  	</div>
							  	<button type="submit" class="btn btn-primary" id="ac-input-persentase">Submit</button>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
	  	</div>
	</div>
	<div class="row harga-laundry">
	<?php
		if(!empty($tipe)):
		foreach ($tipe as $k => $v):
	?>
		<div class="col-md-12 col-sm-12">
			<h2 style="text-align: center;"><?php echo $v['nama']; ?></h2>				
			<table class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th rowspan="2">No</th>
						<th rowspan="2">Pekerjaan</th>
						<?php
							if(!empty($lama_service)){
								foreach ($lama_service as $k1 => $v1){
									echo '<th>'.$v1['nama'];
									if(!empty($harga_service_laundry)){
										foreach ($harga_service_laundry as $k2 => $harga_service) {
											if(
												$harga_service['tipe_laundry'] == $v['id']
												&& $harga_service['lama_service'] == $v1['id']
											){
												echo ' '.f_uang($harga_service['harga']).'/'.$harga_service['satuan'];
												break;
											}
										}
									}
									echo '</th>';
								};
							};

							echo '<th>Persentase '.$bagi_hasil.'%</th>';
						?>
					</tr>
					<tr>
						<?php
							$total_persentase = 0;
							if(!empty($lama_service)){
								foreach ($lama_service as $lama){
									$total_persentase = 0;
									$total_harga = 0;
									if(!empty($harga_service_laundry)){
										foreach ($harga_service_laundry as $k1 => $harga_service) {
											if(
												$harga_service['tipe_laundry'] == $v['id']
												&& $harga_service['lama_service'] == $lama['id']
											){
												if(!empty($jenis_pekerjaan)){
													foreach ($jenis_pekerjaan as $pekerjaan) {
														if(!empty($persentase_laundry)){
															foreach ($persentase_laundry as $persentase) {
																if( 
																	$persentase['tipe_laundry']==$v['id'] 
																	&& $persentase['jenis_pekerjaan']==$pekerjaan['id'] 
																){
																	$new_harga = ($harga_service['harga']/100)*$bagi_hasil;
																	$total_harga += ($new_harga*$persentase['persentase'])/100;
																	if($v['id'] == $harga_service['tipe_laundry']){
																		$total_persentase += $persentase['persentase'];
																	}
																	break;
																}
															}
														}
													}
												}
											}
										}
									}
									echo '<th>'.f_uang($total_harga).'</th>';
								}
							}
							echo '<th>'.$total_persentase.'%</th>';
						?>
					</tr>
				</thead>
				<tbody>
				<?php
					if(!empty($jenis_pekerjaan)){
						foreach ($jenis_pekerjaan as $k2 => $pekerjaan) {
							$tr = '<tr><td>'.($k2+1).'</td><td>'.$pekerjaan['nama'].'</td>';
							$check_persentase = '';
							if(!empty($lama_service)){
								foreach ($lama_service as $lama){
									if(!empty($harga_service_laundry)){
										foreach ($harga_service_laundry as $harga_service) {
											if(
												$harga_service['tipe_laundry'] == $v['id']
												&& $harga_service['lama_service'] == $lama['id']
											){
												if(!empty($persentase_laundry)){
													foreach ($persentase_laundry as $persentase) {
														if(
															$persentase['tipe_laundry']==$v['id']
															&& $persentase['jenis_pekerjaan']==$pekerjaan['id']
														){

															$new_harga = ($harga_service['harga']/100)*$bagi_hasil;
															$harga = ($new_harga*$persentase['persentase'])/100;
															$tr .= '<td>'.f_uang($harga).'</td>';
															$check_persentase = $persentase['persentase'].'%';
															break;
														}
													}
												}
											}
										}
									}
									if(empty($check_persentase)){
										$tr .= '<td></td>';
									}
								};
							};
							$tr .= '<td>'.$check_persentase.'</td>';
							$tr .= '</tr>';
							if(!empty($check_persentase)){
								echo $tr;
							}
						}
					}
				?>
				</tbody>
			</table>
		</div>



	<?php
		endforeach;
		else:
	?>
		<h1>Empty Data</h1>
	<?php
		endif;
	?>
	</div>
</div>
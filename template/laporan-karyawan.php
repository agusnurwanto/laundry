<?php
	if ( !function_exists( 'add_action' ) ) {
		echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
		exit;
	}
	global $wpdb;
	loading_ajax();
?>
<div>
	<div><h1>Laporan Karyawan</h1></div>
	<div class="panel-group" id="accordion-laundry" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="ac-header-view-transkasi-laundry">
		      	<h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion-laundry" href="#ac-view-transkasi-laundry" aria-expanded="true" aria-controls="ac-view-transkasi-laundry">
			          Transaksi Karyawan
			        </a>
		      	</h4>
		    </div>
		    <div id="ac-view-transkasi-laundry" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="ac-header-view-transkasi-laundry">
		      	<div class="panel-body">
					<form method="POST">
					  	<div class="form-group">
						    <label for="search">Search</label>
						    <input type="text" name="">
						    </select>
					  	</div>
					</form>
					<div id="style-table"></div>
					<table class="table table-bordered table-striped table-hover table-condensed" id="view-transaksi-karyawan">
						<thead>
							<tr>
								<th id="th_no">No</th>
								<th id="th_customer">Karyawan</th>
								<th id="th_pekerja">Pekerja</th>
								<th id="th_waktu_pengerjaan">Waktu Pengerjaan</th>
								<th id="th_jenis_pekerjaan">Jenis Pekerjaan</th>
								<th id="th_detail_transaksi">Detail Transaksi Laundry</th>
								<th id="th_status">Status</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
	  	</div>
	</div>
</div>
<script type="text/javascript">
	var options = {
		"bDestroy": true,
	    "processing": true,
	    "serverSide": true,
	    "ajax": {
	        'url': laundry_config.ajax_url,
	        'type': 'POST',
	        'data': {
	            'action': 'get_transaksi_karyawan'
	        }
	    },
	    "columns": [
	        { "data": "no" },
	        { "data": "customer" },
	        { "data": "pekerja" },
	        { "data": "waktu_pengerjaan" },
	        { "data": "jenis_pekerjaan" },
	        { "data": "detail_transaksi" },
	        { "data": "status" }
	    ],
	    "dom": 'lBrtip',
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] }
        ],
        "footerCallback": function ( row, data, start, end, display ) {
        	var style = '<style>';
            jQuery('#view-transaksi-karyawan thead th').map(function(no, b){
                var id = jQuery(this).attr('id');
                var align = 'left';
                if(
                    id=='th_status' 
                    || id=='th_no'
                    || id=='th_pekerja'
                ){
                    align = 'center';
                }else if(
                    id=='th_berat'
                    || id=='th_tambahan'
                    || id=='th_diskon'
                    || id=='th_total'
                ){
                    align = 'right';
                }
                style += '#view-transaksi-karyawan tbody td:nth-child('+(no+1)+'){ text-align: '+align+' !important; }';
            });
            style += '</style>';
            jQuery('#style-table').html(style);
        }
	}
	jQuery(document).ready(function(){
		jQuery('#view-transaksi-karyawan').dataTable(options);	
	});
</script>

<!-- Modal -->
<div class="modal fade" id="modal-laporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Transaksi</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_edit_transaksi_karyawan();">Save changes</button>
      </div>
    </div>
  </div>
</div>
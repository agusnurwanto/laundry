<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

function add_laundry_menu() {
	add_menu_page( 'Managemen Laundry', 'Laundry', 'create_users', 'managemen_laundry', 'dasboard_laundry', '
	dashicons-book-alt', 20 );
	add_submenu_page( 'managemen_laundry', 'Laporan Laundry', 'Laporan', 'create_users', 'managemen_laundry', 'dasboard_laundry' );
	add_submenu_page( 'managemen_laundry', 'Harga Laundry', 'Harga Laundry', 'manage_options', 'harga_laundry', 'harga_laundry' );
    add_submenu_page( 'managemen_laundry', 'Transaksi Laundry Customer', 'Transaksi Customer', 'create_users', 'transaksi_laundry', 'transaksi_laundry' );
    add_submenu_page( 'managemen_laundry', 'Transaksi Laundry Karyawan', 'Transaksi Karyawan', 'create_users', 'transaksi_karyawan', 'transaksi_karyawan' );
	add_submenu_page( 'managemen_laundry', 'Settings', 'Settings', 'create_users', 'settings_laundry', 'settings_laundry' );
}

function dasboard_laundry() {
    include 'template/laporan-laundry.php';
}

function harga_laundry() {
    include 'template/harga-laundry.php';
}

function transaksi_laundry() {
    include 'template/transaksi-laundry.php';
}

function transaksi_karyawan() {
    include 'template/transaksi-karyawan.php';
}

function settings_laundry() {
	include 'template/settings-laundry.php';
}

function laundry_install() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."tipe_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        nama varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql );

    $sql1 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."jenis_pekerjaan_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        nama varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql1 );

    $sql2 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."lama_service_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        nama varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql2 );

    $sql3 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."harga_service_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        tipe_laundry int(11) NOT NULL,
        lama_service int(11) NOT NULL,
        harga int(11) NOT NULL,
        satuan varchar(20) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql3 );

    $sql4 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."persentase_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        tipe_laundry int(11) NOT NULL,
        jenis_pekerjaan int(11) NOT NULL,
        persentase double NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql4 );

    $sql5 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."parfum_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        nama varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql5 );

    $sql6 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."transaksi_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer_id int(11) NOT NULL,
        pekerja_id int(11) NOT NULL,
        waktu_masuk datetime,
        waktu_keluar datetime,
        parfum_id int(11) NOT NULL,
        keterangan text,
        tipe_laundry int(11) NOT NULL,
        lama_service int(11) NOT NULL,
        berat int(11) NOT NULL,
        harga int(11) NOT NULL,
        diskon int(11) NOT NULL,
        tambahan_harga int(11) NOT NULL,
        status varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql6 );

    $sql7 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."transaksi_pekerja_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer_id int(11) NOT NULL,
        pekerja_id int(11) NOT NULL,
        jenis_pekerjaan int(11) NOT NULL,
        transaksi_id int(11) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql7 );

    $sql8 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."diskon_laundry (
        id int(11) NOT NULL AUTO_INCREMENT,
        nilai_diskon int(11) NOT NULL,
        keterangan varchar(100) DEFAULT '' NOT NULL,
        tipe varchar(30) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta( $sql8 );
}

function add_role_laundry(){
	$role = get_role('pekerja');
	if ( ! empty($role) ) {
	    $role->add_cap( 'list_users' );
	    $role->add_cap( 'remove_users' );
	    $role->add_cap( 'create_users' );
	    $role->add_cap( 'edit_users' );

	    // Never used, will be removed. create_users or
	    // promote_users is the capability you're looking for.
	    $role->add_cap( 'add_users' );
	}else{
	    $result = add_role( 
			'pekerja', 
			__('Pekerja' ),
			array(
				'read' => true, // true allows this capability
			)
		);
	}

	$role = get_role('customer');
	if ( empty($role) ) {
		$result = add_role( 
			'customer', 
			__('Customer' ),
			array(
				'read' => true, // true allows this capability
			)
		);
	}
}

function insert_default_value_laundry(){
	global $wpdb;
    $check_tipe_laundry = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."tipe_laundry" );
    update_option('rumus_dasar_bagi_hasil', '40');
    if(!empty($check_tipe_laundry)){
    	return ;
    }
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Cuci Setrika' ) );
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Cuci Kering' ) );
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Setrika' ) );
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Bed Cover' ) );
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Selimut' ) );
	$wpdb->insert( $wpdb->prefix."tipe_laundry", array( 'nama' => 'Gordeng' ) );

	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Terima Laundry' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Cuci Baju' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Jemur Baju' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Angkat Jemuran' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Balik Baju' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Setrika' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Packing' ) );
	$wpdb->insert( $wpdb->prefix."jenis_pekerjaan_laundry", array( 'nama' => 'Terima Pengambilan Laundry' ) );
	
	$wpdb->insert( $wpdb->prefix."lama_service_laundry", array( 'nama' => 'Reguler 2 hari' ) );
	$wpdb->insert( $wpdb->prefix."lama_service_laundry", array( 'nama' => 'Reguler 1 hari' ) );
    $wpdb->insert( $wpdb->prefix."lama_service_laundry", array( 'nama' => 'Kilat 6 jam' ) );
    
    $wpdb->insert( $wpdb->prefix."parfum_laundry", array( 'nama' => 'Biasa / Terserah / Seperti yang dulu' ) );
    $wpdb->insert( $wpdb->prefix."parfum_laundry", array( 'nama' => 'Ofresh' ) );
    $wpdb->insert( $wpdb->prefix."parfum_laundry", array( 'nama' => 'Sakura' ) );

    $wpdb->insert( $wpdb->prefix."harga_service_laundry", array( 
        'tipe_laundry' => 1,
        'lama_service' => 1,
        'harga' => 4000, 
        'satuan' => 'kg' 
    ) );
    $wpdb->insert( $wpdb->prefix."harga_service_laundry", array( 
        'tipe_laundry' => 1,
        'lama_service' => 2,
        'harga' => 5000, 
        'satuan' => 'kg' 
    ) );
    $wpdb->insert( $wpdb->prefix."harga_service_laundry", array( 
        'tipe_laundry' => 1,
        'lama_service' => 3,
        'harga' => 8000, 
        'satuan' => 'kg' 
    ) );
	
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 1, 
        'persentase' => 6.25
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 2, 
        'persentase' => 12.5
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 3, 
        'persentase' => 9.37
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 4, 
        'persentase' => 6.25
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 5, 
        'persentase' => 6.25
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 6, 
        'persentase' => 43.75
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 7, 
        'persentase' => 12.5
    ) );
    $wpdb->insert( $wpdb->prefix."persentase_laundry", array( 
        'tipe_laundry' => 1, 
        'jenis_pekerjaan' => 8, 
        'persentase' => 3.1
    ) );

    $wpdb->insert( $wpdb->prefix."diskon_laundry", array( 
        'nilai_diskon' => 15, 
        'keterangan' => 'Untuk agen', 
        'tipe' => 'persen'
    ) );
    $wpdb->insert( $wpdb->prefix."diskon_laundry", array( 
        'nilai_diskon' => 10    , 
        'keterangan' => 'Untuk tetangga dan saudara', 
        'tipe' => 'persen'
    ) );
}

function update_status_laundry(){
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['id'])){
            $ret['msg'] = 'ID transkasi tidak boleh kosong!';
        } else if(empty($_POST['status'])){
            $ret['msg'] = 'Status tidak boleh kosong!';
        }
        if(empty($ret['msg'])){
            $data = array( 'status' => $_POST['status'] );
            $wpdb->update($wpdb->prefix.'transaksi_laundry', $data, array( 'id' =>  $_POST['id']));
            $ret['error'] = false;
            $ret['msg'] = 'Success update status transaksi!';
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_bagi_hasil(){
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['bagi_hasil'])){
            $ret['msg'] = 'Tipe Laundry kosong!';
        }
        if(empty($ret['msg'])){
            update_option('rumus_dasar_bagi_hasil', $_POST['bagi_hasil']);
            $ret['error'] = false;
            $ret['msg'] = 'Success update rumus bagi hasil!';
        }
    }
    echo json_encode($ret);
    wp_die();
}

function save_custom_user_profile_fields($user_id){
    # again do this only if you can
    if(!current_user_can('create_users'))
        return false;

    # save my custom field
    update_usermeta($user_id, 'alamat', $_POST['alamat']);
    update_usermeta($user_id, 'no_hp', $_POST['no_hp']);
}

function custom_user_profile_fields($user){
    ?>
    <h3>Keterangan Tambahan</h3>
    <table class="form-table">
        <tr>
            <th><label for="company">Alamat</label></th>
            <td>
                <input type="text" class="regular-text" name="alamat" value="<?php echo esc_attr( get_the_author_meta( 'alamat', $user->ID ) ); ?>" id="alamat" /><br />
                <span class="description">Dimana Alamatmu</span>
            </td>
        </tr>
        <tr>
            <th><label for="company">Nomer Handphone</label></th>
            <td>
                <input type="text" class="regular-text" name="no_hp" value="<?php echo esc_attr( get_the_author_meta( 'no_hp', $user->ID ) ); ?>" id="no_hp" /><br />
                <span class="description">Masukan Nomermu</span>
            </td>
        </tr>
    </table>
<?php
}

function input_harga_service() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['tipe_laundry'])){
            $ret['msg'] = 'Tipe Laundry kosong!';
        }else if(empty($_POST['lama_laundry'])){
            $ret['msg'] = 'Lama Laundry kosong!';
        }else if(empty($_POST['harga_laundry'])){
            $ret['msg'] = 'Harga Laundry kosong!';
        }else if(empty($_POST['satuan'])){
            $ret['msg'] = 'Satuan kosong!';
        }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'harga_service_laundry where tipe_laundry=%s and lama_service=%s', $_POST['tipe_laundry'], $_POST['lama_laundry']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'tipe_laundry'  => $_POST['tipe_laundry'],
                'lama_service'  => $_POST['lama_laundry'],
                'harga'         => $_POST['harga_laundry'],
                'satuan'        => $_POST['satuan']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'harga_service_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update harga service laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'harga_service_laundry', $data);
                $ret['msg'] = 'Success insert harga service laundry!';
            }
            // ob_start();
            // harga_laundry();
            // $ret['html'] = ob_get_clean();
        }
    }
    echo json_encode($ret);
    wp_die();
}

function input_persentase() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['tipe_laundry'])){
            $ret['msg'] = 'Tipe Laundry kosong!';
        }else if(empty($_POST['pekerjaan_laundry'])){
            $ret['msg'] = 'Pekerjaan Laundry kosong!';
        }else if(empty($_POST['persentase'])){
            $ret['msg'] = 'Persentase kosong!';
        }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'persentase_laundry where tipe_laundry=%s and jenis_pekerjaan=%s', $_POST['tipe_laundry'], $_POST['pekerjaan_laundry']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'tipe_laundry'  => $_POST['tipe_laundry'],
                'jenis_pekerjaan'   => $_POST['pekerjaan_laundry'],
                'persentase'        => $_POST['persentase']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'persentase_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update harga service laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'persentase_laundry', $data);
                $ret['msg'] = 'Success insert harga service laundry!';
            }
            // ob_start();
            // harga_laundry();
            // $ret['html'] = ob_get_clean();
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_parfum_laundry() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['parfum_laundry'])){
            $ret['msg'] = 'Parfum Laundry kosong!';
        }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'parfum_laundry where nama=%s', $_POST['parfum_laundry']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'nama'  => $_POST['parfum_laundry']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'parfum_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update parfum laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'parfum_laundry', $data);
                $ret['msg'] = 'Success insert parfum laundry!';
            }
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_tipe_laundry() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['tipe_laundry'])){
            $ret['msg'] = 'Tipe Laundry kosong!';
        }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'tipe_laundry where nama=%s', $_POST['tipe_laundry']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'nama'  => $_POST['tipe_laundry']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'tipe_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update tipe laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'tipe_laundry', $data);
                $ret['msg'] = 'Success insert tipe laundry!';
            }
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_lama_service() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['lama_service'])){
            $ret['msg'] = 'Lama service kosong!'; }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'lama_service_laundry where nama=%s', $_POST['lama_service']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'nama'  => $_POST['lama_service']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'lama_service_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update lama service laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'lama_service_laundry', $data);
                $ret['msg'] = 'Success insert lama service laundry!';
            }
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_jenis_pekerjaan() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['jenis_pekerjaan'])){
            $ret['msg'] = 'Jenis Pekerjaan Laundry kosong!';
        }
        if(empty($ret['msg'])){
            $sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'jenis_pekerjaan_laundry where nama=%s', $_POST['jenis_pekerjaan']);
            $checkId = $wpdb->get_col($sql);
            $data = array( 
                'nama'  => $_POST['jenis_pekerjaan']
            );
            $ret['error'] = false;
            if(!empty($checkId)){
                foreach ($checkId as $id) {
                    $wpdb->update($wpdb->prefix.'jenis_pekerjaan_laundry', $data, array( 'id' =>  $id));
                    $ret['msg'] = 'Success update jenis pekerjaan laundry!';
                }
            }else{
                $wpdb->insert($wpdb->prefix.'jenis_pekerjaan_laundry', $data);
                $ret['msg'] = 'Success insert jenis pekerjaan laundry!';
            }
        }
    }
    echo json_encode($ret);
    wp_die();
}

function update_diskon_laundry() {
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['diskon_laundry'])){
            $ret['msg'] = 'Nilai Diskon Laundry kosong!';
        }
        if(empty($_POST['tipe_diskon'])){
            $ret['msg'] = 'Tipe Diskon Laundry kosong!';
        }
    	if(empty($_POST['keterangan'])){
    		$ret['msg'] = 'Keterangan Diskon Laundry kosong!';
    	}
    	if(empty($ret['msg'])){
    		$sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'diskon_laundry where nilai_diskon=%s AND keterangan=%s AND tipe=%s', $_POST['diskon_laundry'], $_POST['keterangan'], $_POST['tipe_diskon']);
    		$checkId = $wpdb->get_col($sql);
    		$data = array( 
                'nilai_diskon'  => $_POST['diskon_laundry'],
                'keterangan'  => $_POST['keterangan'],
				'tipe'	=> $_POST['tipe_diskon']
			);
    		$ret['error'] = false;
    		if(!empty($checkId)){
    			foreach ($checkId as $id) {
    				$wpdb->update($wpdb->prefix.'diskon_laundry', $data, array( 'id' =>  $id));
    				$ret['msg'] = 'Success update diskon laundry!';
    			}
    		}else{
    			$wpdb->insert($wpdb->prefix.'diskon_laundry', $data);
				$ret['msg'] = 'Success insert diskon laundry!';
    		}
    	}
    }
    echo json_encode($ret);
    wp_die();
}

function f_uang($uang){
    return 'Rp '.number_format($uang, 2, ',', '.');
}

function get_user_laundry($options){
    $args = array(
        'orderby'      => 'display_name',
        'order'        => 'ASC',
        'fields'       => array('ID', 'display_name')
    );
    if(is_array($options['role'])){
        $args['role__in'] = $options['role'];
    }else{
        $args['role'] = $options['role'];
    }
    $users = get_users( $args );
    $newUsers = array();
    foreach ($users as $user) {
        $alamat = get_usermeta($user->ID, 'alamat');
        $no_hp = get_usermeta($user->ID, 'no_hp');
        $newUsers[] = array(
            'id'    => $user->ID,
            'display_name'  => $user->display_name,
            'no_hp' => $no_hp,
            'alamat'    => $alamat
        );
    }
    return $newUsers;
}

function input_transaksi_customer(){
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['customer_laundry'])){
            $ret['msg'] = 'Customer Laundry kosong!';
        }
        if(empty($_POST['tipe_laundry'])){
            $ret['msg'] = 'Tipe Diskon Laundry kosong!';
        }
        if(empty($_POST['lama_service_laundry'])){
            $ret['msg'] = 'Lama Service Laundry kosong!';
        }
        if(empty($_POST['berat_laundry'])){
            $ret['msg'] = 'Berat Laundry kosong!';
        }
        if(empty($_POST['parfum_laundry'])){
            $ret['msg'] = 'Parfum Laundry kosong!';
        }
        if(empty($_POST['waktu_masuk_laundry'])){
            $ret['msg'] = 'Waktu Masuk Laundry kosong!';
        }
        if(empty($_POST['waktu_keluar_laundry'])){
            $ret['msg'] = 'Waktu Keluar Laundry kosong!';
        }
        if(empty($_POST['pekerja_laundry'])){
            $ret['msg'] = 'Pekerjaan Laundry kosong!';
        }
        if(empty($_POST['total_laundry'])){
            $ret['msg'] = 'Total Laundry kosong!';
        }
        if(empty($_POST['keterangan_laundry'])){
            $ret['msg'] = 'Keterangan Laundry kosong!';
        }
        if(empty($_POST['status_laundry'])){
            $ret['msg'] = 'Status Laundry kosong!';
        }
        $date_in=date_create($_POST['waktu_masuk_laundry']);
        $date_out=date_create($_POST['waktu_keluar_laundry']);
        if(empty($ret['msg'])){
            $data = array(
                'customer_id' => $_POST['customer_laundry'],
                'pekerja_id' => $_POST['pekerja_laundry'],
                'waktu_masuk' => date_format($date_in,"Y-m-d H:i:s"),
                'waktu_keluar' => date_format($date_out,"Y-m-d H:i:s"),
                'parfum_id' => $_POST['parfum_laundry'],
                'keterangan' => $_POST['keterangan_laundry'],
                'tipe_laundry' => $_POST['tipe_laundry'],
                'lama_service' => $_POST['lama_service_laundry'],
                'berat' => $_POST['berat_laundry'],
                'harga' => $_POST['total_laundry'],
                'status' => $_POST['status_laundry'],
            );
            if(empty($_POST['diskon_laundry'])){
                $data['diskon'] = $_POST['diskon_laundry'];
            }
            if(empty($_POST['tambahan_harga_laundry'])){
                $data['tambahan_harga'] = $_POST['tambahan_harga_laundry'];
            }
            $wpdb->insert($wpdb->prefix.'transaksi_laundry', $data);
            $ret['sql'] = $wpdb->last_query;
            $ret['msg'] = 'Success insert transaksi laundry!';
            $ret['error'] = false;
        }
    }
    if($ret['error'] && empty($ret['msg'])){
        $ret['msg'] = 'Error, harap hubungi admin!';
    }
    echo json_encode($ret);
    wp_die();
}

function input_transaksi_karyawan(){
    global $wpdb;
    $ret = array( 'error' => true );
    if(!empty($_POST)){
        if(empty($_POST['customer_laundry'])){
            $ret['msg'] = 'Customer Laundry kosong!';
        }
        if(empty($_POST['karyawan_laundry'])){
            $ret['msg'] = 'Karyawan Laundry kosong!';
        }
        if(empty($_POST['tipe_laundry'])){
            $ret['msg'] = 'Tipe Diskon Laundry kosong!';
        }
        if(empty($_POST['lama_laundry'])){
            $ret['msg'] = 'Lama Laundry kosong!';
        }
        if(empty($_POST['waktu_laundry'])){
            $ret['msg'] = 'Waktu Laundry kosong!';
        }
        $waktu_laundry=date_create($_POST['waktu_laundry']);
        if(empty($ret['msg'])){
            $data = array(
                'customer_id' => $_POST['customer_laundry'],
                'pekerja_id' => $_POST['pekerja_laundry'],
                'jenis_pekerjaan' => $_POST['tipe_laundry'],
                'transaksi_id' => '',
                'waktu_pengerjaan' => date_format($waktu_laundry,"Y-m-d H:i:s")
            );
            $wpdb->insert($wpdb->prefix.'transaksi_pekerja_laundry', $data);
            $ret['sql'] = $wpdb->last_query;
            $ret['msg'] = 'Success insert transaksi karyawan!';
            $ret['error'] = false;
        }
    }
    if($ret['error'] && empty($ret['msg'])){
        $ret['msg'] = 'Error, harap hubungi admin!';
    }
    echo json_encode($ret);
    wp_die();
}

function set_general_setting(){
    global $wpdb;
    $ret = array( 'error' => true, 'msg' => 'Error, harap hubungi admin!' );
    if(!empty($_POST)){
        $check = true;
        if(!empty($_POST['lama_laundry'])){
            update_option('lama_laundry', $_POST['lama_laundry']);
        }
        if(!empty($_POST['default_tipe_laundry'])){
            update_option('tipe_laundry', $_POST['default_tipe_laundry']);
        }
        if(!empty($_POST['default_parfum_laundry'])){
            update_option('parfum_laundry', $_POST['default_parfum_laundry']);
        }
        if($check){
            $ret['error'] = false;
            $ret['msg'] = 'Berhasil disimpan!';
        }
    }
    echo json_encode($ret);
    wp_die();
}

function load_custom_script_admin($hook) {
    // die($hook);
    wp_enqueue_style( 'min-bootstrap', plugin_dir_url( __FILE__ ).'/css/bootstrap.min.css' ); 
    wp_enqueue_style( 'sweetalert', plugin_dir_url( __FILE__ ).'/css/sweetalert.css' ); 
    wp_enqueue_style( 'chosen', plugin_dir_url( __FILE__ ).'/css/chosen.css' ); 
    wp_enqueue_style( 'jquery-dataTables-min', plugin_dir_url( __FILE__ ).'/css/jquery.dataTables.min.css' ); 
    wp_enqueue_style( 'bootstrap-datetimepicker-min', plugin_dir_url( __FILE__ ).'/css/bootstrap-datetimepicker.min.css' ); 
    wp_enqueue_style( 'custom-laundry', plugin_dir_url( __FILE__ ).'/css/custom.css' ); 
    wp_localize_script( 'jquery', 'laundry_config', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) ); 
    
    wp_enqueue_script( 'bootstrap-min', plugin_dir_url( __FILE__ ) . '/js/bootstrap.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'sweetalert', plugin_dir_url( __FILE__ ) . '/js/sweetalert.js', array( 'jquery' ) );
    wp_enqueue_script( 'chosen-jquery-min', plugin_dir_url( __FILE__ ) . '/js/chosen.jquery.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'jquery-dataTables-min', plugin_dir_url( __FILE__ ) . '/js/jquery.dataTables.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'moment-min', plugin_dir_url( __FILE__ ) . '/js/moment.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'bootstrap-datetimepicker-min', plugin_dir_url( __FILE__ ) . '/js/bootstrap-datetimepicker.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'custom-laundry', plugin_dir_url( __FILE__ ) . '/js/custom.js', array( 'jquery' ), time() );
    if ( 'user-new.php' != $hook ) {
        return;
    }
    wp_enqueue_script( 'laundry_custom_script', plugin_dir_url( __FILE__ ) . '/js/global.js', array( 'jquery' ) );
}

function get_transaksi(){
    global $wpdb;
    $ret = array( 'error' => true );
    $total = 0;
    if(!empty($_POST)){
        $total = $wpdb->get_results( 'SELECT count(id) as jml FROM '.$wpdb->prefix.'transaksi_laundry', ARRAY_A );
        $total = $total[0]['jml'];
        $qry = '
            SELECT 
                t.*, 
                (select display_name from '.$wpdb->prefix.'users as u where u.ID=t.customer_id) as customer, 
                (select display_name from '.$wpdb->prefix.'users as u where u.ID=t.pekerja_id) as pekerja, 
                (select nama from '.$wpdb->prefix.'parfum_laundry as p where p.id=t.parfum_id) as parfum, 
                (select nama from '.$wpdb->prefix.'tipe_laundry as tipe where tipe.id=t.tipe_laundry) as tipe, 
                (select nama from '.$wpdb->prefix.'lama_service_laundry as l where l.id=t.lama_service) as lama 
            FROM '.$wpdb->prefix.'transaksi_laundry as t
            limit '.$_POST['start'].','.$_POST['length'];
        $transaksi = $wpdb->get_results( $qry, ARRAY_A );
        $no = 1;
        foreach ($transaksi as $k => $v) {
            $transaksi[$k]['no'] = $no;
            $transaksi[$k]['waktu_pengerjaan'] = $v['waktu_masuk'].' - '.$v['waktu_keluar'];
            $qry2 = 'select * from '.$wpdb->prefix.'diskon_laundry as d where d.id='.$v['diskon'];
            $diskon = $wpdb->get_results( $qry2, ARRAY_A );
            $transaksi[$k]['nilai_diskon'] = "-";
            if(!empty($diskon)){
                $transaksi[$k]['nilai_diskon'] = $diskon[0]['nilai_diskon'].' ('.$diskon[0]['keterangan'].')';
            }
            $transaksi[$k]['status'] = $transaksi[$k]['status'].'<br><button class="button button-primary" onclick="update_status_laundry('.$v['id'].', this);" data-status="'.$transaksi[$k]['status'].'">Edit</button>';
            $transaksi[$k]['harga'] = buatrp($transaksi[$k]['harga']);
            $no++;
        }
        $ret['data'] = $transaksi;
        $ret['error'] = false;
        $ret['msg'] = 'Berhasil disimpan!';
    }
    if($ret['error'] && empty($ret['msg'])){
        $ret['msg'] = 'Error, harap hubungi admin!';
    }
    $ret = array(
        'data'=>$transaksi,
        "draw"=> $_POST['draw'],
        "recordsTotal"=> $total,
        "recordsFiltered"=> count($transaksi),
        // "sql" => $qry
    );
    echo json_encode($ret);
    wp_die();
}

function buatrp($angka){
    $jadi = number_format($angka,2,',','.');
    return $jadi;
}
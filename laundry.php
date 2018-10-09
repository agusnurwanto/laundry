<?php 
/*
Plugin Name: Laundry
Plugin URI: https://maremjaya.com
Description: This is plugin wordpress input data laundry and workshop laundry
Version: 1.0.0
Author: Qodr Magetan
Author URI: https://qodr.or.id
License: GPL2
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

include 'functions.php';

add_action( 'admin_menu', 'add_laundry_menu' );
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

add_action('user_register', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

register_activation_hook( __FILE__, 'laundry_install' );
register_activation_hook( __FILE__, 'insert_default_value_laundry' );
register_activation_hook( __FILE__, 'add_role_laundry' );

add_action( 'wp_ajax_input-harga-lama-service', 'input_harga_service' );
add_action( 'wp_ajax_ac-input-persentase', 'input_persentase' );
add_action( 'wp_ajax_update-bagi-hasil', 'update_bagi_hasil' );
add_action( 'wp_ajax_update-parfum-laundry', 'update_parfum_laundry' );
add_action( 'wp_ajax_update-tipe-laundry', 'update_tipe_laundry' );
add_action( 'wp_ajax_update-lama-service', 'update_lama_service' );
add_action( 'wp_ajax_update-jenis-pekerjaan', 'update_jenis_pekerjaan' );
add_action( 'wp_ajax_update-diskon-laundry', 'update_diskon_laundry' );
add_action( 'wp_ajax_update_status_laundry', 'update_status_laundry' );
add_action( 'wp_ajax_update_status_transaksi_karyawan', 'update_status_transaksi_karyawan' );
add_action( 'wp_ajax_input-transaksi-customer', 'input_transaksi_customer' );
add_action( 'wp_ajax_input-transaksi-karyawan', 'input_transaksi_karyawan' );
add_action( 'wp_ajax_set-general-setting', 'set_general_setting' );
add_action( 'wp_ajax_get_transaksi', 'get_transaksi' );
add_action( 'wp_ajax_get_transaksi_karyawan', 'get_transaksi_karyawan' );

add_action( 'admin_enqueue_scripts', 'load_custom_script_admin' );
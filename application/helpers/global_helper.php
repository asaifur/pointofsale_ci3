<?php

// function pre($exit = null){
// 	$CI = &get_instance();
// 	echo "<pre><hr>";
// 	print_r($CI->db->last_query());
// 	echo "<hr></pre>";
// 	// exit();
// }

function cekvar($var)
{
	$CI = &get_instance();
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	exit();
}
function cekarray($var)
{
	$CI = &get_instance();
	echo "<pre>";
	print_r($var->result());
	echo "</pre>";

	exit();
}
function cekarray2($var)
{
	$CI = &get_instance();
	echo "<pre>";
	print_r($var);
	echo "</pre>";

	exit();
}
function cekdb()
{
	$CI = &get_instance();
	echo "<pre>";
	print_r($CI->db->last_query());
	echo "</pre>";
	exit();
}

function hitung_umur($tgl)
{
	if (!$tgl || $tgl == '0000-00-00') {
		return 'Tanggal tidak valid';
	}

	$birthDate = new DateTime($tgl);
	$today = new DateTime('today');
	$diff = $today->diff($birthDate);

	return $diff->y . ' Tahun ' . $diff->m . ' Bulan ' . $diff->d . ' Hari';
}
function akses_rol()
{
	// Anggap Role ID: 1 = Admin, 2 = Manager, 3 = Staff
	$menus = [
		[
			'title' => 'Dashboard',
			'icon' => 'fas fa-tachometer-alt',
			'link' => 'dashboard',
			'roles' => [1, 2, 3] // Semua bisa lihat
		],
		[
			'title' => 'User Management',
			'icon' => 'fas fa-users',
			'link' => 'users',
			'roles' => [1] // Hanya Admin
		],
		[
			'title' => 'Laporan Keuangan',
			'icon' => 'fas fa-money-bill',
			'link' => 'reports/finance',
			'roles' => [1, 2] // Admin & Manager
		],
		[
			'title' => 'Input Data',
			'icon' => 'fas fa-edit',
			'link' => 'entry/data',
			'roles' => [1, 3] // Admin & Staff
		]
	];
}

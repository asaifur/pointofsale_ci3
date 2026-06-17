<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tanggal')) {
	function tgl_system($tgl)
	{
		if (empty($tgl) || $tgl == '00-00-0000') {
			return null; // atau return ''; sesuai kebutuhan Anda
		} else {

			$tgl = date('Y-m-d', strtotime($tgl));
			return $tgl;
		}
	}

	function tgl_tampil($tgl)
	{
		$tgl = date('d-m-Y', strtotime($tgl));
		return $tgl;
	}


	function tglJam_system2($tgl)
	{
		$tgl = date('Y-m-d H:i:s', strtotime($tgl));
		return $tgl;
	}
	function tglJam_system($tgl)
	{
		$tgl = date('Y-m-d H:i:s', strtotime($tgl));
		return $tgl;
	}

	function tglJam_tampil($tgl)
	{
		$tgl = date('d-m-Y', strtotime($tgl));
		return $tgl;
	}
	function tglJam_tampil2($tgl)
	{
		$tgl = date('d-m-Y H:i:s', strtotime($tgl));
		return $tgl;
	}

	function limit_words2($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}

	function tgl_batas($tgl)
	{
		$tgl = date('Y-m-d', strtotime('-7 day', strtotime($tgl)));
		return $tgl;
	}

	function selisihTampilJam($dari, $sampai)
	{
		$selisih = (strtotime($sampai) - strtotime($dari));
		$day = floor($selisih / (3600 * 24));
		$jam = floor(($selisih - ($day * (3600 * 24))) / (60 * 60));
		return $day . " Hari " . $jam . " Jam";
	}
	function selisihJam($dari, $sampai)
	{
		$tgl1 = new DateTime($dari);
		$tgl2 = new DateTime($sampai);
		$d = $tgl2->diff($tgl1)->days + 1;
		return $d;
	}

	function selisihJam2($dari, $sampai)
	{
		$selisih = (strtotime($sampai) - strtotime($dari));
		$day = floor($selisih / (3600 * 24));
		$jam = floor(($selisih - ($day * (3600 * 24))) / (60 * 60));
		// cekvar($jam);

		if ($dari == $sampai) {
			$timeused = 1;
		} else {
			$timeused = $day;
		}
		// cekvar($timeused);
		return $timeused;
	}

	function selisihJam3($dari, $sampai)
	{
		$selisih = (strtotime($sampai) - strtotime($dari));
		$day = floor($selisih / (3600 * 24));
		$jam = floor(($selisih - ($day * (3600 * 24))) / (60 * 60));
		if ($dari == $sampai) {
			$timeused = 0;
		} else {
			if ($jam <= 6) {
				$timeused = $day + 0.5;
			} else {
				$timeused = $day + 1;
			}
		}
		return $timeused;
	}

	function selisihTanggal($dari, $sampai)
	{
		$awal = date_create($dari);
		$akhir = date_create($sampai);
		//menghitung selisih dengan hasil detik
		$diff  = date_diff($awal, $akhir);
		return $diff->m . " bulan " . $diff->d . " hari " . $diff->h . " jam";
	}

	function pembulatan($uang)
	{
		$uang = number_format($uang, 0, ".", "");
		$ratusan = substr($uang, -2);
		if ($ratusan < 50) {
			$akhir = $uang + (50 - $ratusan);
		} else {
			$akhir = $uang + (100 - $ratusan);
		}
		return number_format($akhir, 2, '.', '');;
	}


	function saveRupiah($uang)
	{
		$uang1 = str_replace(".", "", $uang);
		$uang2 = str_replace(",", ".", $uang1);


		return $uang2;
	}

	function waktu()
	{
		date_default_timezone_set("Asia/Jakarta");
		$jam = date('H:i');

		if ($jam >= '05:30' && $jam < '11:00') {
			$salam = 'Pagi';
		} elseif ($jam >= '11:00' && $jam < '15:00') {
			$salam = 'Siang';
		} elseif ($jam >= '15:00' && $jam < '18:00') {
			$salam = 'Sore';
		} else {
			$salam = 'Malam';
		}

		return $salam;
	}
}

function format_indo($date)
{
	date_default_timezone_set('Asia/Jakarta');
	// array hari dan bulan
	$Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	// pemisahan tahun, bulan, hari, dan waktu
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);
	$hari = date("w", strtotime($date));
	$result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

	return $result;
}

function format_indo_tanpa_hari($date)
{
	date_default_timezone_set('Asia/Jakarta');
	// array hari dan bulan
	$Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	// pemisahan tahun, bulan, hari, dan waktu
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);
	$hari = date("w", strtotime($date));
	$result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

	return $result;
}
function daySql($tgl)
{
	$tgl = date('l', strtotime($tgl));
	$day = intval($tgl) - 1;
	return $day;
}

function cek_tanggal($hariini, $tglberobat)
{
	$diff  = date_diff(date_create($hariini), date_create($tglberobat));
	return $diff->format('%R%a');;
}

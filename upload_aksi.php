<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php
// menghubungkan dengan koneksi
include 'koneksi.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";

// Periksa koneksi database
if (!$koneksi) {
	die("Connection failed: " . mysqli_connect_error());
}
?>

<?php
// upload file xls
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
	mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES['filepegawai']['name']);
if (!move_uploaded_file($_FILES['filepegawai']['tmp_name'], $target_file)) {
	die("Sorry, there was an error uploading your file.");
}

// Debugging: Print the target file path
echo "Target file: $target_file<br>";

// beri permisi agar file xls dapat di baca
chmod($target_file, 0777);

// memeriksa apakah file dapat dibaca
if (!is_readable($target_file)) {
	die("The file $target_file is not readable. Please check the file permissions and ensure it is a valid Excel file.");
}

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($target_file, false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index = 0);

// Debugging: Print the number of rows
echo "Number of rows: $jumlah_baris<br>";

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i = 2; $i <= $jumlah_baris; $i++) {

	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$jenis_perkara = $data->val($i, 1);
	$sisa_bulan_lalu = $data->val($i, 2);
	$diterima_bulan_ini = $data->val($i, 3);
	$jumlah = $data->val($i, 4);
	$dicabut = $data->val($i, 5);
	$dikabulkan = $data->val($i, 6);
	$ditolak = $data->val($i, 7);
	$tidak_diterima = $data->val($i, 8);
	$digugurkan = $data->val($i, 9);
	$dicoret_dari_register = $data->val($i, 10);
	$jumlah_lajur_6_sampai_11 = $data->val($i, 11);
	$sisa_akhir = $data->val($i, 12);
	$banding = $data->val($i, 13);
	$kasasi = $data->val($i, 14);
	$pk = $data->val($i, 15);
	$ket = $data->val($i, 16);

	// Debugging: Print the data to check if it is being read correctly
	echo "Row $i: $jenis_perkara, $sisa_bulan_lalu, $diterima_bulan_ini, $jumlah, $dicabut, $dikabulkan, $ditolak, $tidak_diterima, $digugurkan, $dicoret_dari_register, $jumlah_lajur_6_sampai_11, $sisa_akhir, $banding, $kasasi, $pk, $ket<br>";

	if ($jenis_perkara != "") {
		// input data ke database (table data_pegawai)
		$query = "INSERT INTO data_pegawai (jenis_perkara, sisa_bulan_lalu, diterima_bulan_ini, jumlah, dicabut, dikabulkan, ditolak, tidak_diterima, digugurkan, dicoret_dari_register, jumlah_lajur_6_sampai_11, sisa_akhir, banding, kasasi, pk, ket) VALUES ('$jenis_perkara', '$sisa_bulan_lalu', '$diterima_bulan_ini', '$jumlah', '$dicabut', '$dikabulkan', '$ditolak', '$tidak_diterima', '$digugurkan', '$dicoret_dari_register', '$jumlah_lajur_6_sampai_11', '$sisa_akhir', '$banding', '$kasasi', '$pk', '$ket')";
		if (mysqli_query($koneksi, $query)) {
			$berhasil++;
		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
		}
	} else {
		// Debugging: Print a message if the row is skipped
		echo "Row $i is skipped because 'jenis_perkara' is empty.<br>";
	}
}

// hapus kembali file .xls yang di upload tadi
if (is_writable($target_file)) {
	unlink($target_file);
} else {
	echo "The file $target_file is not writable and cannot be deleted.";
}

// alihkan halaman ke index.php
header("location:index.php?berhasil=$berhasil");
exit();
?>
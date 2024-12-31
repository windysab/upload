<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
// menghubungkan dengan koneksi
include 'koneksi.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";
?>

<?php
// upload file xls
$target = basename($_FILES['filepegawai']['name']);
move_uploaded_file($_FILES['filepegawai']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($target, 0777);

// memeriksa apakah file dapat dibaca
if (!is_readable($target)) {
    die("The file $target is not readable. Please check the file permissions and ensure it is a valid Excel file.");
}

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($target, false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

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

	if($jenis_perkara != ""){
		// input data ke database (table data_pegawai)
		mysqli_query($koneksi,"INSERT into data_pegawai values('','$jenis_perkara','$sisa_bulan_lalu','$diterima_bulan_ini','$jumlah','$dicabut','$dikabulkan','$ditolak','$tidak_diterima','$digugurkan','$dicoret_dari_register','$jumlah_lajur_6_sampai_11','$sisa_akhir','$banding','$kasasi','$pk','$ket')");
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
if (is_writable($target)) {
    unlink($target);
} else {
    echo "The file $target is not writable and cannot be deleted.";
}

// alihkan halaman ke index.php
header("location:index.php?berhasil=$berhasil");
exit();
?>
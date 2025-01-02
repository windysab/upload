<!DOCTYPE html>
<html>
<head>
	<title>Report</title>
</head>
<body>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}

		p{
			color: green;
		}
	</style> 
	<h2>REPORT</h2>
	
	<?php 
	if(isset($_GET['berhasil'])){
		echo "<p>".$_GET['berhasil']." Data successfully imported.</p>";
	}
	?>

	<a href="upload.php">IMPORT DATA</a>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Jenis Perkara</th>
			<th>Sisa Bulan Lalu</th>
			<th>Diterima Bulan Ini</th>
			<th>Jumlah</th>
			<th>Dicabut</th>
			<th>Dikabulkan</th>
			<th>Ditolak</th>
			<th>Tidak Diterima</th>
			<th>Digugurkan</th>
			<th>Dicoret dari Register</th>
			<th>Jumlah Lajur 6 s/d 11</th>
			<th>Sisa Akhir</th>
			<th>Banding</th>
			<th>Kasasi</th>
			<th>PK</th>
			<th>Ket</th>
		</tr>
		<?php 
		include 'koneksi.php';
		$no=1;
		$data = mysqli_query($koneksi,"select * from data_pegawai");
		while($d = mysqli_fetch_array($data)){
			?>
			<tr>
				<th><?php echo $no++; ?></th>
				<th><?php echo $d['jenis_perkara']; ?></th>
				<th><?php echo $d['sisa_bulan_lalu']; ?></th>
				<th><?php echo $d['diterima_bulan_ini']; ?></th>
				<th><?php echo $d['jumlah']; ?></th>
				<th><?php echo $d['dicabut']; ?></th>
				<th><?php echo $d['dikabulkan']; ?></th>
				<th><?php echo $d['ditolak']; ?></th>
				<th><?php echo $d['tidak_diterima']; ?></th>
				<th><?php echo $d['digugurkan']; ?></th>
				<th><?php echo $d['dicoret_dari_register']; ?></th>
				<th><?php echo $d['jumlah_lajur_6_sampai_11']; ?></th>
				<th><?php echo $d['sisa_akhir']; ?></th>
				<th><?php echo $d['banding']; ?></th>
				<th><?php echo $d['kasasi']; ?></th>
				<th><?php echo $d['pk']; ?></th>
				<th><?php echo $d['ket']; ?></th>
			</tr>
			<?php 
		}
		?>
	</table>
</body>
</html>
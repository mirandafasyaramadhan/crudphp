<?php
	
	include "koneksi.php";
	include "fungsi_antiinjection.php";

	//variable untuk memanggil colum di db
	$id = antiinjection($_POST['id']);
	$nama = antiinjection($_POST['nama']);
	$nim = antiinjection($_POST['nim']);
	$id_dosen = antiinjection($_POST['id_dosen']);
	$gender = antiinjection($_POST['gender']);
 
	if ($_GET['mod']=='tambah') {
		$sql = $db->query("INSERT INTO mahasiswa (nama, nim, gender, id_dosen) VALUES ('$nama', '$nim', '$gender', '$id_dosen') ");
			header('location:index.php?code=1'); // disaat kita telah melakukan tambah data, dia akan muncul alert atau notifikasi dari file alert.php dengan key code=1
	}

	elseif ($_GET['mod']=='edit') {
		$sql = $db->query("UPDATE mahasiswa SET nama='$nama', nim='$nim', gender='$gender', id_dosen='$id_dosen' WHERE id ='$id' ");
		header('location:index.php?code=2');// disaat kita telah melakukan edit data, dia akan muncul alert atau notifikasi dari file alert.php dengan key code=2
	}

	$id = $_GET['id'];
	if($_GET['mod']=='delete') {
			$sql1 = $db->query("DELETE FROM mahasiswa WHERE id ='$id' ");
			header('location:index.php?code=3'); // disaat kita telah melakukan hapus data, dia akan muncul alert atau notifikasi dari file alert.php dengan key code=3
	}

?>
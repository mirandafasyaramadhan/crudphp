<!DOCTYPE html> 
<html lang="en">
	<head> 
		<title>Fasyaa</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>

	<body>
  		<div class="container-fluid">
  			<?php 
  			include "koneksi.php";
//Disini menggunakan function switch case untuk memanggil form sekaligus menghemat memory agar tidak terlalu banyak file
  			switch(@$_GET['mod']) {
  				default: ?>

  				<br></br>

			      <p><a href='?mod=add'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-plus-sign'></span> Add User</button></a></p>

			    <div class="row">	

			      	<div class="col-md">

			      	  <?php include"alert.php"; ?>

			          <table class="table table-striped">
			            <thead>
			              <tr>
			                <th>No.</th>
			                <th>Nama</th>
			                <th>NIM</th>
			                <th>Gender</th>
			                <th>Id_Dosen</th>
			                <th>Action</th>
			              </tr>
			            </thead>
			            <tbody>
			            	<?php 
			            	//dibawah ini query untuk read data yang ada di database serta di implementasikan ke array disetiap column dan baris
			            		$no = 1;
			            		$sql = $db->query("SELECT * FROM mahasiswa");
			            		while ($data = $sql->fetch_array()) { 
			            			//kenapa untuk session edit menggunakn echo? agar pas di klik dapat dibaca berdasarkan id dari data, dikarenakan kita membuat menggunakan satu file include 3 aksi sekaligus (insert,update,delete);
		            		echo" 
			              <tr>
			                <td>$no</td>
			                <td>$data[nama]</td>
			                <td>$data[nim]</td>
			                <td>$data[gender]</td>
			                <td>$data[id_dosen]</td>
			                <td><a href='?mod=edit&id=$data[id]'><button type='button' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</button></a> "; ?>
			                <a href='aksi.php?mod=delete&id=<?php echo $data['id'];?>' onClick="return confirm('Yakin akan menghapus Data?')"><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'>Delete</button></a></td>
			              </tr>
			              <?php $no++; } ?>
			            </tbody>
			          </table>
		       		</div>
			    <?php 
			    break; // arti break dimana saat sesi baca data telah selesai

	   			case 'add': // memulai sesi tambah data
	   			?>
				    <form method='POST' action='aksi.php?mod=tambah' class='form-horizontal'>
				    <h2>Tambah Mahasiswa</h2>
					  <div class="form-group">
					    <label class="col-sm-1 control-label">Nama</label>
					    <div class="col-sm-4">
					      <input type="text" name='nama' class="form-control" placeholder="Text input">
					    </div>
					  </div>

					  <div class="form-group">
					  <label class="col-sm-1 control-label">NIM</label>
					    <div class="col-sm-4">
					      <input type="text" name='nim' class="form-control" placeholder="NIM">
					    </div>
					  </div>


					  <div class="form-group">
					  	<label class="col-sm-1 control-label">Gender</label>
					  	<div class="col-sm-4">
						  <input type="radio" name="gender" id="gender" value="L">Laki-laki &nbsp;
						  <input type="radio" name="gender" id="gender" value="P">Perempuan
					  </div>
					  </div>

					 <!-- Dibawah ini query unutk menampilkan data dari db dosen wali ke select option dan dipilih untuk masuk ke data di kolom id_dosen (mahasiswa) -->
					<?php
						$query = "SELECT * FROM dosen_wali ORDER BY id_dosen DESC";
  						$result = mysqli_query($db, $query);
					?>

					<div class="form-group">
  						<label for="" class="col-sm-1 control-label">Dosen Wali : </label>
  						<div class="col-sm-4">
  							<select class="form-control" name='id_dosen'>
  								<option value=''>-Pilih Dosen Wali-</option>
   								<?php while($data = mysqli_fetch_assoc($result) ){?>
    							<option value="<?php echo $data['id_dosen']; ?>"><?php echo $data['id_dosen'];echo " - "; echo $data['nama_dosen'];echo " - "; echo $data['nip']; ?></option>
   								<?php } ?>
  							</select>
  						</div>
  					</div>

					  <div class="form-group">
					    <div class="col-sm-offset-1 col-sm-4">
					      <button type='submit' name='submit' class='btn btn-primary' onClick="return confirm('Yakin akan Tambah Data?')">Tambah</button>
					    </div>
					  </div>
					</form>
				<?php
				break;
				
			//Bagian form untuk edit
				case 'edit': // dimana sesi edit dimulai
					$sql = $db->query("SELECT * FROM mahasiswa WHERE id='$_GET[id]' ");
					$data = $sql->fetch_array();
					
					?>
				    <form method='POST' action='aksi.php?mod=edit' class='form-horizontal'>
				    <h2>Edit User</h2>
				    	<!-- post kan id mahasiswa type hidden-->
				    	<input type='hidden' name='id' value='<?php echo $data['id'];?>'>
					  <div class="form-group">
					    <label class="col-sm-1 control-label">Nama</label>
					    <div class="col-sm-4">
					      <input type="text" name='nama' class="form-control" placeholder="Nama" value="<?php echo $data['nama'];?> ">
					    </div>
					  </div>

					  <div class="form-group">
					    <label class="col-sm-1 control-label">NIM</label>
					    <div class="col-sm-4">
					      <input type="text" name='nim' class="form-control" placeholder="Nim" value="<?php echo $data['nim'];?> ">
					    </div>
					  </div>

					  <div class="form-group">
					  	<label class="col-sm-1 control-label">Gender</label>
					  	<div class="col-sm-4">
						  <input type="radio" name="gender" id="gender" value="L" <?php if ($data['gender'] =='L'){ echo "CHECKED"; }?>>Laki-laki &nbsp;
						  <input type="radio" name="gender" id="gender" value="P" <?php if ($data['gender'] =='P'){ echo "CHECKED"; }?>>Perempuan
					  </div>
					  </div>

					<?php // sama dengan keterangan di bagian tambah data
						$queryy = "SELECT * FROM dosen_wali ORDER BY id_dosen DESC";
  						$result = mysqli_query($db, $queryy);
					?>
					<div class="form-group">
  						<label for="" class="col-sm-1 control-label">Dosen Wali : </label>
  						<div class="col-sm-4">
  							<select class="form-control" name='id_dosen'>
  								<option value=''>-Pilih Dosen Wali-</option>
   								<?php while($data = mysqli_fetch_assoc($result) ){?>
    							<option value="<?php echo $data['id_dosen']; ?>"><?php echo $data['nama_dosen'];echo " - "; echo $data['nip']; ?></option>
   								<?php } ?>
  							</select>
  						</div>
  					</div>

					  <div class="form-group">
					    <div class="col-sm-offset-1 col-sm-4">
					      <button type='submit' name='submit' class='btn btn-primary' onClick="return confirm('Yakin akan Edit Data?')">Save</button>
					      <button type='reset' name='reset' class='btn btn-primary'>Reset</button>
					    </div>
					  </div>
					</form>
				<?php
				break;
			} ?>

			</div>
		</div>
	</body>
</html>
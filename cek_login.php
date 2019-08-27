<?php

ob_start();
session_start();

//memanggil file koneksi
include "admin/koneksi/koneksi.php";

//mengambil data  dari form
$user=$_POST['member_id'];
$pass=$_POST['member_id'];

//membandingkan isi form dengan database
$sql="select * from member where member_id='$user'";

//mengambil data dari tabel
$hasil=mysqli_query($kdb,$sql);
$baris=mysqli_fetch_array($hasil);

//set variable session_star
$_SESSION['member_id']=$baris['member_id'];
$_SESSION['member_type_id']=$baris['member_type_id'];

//check koneksi
if (($user==$baris['member_id']))
{
	if($baris['member_type_id']==1)
	{
	header('location:admin/pinjam.php');
	}
//	elseif ($baris['member_type_id']==2)
//	{
//	header('location:admin/pinjam.php');
//	}
}

else{
        // jika login salah //
echo "<script>
eval(\"parent.location='login.php'\");
alert (' Maaf Login Gagal, Silahkan Isi Username dan Password Anda Dengan Benar');
</script>";

}




?>
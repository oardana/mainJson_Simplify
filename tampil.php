<?php
$conn = mysqli_connect("localhost","root","","laundry");

if($_SERVER['REQUEST_METHOD']=='GET'){
	$query = mysqli_query($conn,"SELECT * FROM layanan");

	$json = [];
	while ($data = mysqli_fetch_assoc($query)) {
		$json[] = $data;
	}
	$isi = mysqli_query($conn,"SELECT * FROM pesan ORDER BY kode_layanan");
	$data = [
			 'data' =>'Welcome To My Crud Simplify',
			 'layanan' =>  $json,
			];
	header('Content-Type: application/json');
	echo json_encode($data);
}else if($_SERVER['REQUEST_METHOD']=='POST'){

	$data = json_decode(file_get_contents('php://input'),true);
	$kode_layanan = $data["kode_layanan"];
	$jenis_layanan = $data["jenis_layanan"];
	$biaya = $data["biaya"];

	if(mysqli_query($conn, "INSERT INTO layanan values('$kode_layanan','$jenis_layanan','$biaya')")){
		$response=array(
					'status' => 200,
					'status_message' =>'Employee Added Successfully.'
				  );
	}else{
		$response=array(
					'status' => 404,
					'status_message' =>'Error Added Data'
				  );
	}
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
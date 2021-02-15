<?php
$conn = mysqli_connect("localhost","root","","laundry");

if($_SERVER['REQUEST_METHOD']=='GET'){

	if(isset($_GET["kode"]) != null){

		$kode = $_GET["kode"];
		$query = mysqli_query($conn,"SELECT * FROM layanan WHERE kode_layanan='$kode'");
		$json = [];
		while ($data = mysqli_fetch_assoc($query)) {
			$json[] = $data;
		}
		if(isset($_GET["kode"]) != $json){
			$response = [
					'code'=> 404,
					'message' => 'Data Tidak Tersedia' 
				];
		}else{
			$response = [
				'code' => 200,
				 'message' =>'Succes',
				 'layanan' =>  $json,
				];
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}else{
		$query = mysqli_query($conn,"SELECT * FROM layanan");

		$json = [];
		while ($data = mysqli_fetch_assoc($query)) {
			$json[] = $data;
		}
		$data = [
				 'code' => 200,
				 'message' =>'Success',
				 'layanan' =>  $json,
				];
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}else if($_SERVER['REQUEST_METHOD']=='POST'){

	if(isset($_GET["kode"]) != null){
		$kode = $_GET["kode"];

		$data = json_decode(file_get_contents('php://input'),true);
		$kode_layanan = $data["kode_layanan"];
		$jenis_layanan = $data["jenis_layanan"];
		$biaya = $data["biaya"];
		$result = mysqli_query($conn, "UPDATE layanan SET kode_layanan='$kode_layanan',jenis_layanan='$jenis_layanan',biaya='$biaya' WHERE kode_layanan='$kode'");
		if($kode_layanan == null || $jenis_layanan == null || $biaya == null){
			$response = [
						'code' => 404,
						'message' =>'Layanan Tidak Boleh Kosong'
					    ];
		}else if(is_numeric($biaya) == false){
			$response=[
						'code'=>404,
						'message' => 'Biaya harus berupa Angka'
					  ];
		}else{
			if($result){
				$response=[
						'code' => 200,
						'message' =>'Layanan Berhasil Diubah'
					  	  ];
			}else{
				$response=[
						'code' => 404,
						'message' =>'Layanan Tidak Bisa Diubah'
					  	  ];
			}
		}
	    header('Content-Type: application/json');
	    echo json_encode($response);
	}else{

		$data = json_decode(file_get_contents('php://input'),true);
		$kode_layanan = $data["kode_layanan"];
		$jenis_layanan = $data["jenis_layanan"];
		$biaya = $data["biaya"];

		if($kode_layanan== null || $jenis_layanan == null || $biaya == null){
			$response=[
						'code'=>404,
						'message' => 'Data Tidak Boleh Kosong'
					  ];
		}else if(is_numeric($biaya) == false){
			$response=[
						'code'=>404,
						'message' => 'biaya harus berupa Angka'
					  ];
		}else{
			$result = mysqli_query($conn, "INSERT INTO layanan values('$kode_layanan','$jenis_layanan','$biaya')");
			if($result){
				$response=[
							'code' => 200,
							'message' =>'Layanan Berhasil Ditambahkan'
						  ];
			}else if(isset($kode_layanan) == mysqli_query($conn,"SELECT * FROM layanan")){
				$response = [
							'code' => 404,
						 	'message' => 'Data Sudah Tersedia'
							];
			}else{
				$response = [
							'code' => 404,
							'message' =>'Layanan Tidak Bisa Ditambahkan'
						    ];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}else if($_SERVER['REQUEST_METHOD']=='DELETE'){
	if(isset($_GET["kode"]) != null){
		$kode = $_GET["kode"];
		$result = mysqli_query($conn, "DELETE FROM layanan WHERE kode_layanan ='$kode'");
		if($result){
			$response=[
						'code' => 200,
						'message' =>'Layanan Berhasil Dihapus'
					  ];
		}else{
			$response=[
						'code' => 404,
						'message' =>'Layanan Tidak Bisa Dihapus'
					  ];
		}
	    header('Content-Type: application/json');
	    echo json_encode($response);
	}
}
?>
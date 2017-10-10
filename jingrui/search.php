<?php

$urlString = file_get_contents('php://input');
$urlJson = json_decode($urlString);
$urlPhone = $urlJson->phone;

if (!$urlPhone) {
	$json = array('ok' => FALSE, 'message' => '电话号码不能为空', 'error' => 'phone is empty');
	echo json_encode($json);
	exit();
}

$servername = "localhost";
$username = "root";
$password = "muyu@123";
$dbname = "JingRui";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $json = array('ok' => FALSE, 'message' => '数据库连接失败', 'error' => $conn->error);
	echo json_encode($json);
	exit();
}

mysqli_query($conn , "set names utf8");
$sql = 'SELECT * FROM tblTianFu WHERE userPhone = ' . $urlPhone;

$sqlArray = mysqli_query($conn, $sql);
if (!$sqlArray->num_rows) {
	$json = array('ok' => FALSE, 'message' => '读取数据失败，手机号可能不对', 'error' => $conn->error, 'sql' => $sql);
	echo json_encode($json);
	exit();
}

if($row = mysqli_fetch_assoc($sqlArray))
{
	$json = array('ok' => TRUE, 'userID' => $row['userID'], 
		'userName' => $row['userName'], 'adress' => $row['adress'],
		'roomArea' => $row['roomArea'], 'roomFangAn' => $row['roomFangAn'],
		'fengGeSeXi' => $row['fengGeSeXi'], 'muShiMian' => $row['muShiMian'],
		'keTingBeiJing' => $row['keTingBeiJing'], 'zhuWoBeiJing' => $row['zhuWoBeiJing'],
		'shouNaFangAn' => $row['shouNaFangAn'], 'zengZhiBao' => $row['zengZhiBao'],
		'zengZhiPeiJian' => $row['zengZhiPeiJian'], 'wuYeFuWu' => $row['wuYeFuWu'],
		'biZhi' => $row['biZhi'] );
	echo json_encode($json);
}

mysqli_free_result($sqlArray);
mysqli_close($conn);

?>
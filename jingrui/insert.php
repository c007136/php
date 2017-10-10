<?php

$urlString = file_get_contents('php://input');
$urlJson = json_decode($urlString);
$userPhone = $urlJson->phone;
$userID = $urlJson->userID;
$userName = $urlJson->userName;
$adress = $urlJson->adress;
$roomArea = $urlJson->roomArea;
$roomFangAn = $urlJson->roomFangAn;
$fengGeSeXi = $urlJson->fengGeSeXi;
$muShiMian = $urlJson->muShiMian;
$keTingBeiJing = $urlJson->keTingBeiJing;
$zhuWoBeiJing = $urlJson->zhuWoBeiJing;
$shouNaFangAn = $urlJson->shouNaFangAn;
$zengZhiBao = $urlJson->zengZhiBao;
$zengZhiPeiJian = $urlJson->zengZhiPeiJian;
$wuYeFuWu = $urlJson->wuYeFuWu;
$biZhi = $urlJson->biZhi;

$servername = "localhost";
$dbusername = "root";
$password = "muyu@123";
$dbname = "JingRui";

$conn = mysqli_connect($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    $json = array('ok' => FALSE, 'message' => '数据库连接失败', 'error' => $conn->error);
	echo json_encode($json);
	exit();
}

mysqli_query($conn , "set names utf8");

$sql = 'SELECT * FROM tblTianFu WHERE userPhone = ' . $userPhone . ';';
$sqlArray = mysqli_query($conn, $sql);

// 数据不存在则插入
if (!$sqlArray->num_rows)
{
	$sql = "INSERT INTO tblTianFu (userPhone, userID, userName, adress, fengGeSeXi, 
		muShiMian, keTingBeiJing, zhuWoBeiJing, shouNaFangAn, zengZhiBao, 
		zengZhiPeiJian, wuYeFuWu, biZhi, roomFangAn, roomArea) VALUES ($userPhone, '$userID', '$userName', '$adress',
		'$fengGeSeXi', '$muShiMian', '$keTingBeiJing', '$zhuWoBeiJing', '$shouNaFangAn', '$zengZhiBao', 
		'$zengZhiPeiJian', '$wuYeFuWu', '$biZhi', '$roomFangAn', '$roomArea');";

    $r = mysqli_query($conn, $sql);
	if (!$r) {
		$json = array('ok' => FALSE, 'message' => '插入数据失败', 'error' => $conn->error, 'sql' => $sql);
		echo json_encode($json);
		exit();
	}

	$json = array('ok' => TRUE, 'message' => '插入数据成功', 'phone' => $userPhone);
	echo json_encode($json);
}
// 数据存在则更新
else
{
	$sql = 'UPDATE tblTianFu SET roomArea = ' . $roomArea . ", adress = '" . "$adress" . 
	       "', userName = '" . "$userName" . "', fengGeSeXi = '" . "$fengGeSeXi" . 
	       "', muShiMian = '" . "$muShiMian" . "', keTingBeiJing = '" . "$keTingBeiJing" . 
	       "', zhuWoBeiJing = '" . "$zhuWoBeiJing" . "', shouNaFangAn = '" . "$shouNaFangAn" . 
	       "', zengZhiBao = '" . "$zengZhiBao" . "', zengZhiPeiJian = '" . "$zengZhiPeiJian" . 
	       "', wuYeFuWu = '" . "$wuYeFuWu" . "', biZhi = '" . "$biZhi" . "', userID = '" . "$userID" .
	       "', roomFangAn = '" . "$roomFangAn" . "' WHERE userPhone = " . $userPhone;

	$r = mysqli_query($conn, $sql);
	if (!$r) {
		$json = array('ok' => FALSE, 'message' => '更新数据失败', 'error' => $conn->error, 'sql' => $sql);
		echo json_encode($json);
		exit();
	}

	$json = array('ok' => TRUE, 'message' => '更新数据成功');
	echo json_encode($json);
}

mysqli_free_result($sqlArray);
mysqli_close($conn);

?>
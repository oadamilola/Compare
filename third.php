<?php
$servername= "sci-mysql" ;
$username= "coa123cycle" ;
$password=  "bgt87awx!@2FD";
$database= "coa123cdb" ;

$conn= mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("Connection failed:". mysqli_connect_error());
}
$sql = "SELECT *
	FROM country
	ORDER BY iso_id ASC ;";
$countryids= mysqli_query($conn,$sql);
$allData=array();
if (mysqli_num_rows($countryids)>0){
    while($row = mysqli_fetch_array($countryids,MYSQLI_ASSOC)){
		$allData[]=$row;
	}
}
echo json_encode($allData);
mysqli_close($conn);
?>
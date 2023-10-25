<!DOCTYPE html>
<html>
<head>

</head>
<body>
<?php
$orderbyval=$_GET['rank'];

$servername= "sci-mysql" ;
$username= "coa123cycle" ;
$password=  "bgt87awx!@2FD";
$database= "coa123cdb" ;

$conn= mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Connection failed:". mysqli_connect_error());
}

if($orderbyval=='gold'){
	$sqlt = "SELECT iso_id,gold,country_name ,silver, bronze, total
	FROM country
	WHERE iso_id LIKE '%'
	ORDER BY gold DESC ;";
}else if($orderbyval=='cyclistnum'){
	$sqlt = "SELECT country.iso_id,COUNT(cyclist.name),country.country_name, country.gold ,country.silver, country.bronze, country.total
	FROM country JOIN cyclist
	ON cyclist.iso_id = country.iso_id
	WHERE country.iso_id LIKE '%'
	GROUP BY country.iso_id
	ORDER BY COUNT(cyclist.name) DESC;";
}else{
	$sqlt= "SELECT cyclist.iso_id,ROUND(AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF('2012-01-01', cyclist.dob)), '%Y') + 0)) AS 'average age',country_name, gold ,silver, bronze, total
	FROM country JOIN cyclist 
	ON country.iso_id = cyclist.iso_id
	WHERE country.iso_id LIKE '%'
	GROUP BY country.iso_id 
	ORDER BY ROUND(AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF('2012-01-01', cyclist.dob)), '%Y') + 0),2) DESC;";
}

$allcountriesfr=mysqli_query($conn,$sqlt);
$allcountries=mysqli_query($conn,$sqlt);
$rankcount=1; //WHY IS IT 1?
$prev=0;
$rankofall=array();

while(($rowsofcountries = mysqli_fetch_array($allcountries))){
	if($prev>$rowsofcountries[1]){
		$rankcount+=1;

	}
	array_push($rankofall,$rankcount);
	$prev=$rowsofcountries[1];
}

echo "<table style='border:1px solid white'>";
$count=0;
if($orderbyval=='avage'){
	echo "<th> Rank </th>";
	echo "<th> ID </th>";
	echo "<th> Country </th>";
	echo "<th> Gold medals </th>";
	echo "<th> Silver medals </th>";
	echo "<th> Bronze medals </th>";
	echo "<th> Total medals </th>";
	echo "<th> Average age </th>";
	if (mysqli_num_rows($allcountriesfr)>0){
		while($row = mysqli_fetch_array($allcountriesfr)){
			echo "<tr>";
			echo "<td> $rankofall[$count] </td>";
			echo "<td> $row[0] </td>";
			echo "<td> $row[2] </td>";
			echo "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5] </td>";
			echo "<td> $row[6] </td>";
			echo "<td> $row[1] </td>";
			echo "</tr>";
		$count+=1;
		}
	}
}else if($orderbyval=='gold'){
	echo "<th> Rank </th>";
	echo "<th> ID </th>";
	echo "<th> Country </th>";
	echo "<th> Gold medals </th>";
	echo "<th> Silver medals </th>";
	echo "<th> Bronze medals </th>";
	echo "<th> Total medals </th>";
	if (mysqli_num_rows($allcountriesfr)>0){
		while($row = mysqli_fetch_array($allcountriesfr)){
			echo "<tr>";
			echo "<td> $rankofall[$count] </td>";
			echo "<td> $row[0] </td>";
			echo "<td> $row[2] </td>";
			echo "<td> $row[1] </td>";
			echo "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5] </td>";
			echo "</tr>";
		$count+=1;
		}
	}
}else{
	echo "<th> Rank </th>";
	echo "<th> ID </th>";
	echo "<th> Country </th>";
	echo "<th> Gold medals </th>";
	echo "<th> Silver medals </th>";
	echo "<th> Bronze medals </th>";
	echo "<th> Total medals </th>";
	echo "<th> Number of Cyclists </th>";
	if (mysqli_num_rows($allcountriesfr)>0){
		while($row = mysqli_fetch_array($allcountriesfr)){
			echo "<tr>";
			echo "<td> $rankofall[$count] </td>";
			echo "<td> $row[0] </td>";
			echo "<td> $row[2] </td>";
			echo "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5] </td>";
			echo "<td> $row[6] </td>";
			echo "<td> $row[1] </td>";
			echo "</tr>";
		$count+=1;
		}
	}
}	
echo "</table>";

mysqli_close($conn);


?>
</body>
</html>

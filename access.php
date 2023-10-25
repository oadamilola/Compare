<!DOCTYPE html>
<html>
<head>

</head>
<body>
<?php
$countryiso_1=$_GET['countryiso1'] ;
$countryiso_2= $_GET['countryiso2'];
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
	$sql = "SELECT iso_id,country_name, gold ,silver, bronze, total
	FROM country
	WHERE iso_id ='$countryiso_1' OR iso_id ='$countryiso_2'
	ORDER BY gold DESC ;";

	$sqlt = "SELECT iso_id, gold 
	FROM country
	WHERE iso_id LIKE '%'
	ORDER BY gold DESC ;";
}else if($orderbyval=='cyclistnum'){
	$sql = "SELECT country.iso_id,country.country_name, country.gold ,country.silver, country.bronze, country.total,COUNT(cyclist.name)
	FROM country JOIN cyclist
	ON cyclist.iso_id = country.iso_id
	WHERE country.iso_id ='$countryiso_1' OR country.iso_id ='$countryiso_2'
	GROUP BY country.iso_id
	ORDER BY COUNT(cyclist.name) DESC;";
	
	$sqlt = "SELECT country.iso_id,COUNT(cyclist.name)
	FROM country JOIN cyclist
	ON cyclist.iso_id = country.iso_id
	WHERE country.iso_id LIKE '%'
	GROUP BY country.iso_id
	ORDER BY COUNT(cyclist.name) DESC;";
}else{
	$sql = "SELECT country.iso_id,country_name, gold ,silver, bronze, total
	FROM country
	WHERE iso_id ='$countryiso_1' OR iso_id ='$countryiso_2'
	ORDER BY gold DESC ;";
	
	$sqlt= "SELECT cyclist.iso_id,ROUND(AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF('2012-01-01', cyclist.dob)), '%Y') + 0)) AS 'average age'
	FROM country JOIN cyclist 
	ON country.iso_id = cyclist.iso_id
	WHERE country.iso_id LIKE '%'
	GROUP BY country.iso_id 
	ORDER BY ROUND(AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF('2012-01-01', cyclist.dob)), '%Y') + 0),2) DESC;";
}

$countrymedals= mysqli_query($conn,$sql);
$allcountries=mysqli_query($conn,$sqlt);
$found1=FALSE;
$found2=FALSE;
$rankcount=1; //WHY IS IT 1?
$prev=0;

while(($rowsofcountries = mysqli_fetch_array($allcountries))AND (($found1==FALSE)OR($found2==FALSE))){
	if($prev>$rowsofcountries[1]){
		$rankcount+=1;
	}
	if($rowsofcountries[0]== $countryiso_1){
		$found1=TRUE;
		$countryrank1=$rankcount;
		$countryval1=$rowsofcountries[1];
	}else if ($rowsofcountries[0]== $countryiso_2){
		$found2=TRUE;
		$countryrank2=$rankcount;
		$countryval2=$rowsofcountries[1];
	}
	$prev=$rowsofcountries[1];
}

$sql = "SELECT name
FROM cyclist
WHERE iso_id ='$countryiso_1' ;";
$country1cyclists= mysqli_query($conn,$sql);

$sql = "SELECT name
FROM cyclist
WHERE iso_id ='$countryiso_2' ;";
$country2cyclists= mysqli_query($conn,$sql);

echo "<table style='border:1px solid white'>";
if($orderbyval=='avage'){
	echo "<th> Rank </th>";
	echo "<th> Country </th>";
	echo "<th> Gold medals </th>";
	echo "<th> Silver medals </th>";
	echo "<th> Bronze medals </th>";
	echo "<th> Total medals </th>";
	echo "<th> Average age </th>";
	if (mysqli_num_rows($countrymedals)>0){
		while($row = mysqli_fetch_array($countrymedals)){
			echo "<tr>";
			if($row[0]==$countryiso_1){
				echo "<td> $countryrank1 </td>";
			}else{
				echo "<td> $countryrank2 </td>";
			}
			echo "<td> $row[1] </td>";
			echo "<td> $row[2] </td>";
			echo "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5] </td>";
			if($row[0]==$countryiso_1){
				echo "<td> $countryval1 </td>";
			}else{
				echo "<td> $countryval2 </td>";
			}
			echo "</tr>";
		}
	}
}else{
	echo "<th> Rank </th>";
	echo "<th> Country </th>";
	echo "<th> Gold medals </th>";
	echo "<th> Silver medals </th>";
	echo "<th> Bronze medals </th>";
	echo "<th> Total medals </th>";
	if (mysqli_num_rows($countrymedals)>0){
		while($row = mysqli_fetch_array($countrymedals)){
			echo "<tr>";
			if($row[0]==$countryiso_1){
				echo "<td> $countryrank1 </td>";
			}else{
				echo "<td> $countryrank2 </td>";
			}
			echo "<td> $row[1] </td>";
			echo "<td> $row[2] </td>";
			echo "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5] </td>";
			echo "</tr>";
		}
	}
}	
echo "</table>";
echo "<div class='gap'>";
echo "</div>";

echo"<div class='cyclists'>";
echo "<div class='tbl'>";
echo "<table >";
echo "<th> Country </th>";
echo "<th> Cyclists Name </th>";
if (mysqli_num_rows($country1cyclists)>0){
    while($row = mysqli_fetch_array($country1cyclists)){
        echo "<tr>";
		echo "<td> $countryiso_1 </td>";
        echo "<td> $row[0] </td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "</div>";

echo "<div class='gap'></div>";

echo "<div class='tbl'>";
echo "<table>";
echo "<th> Country </th>";
echo "<th> Cyclists Name </th>";
if (mysqli_num_rows($country2cyclists)>0){
    while($row = mysqli_fetch_array($country2cyclists)){
        echo "<tr>";
		echo "<td> $countryiso_2 </td>";
        echo "<td> $row[0] </td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "</div>";
echo"</div>";
mysqli_close($conn);


?>
</body>
</html>

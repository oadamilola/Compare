<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" href="stylecomp.css">
<script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
        $(document).ready(function () {
            $("#formtry").submit(function (event) {
                let rankby = $("#rank").val();
				let country1 = $("#countryiso_1").val().toUpperCase();
				let country2 = $("#countryiso_2").val().toUpperCase();
				if(country1==country2){
					let insertedHtml="<p>COUNTRY CODES MUST BE DIFFERENT</p>";
					$("#serverResponse").html(insertedHtml);
				
					event.preventDefault();
				}else{
					$.ajax({
						url:"access.php",
						type: "GET",
						data:{rank:rankby, countryiso1:country1, countryiso2:country2 },
						success:function(responseData){
							$("#serverResponse").html(responseData);
						},
						error:function(e){
							console.log(e.message);
						}
					});
					event.preventDefault();
				}
            });
        });
	</script>
<script>
        $(document).ready(function () {
            $("#rank2").change(function () { 
                let rankby = $("#rank2").val();
					$.ajax({
						url:"all.php",
						type: "GET",
						data:{rank:rankby },
						success:function(responseData){
							$("#serverResponse2").html(responseData);
						},
						error:function(e){
							console.log(e.message);
						}
					});
					event.preventDefault();
            });
        });
	</script>
<script>
$( function() {
		let countryids = [];
		var countrynames = [];
		$.get("third.php",function(responseData){
			let len=responseData.length;
			for (let i = 0; i < len; i++) {
				let country=responseData[i].iso_id;
				let name=responseData[i].country_name;
				countryids.push(country);
				countrynames.push(name);
			}
		},"json");		
		$( "#tags" ).autocomplete({
		source: countrynames,
		minLength: 1,
        scroll: true
    });
	let len=countrynames.length;
	$( "#countryiso_1" ).autocomplete({
		source: countryids
    });
		$("#countryiso_2" ).autocomplete({
		source: countryids
    });
  } );
  </script>
  <script>
$(document).ready(function () {
	$("#rank").change(function () {  
		let rankby = $("#rank").val();
		let country1 = $("#countryiso_1").val().toUpperCase();
		let country2 = $("#countryiso_2").val().toUpperCase();
		if(country1==country2){
			let insertedHtml="<p>COUNTRY CODES MUST BE DIFFERENT</p>";
			$("#serverResponse").html(insertedHtml);
			event.preventDefault();
		}else{
			error.style.display="none";
			$.ajax({
				url:"access.php",
				type: "GET",
				data:{rank:rankby, countryiso1:country1, countryiso2:country2 },
				success:function(responseData){
				$("#serverResponse").html(responseData);
				},
				error:function(e){
					console.log(e.message);
				}
			});
			event.preventDefault();
		}
	});
});</script>
<script>
function mainpage(){
	var x = document.getElementById("compage");
	var y = document.getElementById("mainpage");
  if (x.style.display === "none") {
    x.style.display = "block";
	 y.style.display = "none";
  } else {
    x.style.display = "none";
	y.style.display = "block";
  }
}
function compage(){
	var x = document.getElementById("compage");
	var y = document.getElementById("mainpage");
  if (y.style.display === "none") {
    y.style.display = "block";
	x.style.display = "none";
  } else {
    y.style.display = "none";
	 x.style.display = "block";
  }
}
</script>
<title>Compare Task</title>
</head>
<body>
<div class="header" style="background-color:black">
<h1 class="center"  style="text-align:center">THE 2012 OLYMPICS</h1>
</div>

<div class="tabs">
<input type="submit" id="allpage" value="All Countries" style="background-color:black;color:white;margin-right:1250px" onclick="mainpage()"/>
</div>
<div class="tabs">
<input type="submit" id="comparepage" value="Compare" style="background-color:black;color:white;margin-right:1250px"onclick="compage()" />
</div>

<div class="flex-container" id="compage">
	<div class="main">
		<div class="compareid">
			<form id="formtry">
				<div class="sections">
				<label for="countryiso_1" id="clbl1">First Country ID</label>
				<div class="ui-widget">
				<input name="countryiso_1" type="text" class="larger" id="countryiso_1" autocomplete="on"  size="10" required />
				</div>
				</div>
				<div class="sections">
				<label for="countryiso_2"id="clbl2">Second Country ID</label></td>
					<div class="ui-widget">
					<input name="countryiso_2" type="text" class="larger" id="countryiso_2" autocomplete="on"  size="10" required />
					</div>
				</div>
				<div class="sections">
				<label for="order">Rank By</label>
				<div class="rankings">
				<select  name="rank" id="rank" >
				<option value="gold">Gold</option>
				<option value="cyclistnum">Number of Cyclist</option>
				<option value="avage">Average Age in 2012</option>
				</select> 
				</div>
				</div>
				<div class="sections">
				<input type="submit" id="submit" value="compare" class="larger" />
				</div>
				<div id="error"></div>
				
			</form>
				
		</div>
		
		</div>
		<div id="serverResponse" class="data"></div>
	</div>
</div>
<div class="flex-container" id="mainpage" style="display:none">
	<label for="order">Show Countries Ranked By</label>
	<div class="rankings">
	<select  name="rank" id="rank2" >
	<option value="gold">Gold</option>
	<option value="cyclistnum">Number of Cyclist</option>
	<option value="avage">Average Age in 2012</option>
	</select> 
	<div id="serverResponse2" class="data"></div>
</div>

</body>

</html>

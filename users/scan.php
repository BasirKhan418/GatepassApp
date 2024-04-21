<!-- Index.html file -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">
	
	<title>QR Code Scanner - GMS APP </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        /* style.css file*/
body {
	display: flex;
	justify-content: center;
	margin: 0;
	padding: 0;
	height: 100vh;
	box-sizing: border-box;
	text-align: center;
	background: rgb(128 0 0 / 66%);
}
.container {
	width: 100%;
	max-width: 500px;
	margin: 5px;
}

.container h1 {
	color: #ffffff;
}

.section {
	background-color: #ffffff;
	padding: 50px 30px;
	border: 1.5px solid #b2b2b2;
	border-radius: 0.25em;
	box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
}

#my-qr-reader {
	padding: 20px !important;
	border: 1.5px solid #b2b2b2 !important;
	border-radius: 8px;
}

#my-qr-reader img[alt="Info icon"] {
	display: none;
}

#my-qr-reader img[alt="Camera based scan"] {
	width: 100px !important;
	height: 100px !important;
}

button {
	padding: 10px 20px;
	border: 1px solid #b2b2b2;
	outline: none;
	border-radius: 0.25em;
	color: white;
	font-size: 15px;
	cursor: pointer;
	margin-top: 15px;
	margin-bottom: 10px;
	background-color: #008000ad;
	transition: 0.3s background-color;
}

button:hover {
	background-color: #008000;
}

#html5-qrcode-anchor-scan-type-change {
	text-decoration: none !important;
	color: #1d9bf0;
}

video {
	width: 100% !important;
	border: 1px solid #b2b2b2 !important;
	border-radius: 0.25em;
}
.card {
   background-color: lightblue;
	border-radius: 5px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	margin-top: 20px;
	overflow: hidden;
	width: 100%;
	max-width: 500px;
	margin: 0 auto;
}

.card-header {
    padding: 20px;
    border-bottom: 1px solid #ccc;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h2 {
    margin: 0;
	font-size: 1.5em;
	color:blue;
}

.card-body {
    padding: 20px;
	background-color: wheat;
   
}

.info-row {
    display: flex;
    margin-bottom: 10px;
	background-color: #f9f9f9;
	padding: 10px;
	border-radius: 5px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	border-left: 5px solid #1d9bf0;
	transition: 0.3s border-left;
}

.info-label {
    flex: 1;
    font-weight: bold;
}

.info-value {
    flex: 2;
}
.center{
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	flex-wrap: wrap;
}
.h1er{
	color: red;
   background-color: #f9f9f9;
	padding: 10px;
	border-radius: 5px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	border-left: 5px solid #1d9bf0;
	transition: 0.3s border-left;

}
.close{
	color: red;
	font-size: 60px;
}
a{
	text-decoration: none;
	color: green;
}
    </style>
</head>

<body>
<div class="center">

	
	
	<?php
require "../components/_dbconnection.php";
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$gatepassno = $_POST['gatepassno'];
		$sql = "SELECT * FROM `gatepassdata` WHERE `gatepassno` = '$gatepassno'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_num_rows($result);
		if (!$result) {
			echo '<h1 class="h1er"> Data Not Found OR Query Error</h1>>';
		}
		else{
			if($row<=0){
				echo '<h1 class="h1er"> Data Was Not Found</h1>';
			}
			while($row = mysqli_fetch_assoc($result)){
				echo '
				<div class="card">
        <div class="card-header">
            <h2>User GatePass Details</h2>
            <span class="close"><a href="/gatepassapp/users/scan.php">&times;</a></span>
        </div>
        <div class="card-body">
            <div class="user-info">
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value" id="name">'.$row['name'].'</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value" id="email">'.$row['email'].'</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone: </span>
                    <span class="info-value" id="field1">'.$row['phone'].'</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Guardian Phone:</span>
                    <span class="info-value" id="field2">'.$row['gnumber'].'</span>
                </div>
                <div class="info-row">
                    <span class="info-label">From Date</span>
                    <span class="info-value" id="field3">'.$row['fromdate'].'</span>
                </div>
				<div class="info-row">
				<span class="info-label">To Date:</span>
				<span class="info-value" id="field3">'.$row['enddate'].'</span>
			</div>
			<div class="info-row">
			<span class="info-label">Reason:</span>
			<span class="info-value" id="field3">'.$row['reason'].'</span>
		</div>
		<div class="info-row">
			<span class="info-label">Status:</span>
			<span class="info-value" id="field3">'.$row['status'].'</span>
		</div>
            </div>
        </div>
    </div>
				';
			}
		}
		
		}
	

	?>
	  <audio src="/gatepassapp/images/qrrightaudio.mp3" id= "audioplay"></audio>
	<div class="container">

	<h1>Scan GatePass | GMS</h1>
	<div class="section">
		<div id="my-qr-reader">
		</div>
	</div>
</div>

</div>
	<script
		src="https://unpkg.com/html5-qrcode">
	</script>
	<script src = "/gatepassapp/qrscanner.js">
      
    </script>
</body>

</html>

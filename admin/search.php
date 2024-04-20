<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search For The GatePass</title>
    <style>
        .msg{
  position:absolute;
  top:10px;
  left:10px;
  color:#555;
  text-transform:uppercase;
  z-index:4;
}

.m-ticket{
  width:350px;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 0 25px #bbb;
  display:flex;
  flex-direction:column;
  align-items:center;
  position:relative;
  cursor:move;
}


.m-ticket:before{
  content:"";
  position:absolute;
  left:-10px;
  top:41%;
  background:#eee;
  box-shadow:inset 0 0 25px #bbb;
  width:17px;
  height:17px;
  border-radius:50%;
}


.m-ticket:after{
  content:"";
  position:absolute;
  right:-10px;
  top:41%;
  background:#eee;
  box-shadow:inset 0 0 25px #bbb;
  width:17px;
  height:17px;
  border-radius:50%;
}


.m{
  position:absolute;
  right:-5px;
  top:15%;
  transform:rotate(270.5deg);
  font-size:.80em;
  color:#888;
}


.m-ticket > .movie-details{
  display:flex;
  gap:20px;
  padding:20px 20px;
}


.m-ticket > .movie-details > .poster{
  width:100%;
  height:120px;
  object-fit:contain;
  border-radius:8px;
  box-shadow:0 0 10px #888;
}

.m-ticket > .movie-details > .movie > h4{
  text-transfrom:capitalize;
  font-size:1.6em;
  margin-bottom:20px;
  width:200px;
}


.m-ticket > .movie-details > .movie > p{
  font-size:.80em;
  line-height:19px;
  color:#777;
}


.m-ticket > .info{
  width:93%;
  border-radius:20px;
  background:#eee;
  padding:10px 0px;
  text-align:center;
  font-size:.72em;
}



.m-ticket > .ticket-details{
  display:flex;
  gap:20px;
  padding:20px 20px;
}


.m-ticket > .ticket-details > .scan{
  width:100px;
  height:100px;
}

.m-ticket > .ticket-details > .ticket{
  text-align:center;
  width:200px;
}


.m-ticket > .ticket-details > .ticket > p{
  font-size:.80em;
  line-height:19px;
  color:#777;
}

.m-ticket > .ticket-details > .ticket > b{
  margin-top:10px;
  display:inline-block;
  font-size:1.2em;
  font-weight:400;
}


.m-ticket > .ticket-details > .ticket > h6{
  text-transform:uppercase;
  font-weight:100;
  font-size:.95em;
  margin-top:10px;
}


.m-ticket > .info-cancel{
  width:100%;
  background:#eee;
  color:#888;
  padding:10px 0px;
  text-align:center;
  font-size:.80em;
}


.m-ticket > .total-amount{
  display:flex;
  justify-content:space-between;
  padding:12px 20px;
  font-weight:700;
  font-size:.90em;
  width:100%;
}
    </style>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
      header("location: /gatepassapp/admin/adminlogin.php");
  }
    require '../components/_dbconnection.php';
    require '../components/admin.php';
   
    ?>
    <section class="absolute left-72 top-6">
       
    <div class="bg-gray-100 flex justify-center items-center w-[80vw]">
	<div class="container bg-indigo-500 rounded-lg p-14">
		<form method="post" action="/gatepassapp/admin/search.php">
			<h1 class="text-center font-bold text-white text-4xl">Find the GatePass whether its geniune or not ?</label>
				<p class="mx-auto font-normal text-sm my-6 max-w-lg">Enter users gatepass id ,email and name for searching the gatepass ex:(5344GMS) for email ex:(test@gmail.com) for name ex: (Example Das)</p>
				<div class="sm:flex items-center bg-white rounded-lg overflow-hidden px-2 py-1 justify-between">
					<input class="text-base text-gray-400 flex-grow outline-none px-2 " type="text" placeholder="Search for gatepass ?" name="search"/>
					<div class="ms:flex items-center px-2 rounded-lg space-x-4 mx-auto ">
						<button class="bg-indigo-500 text-white text-base rounded-lg px-4 py-2 font-thin" type="submit">Search</button>
					</div>
				</div>
		</form>
	</div>
</div>
<div class="flex justify-start items-center flex-wrap">


<?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $search = $_POST['search'];
            $sql = "SELECT * FROM `gatepassdata` WHERE `email` LIKE '%$search%' OR `gatepassno` LIKE '%$search%' OR `name` LIKE '%$search%'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($result);
            if($row<=0){
                echo '<div class="bg-red-500 text-white text-center p-4 rounded-lg my-4 w-full">No GatePass Found</div>';
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="mx-4 my-4">
                    <div class="m-ticket" id="' . $row['gatepassno'] . '">
                        <p class="m">GatePassApp</p>
                        <div class="movie-details">
                            <img src="https://cutm.ac.in/wp-content/uploads/Centurion_University_of_Technology_and_Management_Logo.webp" class="poster">
                            <div class="movie">
                                <h4>' . $row['name'] . '</h4>
                                <p>Phone :- ' . $row['phone'] . '</p>
                                <p>' . $row['fromdate'] . '| ' . $row['enddate'] . '</p>
                                <p>Branch :- ' . $row['branch'] . '</p>
                            </div>
                        </div>
                        <div class="info">
                            GMS - Powered by Centurion University 
                        </div>
                        <div class="ticket-details">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data=' . $row['gatepassno'] . '" class="scan" id="qr-image-' . $row['gatepassno'] . '">
                            <div class="ticket">
                                <p>1Ticket(s)</p>
                                <b>GMS-CUTM</b>
                                <p>' . $row['status'] . '</p>
                                <h6>GATEPASS ID: ' . $row['gatepassno'] . '</h6>
                            </div>
                        </div>
                        <div class="info-cancel">
                            GatePass is valid for 30 days after the issue date
                        </div>
                    </div><!---m-ticket end---->
                </div>';
                }
            }
        }
        ?>
        </div>
    </section>
</body>
</html>
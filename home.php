<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href=”https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css” rel=”stylesheet”>

    <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body>
   
 <section class="absolute left-72">
 <?php
    session_start();
  
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    echo "You are not logged in. Please login to access this page";
    header("location: /gatepassapp/login.php");
}
else{
    echo "Welcome to the home page"." " .$_SESSION['email'];
}
require "components/admin.php";
    ?>
 </section>
</body>
</html>
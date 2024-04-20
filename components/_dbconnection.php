<?php
$servername = "localhost";
$username = "root";
$password = "";
$database ="gmsapp";
$conn = mysqli_connect($servername,$username,$password,$database);
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}
else{
   $sql = "CREATE TABLE `gmsapp`.`usersdata` (`sno` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `email` VARCHAR(30) NOT NULL , `phone` VARCHAR(30) NOT NULL , `password` VARCHAR(300) NOT NULL , `regdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `gnumber` VARCHAR(30) NULL DEFAULT NULL , `branch` VARCHAR(30) NULL DEFAULT NULL , PRIMARY KEY (`sno`)) ENGINE = InnoDB;";
   $result = mysqli_query($conn,$sql);
   $adminsql = "CREATE TABLE `gmsapp`.`admindata` (`sno` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `email` VARCHAR(35) NOT NULL , `phone` VARCHAR(30) NOT NULL , `password` VARCHAR(300) NOT NULL , `role` VARCHAR(30) NULL DEFAULT NULL , `regdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`sno`), UNIQUE (`email`)) ENGINE = InnoDB;";
   $adminresult = mysqli_query($conn,$adminsql);
   $result = mysqli_query($conn,$sql);
   $sql= "CREATE TABLE `gmsapp`.`gatepassdata` (`sno` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `email` VARCHAR(35) NOT NULL , `phone` VARCHAR(35) NOT NULL , `gnumber` VARCHAR(35) NOT NULL , `fromdate` DATE NOT NULL , `enddate` DATE NOT NULL , `branch` VARCHAR(30) NOT NULL , `reason` VARCHAR(300) NOT NULL , `status` VARCHAR(35) NOT NULL , `gatepassno` VARCHAR(35) NOT NULL , PRIMARY KEY (`sno`)) ENGINE = InnoDB;";
    $result = mysqli_query($conn,$sql);
}
?>
<?php

session_start();

if(!isset($_SESSION['username']) || $_SESSION['username']!=true){
        header("location:login.php");
        exit;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $_SESSION['username']?></title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
</head>
<body>
    <?php require "partials/nav.php" ?>
    
    <div class="container my-3">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Welcome - <?php echo $_SESSION['username']?></h4>
      <!-- <p>Hey how are you doing? Welcome to iSecure. You are logged in as
      Aww yeah, you successfully read this important alert message. 
      This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
      <hr> -->
      
      <p class="mb-0">Whenever you need to, be sure to logout <a href="/NISS/logout.php"> using this link.</a></p>
    </div>
  </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 </body>
</html>
<?php
    $login = false;
    $showError = false;

    function str_openssl_dec($str,$iv){
        $key='1234567890sumanth*#';
        $cipher="AES-128-CTR";
        $options=0;
        $str=openssl_decrypt($str,$cipher,$key,$options,$iv);
        return $str;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include ("partials/dbconnect.php");
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "select * from users where email = '$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $sql = "select * from users where username = '$username' AND email = '$email' AND password = '$password'";
            if ($num == 1){
                while($row=mysqli_fetch_assoc($result)){
                    $iv=hex2bin($row['iv']);
                    $orgpass=str_openssl_dec($row['password'],$iv);
                    $orguser=str_openssl_dec($row['username'],$iv);
                    
                    if (($password == $orgpass) && ($orguser == $username)){
                        $login = true;
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                    }
                    else{
                        $showError = "Invalid Credentials ";
                        $showError.= $sql;
                    }
                }
            }
            else{
                $showError = "Invalid Credentials <br>";
                $showError.= $sql;
            }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
    <title>Login</title>
  </head>
  <body>
    <?php require("partials/nav.php");
    
    if($login){
        echo '<div class="container signup">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>You are logged in!</strong><br>'
                .$sql.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if($showError){
        echo '<div class="container signup">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> '.$showError.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    
    ?>
        <div class="container">
            <h1 class="text-center">Login</h1>
            <form action="/NIS/login.php" method="post">
                <div class="mb-3 col-lg-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
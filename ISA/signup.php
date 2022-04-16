<?php
    $showSuccess = false;
    $showError = false;

    function str_openssl_enc($str,$iv){
        $key='1234567890sumanth*#';
        $chiper="AES-128-CTR";
        $options=0;
        $str=openssl_encrypt($str,$chiper,$key,$options,$iv);
        return $str;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include ("partials/dbconnect.php");
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $exists = false;
        $empty = false;

        if(($username == "") || $email=="" || $password==""){
            $empty = true;
        }
        
        $existsql = "SELECT * from users where username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $existsql);
        $numRowsExist = mysqli_num_rows($result);
        if($numRowsExist > 0){
            $exists = true;
            $showError = "Account already exists";
        }
        else if(($password == $cpassword) && ($empty == false)){
            $showSuccess = true;
            $iv=openssl_random_pseudo_bytes(16);
            $username=str_openssl_enc($username,$iv);
            $password=str_openssl_enc($password,$iv);
            $iv=bin2hex($iv);
            $sql = "INSERT INTO `users` ( `username`, `email`, `password`, `iv`) VALUES ( '$username', '$email', '$password', '$iv')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showSuccess = true;
            }
        }
        else if($empty){
            $showError = "Fields cannot be empty";
        }
        else{
            $showError = "Passwords do not match";
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
        
    <title>SignUp</title>
  </head>
  <body>
    <?php require("partials/nav.php");
    
    if($showSuccess){
        echo '<div class="container signup">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully signed up!</strong> You can login now.
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
            <h1 class="text-center">SignUp</h1>
            <form action="/ISA/signup.php" method="post">
                <div class="mb-3 col-lg-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" maxlength="20" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" maxlength="50" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" maxlength="25" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="mb-3 col-lg-6">
                    <label for="cpassword" class="form-label">Confirm Password</label>
                    <input type="password" maxlength="25" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
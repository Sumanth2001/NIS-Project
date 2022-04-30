<?php
    $login = false;
    $showError = false;

//     function email_validation($str) {
//         return (!preg_match(
//     "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str))
//             ? FALSE : TRUE;
//     }

//     function check_string($my_string){
//       $regex = preg_match('[@_!#$%^&*()<>?/|}{~:]', $my_string);
//       if($regex)
//          return true;
//       else
//          return false;
//    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include ("partials/dbconnect.php");
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        // $username = mysqli_real_escape_string($conn, $username);
        // $email = mysqli_real_escape_string($conn, $email);
        // $password = mysqli_real_escape_string($conn, $password);
                
        // ' or 1='1
        // sumanth' or 1=1#
        $sql = "SELECT * from users WHERE username = '$username' AND email = '$email' AND password = '$password'";
        $flag = true;
        // if(!email_validation($email) || !check_string($username) || !check_string($password)){
        //     $showError = "Invalid Credentials";
        //     $flag = false;
        // }

        if($flag == true){
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);

            if ($num > 0){
                while($row=mysqli_fetch_assoc($result)){   
                    $login = true;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                }
            }
            else{
                $showError = "Invalid Credentials";
            }
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
                <strong>You are logged in!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><br>'
                .$sql.'
            </div>';
    }
    else if($showError){
        echo '<div class="container signup">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> '.$showError.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    
    ?>
        <div class="container">
            <h1 class="text-center">Login</h1>
            <form action="/NISS/login.php" method="post">
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
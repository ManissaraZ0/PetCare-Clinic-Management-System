<?php
    session_start();

    if (isset($_SESSION["owner_id"])) {
        header("Location: ./");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Care </title>

    <!-- Icon -->
    <link rel="icon" href="./images/logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="./user_style.css" />
    <link rel="stylesheet" href="../css/font.css" />

    <style>
        .validate {
            color: red;
        }
        
        h1.display-3 {
            font-weight: bold !important;
            text-align: center;
        }
    </style>

    <script>
        window.onload = function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };
    </script>

</head>
<body>
    <?php
        include '../connect.php';

        $fnameErr = $lnameErr = $telErr = $emailErr = $passwordErr = "";
        $fname = $lname = $tel = $email = $originalPassword = $password = $confirmPassword = "";
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $checkError = true;

            if (empty($_POST["fname"])) {
                $fnameErr = "Please enter your name";
                $checkError = false;
            } else {
                $fname = test_input($_POST["fname"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                    $fnameErr = "Only letters allowed";
                    $checkError = false;
                }  else {
                    $fnameErr = "";
                }
            }

            if (empty($_POST["lname"])) {
                $lnameErr = "Please enter your name";
                $checkError = false;
            } else {
                $lname = test_input($_POST["lname"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
                    $lnameErr = "Only letters allowed";
                    $checkError = false;
                }  else {
                    $lnameErr = "";
                }
            }

            if (empty($_POST["tel"])) {
                $telErr = "Please enter your phone number";
                $checkError = false;
            } else {
                $tel = $_POST["tel"];
                $telErr = "";
            }
            
            if (empty($_POST["email"])) {
                $emailErr = "Please enter your email";
                $checkError = false;
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $checkError = false;
                } else {
                    $emailErr = "";
                }
            }
              
            if (empty($_POST["pwd"])) {
                $passwordErr = "Please enter your password";
                $checkError = false;
            } else {
                $originalPassword = $_POST["pwd"];
                $password = test_input($_POST["pwd"]);
                $passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
                if (!preg_match($passwordPattern, $password)) {
                    $passwordErr = "The password contains at least one alphabet, one digit, and is at least 8 characters long.";
                    echo "<script> console.log('".$passwordErr."'); </script>";
                    $checkError = false;
                } else {
                    $passwordErr = "";
                }
            }

            $confirmPassword = $_POST["conpwd"];

            if ($checkError) {
                $sql = "SELECT * FROM owner WHERE email='$email'";
                $result = $conn->query($sql);

                if ($result->num_rows == 0) {

                    if ($password == $confirmPassword) {
                        $password = substr(md5($password), 0, 30);
                        $sql = "INSERT INTO `owner` (`fname`, `lname`, `email`, `phone`, `password`) VALUES ('$fname', '$lname', '$email', '$tel', '$password');";
                        $result = $conn->query($sql);

                        header("Location: ./");
                    } else {
                        $passwordErr = "Password and confirm password do not match.";
                    }
                } else {
                    $emailErr = "This email already has an account.";
                }
            }
            
    }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">
                <img src="./images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="./"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>
      
    <div class="container">
        <h1 class="mt-3 mb-3 display-3"> Welcome </h1>
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="mb-4 row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname" class="mb-1"> First name </label> 
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" value="<?php echo $fname;?>">
                                    <small class="validate"> <?php echo $fnameErr; ?> </small>
                                </div> 
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname" class="mb-1"> Last name </label> 
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" value="<?php echo $lname;?>">
                                    <small class="validate"> <?php echo $lnameErr; ?> </small>
                                </div> 
                            </div> 
                        </div>
        
                        <div class="mb-3 row">
                            <div class="form-group">
                                <label for="tel" class="mb-1"> Phone number </label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="Enter phone number" value="<?php echo $tel;?>">
                                </div>
                                <small class="validate"> <?php echo $telErr; ?> </small>
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <div class="form-group">
                                <label for="email" class="mb-1 form-label"> Email </label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email;?>">
                                </div>
                                <small class="validate"> <?php echo $emailErr; ?> </small>
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <div class="form-group">
                                <label for="pwd" class="mb-1"> Password </label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" value="<?php echo $originalPassword;?>">
                            </div>
                        </div>
        
                        <div class="mb-3 row">
                            <div class="form-group">
                                <label for="conpwd" class="mb-1"> Confirm password </label>
                                <input type="password" class="form-control" id="conpwd" placeholder="Enter password" name="conpwd" value="<?php echo $confirmPassword;?>">
                                <small class="validate"> <?php echo $passwordErr; ?> </small>
                            </div>
                        </div>
        
                        <div class="d-grid">
                            <button type="submit" class="mt-3 btn btn-block btn-success bg-indigo" name="signupbtn" value="done"> Sign up </button>
                        </div>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>
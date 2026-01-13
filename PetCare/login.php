<?php
    session_start();
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
        .addSpace {
            padding-top: 15vh;
        }

        .bg-login {
            background-image: url(./images/bg_half.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100%;
            display: inline-flex;
            vertical-align: middle;
            position: relative;
        }

        .wrapper {
            min-height: calc(100vh);
        }

        .is-paddingless {
            padding: 0 !important;
        }

        @media screen and (min-width: 769px) {
            .centering {
                display: flex;
                justify-content: center;
            }
            .content-wrapper {
                min-width: 400px;
                max-width: 400px;
            }
        }

        @media screen and (max-width: 768px) {
            .is-hidden-mobile {
                display: none !important;
            }
        }

        h1.display-1 {
            font-weight: bold !important;
        }

        .full {
            width: 100% !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        .validate {
            color: red !important;
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

        $error = '';
        $email = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = substr(md5($_POST["pwd"]), 0, 30);

            $sql = "SELECT * FROM owner WHERE email='$email' AND password='$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $_SESSION["fname_owner"] = $row["fname"];
                    $_SESSION["lname_owner"] = $row["lname"];
                    $_SESSION["phone_owner"] = $row["phone"];
                    $_SESSION["email_owner"] = $row["email"];
                    $_SESSION["owner_id"] = $row["owner_id"];

                    header("Location: ../PetCare/");
                }
            } else {
                $error = '&#9888; Please check the username and password try again';

                echo "<script>document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                    myModal.show();
                });
                </script>";
            }
        }
    ?>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><b> Unable to process </b></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="text-align: center;">
                <img src="./images/validate.png" width="80px" class="mt-3 mb-3"/>
                <p> Please try again after checking the username and password. </p>
            </div>

            </div>
        </div>
    </div>

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
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm bg-login wrapper is-paddingless is-hidden-mobile">
            </div>
            <div class="col-sm addSpace">
                <div class="centering">
                    <div class="content-wrapper">
                        <h1 class="display-1"> Welcome </h1>
                        <br />
                        <p class="validate"> <?php echo $error; ?> </p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <div class="mb-3 mt-3 form-group">
                                <label for="email" class="form-label"> Email </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>" required>
                                </div>
                            </div>
                            <div class="mb-5 form-group">
                                <label for="pwd" class="form-label"> Password </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
                                    <span class="input-group-text"><i class="fa-solid fa-eye" onmousedown="showPassword()" onmouseup="hidePassword()" ontouchstart="showPassword()" ontouchend="hidePassword()" onmouseleave="hidePassword()"></i></span>
                                </div>
                            </div>
                            <div class="mb-4 d-grid">
                                <button type="submit" class="btn btn-success btn-block bg-indigo" id="login"> Log in </button>
                            </div>
                            <div class="d-grid">
                                <a href="signup.php">
                                    <div class="row">
                                        <div class="col-"><button type="button" class="btn btn-secondary" id="signup" style="width: 100%;"> Sign up </button></div>
                                    </div>
                                </a>
                                <small class="mt-1"><label for="signup" class="form-label"> Haven't had account yet?</label></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPassword() {
            var x = document.getElementById("pwd");
            if (x.type === "password") {
                x.type = "text";
            }
        }

        function hidePassword() {
            var x = document.getElementById("pwd");
            if (x.type === "text") {
                x.type = "password";
            }
        }
    </script>
    <?php
        $conn->close();
    ?>
</body>
</html>
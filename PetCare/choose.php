<?php
    session_start();

    include '../connect.php';

    if (!isset($_SESSION["owner_id"])) {
        header("Location: login.php");
    } else {
        $ownerId = $_SESSION["owner_id"];

        $sql = "SELECT * FROM pet WHERE owner_id='$ownerId'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            header("Location: ./profile/add_pet.php");
        }
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
        h1.display-4 {
            font-weight: bold !important;
            text-align: center;
        }

        a.text-white {
            text-decoration: none;
        }

        h1.in-box {
            font-weight: bold !important;
            color: #FFFFFF !important;
            line-height: 2.5;

        }

        a.in-box {
            color: #FFFFFF;
            text-decoration: none !important;
            text-align: center;
        }

        @media (max-width: 576px) {
            ul.bg-indigo {
                background-color: #0d2035 !important;
                margin-top: 12.8px;
                padding: 20px;
            }
        }

        @media (min-width: 576px) {
            .navbar-expand-sm .navbar-nav .dropdown-menu {
                width: 200px;
            }
        }

        .dropdown-menu[data-bs-popper] {
            right: 0 !important;
            left: auto;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: gainsboro;
        }

        @media (min-width: 1200px) {
            .choose {
                width: 400px !important;
            }
        }

    </style>
</head>
<body>
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
                <ul class="navbar-nav bg-indigo">
                    <li class="nav-item mt-2">
                        <a class="nav-link active" href="choose.php"> Appointment </a>
                    </li>
                    <li class="nav-item mt-2" style="margin-right: 5px;">
                        <a class="nav-link" href="about_us.php"> About us </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class='nav-link' class="dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa-regular fa-circle-user" style="font-size: 40px;"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text"> <?php echo $_SESSION["fname_owner"] . " " . $_SESSION["lname_owner"]; ?> </span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="profile/"><i class="fa-solid fa-user"></i> &nbsp; PROFILE </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-power-off"></i> &nbsp; LOGOUT </a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>

    <div class="mt-4 container">
        <h1 class="mb-4 display-4"> Appointment </h1>
        <div class="row">
            <div class="col-">
                <div class="d-flex justify-content-around">
                    <div class="row">
                        <div class="col-6 col-md-6 col-xl-6 mb-3">
                            <a href="./appointment/appointment_vaccine.php" class="in-box">
                                <div class="card rounded-4 shadow bg-indigo">
                                    <div class="card-body">
                                        <h1 class="in-box"> Vaccination </h1>
                                        <div class="row">
                                            <div class="col-">
                                                <img src="./images/choose/vaccination.png" class="rounded-4 choose" width="100%"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-6 col-xl-6">
                            <a href="./appointment/appointment_health.php" class="in-box">
                                <div class="card rounded-4 shadow bg-indigo">
                                    <div class="card-body">
                                        <h1 class="in-box"> Health check </h1>
                                        <div class="row">
                                            <div class="col-">
                                                <img src="./images/choose/healthCheck.png" class="rounded-4 choose" width="100%"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>

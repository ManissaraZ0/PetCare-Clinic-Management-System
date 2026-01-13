<?php
    session_start();

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../../");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Care </title>

    <!-- Icon -->
    <link rel="icon" href="../../images/logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../../css/font.css" />
    
    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color:  #FBF7EF !important;
        }

        a.active {
            text-decoration: underline !important;
            text-underline-offset: 8px !important;
        }

        .add-space-nav {
            padding-top: 72px;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px #112D4E;
        }
            
        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #3F72AF; 
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #112D4E; 
        }

        .bg-indigo {
            background-color: #112D4E !important;
        }
        
        button.bg-indigo:hover {
            background-color: #0a1d32 !important;
        }
            
        .btn-lb {
            background-color: #DBE2EF !important;
        }
            
        .navbar-size {
            height: 72px !important;
        }

        h1.display-4 {
            font-weight: bold !important;
            text-align: center;
        }

        a.text-white {
            text-decoration: none;
        }

    </style>
</head>
<body>
    <?php
        include '../../../connect.php';

        if (isset($_GET['ownerId'])) {
            $ownerId = $_GET['ownerId'];

            $sql = "SELECT * FROM owner WHERE owner_id=$ownerId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fname = $row["fname"];
                    $lname = $row["lname"];
                    $phone = $row["phone"];
                    $email = $row["email"];
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fnameNew = (string) $_POST["fname"];
            $lnameNew = (string) $_POST["lname"];
            $phoneNew = $_POST["phone"];
            $ownerId = $_POST["ownerId"];

            $sql = "UPDATE `owner` SET `fname`= '$fnameNew', `lname`= '$lnameNew',`phone`= '$phoneNew' WHERE `owner_id`= $ownerId";
            $result = $conn->query($sql);
            if ($result) {
                header("location: customer_info.php?ownerId=$ownerId");
            }
        }
    ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top  bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="../dashboard.php">
                <img src="../../images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="../dashboard.php"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard.php"> Dashboard </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../appointment/appointment.php"> Appointment </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer.php"> Customer </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vaccine/vaccine.php"> Vaccine </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../staff_logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>

    <div class="mt-4 container">
        <h1 class="mb-4 display-4"> Profile </h1>
        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="col-10 col-md-8 col-lg-6 col-xl-6">
                <input type="hidden" name="ownerId" id="ownerId" value="<?php echo $ownerId; ?>">
 
                <div class="mb-4 row">
                    <div class="col-md-6">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="fname" value="<?php echo $fname; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?php echo $lname; ?>" required>
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-12">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $phone; ?>" required>
                    </div>
                </div>
                <div class="mt-5 d-grid">
                    <button type="submit" class="btn btn-success bg-indigo btn-block">Change</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>
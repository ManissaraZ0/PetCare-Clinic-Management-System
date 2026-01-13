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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../../css/font.css" />
    
    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color: #FBF7EF !important;
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

    $appId = "";
    if (isset($_GET["appId"])) {
        $appId = $_GET["appId"];
    }

    echo "<script>
        console.log('$appId');
    </script>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $appId = $_POST["appId"];
        $ownerId = $_POST["ownerId"];
        $dateNew = $_POST["date"];
        $timeNew = $_POST["time"];
       
        $sql = "UPDATE `appointment` SET `date`= '$dateNew', `time`= '$timeNew', update_date= NOW() WHERE appointment_id = '$appId'";
        
        $result = $conn->query($sql);
        if ($result) {
            header("location: customer_info.php?ownerId=$ownerId#appointment");
        }
    }

    $sql = "SELECT * FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE appointment_id='$appId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row["date"];
            $time = $row["time"];
            $ownerId = $row["owner_id"];

            echo "<script>
                        console.log('$date');
                        console.log('$time');
                    </script>";
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
        <h1 class="mb-5 display-4"> Postponement of Appointment </h1>
        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-10 col-md-8 col-lg-6 col-xl-6">
                <input type="hidden" name="ownerId" id="ownerId" value="<?php echo $ownerId; ?>">
                <input type="hidden" name="appId" id="appId" value="<?php echo $appId; ?>">
                <div class="mb-4 row">
                    <div class="col-6">
                        <label for="date" class="mb-2">
                            <h4> Date </h4>
                        </label>
                        <input type="date" id="date" name="date" class="form-control" value="<?php echo $date; ?>">
                    </div>
                    <div class="col-6">
                        <label for="time" class="mb-2">
                            <h4> Time </h4>
                        </label>
                        <select name="time" id="time" class="form-select">
                            <option value="10:00-11:00" <?php if ($time == "10:00-11:00") echo "selected"; ?>> 10:00-11:00 น. </option>
                            <option value="11:00-12:00" <?php if ($time == "11:00-12:00") echo "selected"; ?>> 11:00-12:00 น. </option>
                            <option value="13:00-14:00" <?php if ($time == "13:00-14:00") echo "selected"; ?>> 13:00-14:00 น. </option>
                            <option value="14:00-15:00" <?php if ($time == "14:00-15:00") echo "selected"; ?>> 14:00-15:00 น. </option>
                            <option value="15:00-16:00" <?php if ($time == "15:00-16:00") echo "selected"; ?>> 15:00-16:00 น. </option>
                            <option value="16:00-17:00" <?php if ($time == "16:00-17:00") echo "selected"; ?>> 16:00-17:00 น. </option>
                        </select>
                    </div>
                </div>
                <div class="mt-5 mb-5 d-grid">
                    <button type="submit" class="btn btn-success bg-indigo"> Done </button>
                </div>
        </div>
        </form>
    </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
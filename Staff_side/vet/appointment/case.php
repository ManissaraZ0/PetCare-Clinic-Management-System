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

        div.box {
            width: 470px;
            height: 370px;
            background-color: #112D4E;
        }

        .text-in-button {
            color: #FFFFFF !important;
            text-decoration: none !important;
        }

        table.box td {
            background-color: #112D4E !important;
        }

        td.table-label {
            width: 50px;
            text-align: end;
            padding: 12px 3px 0 0;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 20px;
        }

        .bg-indigo th {
            background-color: #3F72AF !important;
            color: #FFFFFF;
        }

        th.table-date {
            width: 142px;
        }

        th.table-time {
            width: 140px;
        }

        th.table-pet {
            width: 180px;
        }

        th.table-status {
            width: 100px;
        }

        .info {
            margin-top: 5px;
        }

        .card-header {
            padding-top: 15px;
            background-color: #3F72AF;
            color: #FFFFFF;
        }

        .submitbtn {
            color: #FFFFFF;
        }

        @media (max-width: 992px) {
            img {
                width: 40%;
            }
        }
    </style>
</head>
<body>
    <?php
        include '../../../connect.php';

        if (isset($_GET['appId'])) {
            $appId = $_GET['appId'];
        }

        $sql = "SELECT * FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id
            INNER JOIN pet_type pt ON pt.type_id = p.type 
            INNER JOIN owner o ON p.owner_id = o.owner_id 
            INNER JOIN appointment_type apt ON apt.appointment_type_id = a.type
            WHERE appointment_id='$appId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $fname = $row["fname"];
                $lname = $row["lname"];
                $phone = $row["phone"];
                $email = $row["email"];

                $name = $row["name"];
                $type = ucfirst($row["type_name"]);
                $breed = $row["breed"];
                $age = $row["age"];
                $gender = ucfirst($row["gender"]);
                $path = $row["path"];

                $date = $row["date"];
                $time = $row["time"];
                $status = ucfirst($row["status"]);
                $appTypeName = $row["appointment_type_name"];
                $appTypeId = $row["appointment_type_id"];
            }
        }

        $detail = "";
        $receive = "case_receive_health.php";
        if ($appTypeId == '1') {

            $sql = "SELECT * FROM appointment a INNER JOIN vaccine v ON a.vaccine_id = v.vaccine_id
            WHERE a.vaccine_id='$appTypeId'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $vaccineName = $row["vaccine_name"];
                }
            }

            $receive = "case_receive_vaccine.php";
            $detail = " — " . $vaccineName;
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
                        <a class="nav-link" href="appointment.php"> Appointment </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../customer/customer.php"> Customer </a>
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
        <div class="mb-3 card rounded-4">
            <div class="card-header"><h4> Owner information </h4></div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="fname"> First name : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="fname" name="fname" readonly value="<?php echo $fname; ?>"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="lname"> Last name : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="lname" name="lname" readonly value="<?php echo $lname; ?>"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="tel"> Phone number : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="tel" name="tel" readonly value="<?php echo $phone; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="email"> Email : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="email" name="email" readonly value="<?php echo $email; ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 card rounded-4">
            <div class="card-header"><h4> Pet information </h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-xl-2" style="text-align:center;">
                        <img class="mt-3 mb-3 rounded-4" src="../../../<?php echo $path; ?>" alt="Card image" width="100%">
                    </div>
                    <div class="col-lg-10">
                        <div class="row mb-2">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                                <label for="pname"> Name : </label>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                                <input type="text" class="form-control" id="pname" name="pname" readonly value="<?php echo $name; ?>"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                                <label for="type"> Type : </label>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                                <input type="text" class="form-control" id="type" name="type" readonly value="<?php echo $type; ?>"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                                <label for="tel"> Breed : </label>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                                <input type="text" class="form-control" id="breed" name="breed" readonly value="<?php echo $breed; ?>"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                                <label for="email"> Age : </label>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="age" name="age" readonly value="<?php echo $age; ?>" />
                                    <span class="input-group-text"> Year </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 info">
                                <label for="email"> Gender : </label>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-8 col-8">
                                <input type="text" class="form-control" id="gender" name="gender" readonly value="<?php echo $gender; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 card rounded-4">
            <div class="card-header"><h4> Appointment information </h4></div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="date"> Date/Month/Year : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="date" class="form-control" id="date" name="date" readonly value="<?php echo $date; ?>"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="time"> Time : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="time" name="time" readonly value="<?php echo $time; ?>"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="type"> Appointment Type : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="type" name="type" readonly value="<?php echo $appTypeName . $detail; ?>"/>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="status"> Status : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="status" name="status" readonly value="<?php echo $status; ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <a href="<?php echo $receive; ?>?appId=<?php echo $appId; ?>">
                <button type="button" class="mt-4 mb-4 btn btn-success btn-lg submitbtn">
                    Receive a case 
                </button>
            </a>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>

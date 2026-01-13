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

    <!-- CSS -->
    <link rel="stylesheet" href="../../../css/font.css" />
    
    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color:  #FBF7EF !important;
            color: black;
        }

        .addSpace {
            padding-top: 15vh;
        }

        a.active {
            text-decoration: underline;
            text-underline-offset: 8px;
        }

        h1.display-4 {
            font-weight: bold !important;
            text-align: center;
        }

        .bg-indigo {
            background-color: #112D4E !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        .bg-indigo th {
            background-color: #3F72AF !important;
            color: #FFFFFF;
        }

        th.id_vacc {
            width: 120px;
        }

        th.edit {
            width: 20px;
        }
        
        a {
            color: #FFFFFF;
            text-decoration: none;
        }

        td {
            vertical-align: middle;
        }

        .validate {
            color: red;
        }

    </style>

</head>
<body>
    <?php
        include '../../../connect.php';
        $vaccine_nameErr = $vaccine_priceErr = "";
        $vaccine_name = $vaccine_price = $type = $status= "";
        $checkError = true;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["vaccine_name"])) {
                $vaccine_nameErr = "Please enter vaccine";
                $checkError = false;
            } else {
                $vaccine_name = test_input($_POST["vaccine_name"]);
                $vaccine_nameErr = "";
            }

            if (empty($_POST["vaccine_price"])) {
                $fnameErr = "Please enter price";
                $checkError = false;
            } else {
                $vaccine_price = test_input($_POST["vaccine_price"]);
                if (!preg_match("/^\d+$/", $vaccine_price)) {
                    $vaccine_priceErr = "Only letters allowed";
                    $checkError = false;
                }  else {
                    $vaccine_priceErr = "";
                }
            }
            
            $type = $_POST["type_pet"];
            $status = 'available';

            if ($checkError) {
                $sql = "INSERT INTO `vaccine` (`vaccine_name`, `type`, `vaccine_price`, `status`) VALUES ('$vaccine_name', '$type', '$vaccine_price', '$status');";
                $result = $conn->query($sql);

                if ($result) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                header("Location: vaccine.php");
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
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
                        <a class="nav-link" href="../customer/customer.php"> Customer </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="vaccine.php"> Vaccine </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../staff_logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="addSpace"></div>
        <h1 class="mb-4 display-4"> Add vaccine </h1>

        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="col-10 col-md-8 col-lg-6 col-xl-6">
                <div class="mb-4 row">
                    <div class="col-xl-">
                        <label for="vaccine_name" class="form-label"><h4> Name vaccine </h4><small class="validate"><?php echo $vaccine_nameErr; ?></small></label>
                        <input type="text" id="vaccine_name" name="vaccine_name" class="form-control">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-6">
                        <label for="type_pet" class="mb-2"><h4> Type </h4></label>
                        <select name="type_pet" id="type_pet" class="form-select">
                            <option value="1"> Cat </option>
                            <option value="2"> Dog </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="vaccine_price" class="mb-2"><h4> Price </h4><small class="validate"><?php echo $vaccine_priceErr; ?></small></label>
                        <input type="text" id="vaccine_price" name="vaccine_price" class="form-control">
                    </div>
                <div class="mt-5 mb-5 d-grid">
                    <button type="submit" class="btn btn-success bg-indigo"> Add </button>
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
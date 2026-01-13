<?php
    session_start();

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Care </title>

    <!-- Icon -->
    <link rel="icon" href="../images/logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../css/font.css" />

    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color:  #FBF7EF !important;
            color: black;
        }

        .add-space-nav {
            padding-top: 72px !important;
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
        }

        .bg-white {
            background-color: #FFFFFF;
        }

        .inBox {
            text-align: center;
        }

        .bg-indigo {
            background-color: #112D4E !important;
            color: #FFFFFF !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        #myPieChart {
            width: 250px !important;
            height: 250px !important;
        }

        #myBarChart {
            width: 90% !important;
            height: 250px !important;
        }

        .card-body {
            text-align: -webkit-center;
        }
    </style>

</head>
<body>
    <?php
        include "../../connect.php";

        date_default_timezone_set("Asia/Bangkok");
        $todayShow = date("d M Y");
        $today = date("Y-m-d");
    ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <img src="../images/logo.png" alt="Avatar Logo" style="width:40px;" /> 
            </a>
            <a class="navbar-brand" href="dashboard.php"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"> Dashboard </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./appointment/appointment.php"> Appointment </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./customer/customer.php"> Customer </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./vaccine/vaccine.php"> Vaccine </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../staff_logout.php" tooltip="Log out"><i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="add-space-nav"></div>
        <h1 class="mt-3 mb-4 display-4"> Dashboard </h1>
        <div class="row">
            <div class="col-lg- col-xl-4">
                <div class="mb-3 card rounded-4 bg-indigo">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 col-5 d-flex justify-content-center align-content-center flex-wrap">
                                <i class="fa-solid fa-user-group fa-5x"></i>
                            </div>
                            <div class="col-sm-7 col-7 inBox">
                                <h4> Total Pet </h4>
                                <?php
                                    $sql = "SELECT * FROM pet";
                                    $result = $conn->query($sql);
                            
                                    $allPet = $result->num_rows;
                                ?>
                                <h1><?php echo $allPet; ?></h1>
                                <p class="mb-0"> Till today </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg- col-xl-4">
                <div class="mb-3 card rounded-4 bg-indigo">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 col-5 d-flex justify-content-center align-content-center flex-wrap">
                                <i class="fa-solid fa-user fa-5x"></i>
                            </div>
                            <div class="col-sm-7 col-7 inBox">
                                <h4> New Pet </h4>
                                <?php
                                    $sql = "SELECT * FROM pet WHERE create_date LIKE '$today%'";
                                    $result = $conn->query($sql);
                            
                                    $newPet = $result->num_rows;
                                ?>
                                <h1><?php echo $newPet; ?></h1>
                                <p class="mb-0"><?php echo $todayShow; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg- col-xl-4">
                <div class="mb-3 card rounded-4 bg-indigo">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-4 d-flex justify-content-center align-content-center flex-wrap">
                                <i class="fa-solid fa-file-lines fa-5x"></i>
                            </div>
                            <div class="col-sm-8 col-8 inBox">
                                <h4> Today Appointments </h4>
                                <?php
                                    $sql = "SELECT * FROM appointment WHERE date='$today'";
                                    $result = $conn->query($sql);
                            
                                    $appToday = $result->num_rows;
                                ?>
                                <h1><?php echo $appToday; ?></h1>
                                <p class="mb-0"><?php echo $todayShow; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-md-">
                <div class="mt-2 mb-3 card rounded-4 bg-white">
                    <div class="card-body">
                        <h4 class="card-title"> Appointment Type Overview </h4>
                        <canvas id="myBarChart"></canvas>
                        <?php
                            $sql = "SELECT sum(case when at.appointment_type_name = 'Health check' then 1 else 0 end) as health_total,
                            sum(case when at.appointment_type_name = 'Vaccination' then 1 else 0 end) as vaccine_total,
                            date(a.create_date) as create_date
                            from appointment a  inner join appointment_type at  on a.`type`  = at.appointment_type_id group by date(a.create_date)
                            ORDER BY date(a.create_date) DESC LIMIT 7";
                            $result = $conn->query($sql);
                            
                            $dates = array();
                            $healthTotals = array();
                            $vaccineTotals = array();

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $dates[] = $row["create_date"];
                                    $healthTotals[] = $row["health_total"];
                                    $vaccineTotals[] = $row["vaccine_total"];
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                        <script>
                            var ctx = document.getElementById('myBarChart').getContext('2d');
                            var myBarChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($dates); ?>,
                                    datasets: [{
                                        label: 'Health Check',
                                        data: <?php echo json_encode($healthTotals); ?>,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }, {
                                        label: 'Vaccination',
                                        data: <?php echo json_encode($vaccineTotals); ?>,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-">
                <div class="mt-2 mb-3 card rounded-4 bg-white">
                    <div class="card-body">
                        <h4 class="card-title"> Pet Type </h4>
                        <canvas id="myPieChart"></canvas>

                        <?php
                            $sql = "SELECT count(1) AS total, pt.type_name
                            FROM pet p INNER JOIN pet_type pt ON p.type = pt.type_id 
                            GROUP BY pt.type_name";
                            $result = $conn->query($sql);
                            
                            $labels = array();
                            $values = array();

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $labels[] = $row["type_name"];
                                    $values[] = $row["total"];
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>

                        <script>
                            var ctx = document.getElementById('myPieChart').getContext('2d');
                            var myPieChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: <?php echo json_encode($labels); ?>,
                                    datasets: [{
                                        data: <?php echo json_encode($values); ?>,
                                        backgroundColor: [
                                            '#3F72AF',
                                            
                                            '#20487a'
                                        ]
                                    }]
                                },
                                options: {
                                    // You can add options here if needed
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
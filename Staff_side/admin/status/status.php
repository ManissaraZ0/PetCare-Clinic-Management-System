<?php
    session_start();

    if(!isset($_SESSION["staff_id"])) {
        header("location: ../../");
    } else {
        $staffId = $_SESSION["staff_id"];
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

        td {
            vertical-align: middle;
        }

        td.con_status {
            text-align: center;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
        }

        .bg-indigo {
            background-color: #112D4E !important;
            color: #FFFFFF !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        .bg-indigo th {
            background-color: #112D4E !important;
            color: #FFFFFF !important;
        }

        i.confirm:hover {
            color: darkgreen !important;
        }

        tr.detail th {
            background-color: #3F72AF !important;
        }

    </style>

</head>
<body>
    <?php 
        include '../../../connect.php';
    ?>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="../news/news.php">
                <img src="../../images/logo.png" alt="Avatar Logo" style="width:40px;" /> 
            </a>
            <a class="navbar-brand" href="../news/news.php"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../news/news.php"> News </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="status.php"> Status </a>
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
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input class="form-control me-2" type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for pet names.." title="Type in a name">
        </div>
        <table class="mt-4 table table-bordered" id="myTable">
            <thead class="bg-indigo">
                <tr>
                    <th style="width: 34%;" colspan="2"> Appointment </th>
                    <th style="width: 10%;"> Date </th>
                    <th style="width: 20%;" colspan="2"> Owner </th>
                    <th style="width: 20%;" colspan="2"> Pet </th>
                    <th style="width: 11%;"> Payment status </th>
                    <th style="width: 5%;"> Confirm </th>
                </tr>
                <tr class="detail">
                    <th style="width: 3%;"> ID </th>
                    <th > Type </th>
                    <th > Date </th>
                    <th style="width: 3%;"> ID </th>
                    <th > Name </th>
                    <th style="width: 3%;"> ID </th>
                    <th > Name </th>
                    <th > </th>
                    <th > </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT a.appointment_id, a.date, a.pet_id, p.name, p.owner_id, o.fname, o.lname,
                     t.appointment_type_name, a.payment_status, a.type FROM appointment a 
                    INNER JOIN pet p ON a.pet_id = p.pet_id 
                    INNER JOIN appointment_type t ON a.type = t.appointment_type_id
                    INNER JOIN owner o ON p.owner_id = o.owner_id
                    WHERE a.status!='cancelled' ORDER BY appointment_id DESC";
                    $result = $conn->query($sql);
        
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $appId = $row["appointment_id"];
                            $date = $row["date"];
                            $pet_id = $row["pet_id"];
                            $name = $row["name"];
                            $owner_id = $row["owner_id"];
                            $fullName = $row["fname"] . " " . $row["lname"];
                            $appointment_type_name = $row["appointment_type_name"];
                            $appTypeId = $row["type"];
                            $payment_status = $row["payment_status"];

                            // Vaccine detail
                            $detail = "";
                            if ($appTypeId == '1') {
                                $sqlVaccine = "SELECT v.vaccine_name FROM appointment a INNER JOIN vaccine v ON a.vaccine_id = v.vaccine_id
                                WHERE a.appointment_id='$appId'";
                        
                                $resultVaccine = $conn->query($sqlVaccine);
                                if ($resultVaccine->num_rows > 0) {
                                    while($rowVaccine = $resultVaccine->fetch_assoc()) {
                                        $vaccineName = $rowVaccine["vaccine_name"];
                                    }
                                }
                                $detail = " — " . $vaccineName;
                            }

                            // Complete Style
                            $style = "";
                            $update = "<a href=\"update_payment_status.php?appId=" . $appId . "\">
                                            <i class=\"fa-solid fa-sack-dollar confirm\" style=\"color:limegreen;\"></i>
                                        </a>";

                            if ($payment_status == 'completed') {
                                $style = "style='color: limegreen;font-weight: bold;'";
                                $update = "";
                            }
        
                            include 'appointment_table.php';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[6];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
    <?php
        $conn->close();
    ?>
</body>
</html>
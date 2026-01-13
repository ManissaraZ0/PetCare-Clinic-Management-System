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

        th.time {
            width: 150px;
        }

        th.details {
            width: 100px;
        }

        td {
            vertical-align: middle;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
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

        .noCase {
            text-align: center;
        }
    </style>

</head>

<body>
    <?php
    include "../../../connect.php";

    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y-m-d");

    echo "<script>
                    console.log('$date');
                </script>";
    ?>

    <script>
        function callAppInfo(date) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    let text = "";

                    for (let x in myObj) {

                        ownerId = myObj[x]["owner_id"];
                        appointment_id = myObj[x]["appointment_id"];
                        fname = myObj[x]["fname"];
                        time = myObj[x]["time"];
                        name = myObj[x]["name"];
                        appointment_type_name = myObj[x]["appointment_type_name"];

                        text += "<tr>";
                        text += "<td>" + time + "</td>";
                        text += "<td>" + name + " (" + fname + ")</td>";
                        text += "<td>" + appointment_type_name + "</td>";
                        text += "<td class='edit'>";
                        text += "<a href=\"case.php?appId=" + appointment_id + "\">";
                        text += "<button type=\'button\' class=\'btn btn-secondary btn-sm btn-block\'>";
                        text += "See more";
                        text += "</button>";
                        text += "</a>";
                        text += "</td>";
                        text += "</tr>";
                    }

                    console.log(text);
                    document.getElementById('table_body').innerHTML = text;

                    if(document.getElementById('table_body').innerHTML == "") {
                        let noCase = "<tr><td colspan='4' class='noCase'><h1 style='margin: 20px 0 20px 0 ;'> There are no appointments today. </h1></td></tr>";
                        document.getElementById('table_body').innerHTML = noCase;
                    }
                }
            }
            xhr.open("GET", "appointment_table.php?date=" + date, true);
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var dateSelect = document.getElementById('date');

            dateSelect.addEventListener("change", function() {
                var date = dateSelect.value;
                callAppInfo(date);
            });
        });
    </script>

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
                        <a class="nav-link active" href="appointment.php"> Appointment </a>
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

    <div class="container">
        <div class="addSpace"></div>
        <h1 class="mb-4 display-4"> Appointment table </h1>
        <form>
            <label for="date" class="mb-1 form-label">
                <h5><b> Date </b></h5>
            </label>
            <div class="row">
                <div class="col- col-xl-6">
                    <input type="date" class="form-control form-control-lg" id="date" placeholder="Enter date" name="date" value="<?php echo $date; ?>">
                    <?php
                        $firstDate = 0;
                        
                        if ($firstDate == 0) {
                            $firstDate = date("Y-m-d");
                        }
                            
                        if ($firstDate != 0) {
                            echo "<script>callAppInfo('" . $firstDate . "')</script>";
                        }
                    ?>
                </div>
            </div>
        </form>
        <table class="mt-4 table table-bordered">
            <thead class="bg-indigo">
                <tr>
                    <th class="time"> Time </th>
                    <th class="name"> Name </th>
                    <th class="type"> Type </th>
                    <th class="details"> Details </th>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
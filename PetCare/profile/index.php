<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../");
} else {
    $ownerId = $_SESSION["owner_id"];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../css/font.css" />

    <style>
        body {
            font-family: "Kanit", arial, sans-serif;
            background-color: #F9F7F7 !important;
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

        table.appointment th {
            background-color: #3F72AF !important;
            color: #FFFFFF;
            text-align: center;
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

        th.table-rej {
            width: 140px;
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

        .card-header {
            padding-top: 15px;
            background-color: #3F72AF;
            color: #FFFFFF;
        }

        .info {
            margin-top: 5px;
        }

        td.rejec a {
            color: red;
            text-decoration: none;
        }

        td.rejec a:hover {
            color: darkred;
        }

        td.status {
            text-transform: capitalize;
        }

        td.table-space {
            width: 30%;
        }

        @media (max-width: 992px) {
            img {
                width: 40%;
            }
        }

        .noCase {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    include '../../connect.php';
    ?>

    <script>
        function callAppointment(status, petId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    let text = "";

                    for (let x in myObj) {

                        date = myObj[x]["date"];
                        appointment_id = myObj[x]["appointment_id"];
                        fname = myObj[x]["fname"];
                        time = myObj[x]["time"];
                        name = myObj[x]["name"];
                        appointment_type_name = myObj[x]["appointment_type_name"];
                        status = myObj[x]["status"];
                        owner_id = myObj[x]["owner_id"];

                        if (appointment_type_name == 'Vaccination') {
                            console.log("Meow");
                            var xhr2 = new XMLHttpRequest();
                            xhr2.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    console.log(xhr2.responseText);
                                    console.log("Meow2");
                                    var vaccine_name = xhr2.responseText;

                                    detail = " — " + vaccine_name;
                                }
                            }
                            xhr2.open("GET", "vaccine_name.php?appId=" + appointment_id, false);
                            xhr2.send();
                        } else {
                            detail = "";
                        }

                        if (status == 'finished') {
                            style = "style='color: green; font-weight: bold;'";
                            reject = "";
                        } else {
                            style = "";
                            reject = "<a href='postponement_app.php?appId=" + appointment_id + "'> เลื่อนนัด </a> /";
                            reject += "<a href='#' onclick='cancelApp(" + appointment_id + ")'> ยกเลิก </a>";
                        }

                        text += "<tr>";
                        text += "<td>" + date + "</td>";
                        text += "<td>" + time + "</td>";
                        text += "<td>" + name + "</td>";
                        text += "<td>" + appointment_type_name + detail + "</td>";
                        text += "<td class='status'" + style + ">" + status + "</td>";
                        text += "<td class='rejec'>";
                        text += reject;
                        text += "</td>";
                        text += "</tr>";
                    }

                    console.log(text);
                    document.getElementById('table_body').innerHTML = text;

                    if(document.getElementById('table_body').innerHTML == "") {
                        let noCase = "<tr><td colspan='6' class='noCase'><h3 style='margin: 20px 0 20px 0 ;'> There are no appointments. </h3></td></tr>";
                        document.getElementById('table_body').innerHTML = noCase;
                    }
                }
            }
            xhr.open("GET", "appointment_table.php?status=" + status + "&petId=" + petId, true);
            xhr.send();
        }



        document.addEventListener('DOMContentLoaded', function() {
            var statusSelect = document.getElementById('status');
            var petSelect = document.getElementById('pet');

            statusSelect.addEventListener("change", function() {
                var petId = petSelect.value;
                var status = statusSelect.value;
                callAppointment(status, petId);
            });

            petSelect.addEventListener("change", function() {
                var petId = petSelect.value;
                var status = statusSelect.value;
                callAppointment(status, petId);
            });
        });
    </script>

    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="../">
                <img src="../images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="../"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav">
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="../choose.php"> Appointment </a>
                    </li>
                    <li class="nav-item mt-2" style="margin-right: 5px;">
                        <a class="nav-link" href="../about_us.php"> About us </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class='nav-link' class="dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa-regular fa-circle-user" style="font-size: 40px;"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text"> <?php echo $_SESSION["fname_owner"] . " " . $_SESSION["lname_owner"]; ?> </span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href=""><i class="fa-solid fa-user"></i> &nbsp; PROFILE </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-power-off"></i> &nbsp; LOGOUT </a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>

    <div class="mt-4 container">
        <div class="mb-3 card rounded-4">
            <div class="card-header">
                <h4><i class="fa-solid fa-user"></i>&nbsp; User information </h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="fname"> First name : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="fname" name="fname" readonly value="<?php echo $_SESSION["fname_owner"]; ?>" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="lname"> Last name : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="lname" name="lname" readonly value="<?php echo $_SESSION["lname_owner"]; ?>" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="tel"> Phone number : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="tel" name="tel" readonly value="<?php echo $_SESSION["phone_owner"]; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-4 info">
                        <label for="email"> Email : </label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-8">
                        <input type="text" class="form-control" id="email" name="email" readonly value="<?php echo $_SESSION["email_owner"]; ?>" />
                    </div>
                </div>
                <div class="mt-3 row justify-content-end">
                    <div class="col- col-sm-4 col-xl-1">
                        <a class="text-in-button" href="edit_owner.php">
                            <button type="button" class="mb-4 btn btn-success btn-sm submitbtn" style="width: 100%;margin: 0 !important;">
                                Edit
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php

        $sql = "SELECT * FROM pet p INNER JOIN pet_type t ON p.type = t.type_id WHERE owner_id='$ownerId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                include 'pet_info.php';
            }
        }
        ?>
        <div class="mt-4 mb-4 row justify-content-start">
            <div class="col- col-sm-4 col-xl-2">
                <a class="text-in-button" href="add_pet.php">
                    <button class="mb-4 btn btn-success submitbtn bg-indigo" style="width: 100%;margin: 0 !important;">
                        <b> + Add pet </b>
                    </button>
                </a>
            </div>
        </div>

        <h3 id="appointment"><b> Appointment table </b></h3>
        <form method="get" action="">
            <div class="table-responsive-md">
                <table class="mt-3 table box">
                    <tr>
                        <td class="table-label" style="border-radius: 15px 0 0 15px !important;">
                            <label for="table"> Pet </label>
                        </td>
                        <td class="table-input">
                            <select class="form-select" id="pet" name="pet">
                                <option value='all'> All </option>
                                <?php
                                $sql = "SELECT * FROM pet WHERE owner_id = '" . $ownerId . "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["pet_id"] . "'>" . $row["name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td class="table-label">
                            <label for="status"> Status </label>
                        </td>
                        <td class="table-input">
                            <select class="form-select" id="status" name="status">
                                <option value="all"> All </option>
                                <option value="finished"> Finished </option>
                                <option value="in process"> In process </option>
                                <?php
                                $firstStatus = 0;

                                if ($firstStatus == 0) {
                                    $firstStatus = "all";
                                }

                                if ($firstStatus != 0) {
                                    if ($firstStatus == "all") {
                                        echo "<script>callAppointment('" . $firstStatus . "', '" . $firstStatus . "')</script>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td class="table-space" style="border-radius: 0 15px 15px 0 !important;">
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table appointment table-bordered">
                <thead>
                    <tr>
                        <th class="table-date">Date/Month/Year</th>
                        <th class="table-time">Time</th>
                        <th class="table-pet">Pet</th>
                        <th class="table-type">Appointment Type</th>
                        <th class="table-status">Status</th>
                        <th class="table-rej">Rejection</th>
                    </tr>
                </thead>
                <tbody id="table_body">

                </tbody>
            </table>
        </div>
    </div>
    <script>
        function cancelApp(id) {
            let confirmAction = confirm("Do you want to cancel?");
            if (confirmAction) {
                window.location.assign("cancel.php?appId=" + id);
            }
        }
    </script>
    <?php
        $conn->close();
    ?>
</body>

</html>
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

    <!-- CSS -->
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
            width: 70px;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
        }

        td {
            vertical-align: middle;
        }

        td.edit {
            text-align: center;
        }

        i.edit:hover {
            color: #b70000 !important;
        }
    </style>

</head>

<body>
    <?php
    include "../../../connect.php";

    $editId = "";
    if (isset($_GET["editId"])) {
        $editId = $_GET["editId"];
    }
    ?>

    <script>
        function callVaccineInfo(vacType) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    let text = "";

                    for (let x in myObj) {

                        vaccineId = myObj[x]["vaccine_id"];
                        vaccineName = myObj[x]["vaccine_name"];
                        vaccinePrice = myObj[x]["vaccine_price"];
                        status = myObj[x]["status"];
                        type = myObj[x]["type"];
                        typeName = myObj[x]["type_name"];

                        if (status == 'unavailable') {
                            styleStatus = 'color: red;'
                        } else {
                            styleStatus = 'color: limegreen;'
                        }

                        if (vaccineId == '<?php echo $editId; ?>') {
                            text += "<tr><form method=\"post\" action=\"vaccine_edit.php\" id=\"form_update\">";
                            text += "<input type=\"hidden\" class=\"form-control\" name=\"vaccine_id\" id=\"vaccine_id\" value=\"" + vaccineId + "\" form=\"form_update\">";
                            text += "<td>" + vaccineId;
                            text += "</td><td><input type=\"text\" class=\"form-control\" required name=\"vaccine_name\" id=\"vaccine_name\" value=\"" + vaccineName + "\" form=\"form_update\">";
                            text += "</td><td><select id=\"type_id\" name=\"type_id\" class=\"form-select\" form=\"form_update\">";
                            selectedCat = "";
                            selectedDog = "";
                            if (type == "1") {
                                selectedCat = "selected";
                            } else {
                                selectedDog = "selected";
                            }
                            text += "<option value=\"1\"" + selectedCat + "> Cat </option>";
                            text += "<option value=\"2\"" + selectedDog + "> Dog </option>";
                            text += "</select>";
                            text += "</td><td><input type=\"number\" class=\"form-control\" required name=\"vaccine_price\" id=\"vaccine_price\" value=\"" + vaccinePrice + "\" form=\"form_update\">";
                            text += "</td><td><select id=\"status\" name=\"status\" class=\"form-select\" form=\"form_update\">";
                            selectedAvailable = "";
                            selectedUnavailable = "";
                            if (status == "available") {
                                selectedAvailable = "selected";
                            } else {
                                selectedUnavailable = "selected";
                            }
                            text += "<option value=\"available\"" + selectedAvailable + "> Available </option>";
                            text += "<option value=\"unavailable\"" + selectedUnavailable + "> Unavailable </option>";
                            text += "</select>";
                            text += "</td><td><button type=\"submit\" class=\"btn btn-dark\" form=\"form_update\"> Update </button></td>";
                            text += "</form></tr>";

                            console.log(text);
                        } else {
                            text += "<tr>";
                            text += "<td>" + vaccineId + "</td>";
                            text += "<td>" + vaccineName + "</td>";
                            text += "<td style='text-transform: capitalize;'>" + typeName + "</td>";
                            text += "<td>" + vaccinePrice + "฿</td>";
                            text += "<td style='text-transform: capitalize;font-weight: bold;" + styleStatus + "'>" + status + "</td>";
                            text += "<td class='edit'>";
                            text += "<a href='vaccine.php?editId=" + vaccineId + "'>";
                            text += "<i class='fa-solid fa-pen-to-square edit' style='color: #000;'></i>";
                            text += "</a>";
                            text += "</td>";
                            text += "</tr>";
                        }


                    }

                    document.getElementById('table_body').innerHTML = text;
                }
            }
            xhr.open("GET", "vaccine_table.php?vacType=" + vacType, true);
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var vacSelect = document.getElementById('select-type-vac');

            vacSelect.addEventListener("change", function() {
                var vacType = vacSelect.value;
                callVaccineInfo(vacType);
            });

            var vacType = vacSelect.value;
            callVaccineInfo(vacType);
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
        <h1 class="mb-4 display-4"> Vaccine </h1>

        <div class="row">
            <div class="col-2 col-xl-1 d-grid justify-content-center">
                <label for="select-type-vac" class="mb-1 form-label">
                    <h5 style="padding-top: 6px;"><b> Type </b></h5>
                </label>
            </div>

            <div class="col-10 col-xl-5">
                <select name="select-type-vac" id="select-type-vac" class="mb-4 form-select">
                    <option value="all"> All </option>
                    <option value="dog"> Dog </option>
                    <option value="cat"> Cat </option>
                    <?php
                    $firstVac = 0;

                    if ($firstVac == 0) {
                        $firstVac = "all";
                    }

                    if ($firstVac != 0) {
                        if ($firstVac == "all") {
                            echo "<script>callVaccineInfo('" . $firstVac . "')</script>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col- col-sm-4 col-xl-3">
                <a href="vaccine_add.php">
                    <button type="button" class="mb-4 btn btn-success submitbtn bg-indigo" style="width: 100%;margin: 0 !important;">
                        <b> + Add vaccine </b>
                    </button>
                </a>
            </div>
        </div>

        <table class="mt-4 table table-bordered">
            <thead class="bg-indigo">
                <tr>
                    <th class="id_vacc">ID of vaccine</th>
                    <th class="name_vacc">Name of vaccine</th>
                    <th class="type_vacc">Type</th>
                    <th class="price_vacc">Price</th>
                    <th class="status">Status</th>
                    <th class="edit"></th>
                </tr>
            </thead>
            <tbody id="table_body">

            </tbody>
        </table>

    </div>
    <script>
        function deleteVac(id) {
            let confirmAction = confirm("Do you want to delete?");
            if (confirmAction) {
                window.location.assign("delete_vac.php?vaccine_id=" + id);
            }
        }
    </script>
    <?php
        $conn->close();
    ?>
</body>

</html>
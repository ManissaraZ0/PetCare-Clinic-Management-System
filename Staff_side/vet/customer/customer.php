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

        th.details {
            width: 100px;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
        }

        td {
            vertical-align: middle;
            text-transform: capitalize;
        }

        th.id_owner,
        th.id_pet,
        th.type_pet {
            width: 110px;
        }
    </style>

</head>

<body>
    <?php
    include "../../../connect.php";
    ?>

    <script>
        function callOwnerInfo() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    let thead = "<tr>";
                    thead += "<th class='id_owner'> ID of owner </th>" ;
                    thead += "<th class='name_owner'> Name of owner </th>";
                    thead += "<th class='phone'> Phone </th>";
                    thead += "<th class='details'> Details </th>";
                    thead += "</tr>";

                    document.getElementById('table_head').innerHTML = thead;

                    let text = "";

                    for (let x in myObj) {

                        ownerId = myObj[x]["owner_id"];
                        fullName = myObj[x]["fname"] + " " + myObj[x]["lname"];
                        phone = myObj[x]["phone"];

                        text += "<tr>";
                        text += "<td>" + ownerId + "</td>";
                        text += "<td>" + fullName + "</td>";
                        text += "<td>" + phone + "</td>";
                        text += "<td class='edit'>";
                        text += "<a href='customer_info.php?ownerId=" + ownerId + "'>";
                        text += "<button type='button' class='btn btn-secondary btn-sm btn-block'>";
                        text += "See more";
                        text += "</button>";
                        text += "</a>";
                        text += "</td>";
                        text += "</tr>";
                    }

                    document.getElementById('table_body').innerHTML = text;
                }
            }
            xhr.open("GET", "owner_table.php", true);
            xhr.send();
        }

        function callPetInfo() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    myObj = JSON.parse(this.responseText);

                    let thead = "<tr>";
                    thead += "<th class='id_pet'> ID of pet </th>";
                    thead += "<th class='name_pet'> Name of pet </th>";
                    thead += "<th class='id_owner'> ID of owner </th>" ;
                    thead += "<th class='type_pet'> Type of pet </th>";
                    thead += "<th class='details'> Details </th>";
                    thead += "</tr>";

                    document.getElementById('table_head').innerHTML = thead;

                    let text = "";

                    for (let x in myObj) {

                        ownerId = myObj[x]["owner_id"];
                        petId = myObj[x]["pet_id"];
                        name = myObj[x]["name"];
                        TypeName = myObj[x]["type_name"];

                        text += "<tr>";
                        text += "<td>" + petId + "</td>";
                        text += "<td>" + name + "</td>";
                        text += "<td>" + ownerId + "</td>";
                        text += "<td>" + TypeName + "</td>";
                        text += "<td class='edit'>";
                        text += "<a href='customer_info.php?ownerId=" + ownerId + "'>";
                        text += "<button type='button' class='btn btn-secondary btn-sm btn-block'>";
                        text += "See more";
                        text += "</button>";
                        text += "</a>";
                        text += "</td>";
                        text += "</tr>";
                    }

                    document.getElementById('table_body').innerHTML = text;
                }
            }
            xhr.open("GET", "pet_table.php", true);
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var cusSelect = document.getElementById('select-cus');

            cusSelect.addEventListener("change", function() {
                var cusType = cusSelect.value;
                if (cusType == 'owner') {
                    callOwnerInfo();
                } else {
                    callPetInfo();
                }
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
                        <a class="nav-link" href="../appointment/appointment.php"> Appointment </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="customer.php"> Customer </a>
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
        <h1 class="mb-4 display-4"> Customer table </h1>

        <div class="row">
            <div class="col- col-xl-6">
                <form>
                    <div class="form-group">
                        <select name="select-cus" id="select-cus" class="mb-4 form-select">
                            <option value="owner"> Owner </option>
                            <option value="pet"> Pet </option>
                            <?php
                                $firstCus = 0;
                                
                                if ($firstCus == 0) {
                                    $firstCus = "owner";
                                }
                                    
                                if ($firstCus != 0) {
                                    if ($firstCus == "owner") {
                                        echo "<script>callOwnerInfo()</script>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </form>

                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input class="form-control me-2" type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names.." title="Type in a name">
                </div>
            </div>
        </div>

        <table class="mt-4 table table-bordered" id="myTable">
            <thead class="bg-indigo" id="table_head">
            </thead>
            <tbody id="table_body">
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
                td = tr[i].getElementsByTagName("td")[1];
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
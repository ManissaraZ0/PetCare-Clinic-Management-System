<?php
session_start();

if (!isset($_SESSION["staff_id"])) {
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

    <script>
        function deleteNews(id) {
            let confirmAction = confirm("Do you want to delete news ?");
            if (confirmAction) {
                window.location.assign("news_delete.php?newsId=" + id);
            }
        }
    </script>

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

        a {
            color: #FFFFFF;
            text-decoration: none;
        }

        button.submitbtn {
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .bg-lb {
            background-color: #3F72AF;
            color: #FFFFFF;
        }

        .bg-lb:hover {
            background-color: #20487a;
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

        td.edit {
            text-align: center;
        }

        i.edit:hover {
            color: #3F72AF !important;
        }

        .delete-news {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <?php
    include '../../../connect.php';

    $staffId = $_SESSION["staff_id"];
    ?>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="../status/status.php">
                <img src="../../images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="../status/status.php"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="news.php"> News </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../status/status.php"> Status </a>
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
        <a href="news_post.php"><button type="button" class="mt-2 mb-5 btn bg-lb btn-lg submitbtn"> + New post </button></a>
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input class="form-control me-2" type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for news headline names.." title="Type in a name">
        </div>
        <table class="mt-4 table" id="myTable">
            <thead class="bg-indigo">
                <tr>
                    <th class="news_id" style="width: 5%;"> ID </th>
                    <th class="news" style="width: 55%;"> News headlines </th>
                    <th class="date" style="width: 20%;"> Date of production </th>
                    <th class="status" style="width: 10%;"> Status </th>
                    <th class="edit" style="width: 2%;"></th>
                    <th class="edit" style="width: 2%;"></th>
                    <th class="edit" style="width: 2%;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM news ORDER BY create_date DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $news_id = $row["news_id"];
                        $news_name = $row["news_name"];
                        $status = $row["status"];
                        $create_date = $row["create_date"];

                        $style = "style='color: limegreen;font-weight: bold;'";
                        $icon_status = "<i class='fa-solid fa-eye edit' style='color: #000;'></i>";

                        if ($status == 'inactive') {
                            $style = "style='color: red;font-weight: bold;'";
                            $icon_status = "<i class='fa-solid fa-eye-slash edit' style='color: #000;'></i>";
                        }

                        include 'news_table.php';
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
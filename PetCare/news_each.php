<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Care </title>
    <!-- <link rel="stylesheet" href="./user_page.css"> -->

    <!-- Icon -->
    <link rel="icon" href="./images/logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="./user_style.css" />
    <link rel="stylesheet" href="../css/font.css" />
    <link rel="stylesheet" href="../css/ckeditor.css" />

    <style>
        h1.display-4 {
            font-weight: bold !important;
            text-align: center;
        }

        button.submitbtn {
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .text-in-button {
            color: #FFFFFF !important;
            text-decoration: none !important;
        }

        a.text-news {
            color: #000000 !important;
            text-decoration: none !important;
        }

        a.text-news:hover {
            color: #323d6c !important;
        }

        a.text-white {
            text-decoration: none;
        }

        p.text-height {
            line-height: 2.5;
        }

        footer {
            background-color: #112D4E;
            color: #FFFFFF;
            padding-top: 20px;
            padding-bottom: 10px;
            margin-bottom: 0 !important;
            text-align: center;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">
                <img src="./images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="./"> Pet Care </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
                <ul class="navbar-nav bg-indigo">
                    <li class="nav-item mt-2">
                        <a class="nav-link" href="choose.php"> Appointment </a>
                    </li>
                    <li class="nav-item mt-2" style="margin-right: 5px;">
                        <a class="nav-link" href="about_us.php"> About us </a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (!isset($_SESSION["owner_id"])) {
                            echo "<a class='nav-link' href='login.php'>
                                                <button type='button' class='btn btn-block btn-lb' name='loginbtn' value='done'> Log in </button>
                                            </a>";
                        } else {
                            include 'nav_profile.php';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="add-space-nav"></div>

    <div class="mt-5 container">
        <?php
        include '../connect.php';


        $newsId = $_GET["newsId"];

        $sql = "SELECT * FROM news WHERE news_id='$newsId'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $news_id = $row["news_id"];
                $news_name = $row["news_name"];
                $path = $row["path"];
                $news_content = $row["news_content"];
                $news_content = str_replace("../../../", "../", $news_content);
            }
        }
        ?>
        <h1 class="mb-3 display-4"><?php echo $news_name; ?></h1>
        <div class="mt-4 mb-5 d-flex justify-content-center">
            <div class="row">
                <div class="col-">
                    <div class="ck-content">
                        <?php echo $news_content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--credits-->
    <footer>
        <a href="#"><img src="./images/facebook-icon.png" width="30px" height="30px" /></a>
        <a href="#"><img src="./images/Instagram-icon.png" width="30px" height="30px" /></a>
        <p class="mt-3"> 088-888-8888 </p>
        <p> &copy; 2023 Pet Care</p>
        <p>Developed by <a href="#" class="text-white">จะเครซี่</a></p>
    </footer>
    <?php
        $conn->close();
    ?>
    </body>
</html>
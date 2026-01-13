<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Pet Care </title>

        <!-- Icon -->
        <link rel="icon" href="./images/logo.png" type="image/png" sizes="16x16">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Emoji -->
        <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="./user_style.css" />
        <link rel="stylesheet" href="../css/font.css" />

        <style>
            h1.display-6 {
                font-weight: bold !important;
            }

            h1.center {
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
            .dropdown-menu .dropdown-item:hover {
                background-color: gainsboro;
            }

            a div.box {
                color: #0d2035;
                text-align: center;
            }

            a.box {
               text-decoration: none !important;
            }

            a div.box:hover {
                color: #3F72AF;
            }

        </style>

    </head>

    <body>
        <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
            <div class="container-fluid">
                <a class="navbar-brand" href="">
                    <img src="./images/logo.png" alt="Avatar Logo" style="width:40px;" />
                </a>
                <a class="navbar-brand" href=""> Pet Care </a>
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

        <!-- Carousel -->
        <div id="demo" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        </div>
            
        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./images/carousel/1.png" alt="Los Angeles" class="d-block" style="width:100%">
            </div>
            <div class="carousel-item">
                <img src="./images/carousel/2.png" alt="Chicago" class="d-block" style="width:100%">
            </div>
            </div>
            
            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <div class="mt-5 container">
            <div class="row">
                <div class="col-xl-4 col-">
                    <div class="mb-3 card rounded-4 bg-indigo">
                        <div class="card-body" style="padding: 10px;">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-6 col-6" style="padding-right: 6px;">
                                    <a href="choose.php" class="box">
                                        <div class="card rounded-3 bg-white box">
                                            <div class="card-body">
                                                <i class="mb-3 fa-regular fa-calendar-check fa-4x"></i>
                                                <h4 class="mb-0 box"> Appointments </h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-6 col-6" style="padding-left: 6px;">
                                    <a href="about_us.php#contact" class="box">
                                        <div class="card rounded-3 bg-white box">
                                            <div class="card-body">
                                                <i class="mb-3 fa-solid fa-comments fa-4x"></i>
                                                <h4 class="mb-0 box"> Contact Me </h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-">
                    <h1 class="display-6"> Welcome to pet care </h1>
                    <p class="text-height"> 
                        บริการสำหรับนัดหมายตรวจสุขภาพและการรับวัคซีนสำหรับแมวและสุนัขล่วงหน้า
                        บริการด้วยเทคโนโลยีที่ทันสมัย ถูกหลักอนามัยและจริยธรรม 
                        นอกจากการให้บริการทางการแพทย์แก่สัตว์เรายังมุ่งมั่นที่จะสร้างสังคมที่ดีและปกป้องสิ่งแวดล้อมของเรา 
                        โดยเรามุ่งเสริมสร้างความตระหนักรู้ให้กับเจ้าของสัตว์เกี่ยวกับสิ่งแวดล้อมและวิธีการดูแลสัตว์อย่างเหมาะสม
                    </p>
                </div>
            </div>

            <!-- News -->
            <hr />
            <h1 class="mb-4 display-6 center"> News </h1>
            <div class="row">
                <?php
                    include '../connect.php';

                    $sql = "SELECT * FROM news WHERE status='active' ORDER BY create_date DESC LIMIT 4";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            include 'news_pattern.php';
                        }
                    }
                ?>
            </div>
            <button class="mb-4 btn btn-secondary btn-sm submitbtn"><a class="text-in-button" href="news.php"> See More </a></button>
        </div>
        
        <!--credits-->
        <footer>
            <a href="#"><img src="./images/facebook-icon.png" width="30px" height="30px"/></a>
            <a href="#"><img src="./images/Instagram-icon.png" width="30px" height="30px"/></a>
            <p class="mt-3"> 088-888-8888 </p>
            <p> &copy; 2023 Pet Care</p>
            <p>Developed by <a href="#" class="text-white">จะเครซี่</a></p>
        </footer>
        <?php
            $conn->close();
        ?>
    </body>
</html>
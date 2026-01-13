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
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous">
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

        <!-- Emoji -->
        <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="./user_style.css" />
        <link rel="stylesheet" href="../css/font.css" />

        <style>
            h1.display-4 {
                font-weight: bold !important;
                text-align: center;
            }

            a.text-white {
                text-decoration: none;
            }

            footer { 
                background-color: #112D4E;
                color: #FFFFFF; 
                padding-top: 20px;
                padding-bottom: 10px;
                margin-bottom: 0 !important;
                text-align: center; 
            }

            p.text-height {
                line-height: 2.5;
            }

            h1.heading {
                font-weight: bold !important;
                font-size: 30px;
                background-color: #112D4E;
                color: #FFFFFF;
                padding: 10px;
                padding-left: 20px;
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
        </style>
    </head>

    <body>
        <nav
            class="navbar navbar-expand-sm navbar-dark fixed-top bg-indigo navbar-size">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">
                    <img src="./images/logo.png" alt="Avatar Logo"
                        style="width:40px;" />
                </a>
                <a class="navbar-brand" href="./"> Pet Care </a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end"
                    id="mynavbar">
                    <ul class="navbar-nav bg-indigo">
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="choose.php"> Appointment </a>
                        </li>
                        <li class="nav-item mt-2" style="margin-right: 5px;">
                            <a class="nav-link active" href="about_us.php">
                                About us </a>
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

        <div class="mt-4 container">
            <h1 class="mb-4 display-4"> About us </h1>
            <div class="row">
                <div class="col- col-xl-7">
                    <h1 class="heading rounded"> ประวัติคลินิก </h1>
                    <p class="mt-4 text-height" style="text-indent: 4em;">
                        คลินิก Pet Care เปิดตัวเป็นครั้งแรกในปี พ.ศ. 2566 โดยดร.สมหญิง น้ำใจงาม
                        พวกเราได้รับความไว้วางใจจากเจ้าของสัตว์เลี้ยง
                        ทั้งในเขตกรุงเทพและปริมณฑล โดยมีเครือข่ายของลูกค้าที่เชื่อถือมากมาย
                        นอกจากการให้บริการสุขภาพสัตว์แล้ว เรายังมุ่งมั่นที่จะเป็นส่วนหนึ่งของชุมชน 
                        โดยการจัดกิจกรรมและโครงการเพื่อช่วยเหลือสัตว์ที่เดือดร้อน
                        เรายินดีที่ได้รับความไว้วางใจและความเชื่อมั่นจากลูกค้าทุกท่าน
                        และยังมุ่งมั่นที่จะพัฒนาและปรับปรุงบริการเพื่อให้คุณได้รับการดูแลสุขภาพสัตว์ที่ดีที่สุด
                    </p>
                </div>
                <div class="col- col-xl-5">
                    <!-- Carousel -->
                    <div id="demo" class="carousel slide"
                        data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo"
                                data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo"
                                data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo"
                                data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#demo"
                                data-bs-slide-to="3"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="./images/carousel_about_us/1.png"
                                    alt="Los Angeles" class="d-block"
                                    style="width:100%">
                            </div>
                            <div class="carousel-item">
                                <img src="./images/carousel_about_us/2.png"
                                    alt="Chicago" class="d-block"
                                    style="width:100%">
                            </div>
                            <div class="carousel-item">
                                <img src="./images/carousel_about_us/3.png"
                                    alt="Chicago" class="d-block"
                                    style="width:100%">
                            </div>
                            <div class="carousel-item">
                                <img src="./images/carousel_about_us/4.png"
                                    alt="Chicago" class="d-block"
                                    style="width:100%">
                            </div>
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-">
                    <h1 class="mt-3 mb-4 heading rounded">
                        ข้อมูลคุณหมอ 
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col- col-xl-2">
                    <img src="./images/doctor.png" class="rounded-circle" width="166px" alt="ดร. สมหญิง มณีสร"/>
                </div>
                <div class="col- col-xl-10">
                    <p class="text-height">
                        <b>ชื่อ: </b>สัตวแพทย์หญิง สมหญิง น้ำใจงาม <br />
                        <b>ชื่อเล่น: </b>คุณหมอเจน <br />
                        <b>ประวัติการศึกษา: </b>สำเร็จการศึกษาปริญญาบัณฑิตด้านสัตวแพทยศาสตร์จากมหาวิทยาลัยบราวน์ <br />
                        <b>ประสบการณ์: </b>ได้รับการฝึกฝนและประสบการณ์จากการทำงานในคลินิกสัตวแพทย์ชั้นนำทั่วไปและพิเศษ
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-">
                    <h1 class="mt-3 heading rounded" id="contact"> 
                        ช่องทางการติดต่อ
                    </h1>
                </div>
            </div>
                
            <div class="row">
                <div class="col-">
                    <p class="text-height">
                        <b>ที่อยู่: </b>123 ถนนเพชรบุรี แขวงทุ่งมหาเมฆ เขตสะพานสูง กรุงเทพมหานคร 10140<br />
                        <b>โทรศัพท์: </b>02-987-6543 <br />
                        <b>อีเมล์: </b>www.petcare.com <br />
                        สำหรับคำถามหรือการนัดหมายกรุณาติดต่อเราทางโทรศัพท์หรืออีเมล์ หรือเข้าชมเว็บไซต์ของเราเพื่อข้อมูลเพิ่มเติม
                    </p>
                </div>
            </div>

        </div>

        <!--credits-->
        <footer>
            <a href="#"><img src="./images/facebook-icon.png" width="30px"
                    height="30px" /></a>
            <a href="#"><img src="./images/Instagram-icon.png" width="30px"
                    height="30px" /></a>
            <p class="mt-3"> &copy; 2023 Pet Care</p>
            <p>Developed by <a href="#" class="text-white">จะเครซี่</a></p>
        </footer>
    </body>
</html>
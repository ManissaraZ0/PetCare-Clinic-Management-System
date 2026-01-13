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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Emoji -->
    <script src="https://kit.fontawesome.com/465b5bf914.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../../../css/font.css" />

    <!-- CK editor -->
    <script src="../../js/build/ckeditor.js"></script>

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

        button.submitbtn {
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .bg-indigo {
            background-color: #112D4E !important;
            color: #FFFFFF !important;
        }

        .navbar-size {
            height: 72px !important;
        }

        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>

</head>

<body>
    <?php
    include '../../../connect.php';
    function phpAlert($msg)
    {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["uploadfile"]["name"])) {

        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $date = new DateTime(); //this returns the current date time
        $result = $date->format('Ymd_His');
        $pathImage = $result . "_" . $filename;
        $folder = "../../../image-upload/news/" . $pathImage;
        $fullPath = "image-upload/news/" . $pathImage;

        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($tempname, $folder)) {
            phpAlert("Image uploaded successfully!");
        } else {
            phpAlert("Failed to upload image!");
        }

        $news_name = $_POST["news_name"];
        $news_detail = $_POST["news_detail"];
        $path = $_POST["path"];
        $news_content = $_POST["news_content"];
        $create_by = $_POST["create_by"];

        date_default_timezone_set("Asia/Bangkok");
        $create_date = date("Y-m-d h:i:s");
        $status = 'active';

        $sql = "INSERT INTO `news` (`news_name`, `news_detail`, `path`, `status`, `create_date`, `create_by`, `news_content`) 
            VALUES ('$news_name', '$news_detail', '$fullPath', '$status', '$create_date', '$create_by', '$news_content');";
        $result = $conn->query($sql);

        header("Location: news.php");
    }
    ?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top bg-indigo navbar-size">
        <div class="container-fluid">
            <a class="navbar-brand" href="news.php">
                <img src="../../images/logo.png" alt="Avatar Logo" style="width:40px;" />
            </a>
            <a class="navbar-brand" href="news.php"> Pet Care </a>
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="create_by" name="create_by" value="<?php echo $staffId; ?>" />

            <label for="news_name" class="form-label">
                <h4> News headlines </h4>
            </label>
            <input type="text" class="form-control mb-3" id="news_name" name="news_name" required />

            <label for="path" class="form-label">
                <h4> Image headlines </h4>
            </label>
            <input type="file" class="form-control mb-3" id="path" name="uploadfile" required />

            <label for="news_detail" class="form-label">
                <h4> Details </h4>
            </label>
            <textarea class="form-control mb-3" rows="5" id="news_detail" name="news_detail" required></textarea>

            <label for="news_content" class="form-label">
                <h4> News content </h4>
            </label>
            <textarea name="news_content" class="form-control" id="news_content"></textarea>

            <!-- Script -->
            <script type="text/javascript">
                ClassicEditor
                    .create(document.querySelector('#news_content'), {
                        ckfinder: {
                            uploadUrl: './fileupload.php'
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>

            <button type="submit" class="mt-4 mb-4 btn btn-success btn-lg submitbtn"> Post </button>
        </form>
    </div>
    <?php
        $conn->close();
    ?>
</body>

</html>
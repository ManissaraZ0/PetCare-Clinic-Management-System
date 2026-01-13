<div class="col-md-6 col-lg-6 col-xl-3 justify-content-center d-flex">
    <a href="news_each.php?newsId=<?php echo $row["news_id"]; ?>" class="text-news">
        <div style="text-align: center;">
            <img src="../<?php echo $row["path"]; ?>" alt="<?php echo $row["news_id"]; ?>" class="rounded" width="265" />
        </div>
        <h6 class="mt-3"><b><?php echo $row["news_name"]; ?></b></h6>
        <p><?php echo $row["news_detail"]; ?></p>
    </a>
</div>
<tr>
    <td> <?php echo $news_id; ?> </td>
    <td> <?php echo $news_name; ?> </td>
    <td> <?php echo $create_date; ?> </td>
    <td <?php echo $style; ?>> <?php echo ucfirst($status); ?> </td>
    <td class="edit">
        <a href="news_edit.php?newsId=<?php echo $news_id; ?>">
            <i class='fa-solid fa-pen-to-square edit' style='color: #000;'></i>
        </a>
    </td>
    <td class="edit">
        <a href="news_status.php?newsId=<?php echo $news_id; ?>">
            <?php echo $icon_status; ?>
        </a>
    </td>
    <td class="edit">
        <span class="table delete-news" onclick="deleteNews(<?php echo $news_id; ?>)">
            <i class='fa-solid fa-trash-can edit' style='color: #000;'></i>
        </span>
    </td>
</tr>
<div class="dropdown">
    <a class='nav-link' class="dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fa-regular fa-circle-user" style="font-size: 40px;"></i>
    </a>
    <ul class="dropdown-menu">
        <li><span class="dropdown-item-text"> <?php echo $_SESSION["fname_owner"] . " " . $_SESSION["lname_owner"]; ?> </span></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="profile/"><i class="fa-solid fa-user"></i> &nbsp; PROFILE </a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-power-off"></i> &nbsp; LOGOUT </a></li>
    </ul>
</div>
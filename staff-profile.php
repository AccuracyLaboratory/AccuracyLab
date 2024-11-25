<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    header("location: staff-login");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/header.php"; ?>
</head>

<body>
    <div class="container-scroller">
        <?php include "partials/staff-heading.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "partials/staff-navbar.php"; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    
                </div>
                <?php include "partials/footer.php"; ?>
            </div>
        </div>
    </div>
    <?php include "partials/scripts.php"; ?>
</body>

</html>
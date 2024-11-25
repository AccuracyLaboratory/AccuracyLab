<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "contact";
} else {
    header("location: login");
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
        <?php include "partials/user-heading.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "partials/user-navbar.php"; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Contact Us</strong></h2>
                                    <p class="card-description">
                                        Get In Touch With Us
                                    </p>
                                    <p>
                                        Located at Poblacion III, San Jose Batangas
                                        <br><br>
                                        Call us: (043) 741 6463
                                    </p>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15493.365601921245!2d121.09697037025882!3d13.878523308169923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd1242516458cd%3A0x6f53f680f789447f!2sC.A.%20Aguila%2C%20San%20Jose%2C%20Batangas!5e0!3m2!1sen!2sph!4v1731937928910!5m2!1sen!2sph" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "partials/footer.php"; ?>
            </div>

        </div>
    </div>
    <?php include "partials/scripts.php"; ?>
</body>

</html>
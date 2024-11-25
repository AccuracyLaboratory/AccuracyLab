<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "about";
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
                                    <h2 class="card-title"><strong>About Us</strong></h2>
                                    <p class="card-description">
                                        Accuracy Laboratory Corporation
                                    </p>
                                    <p>
                                        Laboratory Clinic San Jose, Batangas, where we strive to exceed your expectations with comfort and top-notch services. Our clinic is dedicated to supporting healthcare professionals while ensuring your privacy and confidentiality.
                                        <br>
                                        <br>
                                        Our innovative system enhances the clinic's daily operations, ranging from patient appointments to inventory management and equipment monitoring, all through an intuitive, integrated dashboard. This system is crafted with efficiency and quality care at its core.
                                        <br>
                                        <br>
                                        Patients benefit from the convenience of scheduling or canceling appointments effortlessly, which reduces wait times and enhances their overall experience. Our automated inventory management feature provides real-time tracking of medical supplies, ensuring that the clinic is always equipped with the necessary resources. Furthermore, our equipment monitoring tools offer live updates on equipment status, usage, and maintenance needs, which help prevent downtime and guarantee optimal performance.
                                        <br>
                                        <br>
                                        With these advanced features, our system supports the clinic in providing timely, high-quality healthcare services while maximizing operational efficiency.
                                    </p>
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
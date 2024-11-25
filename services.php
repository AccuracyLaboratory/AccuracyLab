<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "services";
} else {
    header("location: login");
    exit;
}

if (isset($_GET['title'])) {
    $serviceTitle = htmlspecialchars($_GET['title']);
} else {
    $serviceTitle = 'Unknown Service';
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
                                    <h2 class="card-title"><strong><?php echo $serviceTitle; ?></strong></h2>
                                    <p class="card-description">
                                        Our <?php echo $serviceTitle; ?> service provides reliable diagnostics with advanced equipment and expert care.
                                    </p>
                                    <?php if ($serviceTitle == "X-RAY") {
                                        echo '<p>Our X-ray department is equipped with state-of-the-art imaging technology that delivers clear, detailed images, allowing for accurate assessments of bone, joint, and soft tissue health.
We offer a range of X-ray examinations, including standard X-rays for routine checks, and specialized imaging for more detailed evaluations of specific areas such as the chest, spine, and extremities. Our experienced radiologists and technicians ensure that each X-ray is conducted safely and efficiently.</p>';
                                    } elseif ($serviceTitle == "Laboratory") {
                                        echo '<p>At STANmeD Diagnostic and Medical Clinic in San Jose, Batangas, we offer a full range of laboratory services to support your health. Our modern lab is equipped with the latest technology and staffed by skilled professionals dedicated to providing accurate and timely results.
We offer routine blood tests to check your overall health, chemistry panels to assess key functions like metabolism and organ health, and microbiology tests to identify infections. In addition to urinalysis for diagnosing urinary and kidney conditions. We focus on delivering precise results quickly and ensuring a comfortable, confidential experience. </p>';
                                    } elseif ($serviceTitle == "2d Echo") {
                                        echo "<p>We also offer expert ECG (electrocardiogram) services to assess your heart’s health and rhythm. Our ECG services are designed to help diagnose and monitor various heart conditions, providing essential insights into your cardiovascular system.
Using advanced ECG technology, we capture detailed electrical activity of your heart to identify irregularities such as arrhythmias, heart attacks, and other heart-related issues. Our skilled technicians ensure that the ECG procedure is performed smoothly and comfortably, while our experienced cardiologists interpret the results to provide accurate diagnoses and recommendations.
</p>";
                                    } elseif ($serviceTitle == "Ultrasound") {
                                        echo '<p>We also have comprehensive 2D echocardiogram (2D ECHO) services to evaluate your heart’s structure and function. 
Our advanced 2D ECHO technology helps diagnose and monitor various heart conditions, including valve issues, heart disease, and congenital abnormalities. The procedure is quick and painless, performed by our skilled technicians who ensure your comfort throughout the process. Our experienced cardiologists analyze the images to provide accurate diagnoses and tailored treatment recommendations.</p>';
                                    } elseif ($serviceTitle == "ECG") {
                                        echo '<p>We also have advanced ultrasound services. Our ultrasound services include the presentation of abdominal, pelvic, obstetric, and musculoskeletal evaluations. Whether you’re checking for organ health, monitoring pregnancy, or assessing soft tissue injuries, our state-of-the-art equipment and skilled technicians ensure high-quality, accurate results.
The procedure is comfortable and quick, with minimal preparation required. Our experienced radiologists interpret the images to deliver clear, actionable insights for your healthcare provider.</p>';
                                    }
                                    ?>
                                </div>

                                <div class="card-footer text-end">
                                    <a href="user-appointment" class="btn btn-primary">Get an appointment</a>
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
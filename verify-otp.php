<?php
session_start();
require_once "connectDB.php";

$otp_err = "";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    echo "";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = trim($_POST["otp"]);

    if ($otp_input == $_SESSION['otp']) {
        header("location: reset-password");
    } else {
        $otp_err = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials/header.php"; ?>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="assets/img/logo.png" alt="logo">
                            </div>
                            <h4>OTP Code</h4>
                            <h6 class="fw-light">Enter the OTP sent to your email "<span class="text-muted"><?php echo $email; ?></span>"</h6>
                            <form class="pt-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="otp" class="form-control <?php echo (!empty($otp_err)) ? 'is-invalid' : ''; ?>" placeholder="OTP">
                                    <span class="invalid-feedback"><?php echo $otp_err; ?></span>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn mb-4">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "partials/scripts.php"; ?>
</body>
</html>

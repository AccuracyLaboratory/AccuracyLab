<?php
session_start();
require_once "connectDB.php";

$password = $confirm_password = "";
$password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($password)) {
        $password_err = "Please enter a new password.";
    } elseif (strlen($password) < 8) {
        $password_err = "Password must be at least 8 characters.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $password_err = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $password_err = "Password must contain at least one lowercase letter.";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $password_err = "Password must contain at least one number.";
    } elseif (!preg_match('/[\W_]/', $password)) {
        $password_err = "Password must contain at least one special character (e.g., @, #, $, etc.).";
    } elseif ($password != $confirm_password) {
        $confirm_password_err = "Passwords do not match.";
    } else {
        $email = $_SESSION['email'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
            if (mysqli_stmt_execute($stmt)) {
                session_destroy();
                echo "<script>swal({
                    title: 'Success!',
                    text: 'Password Reset Successfully!',
                    icon: 'success',
                    closeOnClickOutside: false,
                    button: false
                });</script>";
                echo '<meta http-equiv="Refresh" content="3; url=login">';
                exit;
            } else {
                echo "Something went wrong. Please try again.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
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
                            <h4>Reset Password</h4>
                            <h6 class="fw-light">Please enter new password and confirm your password.</h6>
                            <form class="pt-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> form-control-lg" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?> form-control-lg" id="confirm_password" name="confirm_password" placeholder="Repeat Password" value="<?php echo $confirm_password; ?>">
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" id="check">
                                            Show Password
                                        </label>
                                    </div>
                                </div>
                                <script>
                                    const passwordInput = document.getElementById("password");
                                    const confirmPasswordInput = document.getElementById("confirm_password");
                                    const showPasswordCheckbox = document.getElementById("check");

                                    showPasswordCheckbox.addEventListener("change", function() {
                                        if (showPasswordCheckbox.checked) {
                                            passwordInput.type = "text";
                                            confirmPasswordInput.type = "text";
                                        } else {
                                            passwordInput.type = "password";
                                            confirmPasswordInput.type = "password";
                                        }
                                    });
                                </script>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn mb-4">Reset Password</button>
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
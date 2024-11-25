<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $service = $row['staff_role'];
    $active = "appointmentlist";
} else {
    header("location: staff-login");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/header.php"; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container-scroller">
        <?php include "partials/staff-heading.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "partials/staff-navbar.php"; ?>

            <?php

            use phpmailer\phpmailer\PHPMailer;
            use phpmailer\phpmailer\Exception;

            require 'vendor/phpmailer/phpmailer/src/Exception.php';
            require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
            require 'vendor/phpmailer/phpmailer/src/SMTP.php';

            $status_err = "";
            if (isset($_POST["update"])) {
                $appointment_id = $_POST['appointment_id'];
                $user_email = $_POST['user_email'];
                $user_name = $_POST['username'];

                if (!isset($_POST["status"])) {
                    $status_err = "Please select a status.";
                } else {
                    $status = mysqli_real_escape_string($link, trim($_POST["status"]));
                }

                if (empty($status_err)) {
                    $sql1 = "UPDATE appointments SET status=? WHERE appointment_id=?";
                    $stmt = mysqli_prepare($link, $sql1);
                    mysqli_stmt_bind_param($stmt, 'ii', $status, $appointment_id);

                    if (mysqli_stmt_execute($stmt)) {
                        if ($status == 1) {
                            $sql2 = "UPDATE inventory SET quantity_used = quantity_used + 1 WHERE service = ?";
                            $stmt2 = mysqli_prepare($link, $sql2);
                            mysqli_stmt_bind_param($stmt2, 's', $service);

                            if (mysqli_stmt_execute($stmt2)) {
                                echo "<script>swal({
                        title: 'Success!',
                        text: 'Appointment and Inventory Updated Successfully!',
                        icon: 'success',
                        button: false,
                    });</script>";
                            } else {
                                echo "<script>swal({
                        title: 'Error!',
                        text: 'Appointment updated, but failed to update inventory!',
                        icon: 'error',
                        button: 'Ok!',
                    });</script>";
                            }
                        } else {
                            echo "<script>swal({
                    title: 'Success!',
                    text: 'Appointment Updated Successfully!',
                    icon: 'success',
                    button: false,
                });</script>";
                        }
            ?>
                        <meta http-equiv="Refresh" content="3; url=staff-appointment-list">
            <?php

                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'accuracylaboratoryclinic@gmail.com';
                            $mail->Password   = 'jgfd uaif wgpi dwuj';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;

                            $mail->setFrom('accuracylaboratoryclinic@gmail.com', 'Accuracy Laboratory Clinic');
                            $mail->addAddress($user_email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Appointment Confirmation';
                            $mail->Body    = "<p>Dear $user_name,</p><p>Your appointment has been successfully updated to <strong>Approved</strong> status.</p><p>Thank you for choosing Accuracy Laboratory Clinic!</p>";

                            $mail->send();
                            echo "<script>console.log('Email has been sent');</script>";
                        } catch (Exception $e) {
                            echo "<script>console.log('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                        }
                    } else {
                        echo "<script>swal({
                            title: 'Error!',
                            text: 'Unsuccessful!',
                            icon: 'error',
                            button: 'Ok!',
                        });</script>";
                    }
                }
            }
            ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Appointments</h4>
                            <p class="card-description">
                                <?php echo $service; ?> appointment list.
                            </p>
                            <div class="table-responsive">
                                <table id="appointmentTable" class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Appointment ID</th>
                                            <th>Patient Name</th>
                                            <th>Mobile Number</th>
                                            <th>Appointment Date</th>
                                            <?php if ($service == "Laboratory") {
                                                echo '<th>Type of Test</th>';
                                            } ?>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM appointments WHERE service='$service' ";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                                $user_id = $row1['user_id'];
                                                $sql3 = "SELECT * FROM users WHERE user_id = $user_id";
                                                $result3 = mysqli_query($link, $sql3);
                                                $row3 = mysqli_fetch_assoc($result3);
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['appointment_id']; ?></td>
                                                    <td><?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?></td>
                                                    <td><?php if ($row3['contact_number'] == "") {
                                                            echo 'N/A';
                                                        } else {
                                                            echo $row3['contact_number'];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php $formattedDate = date("l, F j Y - h:i A", strtotime($row1["datetime"]));
                                                        echo $formattedDate; ?>
                                                    </td>

                                                    <?php if ($service == "Laboratory") {
                                                        echo '<td>' . $row1['subservice'] . '</td>';
                                                    } ?>

                                                    <td>
                                                        <?php if ($row1['status'] == 0) {
                                                            echo '<label class="badge badge-warning">Pending</label>';
                                                        } elseif ($row1['status'] == 1) {
                                                            echo '<label class="badge badge-success">Approved</label>';
                                                        } elseif ($row1['status'] == 2) {
                                                            echo '<label class="badge badge-danger">Rejected</label>';
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row1['status'] == 0) {
                                                        ?>
                                                            <div class="d-inline">
                                                                <a class="ml-1 action-icon" href="#" data-toggle="modal"
                                                                    type="button" data-target="#manage-appointment-<?php echo $row1['appointment_id'] ?>">
                                                                    <i class="ti-pencil"></i> Manage
                                                                </a>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="d-inline">
                                                                <a class="ml-1 action-icon" href="#">
                                                                    <i class="ti-check"></i> Done
                                                                </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php

                                                include 'manage-appointment.php';
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "partials/footer.php"; ?>
            </div>
        </div>
    </div>
    <?php include "partials/scripts.php"; ?>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        #appointmentTable thead .sorting:before,
        #appointmentTable thead .sorting:after,
        #appointmentTable thead .sorting_asc:before,
        #appointmentTable thead .sorting_asc:after,
        #appointmentTable thead .sorting_desc:before,
        #appointmentTable thead .sorting_desc:after {
            display: none;
        }

        div.dataTables_length {
            display: flex;
            align-items: center;
        }

        div.dataTables_length label {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        div.dataTables_length select {
            margin-left: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#appointmentTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthMenu": [10, 25, 50],
                "pageLength": 10
            });
        });
    </script>
</body>

</html>
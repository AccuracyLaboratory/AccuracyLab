<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE user_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    $active = "home";
} else {
    header("location: login");
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
        <?php include "partials/user-heading.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "partials/user-navbar.php"; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Appointments</h4>
                            <p class="card-description">
                                My appointment list.
                            </p>
                            <div class="table-responsive">
                                <table id="appointmentTable" class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Appointment ID</th>
                                            <th>Patient Name</th>
                                            <th>Mobile Number</th>
                                            <th>Service</th>
                                            <th>Appointment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM appointments WHERE user_id='$user_id' ";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['appointment_id']; ?></td>
                                                    <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                    <td><?php if ($row['contact_number'] == "") {
                                                            echo 'N/A';
                                                        } else {
                                                            echo $row['contact_number'];
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $row1['service']; ?></td>
                                                    <td>
                                                        <?php $formattedDate = date("l, F j Y - h:i A", strtotime($row1["datetime"]));
                                                        echo $formattedDate; ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($row1['status'] == 0) {
                                                            echo '<label class="badge badge-warning">Pending</label>';
                                                        } elseif ($row1['status'] == 1) {
                                                            echo '<label class="badge badge-success">Approved</label>';
                                                        } elseif ($row1['status'] == 2) {
                                                            echo '<label class="badge badge-danger">Rejected</label>';
                                                        } ?>
                                                    </td>
                                                </tr>
                                        <?php

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
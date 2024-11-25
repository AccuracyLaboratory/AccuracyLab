<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $service = $row['staff_role'];
    $active = "patientrecords";
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

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Patient Records</h4>
                            <p class="card-description">
                                <?php echo $service; ?> patient record list.
                            </p>
                            <div class="table-responsive">
                                <table id="appointmentTable" class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Result ID</th>
                                            <th>Patient Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>Record Date Created</th>
                                            <?php if ($service == "Laboratory") {
                                                echo '<th>Type of Test</th>';
                                            } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM patient_records WHERE service='$service'";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                                $user_id = $row1['user_id'];
                                                $sql3 = "SELECT * FROM users WHERE user_id = $user_id";
                                                $result3 = mysqli_query($link, $sql3);
                                                $row3 = mysqli_fetch_assoc($result3);
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['patient_record_id']; ?></td>
                                                    <td><?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?></td>
                                                    <td><?php if ($row3['contact_number'] == "") {
                                                            echo 'N/A';
                                                        } else {
                                                            echo $row3['contact_number'];
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $row3['email']; ?></td>
                                                    <td>
                                                        <?php $formattedDate = date("l, F j Y - h:i A", strtotime($row1["date_created"]));
                                                        echo $formattedDate; ?>
                                                    </td>

                                                    <?php if ($service == "Laboratory") {
                                                        echo '<td>' . $row1['subservice'] . '</td>';
                                                    } ?>

                                                    <td>
                                                        <div class="d-inline">
                                                            <a class="ml-1 action-icon" href="#" data-toggle="modal"
                                                                type="button" data-target="#view-records-<?php echo $row1['patient_record_id'] ?>">
                                                                <i class="ti-eye"></i> View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php

                                                include 'view-records.php';
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
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 10
            });
        });
    </script>
</body>

</html>
<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM admins WHERE admin_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "patientrecords";
} else {
    header("location: admin-login");
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
        <?php include "partials/admin-heading.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "partials/admin-navbar.php"; ?>

            <style>
                .card-description {
                    font-size: 38px !important;
                    font-weight: 800 !important;
                    color: black !important;
                }

                .card-total-patient {
                    background-color: #f8d7da;
                    /* Light red */
                    color: #721c24;
                }

                .card-laboratory {
                    background-color: #d4edda;
                    /* Light green */
                    color: #155724;
                }

                .card-xray {
                    background-color: #cce5ff;
                    /* Light blue */
                    color: #004085;
                }

                .card-echo {
                    background-color: #fff3cd;
                    /* Light yellow */
                    color: #856404;
                }

                .card-ultrasound {
                    background-color: #e2e3e5;
                    /* Light gray */
                    color: #383d41;
                }

                .card-ecg {
                    background-color: #d1ecf1;
                    /* Light cyan */
                    color: #0c5460;
                }
            </style>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row" id="appointmentCounts">
                        <div class="col-md-4">
                            <div class="card card-total-patient">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Total Patient Records</strong></h2>
                                    <p class="card-description" id="totalCount">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-laboratory">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Laboratory</strong></h2>
                                    <p class="card-description" id="laboratoryCount">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-xray">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>X-ray</strong></h2>
                                    <p class="card-description" id="xrayCount">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="card card-echo">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>2D Echo</strong></h2>
                                    <p class="card-description" id="echoCount">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="card card-ultrasound">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Ultrasound</strong></h2>
                                    <p class="card-description" id="ultrasoundCount">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="card card-ecg">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>ECG</strong></h2>
                                    <p class="card-description" id="ecgCount">#</p>
                                </div>
                            </div>
                        </div>


                        <script>
                            async function fetchServiceCounts() {
                                try {
                                    const response = await fetch('fetch-service-counts.php');
                                    const data = await response.json();

                                    document.getElementById('totalCount').innerText = data.total;
                                    document.getElementById('laboratoryCount').innerText = data.laboratory;
                                    document.getElementById('xrayCount').innerText = data.xray;
                                    document.getElementById('echoCount').innerText = data['2d_echo']; 
                                    document.getElementById('ultrasoundCount').innerText = data.ultrasound;
                                    document.getElementById('ecgCount').innerText = data.ecg;
                                } catch (error) {
                                    console.error("Error fetching service counts:", error);
                                }
                            }

                            window.onload = fetchServiceCounts;
                        </script>


                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Appointment list</h4>
                                    <div class="table-responsive">
                                        <table id="appointmentTable" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Appointment ID</th>
                                                    <th>Patient Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Appointment Date</th>
                                                    <th>Service</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql1 = "SELECT * FROM appointments";
                                                $r = mysqli_query($link, $sql1);

                                                function formatID($id) {
                                                    return str_pad($id, 3, "0", STR_PAD_LEFT);
                                                }
                                                
                                                if ($r->num_rows > 0) {
                                                    while ($row1 = mysqli_fetch_assoc($r)) {
                                                        $user_id = $row1['user_id'];
                                                        $sql3 = "SELECT * FROM users WHERE user_id = $user_id";
                                                        $result3 = mysqli_query($link, $sql3);
                                                        $row3 = mysqli_fetch_assoc($result3);
                                                ?>
                                                        <tr class="text-center">
                                                        <td><?php echo formatID($row1['appointment_id']); ?></td>
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
                                                            <td><?php echo $row1['service']; ?></td>

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
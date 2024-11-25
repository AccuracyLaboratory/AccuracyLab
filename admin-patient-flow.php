<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM admins WHERE admin_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "patientflow";
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

                .card-total-appointments {
                    background-color: #f0e68c;
                    color: #6b4f1d;
                }

                .card-approved-appointments {
                    background-color: #98fb98;
                    color: #2d6b2d;
                }

                .card-cancelled-appointments {
                    background-color: #ffcccb;
                    color: #a33d3d;
                }
            </style>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row" id="appointmentCounts">
                        <div class="col-md-4">
                            <div class="card card-total-appointments">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Total Appointments</strong></h2>
                                    <p class="card-description" id="totalAppointments">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-approved-appointments">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Approved Appointments</strong></h2>
                                    <p class="card-description" id="approvedAppointments">#</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-cancelled-appointments">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Cancelled Appointments</strong></h2>
                                    <p class="card-description" id="cancelledAppointments">#</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 d-inline-flex align-items-center justify-content-end">
                                            <label for="yearFilter" class="me-2">Select Year:</label>
                                            <select id="yearFilter" class="form-control" style="width: 100px;"  onchange="updateChart()"></select>
                                        </div>
                                    <h2 class="card-title"><strong>Patient Flow</strong></h2>
                                    <canvas id="myLineChart" style="height: 400px; width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>


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

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        async function fetchAppointmentCounts() {
                            try {
                                const response = await fetch('fetch-appointment-counts.php');
                                const data = await response.json();

                                document.getElementById('totalAppointments').innerText = data.total;
                                document.getElementById('approvedAppointments').innerText = data.approved;
                                document.getElementById('cancelledAppointments').innerText = data.cancelled;

                            } catch (error) {
                                console.error("Error fetching appointment counts:", error);
                            }
                        }
                        async function updateChart() {
                            fetchAppointmentCountss();
                        }
                        function populateYearOptions() {
                            
                            const currentYear = new Date().getFullYear();
                            const yearFilter = document.getElementById('yearFilter');
                            yearFilter.innerHTML = '';
                            for (let year = currentYear; year >= 2000; year--) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.text = year;
                                yearFilter.appendChild(option);
                            }
                        }
                        async function fetchAppointmentCountss() {
                            try {
                                const year =  document.getElementById('yearFilter').value; 
                                const response = await fetch(`fetch-currentyear-appointment.php?YEAR=${year}`);
                                const data = await response.json();
                                // console.log("data",data);
                               if(data){
                                const ctx = document.getElementById('myLineChart').getContext('2d');
                                const myLineChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: data.months,
                                        datasets: [{
                                            label: `Appointments in ${new Date().getFullYear()}`,
                                            data: data.counts,
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                            borderWidth: 2,
                                            fill: true,
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            title: {
                                                display: true,
                                                text: `Monthly Appointments for ${new Date().getFullYear()}`
                                            }
                                        }
                                    }
                                });
                               }else{
                                console.log('No data data available.');
                               }
                            } catch (error) {
                                console.error("Error fetching appointment counts:", error);
                            }
                        }

                        window.onload = () => {
                            populateYearOptions();
                            fetchAppointmentCounts();
                            fetchAppointmentCountss();
                        };
                    </script>

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
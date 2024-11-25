<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM admins WHERE admin_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "machine";
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

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title">
                                            <h4 class="card-title">Machine</h4>
                                            <p class="card-description">
                                                Machine list.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6 d-inline-flex align-items-center justify-content-end">
                                            <label for="yearFilter" class="me-2">Select Services:</label>
                                            <select id="yearFilter" class="form-control" style="width: 100px;">
                                            <option value="Laboratory" <?php if ($service === 'Laboratory') echo 'selected'; ?>>Laboratory</option>
                                            <option value="Xray" <?php if ($service === 'Xray') echo 'selected'; ?>>X-Ray</option>
                                            <option value="2D Echo" <?php if ($service === '2D Echo') echo 'selected'; ?>>2D Echo</option>
                                            <option value="Ultrasound" <?php if ($service === 'Ultrasound') echo 'selected'; ?>>Ultrasound</option>
                                            <option value="ECG" <?php if ($service === 'ECG') echo 'selected'; ?>>ECG</option>
                                            </select>
                                        </div> -->
                                    <div class="table-responsive">
                                        
                                        <table id="machineTable" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Machine ID</th>
                                                    <th>Machine</th>
                                                    <!-- <th>Quantity</th> -->
                                                    <th>Status</th>
                                                    <th>Schedule Maintenance</th>
                                                    <th>Downtime</th>
                                                    <th>Last Updated</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql1 = "SELECT * FROM machine";
                                                $r = mysqli_query($link, $sql1);

                                                function formatID($id) {
                                                    return "MAC".str_pad($id, 3, "0", STR_PAD_LEFT);
                                                }
                                                if ($r->num_rows > 0) {
                                                    while ($row1 = mysqli_fetch_assoc($r)) {
                                                ?>
                                                        <tr class="text-center">
                                                            <td><?php echo formatID($row1['machine_id']); ?></td>
                                                            <td><?php echo $row1['machine']; ?></td>
                                                            <!-- <td><?php echo $row1['quantity']; ?></td> -->
                                                            <td>
                                                                <?php
                                                                if ($row1['status'] == 0) {
                                                                    echo '<label class="badge badge-success">Available</label>';
                                                                } else {
                                                                    echo '<label class="badge badge-danger">Unavailable</label>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row1['schedule_maintenance']; ?></td>
                                                            <td><?php echo $row1['downtime']; ?></td>
                                                            <td>
                                                                <?php $formattedDate = date("l, F j Y - h:i A", strtotime($row1["last_updated"]));
                                                                echo $formattedDate; ?>
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
                        <!-- <div class="col-md-6 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Machine Data Visual</strong></h2>
                                    <p class="card-description"></p>
                                    <canvas id="mybarchart"></canvas>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                $(document).ready(function() {
                                    $.ajax({
                                        url: 'fetch-machine.php',
                                        method: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                            var machineNames = data.machines;
                                            var quantities = data.quantities;

                                            var colors = machineNames.map(() => {
                                                return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.6)`;
                                            });

                                            var ctx = document.getElementById('mybarchart').getContext('2d');
                                            var myBarChart = new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: machineNames,
                                                    datasets: [{
                                                        label: 'Quantity',
                                                        backgroundColor: colors,
                                                        borderColor: colors.map(color => color.replace('0.6', '1')),
                                                        borderWidth: 1,
                                                        data: quantities
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            labels: {
                                                                color: 'black',
                                                                generateLabels: function(chart) {
                                                                    return machineNames.map((name, index) => ({
                                                                        text: name,
                                                                        fillStyle: colors[index],
                                                                        strokeStyle: colors[index].replace('0.6', '1'),
                                                                        hidden: false,
                                                                        lineWidth: 1
                                                                    }));
                                                                }
                                                            }
                                                        }
                                                    },
                                                    scales: {
                                                        yAxes: [{
                                                            beginAtZero: true,
                                                            stacked: false,
                                                            ticks: {
                                                                stepSize: 1,
                                                                min: 0,
                                                            }
                                                        }],
                                                    }
                                                }
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error fetching machine data:', error);
                                        }
                                    });
                                });
                            </script>


                        </div> -->
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title">
                                            <h4 class="card-title">Maintenance Alert</h4>
                                            <p class="card-description"></p>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="machineTable2" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Machine</th>
                                                    <th>Last Updated</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql1 = "SELECT * FROM machine WHERE schedule_maintenance != ''";
                                                $r = mysqli_query($link, $sql1);


                                                if ($r->num_rows > 0) {
                                                    while ($row1 = mysqli_fetch_assoc($r)) {
                                                ?>
                                                        <tr class="text-center">
                                                            <td><?php echo $row1['machine']; ?></td>
                                                            <td>
                                                                <?php $formattedDate = date("l, F j Y - h:i A", strtotime($row1["last_updated"]));
                                                                echo $formattedDate; ?>
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
        #machineTable thead .sorting:before,
        #machineTable thead .sorting:after,
        #machineTable thead .sorting_asc:before,
        #machineTable thead .sorting_asc:after,
        #machineTable thead .sorting_desc:before,
        #machineTable thead .sorting_desc:after {
            display: none;
        }

        #machineTable2 thead .sorting:before,
        #machineTable2 thead .sorting:after,
        #machineTable2 thead .sorting_asc:before,
        #machineTable2 thead .sorting_asc:after,
        #machineTable2 thead .sorting_desc:before,
        #machineTable2 thead .sorting_desc:after {
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
            $('#machineTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthMenu": [10, 25, 50],
                "pageLength": 10
            });
            $('#machineTable2').DataTable({
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
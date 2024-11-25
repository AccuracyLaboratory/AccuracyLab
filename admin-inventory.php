<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM admins WHERE admin_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "inventory";
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
                                            <h4 class="card-title">Inventory</h4>
                                            <p class="card-description">
                                                Inventory list.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="inventoryTable" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Item ID</th>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Quantity Used</th>
                                                    <th>Remaining Stocks</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql1 = "SELECT * FROM inventory";
                                                $r = mysqli_query($link, $sql1);

                                                function formatID($id) {
                                                    return "INV".str_pad($id, 3, "0", STR_PAD_LEFT);
                                                }
                                                if ($r->num_rows > 0) {
                                                    while ($row1 = mysqli_fetch_assoc($r)) {
                                                ?>
                                                        <tr class="text-center">
                                                            <td><?php echo formatID($row1['inventory_id']); ?></td>
                                                            <td><?php echo $row1['item']; ?></td>
                                                            <td><?php echo $row1['quantity']; ?></td>
                                                            <td><?php echo $row1['quantity_used']; ?></td>
                                                            <td><?php $remaining_stocks = $row1['quantity'] - $row1['quantity_used'];
                                                                echo $remaining_stocks; ?></td>
                                                            <td>
                                                                <?php
                                                                $quantity = $row1['quantity'];
                                                                $quantity_used = $row1['quantity_used'];

                                                                $available_quantity = $quantity - $quantity_used;

                                                                $low_stock_threshold = $quantity * 0.30;

                                                                if ($available_quantity == 0) {
                                                                    echo '<label class="badge badge-danger">Out of Stock</label>';
                                                                } elseif ($available_quantity <= $low_stock_threshold) {
                                                                    echo '<label class="badge badge-warning">Low Stock</label>';
                                                                } else {
                                                                    echo '<label class="badge badge-success">In Stock</label>';
                                                                }
                                                                ?>

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
                        <div class="col-md-6 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Stock and Used Items</strong></h2>
                                    <p class="card-description"></p>
                                    <canvas id="myComboBarlinechart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title">
                                            <h4 class="card-title">Reorder Alert.</h4>
                                            <p class="card-description"></p>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="inventoryTable2" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Item</th>
                                                    <th>Remaining Stock</th>
                                                    <th>Needed Stocks</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql1 = "SELECT * FROM inventory";
                                                $r = mysqli_query($link, $sql1);

                                                if ($r->num_rows > 0) {
                                                    while ($row1 = mysqli_fetch_assoc($r)) {
                                                        $quantity = $row1['quantity'];
                                                        $quantity_used = $row1['quantity_used'];
                                                        $remaining_stocks = $quantity - $quantity_used;

                                                        $low_stock_threshold = $quantity * 0.30;

                                                        if ($remaining_stocks == 0 || $remaining_stocks <= $low_stock_threshold) {
                                                ?>
                                                            <tr class="text-center">
                                                                <td><?php echo $row1['item']; ?></td>
                                                                <td><?php echo $remaining_stocks; ?></td>

                                                                <td><?php
                                                                    $needed_stocks = $quantity - $remaining_stocks;
                                                                    echo $needed_stocks;
                                                                    ?></td>

                                                                <td>
                                                                    <?php
                                                                    if ($remaining_stocks == 0) {
                                                                        echo '<label class="badge badge-danger">Out of Stock</label>';
                                                                    } elseif ($remaining_stocks <= $low_stock_threshold) {
                                                                        echo '<label class="badge badge-warning">Low Stock</label>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                <?php
                                                        }
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="5" class="text-center">No data available</td></tr>';
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
        #inventoryTable thead .sorting:before,
        #inventoryTable thead .sorting:after,
        #inventoryTable thead .sorting_asc:before,
        #inventoryTable thead .sorting_asc:after,
        #inventoryTable thead .sorting_desc:before,
        #inventoryTable thead .sorting_desc:after {
            display: none;
        }

        #inventoryTable2 thead .sorting:before,
        #inventoryTable2 thead .sorting:after,
        #inventoryTable2 thead .sorting_asc:before,
        #inventoryTable2 thead .sorting_asc:after,
        #inventoryTable2 thead .sorting_desc:before,
        #inventoryTable2 thead .sorting_desc:after {
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
            $('#inventoryTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthMenu": [10, 25, 50],
                "pageLength": 10
            });
            $('#inventoryTable2').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthMenu": [10, 25, 50],
                "pageLength": 10
            });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        fetch('fetch-stock-used-items.php')
            .then(response => response.json())
            .then(data => {
                const items = data.items;
                const quantities = data.quantities;
                const quantitiesUsed = data.quantities_used;
                const completedAppointments = data.appointments;

                const ctx = document.getElementById('myComboBarlinechart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: items,
                        datasets: [{
                                label: 'Quantity Available',
                                type: 'bar',
                                backgroundColor: 'rgba(166, 125, 85, 0.7)',
                                data: quantities
                            },
                            {
                                label: 'Quantity Used',
                                type: 'bar',
                                backgroundColor: 'rgba(204, 214, 121, 0.7)',
                                data: quantitiesUsed
                            },
                            {
                                label: 'Appointment',
                                type: 'line',
                                fill: false,
                                borderColor: 'rgba(0, 0, 0, 1)',
                                data: completedAppointments,
                                yAxisID: 'y2'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Quantity Available and Used'
                                }
                            },
                            y2: {
                                beginAtZero: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Appointment'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Item'
                                }
                            }
                        },
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>

</body>

</html>
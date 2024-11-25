<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $service = $row['staff_role'];
    $active = "machine";
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
            $machine_err = $quantity_err = $schedule_maintenance_err = $downtime_err = $status_err = "";
            if (isset($_POST["update"])) {
                $machine_id = $_POST['machine_id'];

                if (empty(trim($_POST["machine"]))) {
                    $machine_err = "Please enter an machine.";
                } else {
                    $sql = "SELECT machine_id FROM machine WHERE machine = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $param_machine);

                        $param_machine = trim($_POST["machine"]);

                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 2) {
                                $machine_err = "This machine is already taken.";
                            } else {
                                $machine = trim($_POST["machine"]);
                            }
                        } else {
                            echo "<script>swal({
                                title: 'Oops!',
                                text: 'Something went wrong. Please try again later.',
                                icon: 'warning',
                                button: 'Done!',
                            });</script>";
                        }

                        mysqli_stmt_close($stmt);
                    }
                }
                
                if (!isset($_POST["status"])) {
                    $status_err = "Please select a status.";
                } else {
                    $status = mysqli_real_escape_string($link, trim($_POST["status"]));
                }

                if (empty(trim($_POST["quantity"]))) {
                    $quantity_err = "Please enter quantity.";
                } else {
                    $quantity = trim($_POST["quantity"]);
                }

                if (empty(trim($_POST["schedule_maintenance"]))) {
                    $schedule_maintenance_err = "Please enter schedule maintenance.";
                } else {
                    $schedule_maintenance = trim($_POST["schedule_maintenance"]);
                }

                if (empty(trim($_POST["downtime"]))) {
                    $downtime_err = "Please enter downtime.";
                } else {
                    $downtime = trim($_POST["downtime"]);
                }

                if (empty($machine_err) && empty($quantity_err) && empty($status_err) && empty($schedule_maintenance_err) && empty($downtime_err)) {
                    // Update appointment status
                    $sql1 = "UPDATE machine SET machine=?, quantity=?, status=?, schedule_maintenance=?, downtime=? WHERE machine_id=?";
                    $stmt = mysqli_prepare($link, $sql1);
                    mysqli_stmt_bind_param($stmt, 'siissi', $machine, $quantity, $status, $schedule_maintenance, $downtime, $machine_id);

                    if (mysqli_stmt_execute($stmt)) {

                        echo "<script>swal({
                            title: 'Success!',
                            text: 'Machine Updated Successfully!',
                            icon: 'success',
                            button: false,
                        });</script>";

            ?>
                        <meta http-equiv="Refresh" content="3; url=staff-machine">
            <?php
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="title">
                                    <h4 class="card-title">Machine</h4>
                                    <p class="card-description">
                                        <?php echo $service; ?> machine list.
                                    </p>
                                </div>
                                <div class="create">
                                    <a href="#" data-toggle="modal"
                                        type="button" data-target="#create-machine" class="btn btn-primary">Create New Machine</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="machineTable" class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Machine ID</th>
                                            <th>Machine Name</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Schedule Maintenance</th>
                                            <th>Downtime</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM machine WHERE service='$service' ";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['machine_id']; ?></td>
                                                    <td><?php echo $row1['machine']; ?></td>
                                                    <td><?php echo $row1['quantity']; ?></td>
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
                                                        <div class="d-inline">
                                                            <a class="ml-1 action-icon" href="#" data-toggle="modal"
                                                                type="button" data-target="#manage-machine-<?php echo $row1['machine_id'] ?>">
                                                                <i class="ti-pencil"></i> Manage
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php

                                                include 'manage-machine.php';
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
            <?php

            $machine = $quantity = $photo = "";
            $machine_err = $quantity_err = $photo_err = "";

            if (isset($_POST['create-machine'])) {

                if (empty(trim($_POST["machine"]))) {
                    $machine_err = "Please enter an machine.";
                } else {
                    $sql = "SELECT machine_id FROM machine WHERE machine = ? AND service = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ss", $param_machine, $param_service);

                        $param_machine = trim($_POST["machine"]);
                        $param_service = $service;

                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 1) {
                                $machine_err = "This machine is already taken.";
                            } else {
                                $machine = trim($_POST["machine"]);
                            }
                        } else {
                            echo "<script>swal({
                                title: 'Oops!',
                                text: 'Something went wrong. Please try again later.',
                                icon: 'warning',
                                button: 'Done!',
                            });</script>";
                        }

                        mysqli_stmt_close($stmt);
                    }
                }

                if (empty(trim($_POST["quantity"]))) {
                    $quantity_err = "Please enter quantity.";
                } else {
                    $quantity = trim($_POST["quantity"]);
                }

                if (empty($_FILES['photo']['name'])) {
                    $photo = "default_image.png";
                    $photo_new_name = "default_image.png";
                } else {
                    $photo = $_FILES["photo"]["name"];
                    $photo_tmp_name = $_FILES["photo"]["tmp_name"];
                    $photo_size = $_FILES["photo"]["size"];
                    $photo_new_name = rand() . "_" . $photo;
                }

                if (empty($machine_err) && empty($quantity_err)) {

                    $sql = "INSERT INTO machine (service, machine, quantity, photo) VALUES (?, ?, ?, ?)";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssis", $param_service, $param_machine, $param_quantity, $param_photo);

                        $param_service = $service;
                        $param_machine = $machine;
                        $param_quantity = $quantity;
                        $param_photo = $photo_new_name;

                        if (mysqli_stmt_execute($stmt)) {
                            if ($photo_new_name !== "default_image.png") {
                                move_uploaded_file($photo_tmp_name, "storage/machine/" . $photo_new_name);
                            }
                            echo "<script>swal({
                                title: 'Success!',
                                text: 'Machine Created Successfully!',
                                icon: 'success',
                                closeOnClickOutside: false,
                                button: false
                            });</script>";
                            echo '<meta http-equiv="Refresh" content="0; url=staff-machine">';
                        } else {
                            echo "<script>swal({
                                title: 'Oops!',
                                text: 'Something went wrong. Please try again later.',
                                icon: 'warning',
                                button: 'Done!',
                            });</script>";
                        }

                        mysqli_stmt_close($stmt);
                    }
                }

                mysqli_close($link);
            }

            ?>


            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="create-machine">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Create Machine Item
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="card shadow mb-3">
                                            <div class="card-header">
                                                <strong class="card-title">Create Machine</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <div class="text-center">
                                                                <img src="storage/machine/default_image.png"
                                                                    class="avatar img-thumbnail mb-2" alt="avatar" height="250px"
                                                                    width="250px">
                                                            </div>
                                                            <br>
                                                            <label for="customFile">Choose Machine Photo</label>
                                                            <div class="custom-file">
                                                                <input type="file" id="customFile" accept="image/*" name="photo"
                                                                    class="custom-file-input form-control <?php echo (!empty($photo_err)) ? 'is-invalid' : ''; ?> file-upload mb-3">
                                                                <span class="invalid-feedback"><?php echo $photo_err; ?></span>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {

                                                                    var readURL = function(input) {
                                                                        if (input.files && input.files[0]) {
                                                                            var reader = new FileReader();

                                                                            reader.onload = function(e) {
                                                                                $('.avatar').attr('src', e.target.result);
                                                                            }

                                                                            reader.readAsDataURL(input.files[0]);
                                                                        }
                                                                    }


                                                                    $(".file-upload").on('change', function() {
                                                                        readURL(this);
                                                                    });
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="example-machine">Machine Name</label>
                                                            <input type="text" class="form-control <?php echo (!empty($machine_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="machine" placeholder="Machine Name" value="<?php echo $machine; ?>">
                                                            <span class="invalid-feedback"><?php echo $machine_err; ?></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="example-quantity">Quantity</label>
                                                            <input type="number" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>">
                                                            <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="text-center">
                                    <button class="btn btn-lg btn-primary" type="submit" name="create-machine">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        });
    </script>
</body>

</html>
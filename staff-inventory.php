<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $service = $row['staff_role'];
    $active = "inventory";
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
            $item_err = $quantity_err = $quantity_used_err = "";
            if (isset($_POST["update"])) {
                $inventory_id = $_POST['inventory_id'];

                if (empty(trim($_POST["item"]))) {
                    $item_err = "Please enter an item.";
                } else {
                    $sql = "SELECT inventory_id FROM inventory WHERE item = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $param_item);

                        $param_item = trim($_POST["item"]);

                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 2) {
                                $item_err = "This item is already taken.";
                            } else {
                                $item = trim($_POST["item"]);
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

                if (empty(trim($_POST["quantity_used"]))) {
                    $quantity_used_err = "Please enter quantity used.";
                } else {
                    $quantity_used = trim($_POST["quantity_used"]);
                }

                if (empty($item_err) && empty($quantity_err) && empty($quantity_used_err)) {
                    $sql1 = "UPDATE inventory SET item=?, quantity=?, quantity_used=? WHERE inventory_id=?";
                    $stmt = mysqli_prepare($link, $sql1);
                    mysqli_stmt_bind_param($stmt, 'siii', $item, $quantity, $quantity_used, $inventory_id);

                    if (mysqli_stmt_execute($stmt)) {

                        echo "<script>swal({
                            title: 'Success!',
                            text: 'Inventory Updated Successfully!',
                            icon: 'success',
                            button: false,
                        });</script>";

            ?>
                        <meta http-equiv="Refresh" content="3; url=staff-inventory">
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
                                    <h4 class="card-title">Inventory</h4>
                                    <p class="card-description">
                                        <?php echo $service; ?> inventory list.
                                    </p>
                                </div>
                                <div class="create">
                                    <a href="#" data-toggle="modal"
                                        type="button" data-target="#create-inventory" class="btn btn-primary">Create New Item</a>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM inventory WHERE service='$service' ";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['inventory_id']; ?></td>
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
                                                    <td>
                                                        <div class="d-inline">
                                                            <a class="ml-1 action-icon" href="#" data-toggle="modal"
                                                                type="button" data-target="#manage-inventory-<?php echo $row1['inventory_id'] ?>">
                                                                <i class="ti-pencil"></i> Manage
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php

                                                include 'manage-inventory.php';
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

            $item = $quantity = $photo = "";
            $item_err = $quantity_err = $photo_err = "";

            if (isset($_POST['create-inventory'])) {

                if (empty(trim($_POST["item"]))) {
                    $item_err = "Please enter an item.";
                } else {
                    $sql = "SELECT inventory_id FROM inventory WHERE item = ? AND service = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ss", $param_item, $param_service);

                        $param_item = trim($_POST["item"]);
                        $param_service = $service;

                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 1) {
                                $item_err = "This item is already taken.";
                            } else {
                                $item = trim($_POST["item"]);
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

                if (empty($item_err) && empty($quantity_err)) {

                    $sql = "INSERT INTO inventory (service, item, quantity, photo) VALUES (?, ?, ?, ?)";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssis", $param_service, $param_item, $param_quantity, $param_photo);

                        $param_service = $service;
                        $param_item = $item;
                        $param_quantity = $quantity;
                        $param_photo = $photo_new_name;

                        if (mysqli_stmt_execute($stmt)) {
                            if ($photo_new_name !== "default_image.png") {
                                move_uploaded_file($photo_tmp_name, "storage/inventory/" . $photo_new_name);
                            }
                            $item = $quantity = $photo = "";
                            echo "<script>swal({
                                title: 'Success!',
                                text: 'Inventory Created Successfully!',
                                icon: 'success',
                                closeOnClickOutside: false,
                                button: false
                            });</script>";
                            echo '<meta http-equiv="Refresh" content="0; url=staff-inventory">';
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
                aria-hidden="true" id="create-inventory">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Create Inventory Item
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
                                                <strong class="card-title">Create Inventory</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <div class="text-center">
                                                                <img src="storage/inventory/default_image.png"
                                                                    class="avatar img-thumbnail mb-2" alt="avatar" height="250px"
                                                                    width="250px">
                                                            </div>
                                                            <br>
                                                            <label for="customFile">Choose Item Photo</label>
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
                                                            <label for="example-item_name">Item Name</label>
                                                            <input type="text" class="form-control <?php echo (!empty($item_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="item" placeholder="Item Name" value="<?php echo $item; ?>">
                                                            <span class="invalid-feedback"><?php echo $item_err; ?></span>
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
                                    <button class="btn btn-lg btn-primary" type="submit" name="create-inventory">Create</button>
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
        #inventoryTable thead .sorting:before,
        #inventoryTable thead .sorting:after,
        #inventoryTable thead .sorting_asc:before,
        #inventoryTable thead .sorting_asc:after,
        #inventoryTable thead .sorting_desc:before,
        #inventoryTable thead .sorting_desc:after {
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
        });
    </script>
</body>

</html>
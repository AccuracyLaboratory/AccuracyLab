<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="manage-machine-<?php echo $row1['machine_id'] ?>">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Machine ID #<?php echo $row1['machine_id']; ?>
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
                                    <strong class="card-title">Manage Machine</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input type="hidden" name="machine_id"
                                                    value="<?php echo $row1['machine_id']; ?>">
                                                <label for="example-status">Status</label>
                                                <select name="status"
                                                    class="form-control select <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>">
                                                    <option value="">Please select a status:</option>
                                                    <optgroup label="Status:">
                                                        <option value="0" <?php if ($row1['status'] == 0)
                                                                                echo 'selected'; ?>>Available</option>
                                                        <option value="1" <?php if ($row1['status'] == 1)
                                                                                echo 'selected'; ?>>Unavailable</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-machine_name">Machine Name</label>
                                                <input type="text" class="form-control <?php echo (!empty($machine_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="machine" placeholder="Machine Name" value="<?php echo $row1['machine']; ?>">
                                                <span class="invalid-feedback"><?php echo $machine_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-quantity">Quantity</label>
                                                <input type="number" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="quantity" placeholder="Quantity" value="<?php echo $row1['quantity']; ?>">
                                                <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-schedule_maintenance">Schedule Maintenance</label>
                                                <input type="date" class="form-control <?php echo (!empty($schedule_maintenance_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="schedule_maintenance" placeholder="Schedule Maintenance" value="<?php echo $row1['schedule_maintenance']; ?>">
                                                <span class="invalid-feedback"><?php echo $schedule_maintenance_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-downtime">Downtime</label>
                                                <input type="date" class="form-control <?php echo (!empty($downtime_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="downtime" placeholder="Downtime" value="<?php echo $row1['downtime']; ?>">
                                                <span class="invalid-feedback"><?php echo $downtime_err; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-lg btn-primary" type="submit" name="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
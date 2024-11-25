<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="manage-appointment-<?php echo $row1['appointment_id'] ?>">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Appointment ID #<?php echo $row1['appointment_id']; ?>
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
                                    <strong class="card-title">Manage Appointment</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input type="hidden" name="appointment_id"
                                                    value="<?php echo $row1['appointment_id']; ?>">
                                                <input type="hidden" name="user_email"
                                                    value="<?php echo $row3['email']; ?>">
                                                <input type="hidden" name="username"
                                                    value="<?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?>">
                                                <label for="example-status">Status</label>
                                                <select name="status"
                                                    class="form-control select <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>">
                                                    <option value="">Please select a status:</option>
                                                    <optgroup label="Status:">
                                                        <option value="0" <?php if ($row1['status'] == 0)
                                                                                echo 'selected'; ?>>Pending</option>
                                                        <option value="1" <?php if ($row1['status'] == 1)
                                                                                echo 'selected'; ?>>Approved</option>
                                                        <option value="2" <?php if ($row1['status'] == 2)
                                                                                echo 'selected'; ?>>Rejected</option>
                                                    </optgroup>
                                                </select>

                                                <span class="invalid-feedback"><?php echo $status_err; ?></span>
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
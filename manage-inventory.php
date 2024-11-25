<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="manage-inventory-<?php echo $row1['inventory_id'] ?>">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Inventory ID #<?php echo $row1['inventory_id']; ?>
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
                                    <strong class="card-title">Manage Inventory</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input type="hidden" name="inventory_id"
                                                    value="<?php echo $row1['inventory_id']; ?>">
                                                <label for="example-item_name">Item Name</label>
                                                <input type="text" class="form-control <?php echo (!empty($item_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="item" placeholder="Item Name" value="<?php echo $row1['item']; ?>">
                                                <span class="invalid-feedback"><?php echo $item_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-quantity">Quantity</label>
                                                <input type="number" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="quantity" placeholder="Quantity" value="<?php echo $row1['quantity']; ?>">
                                                <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-quantity_used">Quantity Used</label>
                                                <input type="number" class="form-control <?php echo (!empty($quantity_used_err)) ? 'is-invalid' : ''; ?> form-control-lg" name="quantity_used" placeholder="Quantity" value="<?php echo $row1['quantity_used']; ?>">
                                                <span class="invalid-feedback"><?php echo $quantity_used_err; ?></span>
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
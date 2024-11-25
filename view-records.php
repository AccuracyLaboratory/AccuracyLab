<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view-records-<?php echo $row1['patient_record_id'] ?>">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Patient Record ID #<?php echo $row1['patient_record_id']; ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row justify-content-center mb-4">
                        <div class="col-12">
                            <div class="row result">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <img src="storage/<?php if ($row["photo"] != "") {
                                                                                echo $row["photo"];
                                                                            } else {
                                                                                echo 'default_image.png';
                                                                            } ?>" alt="Admin">
                                                    </div>
                                                    <h5 class="user-name"><?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?></h5>
                                                    <h6 class="user-email"><?php echo $row3['email']; ?></h6>
                                                </div>
                                                <div class="about">
                                                    <h5>Profile Information</h5>
                                                    <p><b>Gender:</b> <?php if ($row3['gender'] == "") {
                                                                            echo 'N/A';
                                                                        } else {
                                                                            echo $row3['gender'];
                                                                        } ?></p>
                                                    <p><b>Date of Birth:</b> <?php if ($row3['birthday'] == "") {
                                                                                    echo 'N/A';
                                                                                } else {
                                                                                    echo $row3['birthday'];
                                                                                } ?></p>
                                                    <p><b>Age:</b> <?php if ($row3['age'] == "") {
                                                                        echo 'N/A';
                                                                    } else {
                                                                        echo $row3['age'];
                                                                    } ?></p>
                                                    <p><b>Mobile Number:</b> <?php if ($row3['contact_number'] == "") {
                                                                                    echo 'N/A';
                                                                                } else {
                                                                                    echo $row3['contact_number'];
                                                                                } ?></p>
                                                    <p><b>Address:</b> <?php if ($row3['address'] == "") {
                                                                            echo 'N/A';
                                                                        } else {
                                                                            echo $row3['address'];
                                                                        } ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $row1['service']; ?> Form</h4>
                                            <?php
                                            if ($row1['service'] == "Laboratory") { ?>
                                                <p class="card-description">
                                                    Type of Test: <?php echo $row1['subservice']; ?>
                                                </p>
                                            <?php } ?>

                                            <input type="hidden" name="appointment_id"
                                                value="<?php echo $row1['appointment_id']; ?>">
                                            <input type="hidden" name="user_id"
                                                value="<?php echo $row3['user_id']; ?>">
                                            <input type="hidden" name="subservice"
                                                value="<?php echo $row1['subservice']; ?>">
                                            <input type="hidden" name="service"
                                                value="<?php echo $row1['service']; ?>">

                                            <?php
                                            if ($row1['service'] == "Laboratory") {
                                                if ($row1['subservice'] == 'Chem 6') {
                                            ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGPT/ALT</label>
                                                        <input type="text" name="sgpt_alt"
                                                            class="form-control <?php echo (!empty($sgpt_alt_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGPT/ALT."
                                                            value="<?php echo $sgpt_alt; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgpt_alt_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Chem 7') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>HDL</label>
                                                        <input type="text" name="hdl"
                                                            class="form-control <?php echo (!empty($hdl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter HDL."
                                                            value="<?php echo $hdl; ?>">
                                                        <span class="invalid-feedback"><?php echo $hdl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LDL</label>
                                                        <input type="text" name="ldl"
                                                            class="form-control <?php echo (!empty($ldl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter LDL."
                                                            value="<?php echo $ldl; ?>">
                                                        <span class="invalid-feedback"><?php echo $ldl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Chem 8') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>HDL</label>
                                                        <input type="text" name="hdl"
                                                            class="form-control <?php echo (!empty($hdl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter HDL."
                                                            value="<?php echo $hdl; ?>">
                                                        <span class="invalid-feedback"><?php echo $hdl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LDL</label>
                                                        <input type="text" name="ldl"
                                                            class="form-control <?php echo (!empty($ldl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter LDL."
                                                            value="<?php echo $ldl; ?>">
                                                        <span class="invalid-feedback"><?php echo $ldl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGPT/ALT</label>
                                                        <input type="text" name="sgpt_alt"
                                                            class="form-control <?php echo (!empty($sgpt_alt_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGPT/ALT."
                                                            value="<?php echo $sgpt_alt; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgpt_alt_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Chem 9') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>HDL</label>
                                                        <input type="text" name="hdl"
                                                            class="form-control <?php echo (!empty($hdl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter HDL."
                                                            value="<?php echo $hdl; ?>">
                                                        <span class="invalid-feedback"><?php echo $hdl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LDL</label>
                                                        <input type="text" name="ldl"
                                                            class="form-control <?php echo (!empty($ldl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter LDL."
                                                            value="<?php echo $ldl; ?>">
                                                        <span class="invalid-feedback"><?php echo $ldl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGOT/AST</label>
                                                        <input type="text" name="sgot_ast"
                                                            class="form-control <?php echo (!empty($sgot_ast_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGOT/AST."
                                                            value="<?php echo $sgot_ast; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgot_ast_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGPT/ALT</label>
                                                        <input type="text" name="sgpt_alt"
                                                            class="form-control <?php echo (!empty($sgpt_alt_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGPT/ALT."
                                                            value="<?php echo $sgpt_alt; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgpt_alt_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Chem 10') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>HDL</label>
                                                        <input type="text" name="hdl"
                                                            class="form-control <?php echo (!empty($hdl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter HDL."
                                                            value="<?php echo $hdl; ?>">
                                                        <span class="invalid-feedback"><?php echo $hdl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LDL</label>
                                                        <input type="text" name="ldl"
                                                            class="form-control <?php echo (!empty($ldl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter LDL."
                                                            value="<?php echo $ldl; ?>">
                                                        <span class="invalid-feedback"><?php echo $ldl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bun</label>
                                                        <input type="text" name="bun"
                                                            class="form-control <?php echo (!empty($bun_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter Bun."
                                                            value="<?php echo $bun; ?>">
                                                        <span class="invalid-feedback"><?php echo $bun_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGOT/AST</label>
                                                        <input type="text" name="sgot_ast"
                                                            class="form-control <?php echo (!empty($sgot_ast_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGOT/AST."
                                                            value="<?php echo $sgot_ast; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgot_ast_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGPT/ALT</label>
                                                        <input type="text" name="sgpt_alt"
                                                            class="form-control <?php echo (!empty($sgpt_alt_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGPT/ALT."
                                                            value="<?php echo $sgpt_alt; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgpt_alt_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Chem 13') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>FBS</label>
                                                        <input type="text" name="fbs"
                                                            class="form-control <?php echo (!empty($fbs_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter FBS."
                                                            value="<?php echo $fbs; ?>">
                                                        <span class="invalid-feedback"><?php echo $fbs_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cholesterol</label>
                                                        <input type="text" name="cholesterol"
                                                            class="form-control <?php echo (!empty($cholesterol_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter cholesterol."
                                                            value="<?php echo $cholesterol; ?>">
                                                        <span class="invalid-feedback"><?php echo $cholesterol_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Triglycerides</label>
                                                        <input type="text" name="triglycerides"
                                                            class="form-control <?php echo (!empty($triglycerides_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter triglycerides."
                                                            value="<?php echo $triglycerides; ?>">
                                                        <span class="invalid-feedback"><?php echo $triglycerides_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>HDL</label>
                                                        <input type="text" name="hdl"
                                                            class="form-control <?php echo (!empty($hdl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter HDL."
                                                            value="<?php echo $hdl; ?>">
                                                        <span class="invalid-feedback"><?php echo $hdl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LDL</label>
                                                        <input type="text" name="ldl"
                                                            class="form-control <?php echo (!empty($ldl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter LDL."
                                                            value="<?php echo $ldl; ?>">
                                                        <span class="invalid-feedback"><?php echo $ldl_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uric Acid</label>
                                                        <input type="text" name="uric_acid"
                                                            class="form-control <?php echo (!empty($uric_acid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter uric_acid."
                                                            value="<?php echo $uric_acid; ?>">
                                                        <span class="invalid-feedback"><?php echo $uric_acid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Creatinine</label>
                                                        <input type="text" name="creatinine"
                                                            class="form-control <?php echo (!empty($creatinine_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter creatinine."
                                                            value="<?php echo $creatinine; ?>">
                                                        <span class="invalid-feedback"><?php echo $creatinine_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bun</label>
                                                        <input type="text" name="bun"
                                                            class="form-control <?php echo (!empty($bun_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter Bun."
                                                            value="<?php echo $bun; ?>">
                                                        <span class="invalid-feedback"><?php echo $bun_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGOT/AST</label>
                                                        <input type="text" name="sgot_ast"
                                                            class="form-control <?php echo (!empty($sgot_ast_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGOT/AST."
                                                            value="<?php echo $sgot_ast; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgot_ast_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>SGPT/ALT</label>
                                                        <input type="text" name="sgpt_alt"
                                                            class="form-control <?php echo (!empty($sgpt_alt_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter SGPT/ALT."
                                                            value="<?php echo $sgpt_alt; ?>">
                                                        <span class="invalid-feedback"><?php echo $sgpt_alt_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>NA (Sodium)</label>
                                                        <input type="text" name="na"
                                                            class="form-control <?php echo (!empty($na_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter NA (Sodium)."
                                                            value="<?php echo $na; ?>">
                                                        <span class="invalid-feedback"><?php echo $na_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>K (Potassium)</label>
                                                        <input type="text" name="k"
                                                            class="form-control <?php echo (!empty($k_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter K (Potassium)."
                                                            value="<?php echo $k; ?>">
                                                        <span class="invalid-feedback"><?php echo $k_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>CL (Chloride)</label>
                                                        <input type="text" name="cl"
                                                            class="form-control <?php echo (!empty($cl_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter CL (Chloride)."
                                                            value="<?php echo $cl; ?>">
                                                        <span class="invalid-feedback"><?php echo $cl_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Urinalysis') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" name="color"
                                                            class="form-control <?php echo (!empty($color_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter color."
                                                            value="<?php echo $color; ?>">
                                                        <span class="invalid-feedback"><?php echo $color_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Consistency</label>
                                                        <input type="text" name="consistency"
                                                            class="form-control <?php echo (!empty($consistency_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter consistency."
                                                            value="<?php echo $consistency; ?>">
                                                        <span class="invalid-feedback"><?php echo $consistency_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>PH Reaction</label>
                                                        <input type="text" name="ph_reaction"
                                                            class="form-control <?php echo (!empty($ph_reaction_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter PH reaction."
                                                            value="<?php echo $ph_reaction; ?>">
                                                        <span class="invalid-feedback"><?php echo $ph_reaction_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Specific Gravity</label>
                                                        <input type="text" name="specific_gravity"
                                                            class="form-control <?php echo (!empty($specific_gravity_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter specific gravity."
                                                            value="<?php echo $specific_gravity; ?>">
                                                        <span class="invalid-feedback"><?php echo $specific_gravity_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Albumin</label>
                                                        <input type="text" name="albumin"
                                                            class="form-control <?php echo (!empty($albumin_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter albumin."
                                                            value="<?php echo $albumin; ?>">
                                                        <span class="invalid-feedback"><?php echo $albumin_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sugar</label>
                                                        <input type="text" name="sugar"
                                                            class="form-control <?php echo (!empty($sugar_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter sugar."
                                                            value="<?php echo $sugar; ?>">
                                                        <span class="invalid-feedback"><?php echo $sugar_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Fecalysis') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" name="color"
                                                            class="form-control <?php echo (!empty($color_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter color."
                                                            value="<?php echo $color; ?>">
                                                        <span class="invalid-feedback"><?php echo $color_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Consistency</label>
                                                        <input type="text" name="consistency"
                                                            class="form-control <?php echo (!empty($consistency_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter consistency."
                                                            value="<?php echo $consistency; ?>">
                                                        <span class="invalid-feedback"><?php echo $consistency_err; ?></span>
                                                    </div>
                                                <?php
                                                } elseif ($row1['subservice'] == 'Complete Blood Count') {
                                                ?>
                                                    <div class="form-group">
                                                        <label>WBC</label>
                                                        <input type="text" name="wbc"
                                                            class="form-control <?php echo (!empty($wbc_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter wbc."
                                                            value="<?php echo $wbc; ?>">
                                                        <span class="invalid-feedback"><?php echo $wbc_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>RBC</label>
                                                        <input type="text" name="rbc"
                                                            class="form-control <?php echo (!empty($rbc_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter RBC."
                                                            value="<?php echo $rbc; ?>">
                                                        <span class="invalid-feedback"><?php echo $rbc_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Hematocrit</label>
                                                        <input type="text" name="hematocrit"
                                                            class="form-control <?php echo (!empty($hematocrit_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter hematocrit."
                                                            value="<?php echo $hematocrit; ?>">
                                                        <span class="invalid-feedback"><?php echo $hematocrit_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Hemoglobin</label>
                                                        <input type="text" name="hemoglobin"
                                                            class="form-control <?php echo (!empty($hemoglobin_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter hemoglobin."
                                                            value="<?php echo $hemoglobin; ?>">
                                                        <span class="invalid-feedback"><?php echo $hemoglobin_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Granulocytes</label>
                                                        <input type="text" name="granulocytes"
                                                            class="form-control <?php echo (!empty($granulocytes_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter granulocytes."
                                                            value="<?php echo $granulocytes; ?>">
                                                        <span class="invalid-feedback"><?php echo $granulocytes_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Lymphocytes</label>
                                                        <input type="text" name="lymphocytes"
                                                            class="form-control <?php echo (!empty($lymphocytes_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter lymphocytes."
                                                            value="<?php echo $lymphocytes; ?>">
                                                        <span class="invalid-feedback"><?php echo $lymphocytes_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>MID</label>
                                                        <input type="text" name="mid"
                                                            class="form-control <?php echo (!empty($mid_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter MID."
                                                            value="<?php echo $mid; ?>">
                                                        <span class="invalid-feedback"><?php echo $mid_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Platelet</label>
                                                        <input type="text" name="platelet"
                                                            class="form-control <?php echo (!empty($platelet_err)) ? 'is-invalid' : ''; ?>"
                                                            placeholder="Please enter platelet."
                                                            value="<?php echo $platelet; ?>">
                                                        <span class="invalid-feedback"><?php echo $platelet_err; ?></span>
                                                    </div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="form-group">
                                                    <label>Result Impression</label>
                                                    <textarea name="result_impression"
                                                        class="form-control <?php echo (!empty($result_impression_err)) ? 'is-invalid' : ''; ?>"
                                                        placeholder="Please enter result impression."
                                                        style="width: 100%; height: 200px; resize: vertical;"><?php echo $result_impression; ?></textarea>
                                                    <span class="invalid-feedback"><?php echo $result_impression_err; ?></span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-lg btn-primary" type="submit" name="submit">Create Result</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
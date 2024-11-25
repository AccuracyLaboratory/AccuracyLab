<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM staff WHERE staff_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $service = $row['staff_role'];
    $active = "patientresult";
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
            $fbs = $cholesterol = $triglycerides = $hdl = $ldl = $uric_acid = $creatinine = $bun = $sgot_ast = $sgpt_alt = $na = $k = $cl = "";
            $fbs_err = $cholesterol_err = $triglycerides_err = $hdl_err = $ldl_err = $uric_acid_err = $creatinine_err = $bun_err = $sgot_ast_err = $sgpt_alt_err = $na_err = $k_err = $cl_err = "";
            $color = $transparency = $ph_reaction = $specific_gravity = $albumin = $sugar = $consistency = $wbc = $rbc = $hematocrit = $hemoglobin = $granulocytes = $lymphocytes = $mid = $platelet = "";
            $color_err = $transparency_err = $ph_reaction_err = $specific_gravity_err = $albumin_err = $sugar_err = $consistency_err = $wbc_err = $rbc_err = $hematocrit_err = $hemoglobin_err = $granulocytes_err = $lymphocytes_err = $mid_err = $platelet_err = "";
            $result_impression = $result_impression_err = "";
            $result = 1;

            if (isset($_POST["submit"])) {
                $appointment_id = $_POST['appointment_id'];
                $user_id = $_POST['user_id'];
                $subservice = mysqli_real_escape_string($link, trim($_POST["subservice"]));
                $service = mysqli_real_escape_string($link, trim($_POST["service"]));


                if ($service == "Laboratory") {
                    if ($subservice == "Chem 6") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["sgpt_alt"]))) {
                            $sgpt_alt_err = "Please select a SGPT/APT.";
                        } else {
                            $sgpt_alt = mysqli_real_escape_string($link, $_POST["sgpt_alt"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($sgpt_alt_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, sgpt_alt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iissssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_sgpt_alt);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_sgpt_alt = $sgpt_alt;
                            }
                        }
                    } elseif ($subservice == "Chem 7") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["hdl"]))) {
                            $hdl_err = "Please select a HDL.";
                        } else {
                            $hdl = mysqli_real_escape_string($link, $_POST["hdl"]);
                        }

                        if (empty(trim($_POST["ldl"]))) {
                            $ldl_err = "Please select a LDL.";
                        } else {
                            $ldl = mysqli_real_escape_string($link, $_POST["ldl"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($hdl_err) && empty($ldl_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, hdl, ldl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iisssssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_hdl, $param_ldl);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_hdl = $hdl;
                                $param_ldl = $ldl;
                            }
                        }
                    } elseif ($subservice == "Chem 8") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["sgpt_alt"]))) {
                            $sgpt_alt_err = "Please select a SGPT/APT.";
                        } else {
                            $sgpt_alt = mysqli_real_escape_string($link, $_POST["sgpt_alt"]);
                        }

                        if (empty(trim($_POST["hdl"]))) {
                            $hdl_err = "Please select a HDL.";
                        } else {
                            $hdl = mysqli_real_escape_string($link, $_POST["hdl"]);
                        }

                        if (empty(trim($_POST["ldl"]))) {
                            $ldl_err = "Please select a LDL.";
                        } else {
                            $ldl = mysqli_real_escape_string($link, $_POST["ldl"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($sgpt_alt_err) && empty($hdl_err) && empty($ldl_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, hdl, ldl, sgpt_alt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iissssssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_hdl, $param_ldl, $param_sgpt_alt);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_hdl = $hdl;
                                $param_ldl = $ldl;
                                $param_sgpt_alt = $sgpt_alt;
                            }
                        }
                    } elseif ($subservice == "Chem 9") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["sgpt_alt"]))) {
                            $sgpt_alt_err = "Please select a SGPT/APT.";
                        } else {
                            $sgpt_alt = mysqli_real_escape_string($link, $_POST["sgpt_alt"]);
                        }

                        if (empty(trim($_POST["hdl"]))) {
                            $hdl_err = "Please select a HDL.";
                        } else {
                            $hdl = mysqli_real_escape_string($link, $_POST["hdl"]);
                        }

                        if (empty(trim($_POST["ldl"]))) {
                            $ldl_err = "Please select a LDL.";
                        } else {
                            $ldl = mysqli_real_escape_string($link, $_POST["ldl"]);
                        }

                        if (empty(trim($_POST["sgot_ast"]))) {
                            $sgot_ast_err = "Please select a SGOT/AST.";
                        } else {
                            $sgot_ast = mysqli_real_escape_string($link, $_POST["sgot_ast"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($sgpt_alt_err) && empty($hdl_err) && empty($ldl_err) && empty($sgot_ast_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, hdl, ldl, sgpt_alt, sgot_ast) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iisssssssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_hdl, $param_ldl, $param_sgpt_alt, $param_sgot_ast);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_hdl = $hdl;
                                $param_ldl = $ldl;
                                $param_sgpt_alt = $sgpt_alt;
                                $param_sgot_ast = $sgot_ast;
                            }
                        }
                    } elseif ($subservice == "Chem 10") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["sgpt_alt"]))) {
                            $sgpt_alt_err = "Please select a SGPT/APT.";
                        } else {
                            $sgpt_alt = mysqli_real_escape_string($link, $_POST["sgpt_alt"]);
                        }

                        if (empty(trim($_POST["hdl"]))) {
                            $hdl_err = "Please select a HDL.";
                        } else {
                            $hdl = mysqli_real_escape_string($link, $_POST["hdl"]);
                        }

                        if (empty(trim($_POST["ldl"]))) {
                            $ldl_err = "Please select a LDL.";
                        } else {
                            $ldl = mysqli_real_escape_string($link, $_POST["ldl"]);
                        }

                        if (empty(trim($_POST["sgot_ast"]))) {
                            $sgot_ast_err = "Please select a SGOT/AST.";
                        } else {
                            $sgot_ast = mysqli_real_escape_string($link, $_POST["sgot_ast"]);
                        }

                        if (empty(trim($_POST["bun"]))) {
                            $bun_err = "Please select a BUN.";
                        } else {
                            $bun = mysqli_real_escape_string($link, $_POST["bun"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($sgpt_alt_err) && empty($hdl_err) && empty($ldl_err) && empty($sgot_ast_err) && empty($bun_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, hdl, ldl, sgpt_alt, sgot_ast, bun) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iissssssssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_hdl, $param_ldl, $param_sgpt_alt, $param_sgot_ast, $param_bun);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_hdl = $hdl;
                                $param_ldl = $ldl;
                                $param_sgpt_alt = $sgpt_alt;
                                $param_sgot_ast = $sgot_ast;
                                $param_bun = $bun;
                            }
                        }
                    } elseif ($subservice == "Chem 13") {
                        if (empty(trim($_POST["fbs"]))) {
                            $fbs_err = "Please select a fbs.";
                        } else {
                            $fbs = mysqli_real_escape_string($link, $_POST["fbs"]);
                        }

                        if (empty(trim($_POST["cholesterol"]))) {
                            $cholesterol_err = "Please select a cholesterol.";
                        } else {
                            $cholesterol = mysqli_real_escape_string($link, $_POST["cholesterol"]);
                        }

                        if (empty(trim($_POST["triglycerides"]))) {
                            $triglycerides_err = "Please select a triglycerides.";
                        } else {
                            $triglycerides = mysqli_real_escape_string($link, $_POST["triglycerides"]);
                        }

                        if (empty(trim($_POST["uric_acid"]))) {
                            $uric_acid_err = "Please select a uric_acid.";
                        } else {
                            $uric_acid = mysqli_real_escape_string($link, $_POST["uric_acid"]);
                        }

                        if (empty(trim($_POST["creatinine"]))) {
                            $creatinine_err = "Please select a creatinine.";
                        } else {
                            $creatinine = mysqli_real_escape_string($link, $_POST["creatinine"]);
                        }

                        if (empty(trim($_POST["sgpt_alt"]))) {
                            $sgpt_alt_err = "Please select a SGPT/APT.";
                        } else {
                            $sgpt_alt = mysqli_real_escape_string($link, $_POST["sgpt_alt"]);
                        }

                        if (empty(trim($_POST["hdl"]))) {
                            $hdl_err = "Please select a HDL.";
                        } else {
                            $hdl = mysqli_real_escape_string($link, $_POST["hdl"]);
                        }

                        if (empty(trim($_POST["ldl"]))) {
                            $ldl_err = "Please select a LDL.";
                        } else {
                            $ldl = mysqli_real_escape_string($link, $_POST["ldl"]);
                        }

                        if (empty(trim($_POST["sgot_ast"]))) {
                            $sgot_ast_err = "Please select a SGOT/AST.";
                        } else {
                            $sgot_ast = mysqli_real_escape_string($link, $_POST["sgot_ast"]);
                        }

                        if (empty(trim($_POST["bun"]))) {
                            $bun_err = "Please select a BUN.";
                        } else {
                            $bun = mysqli_real_escape_string($link, $_POST["bun"]);
                        }

                        if (empty(trim($_POST["na"]))) {
                            $na_err = "Please select a NA.";
                        } else {
                            $na = mysqli_real_escape_string($link, $_POST["na"]);
                        }

                        if (empty(trim($_POST["k"]))) {
                            $k_err = "Please select a K.";
                        } else {
                            $k = mysqli_real_escape_string($link, $_POST["k"]);
                        }

                        if (empty(trim($_POST["cl"]))) {
                            $cl_err = "Please select a CL.";
                        } else {
                            $cl = mysqli_real_escape_string($link, $_POST["cl"]);
                        }

                        if (empty($fbs_err) && empty($cholesterol_err) && empty($triglycerides_err) && empty($uric_acid_err) && empty($creatinine_err) && empty($sgpt_alt_err) && empty($hdl_err) && empty($ldl_err) && empty($sgot_ast_err) && empty($bun_err) && empty($na_err) && empty($k_err) && empty($cl_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, fbs, cholesterol, triglycerides, uric_acid, creatinine, hdl, ldl, sgpt_alt, sgot_ast, bun, na, k, cl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "iisssssssssssssss", $param_appointment_id, $param_user_id, $param_service, $param_subservice, $param_fbs, $param_cholesterol, $param_triglycerides, $param_uric_acid, $param_creatinine, $param_hdl, $param_ldl, $param_sgpt_alt, $param_sgot_ast, $param_bun, $param_na, $param_k, $param_cl);

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_fbs = $fbs;
                                $param_cholesterol = $cholesterol;
                                $param_triglycerides = $triglycerides;
                                $param_uric_acid = $uric_acid;
                                $param_creatinine = $creatinine;
                                $param_hdl = $hdl;
                                $param_ldl = $ldl;
                                $param_sgpt_alt = $sgpt_alt;
                                $param_sgot_ast = $sgot_ast;
                                $param_bun = $bun;
                                $param_na = $na;
                                $param_k = $k;
                                $param_cl = $cl;
                            }
                        }
                    } elseif ($subservice == "Urinalysis") {
                        if (empty(trim($_POST["color"]))) {
                            $color_err = "Please select a color.";
                        } else {
                            $color = mysqli_real_escape_string($link, $_POST["color"]);
                        }

                        if (empty(trim($_POST["consistency"]))) {
                            $consistency_err = "Please enter consistency.";
                        } else {
                            $consistency = mysqli_real_escape_string($link, $_POST["consistency"]);
                        }

                        if (empty(trim($_POST["ph_reaction"]))) {
                            $ph_reaction_err = "Please enter pH reaction.";
                        } else {
                            $ph_reaction = mysqli_real_escape_string($link, $_POST["ph_reaction"]);
                        }

                        if (empty(trim($_POST["specific_gravity"]))) {
                            $specific_gravity_err = "Please enter specific gravity.";
                        } else {
                            $specific_gravity = mysqli_real_escape_string($link, $_POST["specific_gravity"]);
                        }

                        if (empty(trim($_POST["albumin"]))) {
                            $albumin_err = "Please enter albumin.";
                        } else {
                            $albumin = mysqli_real_escape_string($link, $_POST["albumin"]);
                        }

                        if (empty(trim($_POST["sugar"]))) {
                            $sugar_err = "Please enter sugar.";
                        } else {
                            $sugar = mysqli_real_escape_string($link, $_POST["sugar"]);
                        }

                        if (empty($color_err) && empty($consistency_err) && empty($ph_reaction_err) && empty($specific_gravity_err) && empty($albumin_err) && empty($sugar_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, color, consistency, ph_reaction, specific_gravity, albumin, sugar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param(
                                    $stmt,
                                    "iissssssss",
                                    $param_appointment_id,
                                    $param_user_id,
                                    $param_service,
                                    $param_subservice,
                                    $param_color,
                                    $param_consistency,
                                    $param_ph_reaction,
                                    $param_specific_gravity,
                                    $param_albumin,
                                    $param_sugar
                                );

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_color = $color;
                                $param_consistency = $consistency;
                                $param_ph_reaction = $ph_reaction;
                                $param_specific_gravity = $specific_gravity;
                                $param_albumin = $albumin;
                                $param_sugar = $sugar;
                            }
                        }
                    } elseif ($subservice == "Fecalysis") {
                        if (empty(trim($_POST["color"]))) {
                            $color_err = "Please select a color.";
                        } else {
                            $color = mysqli_real_escape_string($link, $_POST["color"]);
                        }

                        if (empty(trim($_POST["consistency"]))) {
                            $consistency_err = "Please enter consistency.";
                        } else {
                            $consistency = mysqli_real_escape_string($link, $_POST["consistency"]);
                        }

                        if (empty($color_err) && empty($consistency_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, color, transparency) VALUES (?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param(
                                    $stmt,
                                    "iissss",
                                    $param_appointment_id,
                                    $param_user_id,
                                    $param_service,
                                    $param_subservice,
                                    $param_color,
                                    $param_consistency,
                                );

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_color = $color;
                                $param_consistency = $consistency;
                            }
                        }
                    } elseif ($subservice == "Complete Blood Count") {
                        if (empty(trim($_POST["wbc"]))) {
                            $wbc_err = "Please enter WBC count.";
                        } else {
                            $wbc = mysqli_real_escape_string($link, $_POST["wbc"]);
                        }

                        if (empty(trim($_POST["rbc"]))) {
                            $rbc_err = "Please enter RBC count.";
                        } else {
                            $rbc = mysqli_real_escape_string($link, $_POST["rbc"]);
                        }

                        if (empty(trim($_POST["hematocrit"]))) {
                            $hematocrit_err = "Please enter hematocrit.";
                        } else {
                            $hematocrit = mysqli_real_escape_string($link, $_POST["hematocrit"]);
                        }

                        if (empty(trim($_POST["hemoglobin"]))) {
                            $hemoglobin_err = "Please enter hemoglobin.";
                        } else {
                            $hemoglobin = mysqli_real_escape_string($link, $_POST["hemoglobin"]);
                        }

                        if (empty(trim($_POST["granulocytes"]))) {
                            $granulocytes_err = "Please enter granulocytes.";
                        } else {
                            $granulocytes = mysqli_real_escape_string($link, $_POST["granulocytes"]);
                        }

                        if (empty(trim($_POST["lymphocytes"]))) {
                            $lymphocytes_err = "Please enter lymphocytes.";
                        } else {
                            $lymphocytes = mysqli_real_escape_string($link, $_POST["lymphocytes"]);
                        }

                        if (empty(trim($_POST["mid"]))) {
                            $mid_err = "Please enter MID.";
                        } else {
                            $mid = mysqli_real_escape_string($link, $_POST["mid"]);
                        }

                        if (empty(trim($_POST["platelet"]))) {
                            $platelet_err = "Please enter platelet count.";
                        } else {
                            $platelet = mysqli_real_escape_string($link, $_POST["platelet"]);
                        }

                        if (empty($wbc_err) && empty($rbc_err) && empty($hematocrit_err) && empty($hemoglobin_err) && empty($granulocytes_err) && empty($lymphocytes_err) && empty($mid_err) && empty($platelet_err)) {
                            $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, wbc, rbc, hematocrit, hemoglobin, granulocytes, lymphocytes, mid, platelet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param(
                                    $stmt,
                                    "iissssssssss",
                                    $param_appointment_id,
                                    $param_user_id,
                                    $param_service,
                                    $param_subservice,
                                    $param_color,
                                    $param_wbc,
                                    $param_rbc,
                                    $param_hematocrit,
                                    $param_hemoglobin,
                                    $param_granulocytes,
                                    $param_lymphocytes,
                                    $param_mid,
                                    $param_platelet
                                );

                                $param_appointment_id = $appointment_id;
                                $param_user_id = $user_id;
                                $param_service = $service;
                                $param_subservice = $subservice;
                                $param_wbc = $wbc;
                                $param_rbc = $rbc;
                                $param_hematocrit = $hematocrit;
                                $param_hemoglobin = $hemoglobin;
                                $param_granulocytes = $granulocytes;
                                $param_lymphocytes = $lymphocytes;
                                $param_mid = $mid;
                                $param_platelet = $platelet;
                            }
                        }
                    }
                } else {
                    if (empty(trim($_POST["result_impression"]))) {
                        $result_impression_err = "Please enter result impression.";
                    } else {
                        $result_impression = mysqli_real_escape_string($link, $_POST["result_impression"]);
                    }

                    if (empty($result_impression_err)) {
                        $sql = "INSERT INTO patient_records (appointment_id, user_id, service, subservice, result_impression) VALUES (?, ?, ?, ?, ?)";

                        if ($stmt = mysqli_prepare($link, $sql)) {
                            mysqli_stmt_bind_param(
                                $stmt,
                                "iisss",
                                $param_appointment_id,
                                $param_user_id,
                                $param_service,
                                $param_subservice,
                                $param_result_impression,
                            );

                            $param_appointment_id = $appointment_id;
                            $param_user_id = $user_id;
                            $param_service = $service;
                            $param_subservice = $subservice;
                            $param_result_impression = $result_impression;
                        }
                    }
                }

                if (mysqli_stmt_execute($stmt)) {

                    $sql6 = "UPDATE appointments SET result=? WHERE appointment_id=?";
                    $stmt6 = mysqli_prepare($link, $sql6);

                    mysqli_stmt_bind_param($stmt6, 'ii', $result, $appointment_id);

                    if (mysqli_stmt_execute($stmt6)) {
                        echo "<script>swal({
                                title: 'Success!',
                                text: 'Patient Record Created Successful!',
                                icon: 'success',
                                closeOnClickOutside: false,
                                button: false
                            });</script>";

            ?>
                        <meta http-equiv="Refresh" content="6; url=staff-input-patient-result">
            <?php
                    }
                } else {
                    echo "<script>swal({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'warning',
                        button: 'Ok',
                    });</script>";
                }

                mysqli_stmt_close($stmt);
            }
            ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Appointments</h4>
                            <p class="card-description">
                                <?php echo $service; ?> appointment list.
                            </p>
                            <div class="table-responsive">
                                <table id="appointmentTable" class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Appointment ID</th>
                                            <th>Patient Name</th>
                                            <th>Mobile Number</th>
                                            <th>Appointment Date</th>
                                            <?php if ($service == "Laboratory") {
                                                echo '<th>Type of Test</th>';
                                            } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql1 = "SELECT * FROM appointments WHERE service='$service' AND status=1";
                                        $r = mysqli_query($link, $sql1);


                                        if ($r->num_rows > 0) {
                                            while ($row1 = mysqli_fetch_assoc($r)) {
                                                $user_id = $row1['user_id'];
                                                $sql3 = "SELECT * FROM users WHERE user_id = $user_id";
                                                $result3 = mysqli_query($link, $sql3);
                                                $row3 = mysqli_fetch_assoc($result3);
                                        ?>
                                                <tr class="text-center">
                                                    <td><?php echo $row1['appointment_id']; ?></td>
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

                                                    <?php if ($service == "Laboratory") {
                                                        echo '<td>' . $row1['subservice'] . '</td>';
                                                    } ?>

                                                    <td>
                                                        <?php
                                                        if ($row1['result'] == 0) {
                                                        ?>
                                                            <div class="d-inline">
                                                                <a class="ml-1 action-icon" href="#" data-toggle="modal"
                                                                    type="button" data-target="#create-result-<?php echo $row1['appointment_id'] ?>">
                                                                    <i class="ti-pencil"></i> Input Result
                                                                </a>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="d-inline">
                                                                <a class="ml-1 action-icon" href="#">
                                                                    <i class="ti-check"></i> Done
                                                                </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php

                                                include 'create-result.php';
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

        .account-settings .user-profile {
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            text-align: center;
        }

        .account-settings .user-profile .user-avatar {
            margin: 0 0 1rem 0;
        }

        .account-settings .user-profile .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .account-settings .user-profile h5.user-name {
            margin: 0 0 0.5rem 0;
        }

        .account-settings .user-profile h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .account-settings .about {
            text-align: center;
        }

        .account-settings .about h5 {
            color: #007ae1;
        }

        .account-settings .about p {
            font-size: 0.825rem;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#appointmentTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 10
            });
        });
    </script>
</body>

</html>
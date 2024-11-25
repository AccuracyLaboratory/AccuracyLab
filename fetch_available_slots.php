<?php
require_once "connectDB.php";

if (isset($_POST['date'])) {
    $selected_date = $_POST['date'];

    $query = "SELECT datetime FROM appointments WHERE DATE(datetime) = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $selected_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $booked_times = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $time = date('H:i:s', strtotime($row['datetime']));
        $booked_times[] = $time;
    }

    $valid_times = [
        "09:00:00", "09:30:00", "10:00:00", "10:30:00", "11:00:00", "11:30:00",
        "13:00:00", "13:30:00", "14:00:00", "14:30:00", "15:00:00", "15:30:00"
    ];

    $available_times = array_diff($valid_times, $booked_times);

    $options_html = '<div class="mb-4">';
    $options_html .= '<p class="mb-3 font-weight-bold">Available Time Slots</p>';
    $options_html .= '<hr class="mb-4">';
    $options_html .= '<div class="row">';

    foreach ($available_times as $time) {
        $formatted_time = date('h:i A', strtotime($time));
        $options_html .= '<div class="col-md-4 mb-3">
                            <input type="button" class="form-control time-slot" value="' . $formatted_time . '" readonly />
                          </div>';
    }

    $options_html .= '</div>';
    $options_html .= '</div>';

    echo $options_html;

} else {
    echo 'Please select a date first';
}
?>

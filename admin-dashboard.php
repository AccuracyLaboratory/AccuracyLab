<?php
session_start();

require_once "connectDB.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM admins WHERE admin_id = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $active = "dashboard";
} else {
    header("location: admin-login");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/header.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container-scroller">
        <?php include "partials/admin-heading.php"; ?>
        <div class="container-fluid page-body-wrapper">

            <?php include "partials/admin-navbar.php"; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Today's Most Chosen Services</strong></h2>
                                    <p class="card-description">

                                    </p>
                                    <canvas id="myPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><strong>Total Patient Appointments</strong></h2>
                                    <p class="card-description">

                                    </p>
                                    <canvas id="myBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2 class="card-title"><strong>Yearly Services Ranking</strong></h2>
                                        </div>
                                        <div class="col-md-6 d-inline-flex align-items-center justify-content-end">
                                            <label for="yearFilter" class="me-2">Select Year:</label>
                                            <select id="yearFilter" class="form-control" style="width: 100px;" onchange="updateChart()"></select>
                                        </div>


                                        <canvas id="myLineChart" width="400" height="200"></canvas>
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

    <script>
        async function fetchAppointmentData() {
            const response = await fetch('fetch-services.php');
            const data = await response.json();
            return data;
        }

        fetchAppointmentData().then(data => {
            const ctx = document.getElementById('myPieChart').getContext('2d');

            const hasData = data.services && data.services.length > 0;

            const chartData = {
                labels: hasData ? data.services : ['No Transactions'],
                datasets: [{
                    label: hasData ? 'Service Counts' : 'No Data Available',
                    data: hasData ? data.counts : [1],
                    backgroundColor: hasData ? [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ] : ['rgba(200, 200, 200, 0.2)'],
                    borderColor: hasData ? [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ] : ['rgba(150, 150, 150, 1)'],
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: hasData ? 'Services in Appointments' : 'No Services Transactions Today'
                        }
                    }
                }
            });
        });
    </script>

    <script>
        async function fetchOldNewAppointmentsData() {
            try {
                const response = await fetch('fetch-appointment.php');
                const data = await response.json();
                return data;
            } catch (error) {
                console.error("Error fetching appointment data:", error);
            }
        }

        fetchOldNewAppointmentsData().then(data => {
            if (data) {
                const ctx = document.getElementById('myBarChart').getContext('2d');

                const myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['New Appointments', 'Old Appointments'],
                        datasets: [{
                            label: 'Appointment Counts',
                            data: [data.new, data.old],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'New vs Old Appointments'
                            }
                        }
                    }
                });
            } else {
                console.log('No appointment data available.');
            }
        }).catch(error => {
            console.error("Error rendering bar chart:", error);
        });
    </script>

    <script>
        function populateYearOptions() {
            const currentYear = new Date().getFullYear();
            const yearFilter = document.getElementById('yearFilter');
            yearFilter.innerHTML = '';
            for (let year = currentYear; year >= 2000; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearFilter.appendChild(option);
            }
        }

        async function fetchAppointmentsData(year) {
            try {
                const response = await fetch(`fetch-yearly-appointment.php?year=${year}`);
                const data = await response.json();
                console.log("Fetched data:", data);
                return data;
            } catch (error) {
                console.error("Error fetching appointment data:", error);
            }
        }

        let myLineChart;

        async function updateChart() {
            const selectedYear = document.getElementById('yearFilter').value;
            const data = await fetchAppointmentsData(selectedYear);

            if (data) {
                const ctx = document.getElementById('myLineChart').getContext('2d');

                if (myLineChart) {
                    myLineChart.destroy();
                }

                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const datasets = [];

                for (const service in data) {
                    const serviceCounts = data[service];

                    datasets.push({
                        label: service,
                        data: serviceCounts,
                        borderColor: getRandomColor(),
                        fill: false,
                        tension: 0.1
                    });
                }

                myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: `Appointments Per Service for ${selectedYear}`
                            }
                        }
                    }
                });
            } else {
                console.log('No appointment data available.');
            }
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        window.onload = () => {
            populateYearOptions();
            updateChart();
        };
    </script>

</body>

</html>
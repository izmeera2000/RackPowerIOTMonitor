<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php include('functions.php');
if (!isset($_SESSION['username'])) {
  // $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
?>

<?php $pagetitle = "log"; ?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php') ?>


<body class="g-sidenav-show  bg-gray-100">
  <?php include('sidenav.php') ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include('topnav.php') ?>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-11">
          <div class="card ">
            <div class="card-header ">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Data Incoming</h6>
                  <p class="text-sm mb-0">
                    <!-- <i class="fa fa-check text-info" aria-hidden="true"></i> -->
                    <!-- <span class="font-weight-bold ms-1">30 done</span> this month -->
                  </p>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                  <div class="dropdown float-lg-end pe-4">
                    <!-- <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-ellipsis-v text-secondary"></i>
                    </a> -->
                    <form method="post">
                      <?php if (isset($_SESSION["time1"])) { ?>
                      <button type="submit" class="btn btn-block btn-default" name="pdf"><i
                          class="fa fa-file-pdf-o text-primary"></i></button>

                       <?php }   ?>
                      <button type="button" class="btn btn-block btn-default mb-3" data-bs-toggle="modal"
                        data-bs-target="#modal-form"><i class="fa fa-cog text-primary"></i></button>
                    </form>


                    <!-- <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                      <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal"
                          data-bs-target="#modal-form">Tarikh</a></li> -->
                    <!-- <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li> -->
                    <!-- <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li> -->
                    <!-- </ul> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body ">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <div>
      <!-- <button type="button" class="btn btn-block btn-default mb-3" >Form</button> -->
      <form role="form text-center" method="post" action="">

        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body p-0">
                <div class="card card-plain">
                  <div class="card-header pb-0 text-left">
                    <h3 class="font-weight-bolder text-info text-gradient">Tarikh</h3>
                    <p class="mb-0">Sila masukkan tarikh</p>
                  </div>
                  <div class="card-body">
                    <!-- <label>Email</label>
                    <div class="input-group mb-3">
                      <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                        aria-describedby="email-addon">
                    </div> -->
                    <label for="example-datetime-local-input">Tarikh & Masa Mula</label>
                    <div class="input-group mb-3 ">
                      <input class="form-control" type="datetime-local" id="example-datetime-local-input" name="time1">
                    </div>
                    <label for="example-datetime-local-input2">Tarikh & Masa Tamat</label>
                    <div class="input-group mb-3">
                      <input class="form-control" type="datetime-local" id="example-datetime-local-input2" name="time2">
                    </div>
                    <!-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div> -->
                    <div class="row text-center">
                      <div class="col text-center">
                        
                      <button type="submit" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0"
                          name="resetmasa">Reset</button>
                      </div>

                      <div class="col text-center">

                        <button type="submit" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0"
                          name="setmasa">Simpan</button>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>

    </div>
    <?php include('footer.php') ?>
    </div>
  </main>
  <?php include('corejs.php') ?>
  <script>
    log_device();
    function log_device() {
      function replay() {
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "functions.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


        xhttp.onload = function () {
          var data = JSON.parse(this.responseText);
          // console.log(this.responseText);
          if (data.length !== 0) {
            const labelsc = [];
            const value1 = [];
            const value2 = [];
            const value3 = [];
            const value4 = [];
            const value5 = [];
            for (var i = 0; i < data.length; i++) {
              labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
              value1.push(data[i]["device"]);
              value2.push(data[i]["temp"]);
              value3.push(data[i]["v1"]);
              value4.push(data[i]["v2"]);
              value5.push(data[i]["battery"]);
            }

            chart2.data.labels = labelsc;
            chart2.data.datasets[0].data = value3;
            chart2.data.datasets[1].data = value4;
            chart2.data.datasets[2].data = value2;
            chart2.update();


          }
        };
        xhttp.send("receivedatalog=receivedatalog");
      }


      var ctx2 = document.getElementById("chart-line").getContext("2d");
      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      const chart2 = new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Voltage In(V)",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,

            maxBarThickness: 6

          },
          {
            label: "Voltage Out(V)",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,

            maxBarThickness: 6
          },
          {
            label: "Suhu(°C)",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#fbcf33",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,

            maxBarThickness: 6
          },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: true,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });

      setInterval(replay, 1000);

    }



  </script>

</body>

</html>
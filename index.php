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
<?php
include('functions.php');


  if (!isset($_SESSION['username'])) {
    header('location: login.php');

  }
?>

<?php $pagetitle = "dashboard" ?>
<!DOCTYPE html>
<html lang="en">
<!-- <?php echo $pagetitle; ?> -->

<?php include('head.php') ?>


<body class="g-sidenav-show  bg-gray-100">
  <?php include('sidenav.php') ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include('topnav.php') ?>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Voltage In</p>
                    <h5 class="font-weight-bolder mb-0" id="v1">
                      0 V
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="bi bi-lightning-fill text-lg opacity-10" aria-hidden="true"></i><i
                      class="bi bi-arrow-bar-left text-lg opacity-10"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Voltage Out</p>
                    <h5 class="font-weight-bolder mb-0" id="v2">
                      0 V
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="bi bi-lightning-fill text-lg opacity-10" aria-hidden="true"></i><i
                      class="bi bi-arrow-bar-right text-lg opacity-10"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="row mt-4">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-flex flex-column h-100">
                    <!-- <p class="mb-1 pt-2 text-bold">Built by developers</p> -->
                    <div class="row">
                      <div class="col-8">

                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Suhu</p>
                        <h5 class="font-weight-bolder" id="temp">
                          0 &deg;C
                        </h5>
                      </div>
                      <div class="col-4">

                        <div class=" text-end">
                          <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="bi bi-thermometer-half text-lg opacity-10" aria-hidden="true"></i>
                          </div>
                        </div>
                      </div>
                    </div>



                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-flex flex-column h-100">
                    <!-- <p class="mb-1 pt-2 text-bold">Built by developers</p> -->
                    <div class="row">
                      <div class="col-8">

                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Battery Level</p>
                        <h5 class="font-weight-bolder" id="battery">
                          0%
                        </h5>
                      </div>
                      <div class="col-4">

                        <div class=" text-end">
                          <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="bi bi-lightning-charge text-lg opacity-10" aria-hidden="true"
                              id="battery-icon"></i>
                          </div>
                        </div>
                      </div>
                    </div>



                    <div class="progress-wrapper">
                      <div class="progress-info">
                        <div class="progress-percentage">
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-primary " role="progressbar" aria-valuenow="60"
                          aria-valuemin="0" aria-valuemax="100" style="" id="battery-bar"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <?php include('footer.php') ?>
      </div>
  </main>
  <?php include('corejs.php') ?>
  <script>
    var run = setInterval(replay, 1000)
    var run2 = setInterval(replay2, 10000)


  </script>

</body>

</html>
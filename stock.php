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

<?php $pagetitle = "stock"; ?>

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
                <?php
                $query = "SELECT * FROM data  ORDER BY id DESC LIMIT  1";
                $result = mysqli_query($db, $query);

                $data = array();
                while ($row = $result->fetch_assoc()) {
                  // $data[] = $row;
                  $stock1 = $row['v1'];
                  $stock2 = $row['v2'];
                }
                // echo json_encode($data);
                ?>
         
              </div>
              <div class="card-body ">
                <!-- <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div> -->
              <div class="col">
                  <h6>Manage Stock</h6>

                  <div class="row">
                    <div class="col-md-6 mb-md-0 mb-4">
                      <h3 class="mb-2">Stock 1 </h3>

                      <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                        <!-- <img class="w-10 me-3 mb-0" src="assets/img/logos/mastercard.png" alt="logo"> -->
                        <i class="bi bi-basket w-10 me-3 mb-0"></i>

                        <h6 class="mb-0 text-center">
                          <?php echo $stock1 ?>
                        </h6>
                        <button class="btn btn-block ms-auto text-dark cursor-pointer" data-bs-toggle="modal"
                          data-bs-target="#exampleModal" type="button">
                          <i class="fas fa-pencil-alt ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Edit Stock 1"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <h3 class="mb-2">Stock 2 </h3>


                      <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                        <!-- <img class="w-10 me-3 mb-0" src="assets/img/logos/visa.png" alt="logo"> -->
                        <i class="bi bi-basket2 w-10 me-3 mb-0"></i>

                        <h6 class="mb-0 text-center">
                          <?php echo $stock2 ?>
                        </h6>
                        <button class="btn btn-block ms-auto text-dark cursor-pointer" data-bs-toggle="modal"
                          data-bs-target="#exampleModal2" type="button">
                          <i class="fas fa-pencil-alt ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Edit Stock 2"></i>
                        </button>

                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form method="post">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Stock 1</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="example-number-input" class="form-control-label">Total</label>
                  <input class="form-control" type="number" value="<?php echo $stock1 ?>" id="example-number-input" name="val1">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary" name="edit1">Save changes</button>
              </div>
            </div>
          </form>

        </div>
      </div>
      <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form method="post">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Stock 2</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="example-number-input" class="form-control-label">Total</label>
                  <input class="form-control" type="number" value="<?php echo $stock2 ?>" id="example-number-input" name="val2">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary" name="edit1">Save changes</button>
              </div>
            </div>
          </form>

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
                        <input class="form-control" type="datetime-local" id="example-datetime-local-input"
                          name="time1">
                      </div>
                      <label for="example-datetime-local-input2">Tarikh & Masa Tamat</label>
                      <div class="input-group mb-3">
                        <input class="form-control" type="datetime-local" id="example-datetime-local-input2"
                          name="time2">
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

</body>

</html>
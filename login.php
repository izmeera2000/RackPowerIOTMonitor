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
// if (!isset($_SESSION['username'])) {
//   // $_SESSION['msg'] = "You must log in first";
//   header('location: lamanutama.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<?php include('head.php') ?>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <!-- <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">
              Soft UI Dashboard
            </a> -->
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                <!-- <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../pages/dashboard.html">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Dashboard
                  </a>
                </li> -->
                <!-- <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/profile.html">
                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                    Profile
                  </a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link me-2" href="register.php">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Register
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="login.php">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Login
                  </a>
                </li>
              </ul>
              <!-- <li class="nav-item d-flex align-items-center">
                <a class="btn btn-round btn-sm mb-0 btn-outline-primary me-2" target="_blank" href="https://www.creative-tim.com/builder?ref=navbar-soft-ui-dashboard">Online Builder</a>
              </li> -->
              <!-- <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/product/soft-ui-dashboard" class="btn btn-sm btn-round mb-0 me-1 bg-gradient-dark">Free download</a>
                </li>
              </ul> -->
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                  <p class="mb-0">Enter your username and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" method="post">
                    <label>Username</label>
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="username-addon">
                    </div>
                    <label>Password</label>
                    <div class="mb-4">
                      <input type="password"name="password"  class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    <!-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div> -->
                    <div class="text-center">
                      <button type="submit" name="login" class="btn bg-gradient-info w-100 mt-4 mb-0">Login</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="register.php" class="text-info text-gradient font-weight-bold">Register</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved-11.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->

  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <?php include('corejs.php') ?>
</body>

</html>
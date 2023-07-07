<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 300px;
            padding: 5px;
        }
        .btn2 {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
    <link href="Cust_Profile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
</head>
<body>
    <?php
    $conn = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

    if (!$conn) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    $owner_id = '';

    $query = "SELECT user_id FROM temp WHERE id = 1";
    $statement = oci_parse($conn, $query);
    oci_execute($statement);

    if ($row = oci_fetch_assoc($statement)) {
        $owner_id = $row['USER_ID'];
    }

    $sql = "SELECT owner_name, owner_email, owner_city, owner_zipcode, owner_street, owner_house_no FROM owner WHERE owner_id = :owner_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':owner_id', $owner_id);
    oci_execute($stmt);


    if ($row = oci_fetch_assoc($stmt)) {
        $owner_name = $row["OWNER_NAME"];
        $owner_email = $row["OWNER_EMAIL"];
        $owner_city = $row["OWNER_CITY"];
        $owner_postal_code = $row["OWNER_ZIPCODE"];
        $owner_street = $row["OWNER_STREET"];
        $owner_house_no = $row["OWNER_HOUSE_NO"];
    } else {
        echo "No owner found.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $updated_owner_name = $_POST["owner_name"];
        $updated_owner_email = $_POST["owner_email"];
        $updated_owner_city = $_POST["owner_city"];
        $updated_owner_postal_code = $_POST["owner_postal_code"];
        $updated_owner_street = $_POST["owner_street"];
        $updated_owner_house_no = $_POST["owner_house_no"];

        $sql = "UPDATE owner SET owner_name = :updated_owner_name, owner_email = :updated_owner_email, owner_city = :updated_owner_city, owner_zipcode = :updated_owner_postal_code, owner_street = :updated_owner_street, owner_house_no = :updated_owner_house_no WHERE owner_id = :owner_id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':updated_owner_name', $updated_owner_name);
        oci_bind_by_name($stmt, ':updated_owner_email', $updated_owner_email);
        oci_bind_by_name($stmt, ':updated_owner_city', $updated_owner_city);
        oci_bind_by_name($stmt, ':updated_owner_postal_code', $updated_owner_postal_code);
        oci_bind_by_name($stmt, ':updated_owner_street', $updated_owner_street);
        oci_bind_by_name($stmt, ':updated_owner_house_no', $updated_owner_house_no);
        oci_bind_by_name($stmt, ':owner_id', $owner_id);
        oci_execute($stmt);

        if (oci_num_rows($stmt) > 0) {
            //echo "<p>owner information updated successfully!</p>";
        } else {
            $e = oci_error($stmt);
            echo "Error updating owner information: " . $e['message'];
        }
    }

    oci_free_statement($stmt);
    oci_close($conn);
    ?>

    
    <div class="main-content">
        <!-- Top navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="https://www.creative-tim.com/product/argon-dashboard" target="_blank">User profile</a>
                <!-- Form -->
                <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                </form>
                <!-- User -->
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="Cust_Profile.png">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold"><?php echo $owner_name; ?></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <a href="../examples/profile.html" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>My profile</span>
                            </a>
                            <a href="../examples/profile.html" class="dropdown-item">
                                <i class="ni ni-settings-gear-65"></i>
                                <span>Settings</span>
                            </a>
                            <a href="../examples/profile.html" class="dropdown-item">
                                <i class="ni ni-calendar-grid-58"></i>
                                <span>Activity</span>
                            </a>
                            <a href="../examples/profile.html" class="dropdown-item">
                                <i class="ni ni-support-16"></i>
                                <span>Support</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#!" class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Header -->
        <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(owner.jpg); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <h1 class="display-2 text-white">Hello <?php echo $owner_name; ?></h1>
                        <p class="text-white mt-0 mb-5">This is your profile page. You can see the progress you've made with your info and see your booking summary</p>
                        <a href="#!" class="btn btn-info">Edit profile</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="Cust_Profile.png" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
                                <a href="#" class="btn btn-sm btn-default float-right">Feedback</a>
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                        <div>
                                            <span class="heading">5</span>
                                            <span class="description">Owned<br>Halls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3>
                                    <?php echo $owner_id; ?><span class="font-weight-light">, 27</span>
                                </h3>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i><?php echo $owner_city; ?>, Bangladesh
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="#!" class="btn btn-sm btn-primary">Settings</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <h6 class="heading-small text-muted mb-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-username">Username</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_name" name="owner_name" placeholder="Username" value="<?php echo $owner_name; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_email" name="owner_email" placeholder="Username" value="<?php echo $owner_email; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">House No</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_house_no" name="owner_house_no" placeholder="Username" value="<?php echo $owner_house_no; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">Street</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_street" name="owner_street" placeholder="Username" value="<?php echo $owner_street; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-city">City</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_city" name="owner_city" placeholder="Username" value="<?php echo $owner_city; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-country">Country</label>
                                                <label class="form-control form-control-alternative" for="input-country" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">Bangladesh</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Postal code</label>
                                                <input class="form-control form-control-alternative" type="text" id="owner_postal_code" name="owner_postal_code" placeholder="Username" value="<?php echo $owner_postal_code; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="edit_button" class="btn2">Edit Information</button>
                                <form action="Profile.php" method="post">
                                    <button type="submit" id="update_button" class="btn2" style="display: none;">Update Information</button>
                                </form>
                                <form action="logout.php" method="post">
                                    <button type="submit" id="logout_button" >Logout</button>
                                </form>
                                <hr class="my-4">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6 m-auto text-center">
                <div class="copyright">
                    <p>Made with <a href="https://www.creative-tim.com/product/argon-dashboard" target="_blank">Argon Dashboard</a> by Creative Tim</p>
                </div>
            </div>
        </div>
    </footer> 

    <script>
        var editButton = document.getElementById("edit_button");
        var updateButton = document.getElementById("update_button");

        editButton.addEventListener("click", function() {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].disabled = false;
            }

            editButton.style.display = "none";
            updateButton.style.display = "block";
        });
    </script>
</body>
</html>

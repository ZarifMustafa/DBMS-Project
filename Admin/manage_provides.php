<html>
    <head>
        <title>Owner Changed Successfully</title>
    </head>
    <body>
    <?php
// Check if the form is submitted and the menu IDs are present
if (isset($_POST['menu_ids']) && isset($_POST['hall_id'])) {
    // Retrieve the selected menu IDs and the hall ID
    $menuIds = $_POST['menu_ids'];
    $hallId = $_POST['hall_id'];

    // Connect to the database
    $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');
    if (!$connection) {
        $error = oci_error();
        die('Database connection failed: ' . $error['message']);
    }

    // Prepare the query to check existing records in the 'provides' table
    $existingQuery = "SELECT * FROM provides WHERE hall_id = :hallId";

    // Prepare the query to insert new records into the 'provides' table
    $insertQuery = "INSERT INTO provides (hall_id, menu_id) VALUES (:hallId, :menuId)";

    // Prepare the query to delete existing records from the 'provides' table
    $deleteQuery = "DELETE FROM provides WHERE hall_id = :hallId AND menu_id = :menuId";

    // Execute the query to check existing records
    $existingStatement = oci_parse($connection, $existingQuery);
    oci_bind_by_name($existingStatement, ':hallId', $hallId);
    oci_execute($existingStatement);

    // Fetch all existing records
    $existingRecords = oci_fetch_all($existingStatement, $existingResult, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Fables">
    <meta name="author" content="Enterprise Development">
    <link rel="shortcut icon" href="assets/custom/images/shortcut.png">
    <title>Select Owners</title>
    <style>
        /* CSS styles here */
        .container1 {
            max-width: 600px;
            margin: 0 auto;
        }

        .message-box1 {
            background-color: cyan;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .message-text1 {
            font-family: Arial, sans-serif;
            font-size: 22px;
            color: #333;
            text-transform: uppercase;
            margin: 0;
        }

                    .BH {
                        background-color: #2CD85A;
                        border: none;
                        color: white;
                        padding: 16px 32px;
                        text-decoration: none;
                        margin: 4px 2px;
                    }

    </style>
    <script>
        function validateForm() {
            var checkboxes = document.getElementsByName('owner_ids[]');
            var isChecked = false;
            
            // Check if at least one checkbox is checked
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    isChecked = true;
                    break;
                }
            }
            
            // Display an alert if no checkbox is checked
            if (!isChecked) {
                alert("Please select at least one owner.");
                return false; // Prevent form submission
            }
        }
    </script>
    <!-- animate.css-->  
    <link href="assets/vendor/animate.css-master/animate.min.css" rel="stylesheet">
    <!-- Load Screen -->
    <link href="assets/vendor/loadscreen/css/spinkit.css" rel="stylesheet">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <!-- Font Awesome 5 -->
    <link href="assets/vendor/fontawesome/css/fontawesome-all.min.css" rel="stylesheet">
    <!-- Fables Icons -->
    <link href="assets/custom/css/fables-icons.css" rel="stylesheet"> 
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="assets/vendor/bootstrap/css/bootstrap-4-navbar.css" rel="stylesheet">
    <!-- FANCY BOX -->
    <link href="assets/vendor/fancybox-master/jquery.fancybox.min.css" rel="stylesheet">
    <!-- OWL CAROUSEL  -->
    <link href="assets/vendor/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/owlcarousel/owl.theme.default.min.css" rel="stylesheet">
    <!-- Timeline -->
    <link rel="stylesheet" href="assets/vendor/timeline/timeline.css"> 
    <!-- FABLES CUSTOM CSS FILE -->
    <link href="assets/custom/css/custom.css" rel="stylesheet">
    <!-- FABLES CUSTOM CSS RESPONSIVE FILE -->
    <link href="assets/custom/css/custom-responsive.css" rel="stylesheet">
</head>
<body>
    <div class="search-section">
    <a class="close-search" href="#"></a>
    <div class="d-flex justify-content-center align-items-center h-100">
        <form method="post" action="#" class="w-50">
            <div class="row">
                <div class="col-10">
                    <input type="search" value="" class="form-control palce bg-transparent border-0 search-input" placeholder="Search Here ..." /> 
                </div>
                <div class="col-2 mt-3">
                     <button type="submit" class="btn bg-transparent text-white"> <i class="fas fa-search"></i> </button>
                </div>
            </div>
        </form>
    </div>
         
</div>

<!-- Loading Screen -->
<div id="ju-loading-screen">
  <div class="sk-double-bounce">
    <div class="sk-child sk-double-bounce1"></div>
    <div class="sk-child sk-double-bounce2"></div>
  </div>
</div>

<!-- Start Top Header -->
<div class="fables-forth-background-color fables-top-header-signin">
    <div class="container">
        <div class="row" id="top-row">
            <!--<div class="col-12 col-sm-2 col-lg-5">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle border-0 bg-transparent font-13 lang-dropdown-btn pl-0" type="button" id="dropdownLangButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   language
                  </button>
                  <div class="dropdown-menu p-0 fables-forth-background-color rounded-0 m-0 border-0 lang-dropdown" aria-labelledby="dropdownLangButton">
                        <a class="dropdown-item white-color font-13 fables-second-hover-color" href="#">
                        <img src="assets/custom/images/england.png" alt="england flag" class="mr-1"> English</a>
                        <a class="dropdown-item white-color font-13 fables-second-hover-color" href="#">
                        <img src="assets/custom/images/France.png" alt="england flag" class="mr-1"> French</a> 
                  </div>
                </div>
                
            </div>-->
            <div class="col-12 col-sm-5 col-lg-4 text-right">
                <p class="fables-third-text-color font-13"><span class="fables-iconphone"></span> Phone :  +8801875976488, +88011521200357</p>
            </div>
            <div class="col-12 col-sm-5 col-lg-3 text-right">
                <p class="fables-third-text-color font-13"><span class="fables-iconemail"></span> Email: trrzr@gmail.com</p>
            </div>
            
        </div>
    </div>
</div>
 
<!-- /End Top Header -->

<!-- Start Fables Navigation -->
<div class="fables-navigation fables-main-background-color py-3 py-lg-0">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-9 pr-md-0">
                <nav class="navbar navbar-expand-md btco-hover-menu py-lg-2">
                    <a class="navbar-brand" href="Admin.html">
                        <img src="assets/custom/images/fables-logo.png" alt="Fables Template" class="fables-logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fablesNavDropdown" aria-controls="fablesNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fables-iconmenu-icon text-white font-16"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="fablesNavDropdown">
                        <ul class="navbar-nav mx-auto fables-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="Admin.html" id="sub-nav1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Home
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Features
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav2">

                                    <li>
                                        <a class="dropdown-item dropdown-toggle" href="#">Headers</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Header 1</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="header1-transparent.html">Header 1 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="header1-light.html">Header 1 Light</a></li>
                                                    <li><a class="dropdown-item" href="header1-dark.html">Header 1 Dark</a></li>
                                                    <li><a class="dropdown-item" href="header-megamenu.html">Header Mega menu</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Header 2</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="header2-transparent.html">Header 2 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="header2-light.html">Header 2 Light</a></li>
                                                    <li><a class="dropdown-item" href="header2-dark.html">Header 2 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Header 3</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="header3-transparent.html">Header 3 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="header3-light.html">Header 3 Light</a></li>
                                                    <li><a class="dropdown-item" href="header3-dark.html">Header 3 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Header 4</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="header4-transparent.html">Header 4 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="header4-light.html">Header 4 Light</a></li>
                                                    <li><a class="dropdown-item" href="header4-dark.html">Header 4 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Header 5</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="header5-transparent.html">Header 5 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="header5-light.html">Header 5 Light</a></li>
                                                    <li><a class="dropdown-item" href="header5-dark.html">Header 5 Dark</a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a class="dropdown-item dropdown-toggle" href="#">Footers</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Footer 1</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="footer1-bg-img.html">Footer 1 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="Footer1-light.html">Footer 1 Light</a></li>
                                                    <li><a class="dropdown-item" href="Footer1-dark.html">Footer 1 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Footer 2</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="footer2-bg-img.html">Footer 2 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="footer2-light.html">Footer 2 Light</a></li>
                                                    <li><a class="dropdown-item" href="footer2-dark.html">Footer 2 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Footer 3</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="footer3-bg-img.html">Footer 3 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="footer3-light.html">Footer 3 Light</a></li>
                                                    <li><a class="dropdown-item" href="footer3-dark.html">Footer 3 Dark</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-toggle" href="#">Footer 4</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="footer4-bg-img.html">Footer 4 Transparent</a></li>
                                                    <li><a class="dropdown-item" href="footer4-light.html">Footer 4 Light</a></li>
                                                    <li><a class="dropdown-item" href="footer4-dark.html">Footer 4 Dark</a></li>
                                                </ul>
                                            </li>


                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="team.html">Team Members</a></li>
                                    <li><a class="dropdown-item" href="pricing-table.html">Pricing Table</a></li>
                                    <li><a class="dropdown-item" href="testimonials.html">testimonials</a></li>
                                    <li><a class="dropdown-item" href="blog.html">Blog</a></li>
                                    <li><a class="dropdown-item" href="counters.html">Counters</a></li>
                                    <li><a class="dropdown-item" href="image-hover-effects.html">Image Hover Effects</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    About
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav3">
                                    <li><a class="dropdown-item" href="about1.html">About 1</a></li>
                                    <li><a class="dropdown-item" href="about2.html">About 2</a></li>
                                    <li><a class="dropdown-item" href="about3.html">About 3</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Store
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav4">
                                    <li><a class="dropdown-item" href="store_grid_list.html">Product Category </a></li>
                                    <li><a class="dropdown-item" href="store_single.html">Product Single</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Blog
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav5">
                                    <li><a class="dropdown-item" href="blog-cat1.html">Blog Cat 1</a></li>
                                    <li><a class="dropdown-item" href="blog-cat2.html">Blog Cat 2</a></li>
                                    <li><a class="dropdown-item" href="blog-cat3.html">Blog Cat 3</a></li>
                                    <li><a class="dropdown-item" href="blog-cat-masonry.html">Blog Cat Masonry</a></li>
                                    <li><a class="dropdown-item" href="blog-details1.html">Blog Details 1</a></li>
                                    <li><a class="dropdown-item" href="blog-details2.html">Blog Details 2</a></li>
                                    <li><a class="dropdown-item" href="blog-details3.html">Blog Details 3</a></li>
                                    <li><a class="dropdown-item" href="blog-single-img.html">Blog Single image</a></li>
                                    <li><a class="dropdown-item" href="blog-single-slider.html">Blog Single Slider</a></li>
                                    <li><a class="dropdown-item" href="blog-single-video.html">Blog Single Video</a></li>
                                    <li><a class="dropdown-item" href="blog-timeLine.html">Blog Timeline</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav6">
                                    <li><a class="dropdown-item" href="404.html">404</a></li>
                                    <li><a class="dropdown-item" href="comming-soon.html">Comming Soon</a></li>
                                    <li><a class="dropdown-item" href="gallery.html">Gallery</a></li>
                                    <li><a class="dropdown-item" href="gallery-filter.html">Gallery Filter</a></li>
                                    <li><a class="dropdown-item" href="gallery-filter-masonry.html">Gallery Filter Masonry</a></li>
                                    <li><a class="dropdown-item" href="gallery-history.html">Gallery History</a></li>
                                    <li><a class="dropdown-item" href="gallery-history2.html">Gallery History 2</a></li>
                                    <li><a class="dropdown-item" href="gallery-single.html">Gallery Single</a></li>
                                    <li><a class="dropdown-item" href="gallery-timeline.html">Gallery Timeline </a></li>
                                    <li><a class="dropdown-item" href="gallery-timeline2.html">Gallery Timeline 2</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="sub-nav7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Contact Us
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sub-nav7">
                                    <li><a class="dropdown-item" href="contactus1.html">Contact Us 1</a></li>
                                    <li><a class="dropdown-item" href="contactus2.html">Contact Us 2</a></li>
                                    <li><a class="dropdown-item" href="contactus3.html">Contact Us 3</a></li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </nav>
            </div>
            <div class="col-12 col-md-2 col-lg-3 pr-md-0 icons-header-mobile">

                <div class="fables-header-icons">
                    <div class="dropdown">
                        <a href="#_" class="fables-third-text-color dropdown-toggle right px-3 px-md-2 px-lg-4 fables-second-hover-color top-header-link max-line-height position-relative" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fables-iconcart-icon font-20"></span>
                            <span class="fables-cart-number fables-second-background-color text-center">3</span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="p-3 cart-block">
                                <p class="fables-second-text-color semi-font mb-4 font-17">(2) Items in my cart</p>
                                <div class="row mx-0 mb-3">
                                    <div class="col-4 p-0">
                                        <a href="#"><img src="assets/custom/images/sml1.jpg" alt="" class="w-100"></a>
                                    </div>
                                    <div class="col-8">
                                        <h2><a href="#" class="fables-main-text-color font-13 d-block fables-main-hover-color">LUIS LEATHER DRIVING</a></h2>
                                        <p class="fables-second-text-color font-weight-bold">$ 100.00</p>
                                        <p class="fables-forth-text-color">QTY : 1</p>
                                    </div>
                                </div>
                                <div class="row mx-0 mb-3">
                                    <div class="col-4 p-0">
                                        <a href="#"><img src="assets/custom/images/sml1.jpg" alt="" class="w-100"></a>
                                    </div>
                                    <div class="col-8">
                                        <h2><a href="#" class="fables-main-text-color font-13 d-block fables-main-hover-color">LUIS LEATHER DRIVING</a></h2>
                                        <p class="fables-second-text-color font-weight-bold">$ 100.00</p>
                                        <p class="fables-forth-text-color">QTY : 1</p>
                                    </div>
                                </div>
                                <span class="font-16 semi-font fables-main-text-color">TOTAL</span>
                                <span class="font-14 semi-font fables-second-text-color float-right">$200.00</span>
                                <hr>
                                <div class="text-center">
                                    <a href="#" class="fables-second-background-color fables-btn-rounded  text-center white-color py-2 px-3 font-14 bg-hover-transparent border fables-second-border-color fables-second-hover-color">View my cart</a>
                                    <a href="#" class="fables-second-text-color border fables-second-border-color fables-btn-rounded text-center white-color p-2 px-4 font-14 fables-second-hover-background-color">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="open-search fables-third-text-color right  top-header-link px-3 px-md-2 px-lg-4 fables-second-hover-color border-0 max-line-height">
                        <span class="fables-iconsearch-icon"></span>
                    </a>
                    <a href="signin.html" class="fables-third-text-color fables-second-hover-color font-13 top-header-link px-3 px-md-2 px-lg-4 max-line-height"><span class="fables-iconuser"></span></a>



                </div>
            </div>
        </div>
    </div>
</div> 
<!-- /End Fables Navigation -->
     
<!-- Start Header -->
<div class="fables-header fables-after-overlay" style="background-image: url(assets/custom/images/OwnerRegBg.jpg);">
    <div class="container"> 
         <h2 class="fables-page-title fables-second-border-color">Owner Changed Successfully</h2>
    </div>
</div>  
<!-- /End Header -->
     
<!-- Start Breadcrumbs -->
<div class="fables-light-background-color">
    <div class="container"> 
        <nav aria-label="breadcrumb">
          <ol class="fables-breadcrumb breadcrumb px-0 py-3">
            <li class="breadcrumb-item"><a href="Admin.html" class="fables-second-text-color">Home</a></li>
            <li class="breadcrumb-item"><a href="select_hall_to_set_owner.php" class="fables-second-text-color">Hall Choice</a></li>
            <li class="breadcrumb-item active" aria-current="page">Select Owner</li>
            <li class="breadcrumb-item active" aria-current="page">Owner Changed Successfully</li>
          </ol>
        </nav> 
    </div>
</div>
<!-- /End Breadcrumbs -->
     
<!-- Start page content -->

    <div class="container1">
    <div class="message-box1">
    <p class="message-text1">
        <?php
        // Loop through the existing records
    foreach ($existingResult as $existingRecord) {
        $existingmenuId = $existingRecord['MENU_ID'];

        // Check if the existing menu ID is in the selected menu IDs array
        if (in_array($existingmenuId, $menuIds)) {
            // menu ID exists in the selected menu IDs array, do nothing
            continue;
        } else {
            // menu ID does not exist in the selected menu IDs array, delete the record
            $deleteStatement = oci_parse($connection, $deleteQuery);
            oci_bind_by_name($deleteStatement, ':hallId', $hallId);
            oci_bind_by_name($deleteStatement, ':menuId', $existingmenuId);
            oci_execute($deleteStatement);

            echo "Deleted: Hall ID: " . $hallId . ", menu ID: " . $existingmenuId . "<br>";

            oci_free_statement($deleteStatement);
        }
    }

    // Loop through the selected menu IDs
    foreach ($menuIds as $menuId) {
        // Check if the record exists in the 'provides' table
        $existingRecord = array_filter($existingResult, function ($record) use ($menuId) {
            return $record['MENU_ID'] === $menuId;
        });

        if (count($existingRecord) > 0) {
            // Record exists, do nothing
            continue;
        } else {
            // Record doesn't exist, insert it into the 'provides' table
            $insertStatement = oci_parse($connection, $insertQuery);
            oci_bind_by_name($insertStatement, ':hallId', $hallId);
            oci_bind_by_name($insertStatement, ':menuId', $menuId);
            oci_execute($insertStatement);

            echo "Inserted: Hall ID: " . $hallId . ", menu ID: " . $menuId . "<br>";

            oci_free_statement($insertStatement);
        }
    }
        ?>
    </p>
    </div>
</div><br><br>
                <form action="Admin.html" method="POST" align="center">
                    <input type="hidden" name="hall_id" value="' . $hallId . '">
                    <input class="BH" type="submit" value="Proceed">
                </form><br><br>

    <!-- /End page content -->
    
    
<!-- Start Footer 2 Background Image  -->
<div class="fables-footer-image fables-after-overlay white-color py-4 py-lg-5 bg-rules">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mb-5 text-center">
                <h2 class="font-30 semi-font mb-5">Newsletter</h2>
                <form class="form-inline position-relative"> 
                  <div class="form-group fables-subscribe-formgroup"> 
                    <input type="email" class="form-control fables-subscribe-input fables-btn-rouned" placeholder="Your Email">
                  </div>
                  <button type="submit" class="btn fables-second-background-color fables-btn-rouned fables-subscribe-btn">Subscribe</button>
                </form>
                
            </div>
            <div class="col-12 col-lg-4 mb-4 mb-lg-0">
                <a href="#" class="fables-second-border-color border-bottom pb-3 d-block mb-3 mt-minus-13"><img src="assets/custom/images/fables-logo.png" alt="fables template"></a>
                <p class="font-15 fables-third-text-color">
                    t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters. 
                    <br><br>
                    t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                </p> 
                
            </div>
             
            <div class="col-12 col-sm-6 col-lg-4">
                <h2 class="font-20 semi-font fables-second-border-color border-bottom pb-3">Contact us</h2>
               <div class="my-3">
                    <h4 class="font-16 semi-font"><span class="fables-iconmap-icon fables-second-text-color pr-2 font-20 mt-1 d-inline-block"></span> Address Information</h4>
                    <p class="font-14 fables-fifth-text-color mt-2 ml-4">level13, 2Elizabeth St, Melbourne, Victor 2000</p>
                </div>
                <div class="my-3">
                    <h4 class="font-16 semi-font"><span class="fables-iconphone fables-second-text-color pr-2 font-20 mt-1 d-inline-block"></span> Call Now </h4>
                    <p class="font-14 fables-fifth-text-color mt-2 ml-4">+333 111 111 000</p>
                </div>
                <div class="my-3">
                    <h4 class="font-16 semi-font"><span class="fables-iconemail fables-second-text-color pr-2 font-20 mt-1 d-inline-block"></span> Mail </h4>
                    <p class="font-14 fables-fifth-text-color mt-2 ml-4">adminsupport@website.com</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <h2 class="font-20 semi-font fables-second-border-color border-bottom pb-3 mb-3">EXPLORE OUR SITE</h2>
                <ul class="nav fables-footer-links">
                    <li><a href="about1.html">About Us</a></li>
                    <li><a href="contactus1.html">Contact Us</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="team.html">Team</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="testimonials.html">Testimonials</a></li>
                </ul>
            </div>
                      
        </div> 
        
        </div>
</div>
<div class="copyright fables-main-background-color mt-0 border-0 white-color">
        <ul class="nav fables-footer-social-links just-center fables-light-footer-links">
            <li><a href="#" target="_blank"><i class="fab fa-google-plus-square"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-pinterest-square"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
        </ul>
        <p class="mb-0">Copyright © Fables 2018. All rights reserved.</p> 

</div>
    
<!-- /End Footer 2 Background Image --> 


<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/loadscreen/js/ju-loading-screen.js"></script>
<script src="assets/vendor/jquery-circle-progress/circle-progress.min.js"></script>
<script src="assets/vendor/popper/popper.min.js"></script>
<script src="assets/vendor/WOW-master/dist/wow.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap-4-navbar.js"></script>
<script src="assets/vendor/owlcarousel/owl.carousel.min.js"></script> 
<script src="assets/vendor/timeline/jquery.timelify.js"></script>
<script src="assets/custom/js/custom.js"></script>

        </body>
        </html>

    <?php

    // Free the statements
    oci_free_statement($existingStatement);

    // Close the database connection
    oci_close($connection);
    


}?>
</body>
</html>
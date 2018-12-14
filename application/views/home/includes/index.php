<?php
$locality   = $array['locality'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Book an appointment with your doctor.</title>
  
  
  <!-- Bootstrap -->
  <link href="<?= base_url('web/');?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url('web/');?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
  <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


  <!---------select2---->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/select2/css/');?>select2-bootstrap.css">
  <!---------select2---->

</head>

<body class="body-wrapper">


<?php
  include_once('includes/header.php');
  include_once('includes/location.php');
?>

<!--===============================
=            Hero Area            =
================================-->

<section class="hero-area bg-1 text-center overly" style="background:url('<?= base_url('web/');?>images/doctors.jpg');background-size: cover;">
  <!-- Container Start -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <!-- Header Contetnt -->
        <div class="content-block">
          <h1>Book Your Doctor's Appointment </h1>
          
          
          
        </div>
        <!-- Advance Search -->
        <?php
          include('includes/advancesearch.php');
        ?>
        
      </div>
    </div>
  </div>
  <!-- Container End -->
</section>

<!--===================================
=            Client Slider            =
====================================-->


<!--===========================================
=            Popular deals section            =
============================================-->

<section class="popular-deals section bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-title">
          <h2>Popular Searches</h2>
           
        </div>
      </div>
    </div>
    <div class="row">
      <!-- offer 01 -->
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/general.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">General Physicians</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/dentist.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Dentists</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/child.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Child Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div> 
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/skin.png" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Skin Specialists</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/neurology.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Neuro Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/eye.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Eye Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/cardiologist.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Cardiologists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-12 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/gynae.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="">Gynaecologists</a></h4>               
            </div>
          </div>
        </div>
      </div>       
 
      
      
    </div>
  </div>
</section>



<!--==========================================
=            All Category Section            =
===========================================-->

<!-- <section class=" section">
 
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Trending Clinics & Hospital</h2>
           
        </div>
        <div class="row">
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-laptop icon-bg-1"></i> 
                <h4>Electronics</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Laptops <span>93</span></a></li>
                <li><a href="category.html">Iphone <span>233</span></a></li>
                <li><a href="category.html">Microsoft  <span>183</span></a></li>
                <li><a href="category.html">Monitors <span>343</span></a></li>
              </ul>
            </div>
          </div>  
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-apple icon-bg-2"></i> 
                <h4>Restaurants</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Cafe <span>393</span></a></li>
                <li><a href="category.html">Fast food <span>23</span></a></li>
                <li><a href="category.html">Restaurants  <span>13</span></a></li>
                <li><a href="category.html">Food Track<span>43</span></a></li>
              </ul>
            </div>
          </div> 
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-home icon-bg-3"></i> 
                <h4>Real Estate</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Farms <span>93</span></a></li>
                <li><a href="category.html">Gym <span>23</span></a></li>
                <li><a href="category.html">Hospitals  <span>83</span></a></li>
                <li><a href="category.html">Parolurs <span>33</span></a></li>
              </ul>
            </div>
          </div> 
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-shopping-basket icon-bg-4"></i> 
                <h4>Shoppings</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Mens Wears <span>53</span></a></li>
                <li><a href="category.html">Accessories <span>212</span></a></li>
                <li><a href="category.html">Kids Wears <span>133</span></a></li>
                <li><a href="category.html">It & Software <span>143</span></a></li>
              </ul>
            </div>
          </div> 
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-briefcase icon-bg-5"></i> 
                <h4>Jobs</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">It Jobs <span>93</span></a></li>
                <li><a href="category.html">Cleaning & Washing <span>233</span></a></li>
                <li><a href="category.html">Management  <span>183</span></a></li>
                <li><a href="category.html">Voluntary Works <span>343</span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-car icon-bg-6"></i> 
                <h4>Vehicles</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Bus <span>193</span></a></li>
                <li><a href="category.html">Cars <span>23</span></a></li>
                <li><a href="category.html">Motobike  <span>33</span></a></li>
                <li><a href="category.html">Rent a car <span>73</span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-paw icon-bg-7"></i> 
                <h4>Pets</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Cats <span>65</span></a></li>
                <li><a href="category.html">Dogs <span>23</span></a></li>
                <li><a href="category.html">Birds  <span>113</span></a></li>
                <li><a href="category.html">Others <span>43</span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
            <div class="category-block">
              <div class="header">
                <i class="fa fa-laptop icon-bg-8"></i> 
                <h4>Services</h4>
              </div>
              <ul class="category-list" >
                <li><a href="category.html">Cleaning <span>93</span></a></li>
                <li><a href="category.html">Car Washing <span>233</span></a></li>
                <li><a href="category.html">Clothing  <span>183</span></a></li>
                <li><a href="category.html">Business <span>343</span></a></li>
              </ul>
            </div>
          </div>  
          
        </div>
      </div>
    </div>
  </div>
</section> -->




<!--============================
=            Footer            =
=============================-->

<?php
  include_once('includes/footer.php');
?>

  <!-- JAVASCRIPTS -->
  <script src="<?= base_url('web/');?>plugins/jquery/dist/jquery.min.js"></script>
  
  <script src="<?= base_url('web/');?>plugins/tether/js/tether.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/raty/jquery.raty-fa.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/popper.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.js"></script>
  <script src="<?= base_url('web/');?>plugins/smoothscroll/SmoothScroll.min.js"></script>
  
  <script src="<?= base_url('web/');?>js/scripts.js"></script>

</body>

</html>




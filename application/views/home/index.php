<?php
$locality   = $array['locality'];
$trending   = $array['trending'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Book an appointment with your doctor.</title>
  <meta name="description" content="Find and book hassle free and easy appointment of doctor's and diagnostic labs in one click.Ask any queries about health,book appointment of clinic,hospital and get useful health free tips." />
  
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
  <link href="<?= base_url('web/');?>css/select2.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 --> 
 <!-- Global site tag (gtag.js) - Google Analytics -->


  <style>
    .checked {
        color: orange;
    } 
  @media (max-width: 480px) {
  .city-option, .locality-option{
    margin-top: 0px;
  }
}
</style>
  


 

</head>

<body class="body-wrapper">


<?php
  include_once('includes/header.php');
  include_once('includes/location.php');
?>

<!--===============================
=            Hero Area            =
================================-->

<section class="hero-area bg-1 overly" style="background:url('<?= base_url('web/');?>images/doctors.jpg');background-size: cover;">
  <!-- Container Start -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <!-- Header Contetnt -->
        <div class="content-block text-center">
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
  <!-- <div class="widget coupon text-center">
    <p>Looking for a diagnosis center or X-Ray center in nearbuy locations?<br>
      We are here to help you to find best diagnosis center at your finger tips.
    </p>
    <a href="<?= base_url('Find/diagnosis');?>" class="btn btn-transparent-white"><i class="fa fa-search"></i> Diagnosis Center</a>
  </div> -->
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
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('General Physicians');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/general.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('General Physicians');">General Physicians</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('Dentist');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/dentist.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#"  onclick="searchdoc('Dentist');" >Dentists</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('Paediatrician');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/child.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('Paediatrician');">Child Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div> 
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('Dermatologist');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/skin.png" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('Dermatologist');">Skin Specialists</a></h4>               
            </div>
          </div>
        </div>
      </div>       
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('Neurologist');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/neurology.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('Neurologist');">Neuro Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#" onclick="searchdoc('Ophthalmologist');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/eye.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('Ophthalmologist')">Eye Specialists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#"  onclick="searchdoc('Cardiologist');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/cardiologist.jpg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center"><a href="#"  onclick="searchdoc('Cardiologist');">Cardiologists</a></h4>                
            </div>
          </div>
        </div>
      </div>       
 
      <div class="col-sm-6 col-lg-3">
        <!-- product card -->
        <div class="product-item bg-light">
          <div class="card">
            <div class="thumb-content">
              <!-- <div class="price">$200</div> -->
              <a href="#"  onclick="searchdoc('Gynecologist / Obstetrician');">
                <img class="card-img-top img-fluid" style="height:180px;" src="<?= base_url('web/');?>images/gynae.jpeg" alt="Card image cap">
              </a>
            </div>
            <div class="card-body"  onclick="searchdoc('Cardiologist');">
                <h4 class="card-title text-center"><a href="#" onclick="searchdoc('Gynecologist / Obstetrician');">Gynaecologists</a></h4>               
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

<?php
  if(count($trending))
  {
?>
<section class=" section">
 
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title" id="trending">
          <h2>Trending Clinics & Hospital</h2>
           
        </div>
        <div class="row">
          <?php
            foreach ($trending as $x) {
              ?>
                <div class="col-lg-3   col-md-3   col-sm-12 col-12" >
                  <div class="category-block" style="height: 330px;">
                    <div class="header">
                      <center>
                        <a href="<?= base_url('Medical/profile/'.$x['id']);?>">
                      <?php
                        if($x['user_image']!='')
                        {
                          ?>
                            <img src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" style="height: 150px;" class="img img-responsive" alt="<?= $x['user_name'];?>"   />
                             
                          <?php
                        }
                        else{
                          ?>
                            <img src="<?= base_url('img/hos.jpg');?>"  style="height: 150px;"  class="img img-responsive" alt="<?= $x['user_name'];?>"/>
                          <?php
                        }                           
                        ?>
                       </a>
                      </center>  
                      <h4><a href="<?= base_url('Medical/profile/'.$x['id']);?>"><?= ucwords($x['user_name']);?></a></h4>
                      <p class="member-time">
                        <?php
                          if($x['user_rated']!=0)
                          { 
                            $totalrating1 = $x['user_rating']/$x['user_rated'];
                            $totalratings = number_format($x['user_rating']/$x['user_rated'],1);
                            //echo $totalratings;
                            $starrating = 1;
                            //echo $totalratings;
                            $lastrating  = 5-ceil($totalratings);
                            while($starrating<= $totalratings)
                            {
                              ?>
                                <span class="fa fa-star checked" title="<?= $totalratings;?> ratings from <?= $x['user_rated'];?> reviews"></span>
                              <?php
                              $starrating++;
                            }
                            if (strpos($totalrating1,'.') !== false) { 
                              ?>               
                              <span class="fa fa-star-half-o checked"  title="<?= $totalratings;?> ratings from <?= $x['user_rated'];?> reviews"></span>
                              <?php 
                            } 
                            while($lastrating!=0)
                            {
                              ?>
                                <span class="fa fa-star"  title="<?= $totalratings;?> ratings from <?= $x['user_rated'];?> reviews"></span>
                              <?php
                              $lastrating--;
                            }                                   
                        ?>
                        
                        <?php
                          }
                        ?>
                      </p>
                    </div>
                     <ul class="category-list" >
                      <?php 
                        if($x['city']!='')
                        {
                          ?>                          
                            <li><a href="#trending"><?= $x['location']." ".$x['city'];?> <span> <i class="fa fa-map-marker"></i> </span> </a></li>
                          <?php  
                        }
                      ?>
                    </ul> 
                  </div>
                </div> 
              <?php
            }
          ?> 
           
            
          
        </div>
      </div>
    </div>
  </div>
</section>
<?php
}
?>



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
  <script type="text/javascript">
    function searchdoc(speciality){
      var current_city  =   $('#current_city').val();
      var current_locality  =   $('#current_locality').val();
      if(current_city == ''){
        current_city = 'Rourkela';
      }
      if(current_locality == ''){
        current_locality = 'Civil Township';
      }
      var url  = "<?=base_url('search?result_type=speciality');?>&city="+current_city+"&location="+current_locality+"&search="+speciality;
      window.location.href = url;
    }
  </script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120768070-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120768070-1');
</script>
</body>

</html>




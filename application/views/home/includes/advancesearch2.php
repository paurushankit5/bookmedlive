
<div class="advance-search">
          <form action="<?= base_url('search');?>" method="get" id="searchfrom" autocomplete="off">
            <input type="hidden" style="display: none;" id ="result_type" name="result_type"/> 
                    
            <div class="row">
              <!-- Store Search -->
              <div class="col-lg-3 col-md-12" style="margin: 10px auto;">

                <div class="block d-flex">

                  <input type="text" class="form-control" id="current_city"
                  <?php if(isset($_SESSION['current_city'])) { ?> value="<?= $_SESSION['current_city']['name'];?>"            <?php } else{ ?> value="Rourkela" <?php } ?>  onkeyup="showcityhint(this.value);" name="city" onfocus="$('.city-option').show();" onblur="hidecity();" placeholder="Select a City" >
                  <div  class="city-option" style="display:none;">
                    <div class="option-content" onClick="printcity('Rourkela');" >
                        <span>Rourkela</span>                       
                    </div>
                    <div class="option-content" onClick="printcity('Patna');" >
                        <span>Patna</span>                       
                    </div>
                    <div class="option-content" onClick="printcity('Delhi');" >
                        <span>Delhi</span>                       
                    </div>
                    <div class="option-content" onClick="printcity('Mumbai');" >
                        <span>Mumbai</span>                       
                    </div>
                    <div class="option-content" onClick="printcity('Vizag');" >
                        <span>Vizag</span>                       
                    </div>
                    

                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-12"style="margin: 10px auto;">

                <div class="block d-flex">
                  <input type="text" class="form-control" id="current_locality" onblur="hidelocality();" 
                  <?php
                    if(isset($_SESSION['current_locality']))
                    {
                      ?>
                        value="<?= $_SESSION['current_locality'];?>"
                      <?php
                    }
                  ?>
                  onkeyup="showlocalityhint(this.value);" name="location" onfocus="$('.locality-option').show();" placeholder=" Select Your locality"  style="font-family:Arial, FontAwesome">
                  <div  class="locality-option" style="display:none;">
                    <?php
                      if(count($locality)){
                        foreach($locality as $loc){
                          ?>
                            <div class="option-content" onClick="printlocality('<?= $loc['name'];?>');" >
                              <span><?= $loc['name'];?></span>                       
                          </div>
                          <?php
                        }
                      }
                    ?>
                    
                    
                    

                  </div>
                  
                </div>
              </div>
              <div class="col-lg-6 col-md-12" style="margin: 10px auto;">
                <div class="block d-flex">
                  <input type="text" onfocus="$('.searchbar-option').show();" onkeyup="showallhint(this.value);" onblur="hideoption();" required autocomplete="off" class="form-control mb-2 mr-sm-2 mb-sm-0" id="searchitem" name="search"  placeholder="Search for Doctor, Speciality, Hospital" <?php if(isset($_GET['search'])){ ?> value="<?= $_GET['search'];?>"  <?php } ?>>
                  <div  class="searchbar-option" style="display:none;">
                    <?php
                      if(count($_SESSION['speciality']))
                      {
                        $i=0;
                        ?>
                        <div class="label">Speciality</div>
                        <?php
                        foreach ($_SESSION['speciality'] as $speciality) {
                          if($i<=7)
                          {
                          $speciality_name  = $speciality['speciality_name'];
                          
                          ?>
                          <div class="label-content" onclick="clickoption('<?= $speciality['speciality_name'];?>','speciality');">
                              <span class="imgdiv" ><img src="<?= base_url('img/speciality2.jpg');?>" class="img img-responsive" alt=""/></span>
                              <span class="content text-center"><?= $speciality['speciality_name'];?></span>
                              <span class="type">Speciality</span>
                          </div>
                          <div class="clearfix"></div>
                          <?php
                          $i++;
                        }
                      }
                      }
                    ?>
                     <div class="label-content option-demo " style="display: none;" >
                        <span class="imgdiv" ><img src="<?= base_url('img/speciality.png');?>" class="img img-responsive" alt=""/></span>
                        <span class="content" style="height:10px;">
                          <div class="progress" >
                            <br>
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                              
                            </div>
                          </div>
                        </span>
                       
                      </div>
                      <div class="label-content option-demo " style="display: none;" >
                        <span class="imgdiv" ><img src="<?= base_url('img/speciality.png');?>" class="img img-responsive" alt=""/></span>
                        <span class="content" style="height:10px;">
                          <div class="progress" >
                            <br>
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                              
                            </div>
                          </div>
                        </span>
                       
                      </div>
                       <div class="label-content option-demo " style="display: none;" >
                        <span class="imgdiv" ><img src="<?= base_url('img/speciality.png');?>" class="img img-responsive" alt=""/></span>
                        <span class="content" style="height:10px;">
                          <div class="progress" >
                            <br>
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                              
                            </div>
                          </div>
                        </span>
                       
                      </div>

                    
                  </div>
                   
                </div>
              </div>
            </div>
          </form>
          
          <?php
            include_once('location.php');
          ?>
        </div>
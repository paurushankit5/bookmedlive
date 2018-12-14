<div class="advance-search">
          <form action="<?= base_url('Find/diagnosis/');?>" method="get" id="searchfrom" autocomplete="off">
                     
            <div class="row">
              <!-- Store Search -->
              <div class="col-lg-5 col-md-12" style="margin-bottom: 10px;">

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
              <div class="col-lg-5 col-md-12"style="margin-bottom: 10px;">

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
                  onkeyup="showlocalityhint(this.value);" name="location" onfocus="$('.locality-option').show();" placeholder="Select Your locality">
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
              <div class="col-lg-2 col-md-12"style="margin-bottom: 10px;">
                <div class="block d-flex">
                   <button class="btn btn-transparent-white btn-block" style="border-radius: 5px;" type="submit"><i class="fa fa-search"></i> Diagnosis</button>
                  
                </div>
              </div>
               
            </div>
          </form>
          
          <?php
            include_once('location.php');
          ?>
        </div>
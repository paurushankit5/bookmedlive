<script type="text/javascript">
            var prevdata  = $('.searchbar-option').html();
            function showallhint(str){
              //hideoption();
              var current_city  = $('#current_city').val();
              if(str.length>=1)
              {
                $.ajax({
                  type  :   'POST',
                  url   :   '<?= base_url('Demo/showallhint');?>',
                  data  :   {
                              "hint"  :  str,
                              "current_city"  :  current_city,
                  },
                  beforeSend: function(){
                      $(".label-content").hide();
                      $(".option-demo").show();
                  },
                  success : function(response){
                    response = response.trim();
                    $(".label-content").show();
                    $(".option-demo").hide();
                    $('.searchbar-option').html(response);
                    $('.searchbar-option').show();
                  }
                });
              }
              else{
                $('.searchbar-option').html(prevdata);
                    $('.searchbar-option').show();
              }
            }
            function clickoption(str,str2,str3){
              $('#searchitem').val(str);
              $('#result_type').val(str2);
              $('#result_id').val(str3);
              var current_city  = $('#current_city').val();
              var current_locality  = $('#current_locality').val();             
              if(current_city==''){
                alert('Please enter your city');
                 $('#searchitem').val('');
              }
              else if( current_locality==''){
                alert('Please enter your locality');
                 $('#searchitem').val('');
              }
              else{ 
              /*if(str.match(/^[0-9]+$/) != null)
              {
                $('#searchitem').hide();
              }*/               
                $('#searchfrom').submit();
              }
              hideoption();
            }
            function hideoption(){

              setTimeout(function(){$('.searchbar-option').hide();},1000);

              
            }
            function hidecity(){

              setTimeout(function(){$('.city-option').hide();},1000);
              $('#current_city').val('');
            }
            function hidelocality(){

              setTimeout(function(){$('.locality-option').hide();},1000);
              
            }

          
          </script>
          <script async="off">
            //var x = document.getElementById("demo");
            <?php
              if(!isset($_SESSION['current_city']))
              {
                ?>
                     $( document ).ready(function() {
                          getLocation();
                      });

                      
                <?php
              }
            ?>
           function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else { 
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

function showPosition(position) {
    /*x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;*/
    //alert(position.coords.latitude);
    $.ajax({
      type  :   "POST",
      url   :   "<?= base_url('Demo/getcity');?>",
      data  :   {
              "lat"   :   position.coords.latitude,
              "long"  :   position.coords.longitude,          
      },
      success :   function(data,cb){
        //$("#demo").append("<pre>"+data);
        data  = JSON.parse(data);
        console.log(data);
       // $('*').html(data);
        var city = [];
        $.each(data.results[0].address_components, function( index,value ) {
          city.push(value.long_name);
      });

      getcity(city); 
      }
    });
}
function getcity(city){
  $.ajax({
          type  :   "POST",
          url   :   "<?= base_url('Demo/checkcityname');?>",
          data  :   {
                  "name"  :   city
          },
          success :   function(res){
            $('#current_city').val(res);          
            //console.log(res);
            getsomelocality(res,city);
          }
        });
}
function getsomelocality(currentcity,alloutcome){

    $.ajax({
        type : "POST",
        url    : "<?= base_url('demo/getuserlocality');?>",
        data   :{
                        "city"        : currentcity,
                        "alloutcome"  : alloutcome,
        },
        success : function(data){
         // alert(data);  
            printlocality(data); 
            showlocality();
        }
    });
}
  function printcity(city){
      $('#current_city').val(city);
      setTimeout(function(){$('.city-option').hide();},200);
       
      $('#current_locality').val('');
      showlocality();
      $('#searchitem').val('');
    }
    function printlocality(locality){
      $('#current_locality').val(locality);
      setTimeout(function(){$('.locality-option').hide();},200);
      $('#searchitem').val('');
    }

    function showlocality(){
      var city =  $('#current_city').val();
      if(city!='')
      {
        $.ajax({
          type  :   "POST",
          data  :   {
                  "city" : city 
          },
          url   :   "<?= base_url('demo/getcitylocality');?>",
          success : function(data){
            //console.log(data);
            $('.locality-option').html(data);
            //$('#current_locality').val("city of patna");
          }
        });
      }
    }
    function showcityhint(city){
        if(city.length>=1)
        {
            $.ajax({
                type    :   "POST",
                data    :   {
                    "city"      :   city
                },
                url     :   "<?= base_url('demo/getcityhint');?>",
                success : function(data){
                    $('.city-option').html(data);
                }
            });
        }
    } 
    function showlocalityhint(locality){
      if(locality.length>=1)
      {
        var currentcity   = $('#current_city').val();
        $.ajax({
          type  :   "POST",
          url   :   "<?= base_url('demo/showlocalityhint');?>",
          data  :   {
                      "city"  : currentcity,
                      "locality"  : locality,
          },
           success : function(data){
                    $('.locality-option').html(data);
                }
        });
      }
    }
</script>
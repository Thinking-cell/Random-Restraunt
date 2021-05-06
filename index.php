<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Random Restaurant</title>
    <style>
        .photo {
            width: 150px;
        }
        .photo img {
            width: 100%;
            object-fit: cover;
        }
        .row-restaurant {
            
            overflow: hidden;
            margin-bottom: 10px;
            
            
        }
        .img
        {
            max-width: 100%;
        }


    </style>
    <script>
        
        function getRestaurants(lat, lng) {

            $("#rd").html("Finding Restraunts...");
            
            $.get(`https://fewd-10244.herokuapp.com/api/api.php?lat=${lat}&long=${lng}`, restaurantsCallback);
        }
        //using above data -->
        function restaurantsCallback(data) {
            let businessess = JSON.parse(data).businesses;
            let $containerRestaurants = $('.container-restaurants');
            let $rowTemplate = $('.row-template');
            businessess.forEach((val) => {
                let phoneNumber = val.phone;
                // debug
                console.log(val);
                let phoneNumberDisplay = val.display_phone;
                let status="(Open)";
                let categories="";
                

                $rowClone = $rowTemplate.clone();
                // REMOVING CLASS to unhide it
                $rowClone.removeClass('d-none row-template');
                if(val.isClosed)
                {
                    status="(Closed)";
                    $rowClone.css("color", "red");
                    
                }
                $rowClone.find('h5').text(val.name);
                $rowClone.find('.photo img').attr('src', val.image_url);

                $rowClone.find('.status').html(status);

                
                $rowClone.find('.phone a').attr('href', `tel:${phoneNumber}`).text(phoneNumberDisplay);

                val.categories.forEach((category)=>
                {
                    categories=categories+', '+category['alias'];
                });
                categories=categories+'.';
                $rowClone.find('.categories').html('Categories: '+categories);
                $rowClone.find('.address').html('Address: '+val.location['address1']+', '+val.location['city']);
                //adding each row to the target div
                $rowClone.appendTo($containerRestaurants);
            })

            $("#rd").html("Found These Restraunts...");
            $('#Spinner').css('display','none');
        }


        

        let $resultInd = $('.resultDisplay');
        
        
        
       

        function getLocation() {
            console.log($("#rd").html("Finding Location..."));
            //$('#Spinner').css('display','none');
            
            $("#resultDisplay").html("TEST");
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                        //  Success
                        (position) => {
                            // call get restraunt 
                            getRestaurants(position.coords.latitude,position.coords.longitude);

                            console.log(position);

                            


                           
                    },
                    showError
                        );
               

            } else { 
                $("#rd").html("Geolocation is not supported by this browser.")
               // resultInd.find('resultTarget').html();
                
            }
        }

        

        function showError(error) {
            // removing spinner
            resultInd.find('.Spinner').addClass('d-none').removeClass('d-flex');

            switch(error.code) {
                case error.PERMISSION_DENIED:
                    $("#rd").html("User denied the request for Geolocation.")
                   // resultInd.find('resultTarget').html();
                    break;
                    
               
                case error.POSITION_UNAVAILABLE:
                    $("#rd").html("Location information is unavailable.")
                    //resultInd.find('resultTarget').html();
                    break;
                
                
                case error.TIMEOUT:
                    $("#rd").html("The request to get user location timed out.")
                   //resultInd.find('resultTarget').html();
                    break;
                
                
                case error.UNKNOWN_ERROR:
                    $("#rd").html("An unknown error occurred.")
                   // resultInd.find('resultTarget').html();
                    break;
                 
                
            }
        }

       



        $(document).ready(function(){
            getLocation();
            
        });
    </script>
</head>
<body>
    <div class="container">
        <h2 class="d-flex justify-content-center">Random Restaurant</h2>
        <div >
            
            <h4 id ="rd" class="d-flex justify-content-center  ">Found these restaurants...</h4>
            
            

        
            <div class=' d-flex justify-content-center' style='margin-bottom:80px;' >
                <div id='Spinner' class="spinner-border text-primary p-5 "></div>
            </div>
        </div>
        
        <div class="container-restaurants">
            
            <div class="row row-restaurant d-none row-template"  >
                <div class="col-md-4 col-sm-6  " >
                    <div class="photo  ">
                        <img src="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 " style="padding:6px;">
                    <h5>Test</h5>
                    
                    <div class="status"></div>
                    <div class="categories"></div>
                    <div class="address"></div>
                    <div class="phone">
                        <a href=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
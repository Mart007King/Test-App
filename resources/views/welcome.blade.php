<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Test App By Martins Samuel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />

        {{-- links --}}
        <link rel="stylesheet" href="/assets/animate.css">
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/fa/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">        
    </head>
    <body >
        
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8 position-absolute top-50 start-50 translate-middle">

                    <div class="card card-lg text-center">

                        <div class="card-header">
                            PHP Skills Test
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Kindly enter required details below and click submit</h5>

                            <div class="card-text position-absolute top-50 start-50 translate-middle">

                                <form id="formDeets" action="{{Route('sub.submit')}}" method="POST">
                                    @csrf

                                    <div class="error"></div>

                                    <div class="mb-3">

                                        <label for="nameForm" class="form-label">Product name</label>

                                        <input type="text" name="productName" class="form-control" id="nameForm" placeholder="e.g Bottle Water">

                                    </div>

                                    <div class="mb-3">

                                        <label for="quantityForm" class="form-label">Quantity in stock</label>

                                        <input type="number" name="quantity" class="form-control" id="quantityForm" placeholder="e.g 3">

                                    </div>

                                    <div class="mb-3">

                                        <label for="priceForm" class="form-label">Price per item</label>

                                        <input type="number" name="price" class="form-control" id="priceForm" placeholder="e.g 1000">

                                    </div>

                                </form>                               

                            </div>
                        </div>
                        <div class="card-footer text-body-secondary">
                            <button type="button" class="btn btn-success" id="submitForm"> Submit </button>
                        </div>

                    </div>

                    <div id="allDeets"  class="row info mt-3 mb-3 animate__animated animate__fadeInUp" style="display: none">

                        <div class="card card-body col-12">

                            <div class="d-flex">

                                <div class="m-3">  Product name: <span> <b id="pname"></b> </span> </div>

                                <div class="m-3">  Quantity in stock: <span> <b id="quantity"></b> </span> </div>

                                <div class="m-3">  Price per item: <span> <b id="price"></b> </span> </div>

                                <div class="m-3">  Datetime submitted: <span> <b id="time"></b> </span> </div>

                                <div class="m-3">  Total value number: <span> <b id="total"></b> </span> </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>        

        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="/jquery/jquery.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script>

            $(document).ready(function () {
              
                $("#submitForm").click(function(){

                    let productName = $("#nameForm").val();
                    let quantity = $("#quantityForm").val();
                    let price = $("#priceForm").val();

                    if (productName == "" || quantity == "" || price == "") {
                        
                        $('.error').html("<div class='alert alert-info text-danger mt-2 text-center'>"+"All fields are required"+"</div>");

                        setInterval(() => {                            
                            $('.error').html('');
                        }, 5000); 

                    }

                    if (productName != "" && quantity != "" && price != "") {

                        let form = document.getElementById('formDeets');
                        let data = new FormData(form);                            
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        
                        $.ajax({
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': csrfToken},
                            url: "{{route('sub.submit')}}",
                            data: data,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function (response) {

                                if (response['status'] == 1) {

                                    $("#allDeets").show();
                                    $("#pname").text(response['pname']);
                                    $("#quantity").text(response['quantity']);
                                    $("#price").text(response['price']);
                                    $("#time").text(response['time']);
                                    $("#total").text(response['total']);
                                    
                                    $('.error').html("<div class='alert alert-info text-success text-center'>"+" Find details of what you entered below "+"</div>");

                                    $("#nameForm").val('');
                                    $("#quantityForm").val('');
                                    $("#priceForm").val('');

                                    setInterval(() => {                            
                                        $('.error').html('');                                        
                                    }, 5000);                                    

                                }else{                                  

                                    $('.error').html("<div class='alert alert-info text-danger text-center'>"+response["message"]+"</div>");

                                    setInterval(() => {                            
                                        $('.error').html('');
                                    }, 5000);

                                }                         

                            },
                            error: function(err) {

                                if (err) {

                                    $('.error').html("<div class='alert alert-info text-danger text-center'>"+ "Server error. Kindly check your network and try again" +"</div>");

                                    setInterval(() => {                            
                                        $('#err').html('');
                                        $(".fa-spinner").hide();
                                    }, 10000);
                                
                                }                          
                            }

                        });
                      
                        
                    }
                })

            });

        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <title>Aurora MIS | Sign In</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-account-pages">

    <!-- Login -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="wrapper-page">
                        <div class="account-pages">
                            <div id="login-whirl" class="account-box">

                                <!-- Logo box-->
                                <div class="account-logo-box">
                                   
                                    <h3 class="text-uppercase text-center">
                                    <img src="{{ asset('images/logo-md.png') }}" class="text-center" width="150px" height="150px" alt="">
                                    <br><br>
                                        MANAGEMENT INFORMATION SYTEM
                                        <br>
                                        <small>PROVINCE OF AURORA</small>
                                    </h3>
                                </div>

                                <div class="account-content">
                                  <form id="login-form" method="post">
                                      @csrf
                                        <div class="form-group mb-3">
                                            <label for="emailaddress" class="font-weight-medium">Username</label>
                                            <input class="form-control" type="text" name="username" required="" placeholder="Enter your username">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password" class="font-weight-medium">Password</label>
                                            <input class="form-control" type="password" required="" name="password" placeholder="Enter your password">
                                        </div>

                                        <hr>

                                        <div class="form-group row text-center">
                                            <div class="col-12">
                                                <button class="btn btn-block btn-success waves-effect waves-light" type="submit">Sign In</button>
                                            </div>
                                        </div>
                                    </form> <!-- end form -->

                                    <p class="text-uppercase text-center">
                                        AURORA MANAGEMENT INFORMATION TEAM
                                        <br>
                                        &copy; 2020
                                    </p>

                                </div> <!-- end account-content -->


                            </div> <!-- end account-box -->
                        </div>
                        <!-- end account-page-->
                    </div>
                    <!-- end wrapper-page -->

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- END HOME -->
<!-- jQuery -->
<script src="{{ asset("plugins/jquery/jquery.min.js")}}"></script>
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>

<script src="{{ asset('/js/system/signin.js') }}"></script>
</body>
</html>
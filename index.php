<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("Location: profile.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style type="text/css">
        #alert,#register-box,#forgot-box,#loader{
            display: none;
        }

        .show-hide-pass .input-group-append{
            cursor: pointer;
        }

        .error{
            color: red;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4 offset-lg-4" id="alert" <?php if(isset($_GET['reset'])){if($_GET['reset'] == "ok"){echo "style='display:block'";}} ?>>
                <div class="alert alert-success">
                    <strong id="result"><?php if(isset($_GET['reset'])){if($_GET['reset'] == "ok"){echo "Reset succesfull, you can now log in!";}} ?></strong>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img src="preloader.gif" width="50px" height="50px" class="m-2" id="loader">
        </div>
        <!-- LOGIN -->
        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light rounded" id="login-box">
                <h2 class="text-center mt-2">Login</h2>
                <form action="" method="post" role="form" class="p-2" id="login-form">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username']; ?>" required>
                    </div>
                    <div class="form-group show-hide-pass">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="rem" id="customCheck" <?php if(isset($_COOKIE['username'])) echo "checked"; ?>>
                            <label for="customCheck" class="custom-control-label">Remember me</label>
                            <a href="#" class="float-right" id="forgot-btn">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" id="login" value="Login" class="btn btn-primary btn-block">
                    </div>
                    <div class="form-group">
                        <p class="text-center">New User? <a href="#" id="register-btn">Register</a></p>
                    </div>
                </form>
            </div>
        </div>

        <!-- REGISTER -->
        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light rounded" id="register-box">
                <h2 class="text-center mt-2">Register</h2>
                <form action="" method="post" role="form" class="p-2" id="register-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Full name" name="name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="nick" required minlength="6">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                    </div>
                    <div class="form-group show-hide-pass">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Password" name="pass1" id="pass1" required minlength="6">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Repeat password" name="pass2" id="pass2" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="rem" id="customCheck2" required>
                            <label for="customCheck2" class="custom-control-label">I agree to <a href="#">Terms and Conditions</a></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="register" id="register" value="Register" class="btn btn-primary btn-block">
                    </div>
                    <div class="form-group">
                        <p class="text-center">Already Registered? <a href="#" id="login-btn">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
        <!-- FORGOTTEN PASS -->
        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light rounded" id="forgot-box">
            <h2 class="text-center mt-2">Reset Password</h2>
            <form action="" method="post" role="form" class="p-2" id="reset-form">
                <div class="form-group">
                    <p class="text-muted text-center">
                        <small>To reset your password, enter your e-mail address and you will receive the reset instructions</small>
                    </p>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="forgot" id="forgot" value="Reset Password" class="btn btn-primary btn-block">
                </div>
                <div class="form-group text-right">
                    <a href="#" id="back-btn">Back</a>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        $(document).ready(_=>{

            function hidePass(){
                $(".show-hide-pass input").attr("type", "password")
                $(".show-hide-pass i").addClass("fa-eye-slash")
                $(".show-hide-pass i").removeClass("fa-eye")
            }
            function showPass(){
                $(".show-hide-pass input").attr("type", "text")
                $(".show-hide-pass i").addClass("fa-eye")
                $(".show-hide-pass i").removeClass("fa-eye-slash")
            }

            $(".show-hide-pass .input-group-append").mousedown(_=>{
                    showPass()
            })
            $(".show-hide-pass .input-group-append").mouseup(_=>{
                    hidePass()
            })



            $("#forgot-btn").click(_=>{
                $("#login-box").hide()
                $("#register-box").hide()
                $("#forgot-box").show()
                hidePass()
            })
            $("#register-btn").click(_=>{
                $("#login-box").hide()
                $("#register-box").show()
                $("#forgot-box").hide()
                hidePass()
            })
            $("#login-btn").click(_=>{
                $("#login-box").show()
                $("#register-box").hide()
                $("#forgot-box").hide()
                hidePass()
            })
            $("#back-btn").click(_=>{
                $("#login-box").show()
                $("#register-box").hide()
                $("#forgot-box").hide()
                hidePass()
            })

            $("#login-form").validate({
                errorPlacement: function (error, element) { 
                    if (element.parent().hasClass("input-group")){
                        error.insertAfter(element.parent());
                    }else{
                        error.insertAfter(element);
                    } 
                }
            })
            $("#register-form").validate({
                rules:{
                    pass2:{
                        equalTo: "#pass1"
                    }
                },
                errorPlacement: function (error, element) { 
                    if (element.parent().hasClass("input-group")){
                        error.insertAfter(element.parent());
                    }else if (element.parent().hasClass("custom-control")){
                        error.insertAfter(element.parent());
                    }else{
                        error.insertAfter(element);
                    } 
                }
            })
            $("#reset-form").validate({
                errorPlacement: function (error, element) { 
                    if (element.parent().hasClass("input-group")){
                        error.insertAfter(element.parent());
                    }else{
                        error.insertAfter(element);
                    } 
                }
            })
        })

        $("#login").click((e)=>{
            if(document.getElementById("login-form").checkValidity()){
                e.preventDefault();
                $('#loader').show()
                $.ajax({
                    url: "action.php",
                    method: "post",
                    data: $("#login-form").serialize()+"&action=login",
                    success: (response)=>{
                        if(response === "ok"){
                            window.location = "profile.php"
                        }else{
                            $("#alert").show()
                            $("#result").html(response)
                            $('#loader').hide()
                        }
                    }
                })
            }
            return true
        })

        $("#register").click((e)=>{
            if(document.getElementById("register-form").checkValidity()){
                e.preventDefault();
                $('#loader').show()
                $.ajax({
                    url: "action.php",
                    method: "post",
                    data: $("#register-form").serialize()+"&action=register",
                    success: (response)=>{
                        $("#alert").show()
                        $("#result").html(response)
                        $('#loader').hide()
                    }
                })
            }
            return true
        })

        $("#forgot").click((e)=>{
            if(document.getElementById("reset-form").checkValidity()){
                e.preventDefault();
                $('#loader').show()
                $.ajax({
                    url: "action.php",
                    method: "post",
                    data: $("#reset-form").serialize()+"&action=reset",
                    success: (response)=>{
                        $("#alert").show()
                        $("#result").html(response)
                        $('#loader').hide()
                    }
                })
            }
            return true
        })
    </script>
</body>
</html>
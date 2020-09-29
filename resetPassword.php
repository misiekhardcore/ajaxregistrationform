<?php
require "config.php";

$msg="";

if((isset($_GET['email'])) && (isset($_GET['token']))){

    $email = $_GET['email'];
    $token = $_GET['token'];

    if((empty($email)) || (empty($token))){
        echo "aaa";
        header("Location:index.php");
        exit();
    }
} else{
    header("Location:index.php");
    exit();
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
        #alert, #loader{
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
            <div class="col-lg-4 offset-lg-4" id="alert">
                <div class="alert alert-success">
                    <strong id="result">Hello world!</strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light rounded">
                <div class="text-center">
                    <img src="preloader.gif" width="50px" height="50px" class="m-2" id="loader">
                </div>
                <h2 class="text-center mt-2">Reset your password here</h2>
                <h4 class="text-success text-center"><?=$msg ?></h4>

                <form action="" method="post" role="form" class="p-2" id="reset-form">
                    <div class="form-group show-hide-pass">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="New Password" name="pass1" id="pass1" required minlength="6">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Repeat password" name="pass2" id="pass2" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="reset" id="reset" value="Reset" class="btn btn-primary btn-block">
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
            $("#back-btn").click(_=>{
                window.location = "index.php"
            })
            $("#reset-form").validate({
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
            $("#reset").click((e)=>{
                
                if(document.getElementById("reset-form").checkValidity()){
                    e.preventDefault();
                    $('#loader').show()
                    $.ajax({
                        url: "action.php",
                        method: "post",
                        data: $("#reset-form").serialize() + "&action=newpass&email=" + "<?=$email ?>" + "&token=" + "<?=$token ?>",
                        success: (response)=>{
                            $("#alert").show()
                            $("#result").html(response)
                            $('#loader').hide()
                            if(response === "ok"){
                                window.location = "index.php?reset=ok"
                            }
                        }
                    })
                }
                return true
            })
        })
    </script>
</body>
</html>
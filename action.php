<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "config.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";
require "PHPMailer/Exception.php";

if((isset($_POST['action'])) && ($_POST['action'] == 'login')){

    session_start();

    $username = check_input($_POST['username']);
    $password = check_input($_POST['password']);

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $sql -> bind_param("ss", $username,$username);
    if(!$sql->execute()){
        echo "sql error";
        exit();
    }
    else{
        $result = $sql->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if(empty($row)){
            echo "Wrong login or password";
            exit();
        }
        
        else{

            if(password_verify($password, $row['pass'])){
                $_SESSION['username'] = $username;
                echo "ok";

                if(!empty($_POST['rem'])){
                    setcookie("username",$_POST['username'],time()+(10*365*24*60*60));
                    setcookie("password",$_POST['password'],time()+(10*365*24*60*60));
                }

                else{

                    if(isset($_COOKIE['username'])){
                        setcookie("username","");
                    }

                    if(isset($_COOKIE['password'])){
                        setcookie("password","");
                    }
                }
            }

            else{
                echo "Wrong login or password";
                exit();
            }
        }
    }
}

if((isset($_POST['action'])) && ($_POST['action'] == 'register')){
    $name = check_input($_POST['name']);
    $nick = check_input($_POST['nick']);
    $email = check_input($_POST['email']);
    $pass1 = check_input($_POST['pass1']);
    $pass2 = check_input($_POST['pass2']);
    $created = date("Y-m-d");

    if($pass1 !== $pass2){
        echo "Passwords don't match!";
        exit();
    } else{
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $sql = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
        $sql->bind_param("ss",$nick,$email);
        if(!$sql->execute()){
            echo "sql error";
            exit();
        }
        else{
            $result = $sql->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if(!empty($row)){

                if($row['username'] == $nick){
                    echo "Username already exists";
                    exit();
                }

                elseif($row['email'] == $email){
                    echo "Email already exists";
                    exit();
                }
            }

            else{
                $sql = $conn->prepare("INSERT INTO users(name, username, email, pass, created) VALUES (?,?,?,?,?)");
                $sql->bind_param("sssss",$name,$nick,$email,$pass,$created);
                
                if($sql->execute()){
                    echo "Registerred successfully. Now you can log in";
                }

                else{
                    echo "There was an error";
                }
            }
        }
    }
    
}

if((isset($_POST['action'])) && ($_POST['action'] == 'reset')){
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $token = "qwertyuiopasdfghjklzxcvbnm1234567890";
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);

        $stmt = $conn->prepare("UPDATE users SET token=?, tokenExpire = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
      
        // $mail = new PHPMailer(true);

        // $mail->Host='smtp.gmail.com';
        // $mail->Port=587;
        // $mail->isSMTP();
        // $mail->SMTPAuth = true;
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->Username = "email@gmail.com";
        // $mail->Password = "password";

        // $mail->AddAddress($email);
        // $mail->setFrom('email@gmail.com', 'user');
        // $mail->isHTML(true);
        // $mail->Subject = 'set password';
        // $mail->Body = "<h3>click link below to reset password</h3><br><a href='http://localhost/ajaxregisterlogin/resetPassword.php?email=$email&token=$token'>click this link</a>";
        // if($mail->send()){
        //     echo "We sent you an email with the link to reset your password";
        // }
        // else{
        //     echo "something went wrong";
        // }

        echo "http://localhost/ajaxregisterlogin/resetPassword.php?email=$email&token=$token";

    }
}

if((isset($_POST['action'])) && ($_POST['action'] == 'newpass')){
    $pass1= $_POST['pass1'];
    $pass = password_hash($pass1, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $token = $_POST['token'];
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND token = ? AND tokenExpire > NOW()");
    $stmt->bind_param("ss",$email,$token);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $stmt = $conn->prepare("UPDATE users SET token ='', pass = ? WHERE email = ? AND token = ?");
        $stmt->bind_param("sss",$pass,$email,$token);
        $stmt->execute();
        
        echo "ok";
    }
}


function check_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
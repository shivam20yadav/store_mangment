<?php
include "conn.php";

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $password2 = mysqli_real_escape_string($con,$_POST['confirm_password']);

    if ($uname == "" )
    {
        echo '<script>alert("please enter username")</script>'; 
    }
    else{
        $sql = "select count(*) as cntUser from user where user_name='".$uname."'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);
        $count = $row['cntUser'];

        if($count > 0){
            echo '<script>alert("Username already")</script>'; 
        }

    }
    if ($password == "")
    {
        echo '<script>alert("please enter password")</script>'; 
    }
    elseif(strlen($password) < 4){
        echo '<script>alert("Password must have atleast 4 characters.")</script>'; 
    }
    elseif($password != $password2){
        
        echo '<script>alert("password are not matching")</script>'; 
    }
    else{
        $password = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO user (user_name, password) VALUES ('$uname','$password')";

        $result = mysqli_query($con, $sql);
        echo "$result";
        if ($result)
        {
            header('Location: login.php');
        }
    }   
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <!--css -->
    <style>
        *{
            margin:0;
            padding:0;
        }
        .section{
            width:100%;
            padding-left:40px;
            padding-top:40px;
            padding-right:40px;
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            
        }
        .video-container{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        
        }
        .new{
            z-index: 1;
        }
        .new fieldset{
            margin-right:70px;
            margin-left:20px;
            margin-bottom:130px;
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
        }
        .new h1{
            color:white;
            font-size:25px;
            margin-left:20px;
            font-family:'Comic Sans MS';
        }
        .new input[type='text']{
            width:220px;
            height:30px; 
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
            font-size:10x;
            padding-left:20px;
            margin-right:20px;
            margin-left:20px;
        }
        .new input[type='password']{
            width:220px;
            height:30px; 
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
            font-size:10x;
            padding-left:20px;
            margin-right:20px;
            margin-left:20px;

        }
        .new input[type='submit']{
            width:240px; 
            height:30px; 
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
            font-size:17px;
            padding-left:20px;
            padding-right:20px;
            margin-left:20px;
            margin-right:30px;
            background-color:turquoise;
        }
        .new p{
            margin-left:15px;
            margin-bottom:5px;
            font-size:20px;
            color:white;
            font-family:'Comic Sans MS';
            font-size:14px;
            
        }
        .new a{
            color:yellow;
            text-decoration:none
        } 
        @media screen and (min-width: 1024px) {
            .new fieldset{
                width:350px;
            }
            .new h1{
                font-size:30px;
                padding-left:20px;
            }
            .new input[type='text']{
                width:300px;
                font-size:18px;
            }
            .new input[type=password]{
                width:300px;
                font-size:18px;
            }
            .new input[type=submit]{
                width:320px;
                height:32px;
            }
            .new p{
                margin-top:10px;
                font-size:17px;
            }
        }    
    </style>

</head>

<body>
    <form method="POST">
    <div class="section">
        <div class="new">
            <br><br>
            <fieldset>
                <h1>Creat your account</h1>
                <input type="text" id="user_name" name="username" placeholder="Phone Number,Username, or e-mail">
                <br><br>
                <input type="password" id="user_pass" name = "password" placeholder="Password">
                <br><br>
                <input type="password" id="user_pass2" name = "confirm_password" placeholder="renter the password">
                <br><br>
                <input type="submit" name=but_submit value="Sign up">
                <br><br>
                <hr>
                <p>
                    If you already have Account!<a href="/page/login.php">Click Hear..</a>
                </p>
            </fieldset>
        </div>
        <div class="video-container">
            <div class="color-overlay"></div>
            <video autoplay loop muted>
                <source src="1.mp4" type="video/mp4">
            </video>
        </div>
    </div>
    </form>
</body>

</html>
<?php
include "conn.php";

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    if ($uname != "" && $password != ""){
        $sql = "select * from user where user_name = '".$uname."'";
	    $rs = mysqli_query($con,$sql);
        $numRows = mysqli_num_rows($rs);
        
        if($numRows  == 1){
            $row = mysqli_fetch_assoc($rs);
            if(password_verify($password,$row['password'])){
                $_SESSION['sess_name'] = $uname;
                header('Location: index.php');
            }
            else{
                echo '<script>alert("Wrong username or password")</script>'; 
            }
        }

    }
    else{
        echo '<script>alert("please enter the username or password")</script>'; 
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Hello, world!</title>
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
            border: 1px solid;
            width:300px;
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            border: 2px solid;   
            color:white;         
        }
        .new h1{
            margin-left:85px;
            margin-top:5px;
            font-family:'Comic Sans MS';
        }
        .new input[type=text]{
            width:250px; 
            height:40px; 
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
            font-size:13px;
            padding-left:10px;
            margin-right:20px;
            margin-left:20px
        }
        .new input[type=password]{
            margin-left:20px;
            margin-right:20px;
            width:250px;
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-left-radius:7px;
            border-top-right-radius:7px;
            font-family:'Comic Sans MS';
            font-size:13px;
            height:40px;
            padding-left:10px;
        }
        .new input[type=submit]{
            width:250px;
            height:40px;
            border-bottom-left-radius:7px;
            border-bottom-right-radius:7px;
            border-top-right-radius:7px;
            border-top-left-radius:7px;
            font-family:'Comic Sans MS';
            font-size:20px;
            background-color:turquoise;
            margin-left:20px;
            margin-right:20px; 
        }
        .some{
            display:none;
        }
        .new h3{
            font-size:17px;
            color:white;
        }
        .new .field fieldset{
            width:250px;
            margin-left:20px;
            margin-bottom:10px;
            padding-left:10px;
            padding-top:2px;
        }
        @media screen and (min-width: 1000px) {
            .new fieldset{
                height:400px;
                width:450px;     
            }
            .new h1{
                padding-left:70px;
            }
            .new input[type=text]{
                width:400px; 
                font-size:20px;
            }
            .new input[type=password]{
                width:400px; 
                font-size:20px;
            }
            .new input[type=submit]{
                width:400px; 
                font-size:20px;
            }
            .some{
                display:block;
            }
            .some hr{
                width: 170px;
                display: block;
                display: inline-block;
                color: white;
                border-top: 2px solid;
                margin-left:20px;
            }
            .new h3{
                display:inline-block;
                padding-left:5px;
                padding-right:5px;
            }
            .new .field fieldset{
                width:400px;
                height:50px
            }
            .new .field h3{
                font-size:2px;
            }
        }
        @media screen and (min-width: 1024px) {
            .new h1{
                padding-bottom:1px;
            }
            .new .field h3{
                font-size:20px;
                margin-top:5px;
            }

        }
    </style>    
    
</head>
<body>
    <form method="POST">
        <div class="section">
            <div class="new">
                <fieldset>
                    <h1>Kairav</h1>
                    <br>
                    <input type="text" id="user_nam_login" name="username" placeholder="Phone Number,Username, or e-mail">
                    <br><br>
                    <input type="password" id="user_pas_login" name="password" placeholder="Password" >
                    <br><br>
                    <input type="submit" value="Login" name="but_submit">
                    <br><br>
                    <div class = some>
                        <hr>
                        <h3>OR</h3>
                        <hr>
                    </div>
                    <div class="field">
                        <fieldset>
                            <h3>Don't have account?<a href="signup.php" >&nbsp&nbspSignup</a></h3>
                        </fieldset>
                    </div>
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
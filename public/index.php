<?php
    require ('../vendor/autoload.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Semi+Expanded&display=swap" rel="stylesheet">
</head>
<body>
    <div class="top-container">
        <a href="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">Home</a>
        <a href="">Informations</a>
        <a href="">Chat</a>
        <a href="">Forum</a>
        <button id="homeLog" onclick="location.href='includes/login.php'">Sign In</button>     
    </div>
    <div class="mid-container">
        <div id="eyes">
            <div class="eye1">
                <div class="eyelid">
                    <span></span>
                </div>
                <div class="ball">          
                </div>
            </div>
            <div class="eye2">
                <div class="eyelid">
                    <span></span>
                </div>
                <div class="ball">          
                </div>
            </div>
        </div>
        <h1 class="typewrite">WELCOME</h1>
    </div>
</body>
</html>
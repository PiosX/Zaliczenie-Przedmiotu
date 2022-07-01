<?php
    require ('../../vendor/autoload.php'); 

    $log_in = new \Classes\Controller\UsersContr();

    $email = @$_POST['email'];
    $password = @$_POST['password'];
    $remEmail = $_COOKIE['rememberEmail'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/logstyle.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Semi+Expanded&display=swap" rel="stylesheet">
    <script src="../javascript/randomEye.js"></script>
</head>
<body> 
    <div id="eye">
        <div class="eyelid">
            <span></span>
        </div>
        <div class="ball">          
        </div>
    </div>
    <div id="log-panel">
        <div class="eye-r">
            <div class="ball-r">       
            </div>
        </div>
        <div id="log">
            <h2 id="log-inf">Welcome</h2>
            <form action="" method="POST" id="login-form">
                <input type="email" name="email" placeholder="Email" value = "<?php echo htmlspecialchars($remEmail) ?>"/><br />
                <input type="password" name="password" placeholder="Password" value = ""/><br />
                <label>
                    <input type="checkbox" name="remember" id="rem-box">Remember me
                </label>
                <input type="submit" name="log-sub" value="Sign In" id="log-sub"/>
                <p id="reg">Don't have an account? <a href="register.php">Sign Up</a></p>
            </form>  
            <?php
                if(isset($_POST['log-sub']))
                {
                    $log_in->loginUser($email,$password);
                    
                    if(isset($_POST['remember']))
                    {
                        setcookie('rememberEmail', $_POST['email'], time() + 60*60*24*30);
                    }
                }
            ?>
        </div>
    </div>  
</body>
</html>
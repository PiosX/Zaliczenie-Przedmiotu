<?php
    require ('../../vendor/autoload.php'); 

    $register = new \Classes\Controller\UsersContr();

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/regstyle.css" />
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
    <div id="log-panel" class="gradient-border">
        <div class="eye-r">
            <div class="ball-r">       
            </div>
        </div>
        <div id="regi">
            <h2 id="reg-inf">Sign Up</h2>
            <form action="" method="POST" id="reg-form">
                <input type="text" name="login" placeholder="Login" value="<?php echo htmlspecialchars($login) ?>" /><br />
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email) ?>"/><br />
                <input type="password" name="password" placeholder="Password" value=""/><br />
                <input type="submit" name="reg-sub" value="Sign Up" id="reg-sub"v/>
                <p>Back to <a href="login.php">login</a></p>
            </form>
            <?php
                if(isset($_POST['reg-sub']))
                {
                    $register->createUser($login,$email,$password);
                }
            ?>
        </div>      
    </div>  
</body>
</html>
<?php
session_start();
require ('../../../vendor/autoload.php'); 
$username = new \Classes\View\UsersView();
$avatar = new \Classes\Controller\UsersContr();
$logout = new \Classes\Model\Users();

    if(isset($_GET['action']) && $_GET['action'] == 'logout')
    {  
        $logout->logout('../../index.php?action=logout');
    }
$logout->deleteSessionAFK();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../../css/profile.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Semi+Expanded&display=swap" rel="stylesheet">
    <script src="../../javascript/log_panel.js"></script>
</head>
<body>
    <?php if(isset($_SESSION['login']) || isset($_SESSION['email']))
            { 
    ?>
    <div id="confirm-cont">
        <div id="confirm">
            <p>Confirm Watch</p>
            <input type="submit" name="cancel" id="cancel-but" onclick="checkWatch()" value="Cancel" />
            <form action="" method="POST">
                <input type="submit" name="confirm" id="confirm-but" onclick="checkWatch()" value="Confirm" />
            </form>
        </div>
    </div>
    <div class="top-container">
        <a href="informations.php">Informations</a>
        <a href="chat.php">Chat</a>
        <a href="forum.php">Forum</a>
        <a href="profile.php?profile=<?php echo $_SESSION['login'] ?>" id="actual">Profile</a>
        <div id="avatar">
            <?php
                $username->showTinyAvatar("../../images/");
            ?>
        </div>
        <button id="homeLog" onclick="location.href='?action=logout'">Logout</button>     
    </div>
    <div class="mid-container">

    </div>
    <?php
            }
            else
            {
                echo "<p style='text-align:center;color:white;font-size:20px;'>You are not logged in. Please <a href='../login.php' style='color:#ffff0f;text-decoration:none;'>log in</a> and try again.</p>";
            }
    ?>
</body>
</html>
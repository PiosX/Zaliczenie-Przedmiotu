<?php
session_start();
require ('../../../vendor/autoload.php'); 
    $users = new \Classes\View\UsersView();
    $mess = new \Classes\Controller\UsersContr();
    $logout = new \Classes\Model\Users();
    @$log = $_GET['profile'];
    @$log2 = $_GET['user']; 

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
    <link rel="stylesheet" href="../../css/chat.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Semi+Expanded&display=swap" rel="stylesheet">
    <script src="../../javascript/log_panel.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var auto_refresh = setInterval(function(){
            $('#mess-cont').load('other_includes/chatRefresh.php?user=<?php echo $log2 ?>'); return false;
        }, 1000);
    </script>
</head>
<body>
    <?php if(isset($_SESSION['login']) || isset($_SESSION['email']))
            { 
    ?>
    <div class="top-container">
        <a href="informations.php">Informations</a>
        <a href="chat.php" id="actual">Chat</a>
        <a href="forum.php">Forum</a>
        <a href="profile.php?profile=<?php echo $_SESSION['login'] ?>">Profile</a>
        <div id="avatar">
            <?php
                $users->showTinyAvatar("../../images/");
            ?>
        </div>
        <button id="homeLog" onclick="location.href='?action=logout'">Logout</button>     
    </div>
    <div class="mid-container">
        <div id="users-cont">
            <div id="users-top">
                <p>Watchers(<?php echo $users->countWatchers(); ?>): </p>
            </div>
            <div id="users-online">
                <p>Online(<?php echo $logout->countYourOnlineWatchers(); ?>)</p>
            </div>
                <div id="online-cont">
                    <ul>
                        <?php
                            $users->showYourOnlineWatchers();
                        ?>
                    </ul>
                </div>
            <div id="users-offline">
                <p>Offline(<?php echo $logout->countYourOfflineWatchers(); ?>)</p>
            </div>
                <div id="offline-cont">
                    <ul>
                        <?php
                            $users->showYourOfflineWatchers();
                        ?>
                    </ul>
                </div>    
        </div>
        <?php if(isset($_GET['user'])): ?>
        <div id="chat-cont">
            <div id="send-to">
                <p>Chat with: <span><?php echo $users->showChatUser(); ?></span></p>
            </div>
            <div id="mess-cont">
                <?php $users->showMessages(); ?>
            </div>
            <div id="mess-send">
                <form action="" method="POST" enctype="multipart/form-data">
                    <textarea name="message" cols="52" rows="5" wrap="hard"></textarea>
                    <input type="submit" name="message-sub" id="message-sub" value="Send">
                </form>
                <?php 
                    @$message = $_POST['message'];
                    $mess->sendMessage($message);
                ?>
            </div>
        </div>
        <?php endif; ?>
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
<script> 
    var myDiv = document.getElementById("mess-cont");
    myDiv.scrollTop = myDiv.scrollHeight+100;
</script>
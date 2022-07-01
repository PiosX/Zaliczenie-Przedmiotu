<?php
namespace Classes\Model;

use PDOException;

    class Users extends \Classes\Config\Dbh
    {
        protected function setUser($login,$email,$password)
        {
            if(isset($login) && isset($email) && isset($password) && !empty($login) && !empty($email) && !empty($password))
            {
                $login = trim($login);
                $email = trim($email);
                $password = trim($password);
                $cost = array("cost"=>12);
                $hashPwd = password_hash($password, PASSWORD_BCRYPT, $cost);
                if(filter_var($login, FILTER_SANITIZE_STRING) && filter_var($email, FILTER_SANITIZE_EMAIL))
                {
                    $sql = "SELECT * FROM users WHERE login = :login OR email = :email";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(":login",$login);
                    $stmt->bindParam(":email",$email);
                    $stmt->execute();
                    $stmt->closeCursor();
                    if($stmt->rowCount()==0)
                    {
                        try
                        {
                            $sql = "INSERT INTO users(login,email,password) VALUES(?,?,?)";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute([$login,$email,$hashPwd]);
                            $succes = "User has been created!";
                        }catch(\PDOException $e)
                        {
                            echo "Error: ".$e->getMessage();
                        }
                    }
                    else
                    {
                        $errorR[] = "Login or Email already registered.";
                    }   
                }
                else
                {
                    $errorR[] = "Invalid login or email.";
                }            
            }
            else
            {
                if(!isset($login) || empty($login))
                {
                    $errorR[] = "Login is required.";
                }
                else if(!isset($email) || empty($email))
                {
                    $error[] = "Email is required.";
                }
                else if(!isset($password) || empty($password))
                {
                    $errorR[] = "Password is required.";
                }
            }
            if(isset($errorR) && count($errorR) > 0)
            {
                foreach($errorR as $error_msg)
                {
                    echo "<div class='alert-error'>$error_msg</div>";
                }         
            }
            if(isset($succes))
            {
                echo "<div class='alert-success'>$succes</div>";
            }
        }

        protected function getUser($email,$password)
        {
            if(isset($email) && isset($password) && !empty($email) && !empty($password))
            {
                $email = trim($email);
                $password = trim($password);

                if(filter_var($email, FILTER_SANITIZE_EMAIL) && filter_var($password, FILTER_SANITIZE_STRING))
                {
                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();

                    if($stmt->rowCount()>0)
                    {
                        $row = $stmt->fetch();
                        if(password_verify($password, $row['password']))
                        {
                            unset($row['password']);
                            $this->createUserSession($email);
                            if(isset($_SESSION['email']))
                            {
                                header("Location:content/profile.php?profile=".$_SESSION['login']."");
                                $login = $_SESSION['login'] ?? 'Guest';
                                $sql = "INSERT INTO online_users(login) VALUES('$login')";
                                $stmt = $this->connect()->prepare($sql);
                                $stmt->execute();
                            }
                        }
                        else
                        {
                            $errorL[] = "Invalid Email or Password.";
                        }
                    }
                    else
                    {
                        $errorL[] = "Invalid Email or Password.";
                    }
                }
            }
            else
            {
                if(!isset($email) || empty($email))
                {
                    $errorL[] = "Email is required.";
                }
                else if(!isset($password) || empty($password))
                {
                    $errorL[] = "Password is required.";
                }
            }
            if(isset($errorL) && count($errorL) > 0)
            {
                foreach($errorL as $error_msg)
                {
                    echo "<div class='alert-error'>$error_msg</div>";
                }         
            }
        }

        public function createUserSession($email)
        {
            session_start();
            $_SESSION['email'] = $email;

            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":email", $_SESSION['email']);
            $stmt->execute();
            $row = $stmt->fetch();
            $_SESSION['login'] = $row['login'];
            $_SESSION['time'] = time() + (10*60);
        }

        public function logout($location)
        {
            $login = $_SESSION['login'];
            $sql = "DELETE FROM online_users WHERE login = '$login'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            session_destroy();
            unset($_SESSION['email']);
            unset($_SESSION['login']);
            header("Location:$location");
        }

        public function deleteSessionAFK()
        {
            if(time()>@$_SESSION['time'] && isset($_SESSION['login']))
            {
                $login = $_SESSION['login'] ?? 'Guest';
                $sql = "DELETE FROM online_users WHERE login = '$login'";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                session_destroy();
                unset($_SESSION['email']);
                unset($_SESSION['login']);
                unset($_SESSION['time']);
                header('Location:../../index.php');
            }
        }

        protected function getAllUsers()
        {
            $sql = "SELECT * FROM users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    if($row['login'] == $_SESSION['login'])
                    {
                        echo "<li><a href='profile.php?profile=".$row['login']."' id='me'>".$row['login']."</a></li>";
                    }else
                    {
                        echo "<li><a href='chat.php?user=".$row['login']."' id='users-ch' onclick='showList()'>".$row['login']."</a></li>";
                    }   
                }
            }
        }

        protected function getUserName()
        {    
            $log = $_GET['profile'];
            $sql = "SELECT * FROM users WHERE login = '$log'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo $row['login'];
                }
            }
            
        }

        protected function getChatUser()
        {
            $log = $_GET['user'];
            $sql = "SELECT * FROM users WHERE login = '$log'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo "<a href='profile.php?profile=".$_GET['user']."'>".$row['login']."</a>";
                }
            }
        }
        protected function checkUser()
        {
            $stmt = $this->connect()->prepare("SELECT login FROM users");
            $stmt->execute();
            while($row = $stmt->fetch())
            {
                $loginArr[] = $row['login'];
            }
            if(!in_array($_GET['profile'], $loginArr))
            {
                header("Location:profile.php?profile=".$_SESSION['login']."");
            }
        }
        protected function watchUser()
        {
            $login = $_SESSION['login'];
            $log = $_GET['profile'];
            if(isset($_POST['confirm']))
            {
                $stmt = $this->connect()->prepare("SELECT * FROM check_status WHERE login = '$login' AND set_to = '$log';");
                $stmt->execute();
                if($stmt->rowCount()>1)
                {

                }
                else if($stmt->rowCount()==0)
                {
                    $sql = "INSERT INTO check_status(login,set_to,check_status) VALUES('$login','$log',1);UPDATE user_stats SET watchers = watchers + 1 WHERE login = '$log';";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute();
                }
                else if($stmt->rowCount()==1)
                {
                    $sql = "UPDATE check_status SET check_status = 1 WHERE login = '$login' AND set_to = '$log' AND check_status = 0;UPDATE user_stats SET watchers = watchers + 1 WHERE login = '$log';";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute();
                }     
            }
            $sql = "SELECT check_status FROM check_status WHERE login = '$login' AND set_to='$log' AND check_status=1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()>0)
            {
                echo "<form action='' method='POST'>";
                    echo "<input type='submit' name='watch-unsub' id='watch-unsub' value='Watched &#10003'>";
                echo "</form>";
            }else
            {
                echo "<input type='submit' name='watch-sub' id='watch-sub' onclick='checkWatch()' value='Watch'>";  
            }
            if(isset($_POST['watch-unsub']))
            {
                $sql = "UPDATE check_status SET check_status = 0 WHERE login = '$login' AND set_to = '$log' AND check_status = 1;UPDATE user_stats SET watchers = watchers - 1 WHERE login = '$log';";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                header("Refresh:0");
            }
        }
        protected function getWatchersNumber()
        {
            $log = $_GET['profile'];
            $sql = "SELECT watchers FROM user_stats WHERE login = '$log';";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo $row['watchers'];
                }
            }
        }
        protected function getPostsNumber()
        {
            $log = $_GET['profile'];
            $sql = "SELECT posts FROM user_stats WHERE login = '$log';";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo $row['posts'];
                }
            }
        }
        protected function setMessage($message)
        {
            $log = $_GET['user']; 
            $login = $_SESSION['login'];
            $message = addslashes($message);
            if(isset($_POST['message-sub']))
            {
                if(isset($_POST['message']) && $_POST['message'] != '')
                {
                    $sql = "INSERT INTO messages(send_by,send_to,message) VALUES('$login','$log', '$message')";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute();
                }        
            }
        }
        protected function getMessages()
        {
            $log = $_GET['user']; 
            $login = $_SESSION['login'];

            $sql = "SELECT * FROM messages WHERE (send_by = '$login' AND send_to = '$log') OR (send_by = '$log' AND send_to = '$login')";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    if($row['send_by'] == $login)
                    {
                        echo "<div id='my-mess'>".$row['message']."</div>";
                    }
                    else
                    {
                        echo "<div id='ur-mess'>".$row['message']."</div>";
                    }
                }
            }
        }
        protected function setAvatar()
        {
            $login = $_SESSION['login'];

            if(!empty($_FILES["image"]["name"]))
            {
                define("MB", 1048576);
                if($_FILES['image']['size'] < 5*MB)
                {
                    $fileName = basename($_FILES['image']['name']);
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
                    if(in_array($fileType, $allowedTypes))
                    {
                        $image = $_FILES['image']['name'];
                        $encImage = md5(rand()*rand()+rand()).$image;
                    
                        if(move_uploaded_file($_FILES['image']['tmp_name'],"../../images/".$encImage))
                        {
                            $stmt = $this->connect()->prepare("SELECT * FROM avatars WHERE login = '$login'");
                            $stmt->execute();
                            if($stmt->rowCount()>0)
                            {
                                $stmt = $this->connect()->prepare("UPDATE avatars SET image = '$encImage' WHERE login = '$login'");
                                $stmt->execute();

                                header("Refresh: 0");
                            }
                            else if($stmt->rowCount()==0)
                            {
                                $stmt = $this->connect()->prepare("INSERT INTO avatars(login,image) VALUES('$login', '$encImage')");
                                $stmt->execute();
                                
                                header("Refresh: 0");
                            }
                            
                        } 
                        else
                        {
                            echo "Error.";
                        }
                    }
                    else
                    {
                        echo "Sorry, only JPG, JPEG, PNG OR GIF are allowed to upload.";
                    }
                }
                else
                {
                    echo "File is too big!";
                }
            }
            else
            {
                echo "PLease select an image to upload!";
            }
        }
        protected function getAvatar()
        {
            $log = $_GET['profile'];

            $sql = "SELECT * from avatars WHERE login = '$log'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo "<img src='../../images/".$row['image']."' width='170px' height='170px'>";
                }
            }
        }
        protected function getTinyAvatar($path)
        {
            $login = $_SESSION['login'];

            $sql = "SELECT * FROM avatars WHERE login = '$login'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo "<a href='profile.php?profile=".$login."' id='avatarHref'><img src='".$path.$row['image']."' width='40px' height='40px' id='tinyAvatar'></a>";
                }
            }
        }
        protected function getYourOnlineWatchers()
        {
            $login = $_SESSION['login'];
            @$log = $_GET['user'];

            $sql = "SELECT * FROM check_status WHERE login = '$login'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    $countOnline[] = $row['set_to'];
                }
                $sql = "SELECT * FROM online_users";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {
                    while($row = $stmt->fetch())
                    {
                        if(in_array($row['login'],$countOnline))
                        {
                            echo "<li><a href='chat.php?user=".$row['login']."' id='users-ch'>".$row['login']."</a></li>";
                        }
                    }
                }
            }
        }
        protected function getYourOfflineWatchers()
        {
            $login = $_SESSION['login'];
            @$log = $_GET['user'];

            $sql = "SELECT * FROM online_users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    $countOffline[] = $row['login'];
                }
                $sql = "SELECT * FROM check_status WHERE login = '$login'";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {
                    while($row = $stmt->fetch())
                    {
                        if(!in_array($row['set_to'],$countOffline))
                        {
                            echo "<li><a href='chat.php?user=".$row['set_to']."' id='users-ch'>".$row['set_to']."</a></li>";
                        }
                    }
                }
            }
        }
        public function countYourOfflineWatchers()
        {
            $login = $_SESSION['login'];
            $count = 0;

            $sql = "SELECT * FROM online_users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    $countOffline[] = $row['login'];
                }
                $sql = "SELECT * FROM check_status WHERE login = '$login'";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {
                    while($row = $stmt->fetch())
                    {
                        if(!in_array($row['set_to'],$countOffline))
                        {
                            $count = $count + 1;
                        }
                    }
                    echo $count;
                }
            }
        }
        public function countYourOnlineWatchers()
        {
            $login = $_SESSION['login'];
            @$log = $_GET['user'];
            $count = 0;

            $sql = "SELECT * FROM check_status WHERE login = '$login'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    $countOnline[] = $row['set_to'];
                }
                $sql = "SELECT * FROM online_users";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {
                    while($row = $stmt->fetch())
                    {
                        if(in_array($row['login'],$countOnline))
                        {
                            $count = $count + 1;
                        }
                    }
                    echo $count;
                }
            }
        }
        protected function getUsersRank()
        {
            $rank = 1;
            $sql = "SELECT user_stats.login, user_stats.watchers, user_stats.posts, avatars.image FROM user_stats INNER JOIN avatars ON user_stats.login = avatars.login ORDER BY user_stats.watchers DESC, user_stats.login";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while($row = $stmt->fetch())
                {
                    echo "<tr>";
                        echo "<td id='rankP'>".$rank++."</td>";
                        echo "<td id='rankIm'><img src='../../images/".$row['image']."' width='40px' height='40px'></td>";
                        echo "<td id='rankLink'><a href='profile.php?profile=".$row['login']."'>".$row['login']."</a></td>";
                        echo "<td id='rankPos'>".$row['posts']."</td>";
                        echo "<td id='rankW'>".$row['watchers']."</td>";
                    echo "</td>";
                }
            }
        }
    }
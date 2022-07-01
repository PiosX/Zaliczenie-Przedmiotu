<?php
    namespace Classes\View;

    class UsersView extends \Classes\Model\Users
    {
        public function showAllUsers()
        {
            $result = $this->getAllUsers();
        }
        public function showUserName()
        {
            $result = $this->getUserName();
        }
        public function countUsers()
        {
            $sql = "SELECT * FROM users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
        public function showChatUser()
        {
            $result = $this->getChatUser();
        }
        public function checkUserName()
        {
            $result = $this->checkUser();
        }
        public function watchingUser()
        {
            $result = $this->watchUser();
        }
        public function showWatchersNumber()
        {
            $result = $this->getWatchersNumber();
        }
        public function showPostsNumber()
        {
            $result = $this->getPostsNumber();
        }
        public function showMessages()
        {
            $result = $this->getMessages();
        }
        public function showAvatar()
        {
            $result = $this->getAvatar();
        }
        public function showTinyAvatar($path)
        {
            $this->getTinyAvatar($path);
        }
        public function showYourOnlineWatchers()
        {
            $this->getYourOnlineWatchers();
        }
        public function showYourOfflineWatchers()
        {
            $this->getYourOfflineWatchers();
        }
        public function countWatchers()
        {
            $login = $_SESSION['login'];
            $sql = "SELECT * FROM check_status WHERE login = '$login'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
        public function showUsersRank()
        {
            $this->getUsersRank();
        }
    }
?>
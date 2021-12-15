<?php
    class User
    {
        public $userID;
        public $loginName;
        public $email;
        public $firstName;
        public $lastName;
        public $gender;
        public $dateOfBirth;
        public $address;

        protected $hasPassword;
        protected $isAdmin;
    }
?>

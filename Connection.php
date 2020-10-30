<?php

//When new object is created and fuction connect() is called, conncection to the mysql database is made.

    class Connection{
        private $servername;
        private $username;
        private $password;
        private $dbname;

        protected function connect(){
            $this->servername = "localhost";
            $this->username = "Martins";
            $this->password = "Kiochader123";
            $this->dbname = "records";
        
            $connection = new mysqli($this->servername, $this->username,
            $this->password, $this->dbname);

            return $connection;
        }
    }
?>
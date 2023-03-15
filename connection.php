<?php
    ini_set("display_errors", 1);

    class Database {
        public $host;
        public $user;
        public $password;
        public $db;

        function __construct($host, $user, $password, $db) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->db = $db;
        }

        function queryExec($query){
            $link = mysqli_connect($this->host, $this->user, $this->password, $this->db);
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $query);
            return $result;
        }
    }

    $link = new Database("localhost:3306", "root", "", "backend_project");
    //$link = new DB("mysql-gayaasgarov.alwaysdata.net", "215044", "qaya15102002", "gayaasgarov_backproject");
?>
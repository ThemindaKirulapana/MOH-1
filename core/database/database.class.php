<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "mohmvc";


    protected function connect(): ?PDO
    {
        try {
            $dsn = 'mysql:host=' . $this->host . '; dbname=' . $this->database;
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // echo "Connected successfully" . '<br>';
            return $pdo;

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return null;
    }

  }

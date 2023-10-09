<?php
    session_start(); 
    if (!$_POST) exit('No direct script access allowed');
    $data = $_POST["f"];
    if (isset($data["name"]) && isset($data["surname"])) {
            //Экранирование name
            $data["name"] = str_replace("<", "&lt;", $data["name"]);
            $data["name"] = str_replace(">", "&gt;", $data["name"]);

            //Экранирование surname
            $data["surname"] = str_replace("<", "&lt;", $data["surname"]);
            $data["surname"] = str_replace(">", "&gt;", $data["surname"]);

            try {
                $conn = new PDO("mysql:host=localhost;dbname=whatAsoft", "root", "root");
                $sql = "UPDATE users SET surname = :surname, name = :name WHERE id = :id";
                //определяем prepared statement
                $stmt = $conn->prepare($sql);
                // привязываем параметры к значениям
                $stmt->bindValue(":id", $data["id"]);
                $stmt->bindValue(":surname", $data["surname"]);
                $stmt->bindValue(":name", $data["name"]);

                // выполняем prepared statement
                $affectedRowsNumber = $stmt->execute();

                // если добавлена как минимум одна строка
                if($affectedRowsNumber > 0 ){
                    echo "Data successfully added: name = " . $data["name"] . "; surname = " . $data["surname"]; 
                    $_SESSION["user"]["surname"] = $data["surname"];
                    $_SESSION["user"]["name"] = $data["name"];
                }
            }
            catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }
?>
<?php
    if (!$_POST) exit('No direct script access allowed');
    $data = $_POST["f"];
    if (isset($data["surname"]) && isset($data["name"]) && isset($data["email"]) && isset($data["login"]) && isset($data["pass"])) {
        if(strlen($data["pass"]) < 6){
            echo "Длинна пароля меньше 6 символов!";
            return false;
        }
        else{
            $data["pass"] = md5($data["pass"]);
        }
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
            echo "E-mail адрес " . $data["email"] . " указан неверно.";
            return false;
        }

        //Экранирование surname
            $data["surname"] = str_replace("<", "&lt;", $data["surname"]);
            $data["surname"] = str_replace(">", "&gt;", $data["surname"]);

        //Экранирование name
            $data["name"] = str_replace("<", "&lt;", $data["name"]);
            $data["name"] = str_replace(">", "&gt;", $data["name"]);

        //Экранирование email
            $data["email"] = str_replace("<", "&lt;", $data["email"]);
            $data["email"] = str_replace(">", "&gt;", $data["email"]);

        //Экранирование login
            $data["login"] = str_replace("<", "&lt;", $data["login"]);
            $data["login"] = str_replace(">", "&gt;", $data["login"]);


        try {
            $conn = new PDO("mysql:host=localhost;dbname=u0860712_sandbox3", "u0860712_sand3", "P6c6D9e3");
            $sql = "INSERT INTO users (surname, name, email, login, pass) VALUES (:surname, :name, :email, :login, :pass)";
            //определяем prepared statement
            $stmt = $conn->prepare($sql);
            // привязываем параметры к значениям
            $stmt->bindValue(":surname", $data["surname"]);
            $stmt->bindValue(":name", $data["name"]);
            $stmt->bindValue(":email", $data["email"]);
            $stmt->bindValue(":login", $data["login"]);
            $stmt->bindValue(":pass", $data["pass"]);
            // выполняем prepared statement
            $affectedRowsNumber = $stmt->execute();

            // если добавлена как минимум одна строка
            if($affectedRowsNumber > 0 ){
                echo "Вы успешно зарегестрировались!";  
            }
        }
        catch (PDOException $e) {
            $errorInfo = $e->getMessage();
            if(strpos($errorInfo, "Duplicate entry") !== false && strpos($errorInfo, "for key 'users.email'")){
                echo "Пользователь с таким email уже существует. Пожалуйста, выберите другой email.";
            }
            elseif(strpos($errorInfo, "Duplicate entry") !== false && strpos($errorInfo, "for key 'users.login'")){
                echo "К сожалению, данный логин уже занят. Пожалуйста, выберите другой логин для регистрации.";
            }else{
                echo "Произошла ошибка: " . $e->getMessage() . " (код ошибки: " . $e->getCode() . ")";
            }
        }
    }
?>
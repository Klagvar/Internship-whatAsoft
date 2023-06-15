<?php
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        session_start();
        unset($_SESSION['user']);
        header('Location:../auth/auth.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST['f'];
    }
    if (isset($data["login"]) && isset($data["pass"])) {
        if(strlen($data["pass"]) < 6){
            echo "Длинна пароля меньше 6 символов!";
            return false;
        }
        else{
            $data["pass"] = md5($data["pass"]);
        }  

        //Экранирование login
            $data["login"] = str_replace("<", "&lt;", $data["login"]);
            $data["login"] = str_replace(">", "&gt;", $data["login"]);
            
        try {
            $conn = new PDO("mysql:host=localhost;dbname=whatasoft", "root", "root");
            $sql = "SELECT * FROM users WHERE login=:login AND pass=:pass";
            //определяем prepared statement
            $stmt = $conn->prepare($sql);
            // привязываем параметры к значениям
            $stmt->bindValue(":login", $data["login"]);
            $stmt->bindValue(":pass", $data["pass"]);
            // выполняем prepared statement
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                session_start();
                $_SESSION["user"] = $user;
                echo "Вы успешно авторизировались!";
            } else {
                echo "Неправильный логин или пароль";
            }
        }
        catch (PDOException $e) {
            $errorInfo = $e->getMessage();
            echo "Произошла ошибка: " . $e->getMessage() . " (код ошибки: " . $e->getCode() . ")";
            
        }
    }
?>
<?php 
try {
    $conn = new PDO("mysql:host=localhost;dbname=u0860712_sandbox3", "u0860712_sand3", "P6c6D9e3");
}
catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Изменение</title>
        <meta charset="utf-8" />
        <script defer src="../js/jquery-3.6.4.min.js"></script>
        <script defer src="../js/ajax.js"></script>
    </head>
    <body>
        <?php
        // если запрос GET
        if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
        {
            $id = $_GET["id"];
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            
            $stmt->execute();
            if($stmt->rowCount() > 0){
                foreach ($stmt as $row) {
                    $surname = $row["surname"];
                    $name = $row["name"];
                }
                echo "<h3>Обновление данных</h3>
                        <form id='edit_user'>
                            <input type='hidden' name='f[id]' value='$id' />
                            <p>Surname:
                            <input type='text' name='f[surname]' value='$surname' required/></p>
                            <p>Name:
                            <input type='text' name='f[name]' value='$name' required/></p>
                            <button type='submit' value='Save'>Сохранить</button>
                    </form>";
            }
        }
        else{
            echo "Некорректные данные";
        }
        ?>
        <div id="my_message"></div>
    </body>
</html>
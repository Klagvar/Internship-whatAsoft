<?php 
try {
    $conn = new PDO("mysql:host=localhost;dbname=whatAsoft", "root", "root");
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
        <link rel="stylesheet" href="../css/style_auth.css">
        <script defer src="../js/jquery-3.6.4.min.js"></script>
        <script defer src="../js/ajax.js"></script>
    </head>
    <body>
        <div class = "edit_user">
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
                    echo "
                            <form id='edit_user'>
                                <h3>Обновление данных</h3>
                                <input type='hidden' name='f[id]' value='$id' />
                                <label for='surname'>Фамилия:</label>
                                <input id='surname' type='text' name='f[surname]' value='$surname' required/>
                                <label for='name'>Имя:</label>
                                <input id='name' type='text' name='f[name]' value='$name' required/>
                                <button type='submit' value='Save'>Сохранить</button>
                        </form>";
                }
            }
            else{
                echo "Некорректные данные";
            }
            ?>
            <div id="my_message"></div>
        </div>
    </body>
</html>
<?php 
try {
    $conn = new PDO("mysql:host=localhost;dbname=whatasoft", "root", "root");
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
            $sql = "SELECT * FROM directory WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            // выполняем выражение и получаем строку по id
            $stmt->execute();
            if($stmt->rowCount() > 0){
                foreach ($stmt as $row) {
                    $name = $row["name"];
                    $description = $row["description"];
                    $difficulty = $row["difficulty"];
                }
                echo "<h3>Обновление данных</h3>
                        <form id='edit_directory'>
                            <input type='hidden' name='f[id]' value='$id' />
                            <p>Name:
                            <input type='text' name='f[name]' value='$name' required/></p>
                            <p>Description:
                            <input type='text' name='f[description]' value='$description' required/></p>
                            <p>Difficulty:
                            <input type='number' name='f[difficulty]' value='$difficulty' /></p>
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
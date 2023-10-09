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
        <div class = "edit_directory">
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
                    echo "
                            <form id='edit_directory'>
                                <h3>Обновление данных</h3>
                                <input type='hidden' name='f[id]' value='$id' />

                                <label for='name'>Name:</label>
                                <input id='name' type='text' name='f[name]' value='$name' required/>

                                <label for='description'>Description:</label>
                                <input id='description' type='text' name='f[description]' value='$description' required/>

                                <label for='difficulty'>Difficulty:</label>
                                <input id='difficulty' type='number' name='f[difficulty]' value='$difficulty' />
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
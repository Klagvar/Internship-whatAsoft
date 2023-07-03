<?php
session_start();
if(!isset($_SESSION['user'])) { 
    $new_url = 'auth/auth.php';
    header('Location: '.$new_url);
    } else {
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <meta charset="utf-8">
        <title>Справочник</title>
        <script defer src="js/jquery-3.6.4.min.js"></script>
        <script defer src="js/script.js"></script>
        <script defer src="js/ajax.js"></script>
    </head>
    <body>
        <div class="user-info">
            <div class="user-details">
                <div>
                    <p><?php echo "Ваша фамилия: " . $_SESSION['user']['surname']; ?></p>
                    <p><?php echo "Ваше Имя: " . $_SESSION['user']['name']; ?></p> 
                </div>
                <div>
                    <button onclick="location.href='user/update_user.php?id=<?php echo $_SESSION["user"]["id"]; ?>'">Изменить</button>
                </div>
            </div>
            <div class="user-greeting">
                <div>
                    <h3><?php echo "Привет, " . $_SESSION['user']['login'] . "!"; ?></h3>
                </div>
                <div>
                    <button onclick="location.href='auth/auth_handler.php?action=logout'">Выход</button>
                </div>
            </div>
     
        </div>
        <div>  
            <div id="table-container">
                <h3>Справочник</h3>
                <!--Добавление данных в таблицу-->
                <?php
                //Вывод таблицы
                try {
                    $conn = new PDO("mysql:host=localhost;dbname=u0860712_sandbox3", "u0860712_sand3", "P6c6D9e3");
                    $sql = "SELECT * FROM directory";
                    $result = $conn->query($sql);
                    echo '<table id="table" class="table_sort"><thead><tr><th>id</th><th id="name" >name</th><th>description</th><th>difficulty</th><th></th></tr></thead>';
                    echo "<tbody>";
                    while($row = $result->fetch()){
                        echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["difficulty"] . "</td>";   
                            echo "<td><button type='submit' onclick='updateDirectory(" . $row["id"] . ")'>Изменить</button>";
                            echo "<button type='button' onclick='deleteFromDirectory(" . $row["id"] . ")'>Удалить</button></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                }
                catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
                ?>
            </div>
            <!--Форма отпрвки данных в таблицу-->
            <form id="adding">
                <h3>Добавление</h3>
                <p>Name:
                <input type="text" name="f[name]" required /></p>
                <label for="description">Description:</label>
                <textarea id="description" name="f[description]" required=""></textarea>
                <p>Difficulty:
                <input type="number" min="1" max="5" name="f[difficulty]" /></p>
                <button type="submit" value="Save">Отправить</button>
            </form>
            <div class="button-container">
                <button onclick="location.href='import_export_directory/export_directory.php'">Выгрузить бд</button>
                <button onclick="location.href='import_export_directory/import_directory.php'">Загрузить бд</button>
            </div>
            <?php }?>
            <div></div>
            <div id="my_message"></div>
        </div>
    </body>
</html>
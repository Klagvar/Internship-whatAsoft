<?php
session_start();
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
        <?php if(!isset($_SESSION['user'])) { 
            $new_url = 'auth/auth.php';
            header('Location: '.$new_url);
            } else {?>
            
            <div class="user-info">
                <div class="user-details">
                    <p><?php echo "Ваша фамилия: " . $_SESSION['user']['surname']; ?></p>
                    <p><?php echo "Ваше Имя: " . $_SESSION['user']['name']; ?></p> 
                    <a href='user/update_user.php?id=<?php echo $_SESSION["user"]["id"]; ?>'>Изменить</a>
                </div>
                <div class="user-greeting">
                    <h3><?php echo "Привет, " . $_SESSION['user']['login'] . "!"; ?></h3>
                    <button onclick="location.href='auth/auth_handler.php?action=logout'">Выход</button>
                </div>       
            </div>
        <div class="following-block">  
            <h3>Справочник</h3>

            <!--Добавление данных в таблицу-->
            <?php
            //Вывод таблицы
            try {
                $conn = new PDO("mysql:host=localhost;dbname=whatasoft", "root", "root");
                $sql = "SELECT * FROM directory";
                $result = $conn->query($sql);
                echo '<table id="table" class="table_sort"><thead><tr><th>id</th><th id="name" >name</th><th>description</th><th>difficulty</th></tr></thead>';
                echo "<tbody>";
                while($row = $result->fetch()){
                    echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["difficulty"] . "</td>";
                        echo "<td><a href='directory/update_directory.php?id=" . $row["id"] . "'>Изменить</a></td>";
                        echo "<td><form action='directory/delete_from_directory.php' method='post' onsubmit='return del()'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "' />
                                    <input type ='submit' value='Удалить'>
                                </form></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
            ?>
            <h3>Добавление</h3>
            
            <!--Форма отпрвки данных в таблицу-->
            <form id="adding">
                <p>Name:
                <input type="text" name="f[name]" required /></p>
                <label for="description">Description:</label>
                <textarea id="description" name="f[description]" required=""></textarea>
                <p>Difficulty:
                <input type="number" min="1" max="5" name="f[difficulty]" /></p>
                <button type="submit" value="Save">Отправить</button>
            </form>
            <br>
            <button onclick="location.href='import_export_directory/import_directory.php'">Загрузить бд</button>
        <?php }?>
            <div></div>
            <div id="my_message"></div>
        </div>
    </body>
</html>
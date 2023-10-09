<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style_import_directory.css">
        <meta charset="utf-8">
        <title>Загрузка бд</title>
    </head>
    <body>
        <div class="import">
            <form id="import" action="../import_export_directory/import_directory.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file">
                <button type="submit" value="Загрузить файл">Загрузить файл</button>
            </form>
            <div class="button-container">
                <button onclick="location.href='../index.php'">Вернуться</button>
            </div>
            <div id="my_message">
    
    <?php
    $host = "localhost";
    $user = "root";
    $password = "root";
    $dbname = "whatAsoft";

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Установка кодировки UTF-8 для соединения с базой данных
    $conn->set_charset("utf8");

    // Проверяем был ли отправлен файл
    if(isset($_FILES['file'])) {
        // Получаем информацию о файле
        $fileName = $_FILES['file']['name'];
        $fileTmpName  = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
       
        $targetDirectory = '../import_export_directory/';
        $targetFilePath = $targetDirectory . $fileName;

        if(move_uploaded_file($fileTmpName, $targetFilePath)) {
            // Файл успешно загружен на сервер
            // Открытие файла CSV для чтения данных
            if (($handle = fopen($fileName, "r")) !== FALSE) {
                // Добавление BOM для кодировки UTF-8
                $csv = "\xEF\xBB\xBF";
                    
                $row_number = 0;
                $header_row = true;
                // Чтение данных из файла CSV и запись в переменную $csv
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if ($header_row) {
                        // Пропуск первой строки с заголовками столбцов
                        $header_row = false;
                        continue;
                    }

                    $num = count($data);
                    for ($c = 0; $c < $num; $c++) {
                        if($c == 0){
                            // Первый столбец - id (автоинкремент)
                            continue;
                        } else if ($c == 1){
                            // Второй столбец - name (строка)
                            $name = mysqli_real_escape_string($conn,$data[$c]);
                        } else if ($c == 2){
                            // Третий столбец - description (строка)
                            $description = mysqli_real_escape_string($conn,$data[$c]);
                        } else if ($c == 3){
                            // Четвертый столбец - difficulty (число)
                            $difficulty = mysqli_real_escape_string($conn,$data[$c]);
                            if($difficulty == '')
                                $difficulty = 3;
                        }
                    }
                       
                    //Экранирование name
                    $name = str_replace("<", "&lt;", $name);
                    $name = str_replace(">", "&gt;", $name);

                    //Экранирование decription
                    $description = str_replace("<", "&lt;", $description);
                    $description = str_replace(">", "&gt;", $description);

                    //Деэкранирование теков <b></b>, <u></u>, <br> в decription
                    $description = str_replace("&lt;b&gt;", "<b>", $description);
                    $description = str_replace("&lt;/b&gt;", "</b>", $description);
                    $description = str_replace("&lt;u&gt;", "<u>", $description);
                    $description = str_replace("&lt;/u&gt;", "</u>", $description);
                    $description = str_replace("&lt;br&gt;", "<br>", $description);

                    // Формируем запрос на добавление строки в таблицу БД
                    $sql = "INSERT INTO directory(name,description,difficulty) VALUES ('$name','$description', $difficulty)";
                       
                    // Выполнение запроса к базе данных с логированием ошибок 
                    if(checkData($name, $description, $difficulty))
                    {
                        if (!$result = mysqli_query($conn,$sql)) 
                        { 
                            error_log("Ошибка при выполнении запроса: ".mysqli_error($conn));
                            echo "Ошибка при выполнении запроса: ".mysqli_error($conn);
                        }
                    } else {
                        echo "Данные не прошли проверку: name: " . $name . "число символов: " . strlen($name) .", description: " . $description . ", difficulty: " . $difficulty . "<br>";
                    }
                    $row_number++;
                }
                fclose($handle);
                echo "Файл успешно загружен!";
                $logDirectory = '../import_export_directory/';
                $logMessage = date('Y-m-d H:i:s') . " - Обработан файл: " . $fileName . PHP_EOL;
                $logFile = $logDirectory . 'import.log';
                file_put_contents($logFile, $logMessage, FILE_APPEND);
                unlink($targetFilePath);
            } else {
                echo "Ошибка при открытии файла";
                unlink($targetFilePath);
            }
        } else 
            echo 'Ошибка при загрузке файла на сервер';
    } else 
        echo 'Файл не был отправлен';
    

    // Закрытие подключения к базе данных
    $conn->close();

    function checkData($name, $description, $difficulty) 
    {
        // Проверка названия
        if (empty($name)) {
            return false; // Недопустимое название
        }

        // Проверка описания
        if (empty($description)) {
            return false; // Недопустимое описание
        }

        // Проверка сложности
        if (!is_numeric($difficulty) || $difficulty < 1 || $difficulty > 5) {
            return false; // Недопустимая сложность
        }

        return true; // Все проверки пройдены, данные допустимы
    }
    ?>
            </div>
        </div>
    </body>
</html>
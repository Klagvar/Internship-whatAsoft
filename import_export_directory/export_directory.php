<?php
    $host = "localhost";
    $user = "root";
    $password = "root";
    $dbname = "whatasoft";

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Установка кодировки UTF-8 для соединения с базой данных
    $conn->set_charset("utf8");

    // Выборка всех терминов из базы данных
    $sql = "SELECT * FROM directory";
    $result = $conn->query($sql);

    // Открытие файла CSV для записи
    $file = fopen("directory_export.csv", "w");

    // Добавление BOM для кодировки UTF-8
    fwrite($file, "\xEF\xBB\xBF");

    // Запись данных в файл CSV
    if ($result->num_rows > 0) {
        // Запись заголовков столбцов (если необходимо)
        $headers = array("id", "name", "description", "difficulty"); // Замените на свои заголовки
        fputcsv($file, $headers, ';');

        // Запись данных
        while ($row = $result->fetch_assoc()) {
            fputcsv($file, $row, ';');
        }
    } else {
        echo "0 results";
    }

    // Закрытие файла и подключения к базе данных
    fclose($file);
    $conn->close();
?>
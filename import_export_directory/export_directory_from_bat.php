<?php
    $host = "localhost";
    $user = "root";
    $password = "root";
    $dbname = "whatasoft";

    $conn = new mysqli($host, $user, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $sql = "SELECT * FROM directory";
    $result = $conn->query($sql);
    
    // Генерация названия файла с датой
    $date = date('d-m-Y'); // Формат даты (год-месяц-день)
    $filename = "directory_export_" . $date . ".csv";

    // Открытие файла для записи
    $file = fopen($filename, "w");
    fwrite($file, "\xEF\xBB\xBF"); // Добавление BOM для поддержки UTF-8

    if ($result->num_rows > 0) 
    {
        $headers = array("id", "name", "description", "difficulty"); 
        fputcsv($file, $headers, ';');
        while ($row = $result->fetch_assoc()) 
            fputcsv($file, $row, ';');
    } else {
        echo "0 results";
    }

    fclose($file);
    $conn->close();
?>
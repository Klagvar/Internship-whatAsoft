<?php
    $host = "localhost";
    $user = "u0860712_sand3";
    $password = "P6c6D9e3";
    $dbname = "u0860712_sandbox3";
    
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $sql = "SELECT * FROM directory";
    $result = $conn->query($sql);

    // Генерация названия файла
    $date = date('d-m-Y'); 
    $filename = "directory_export_" . $date . ".csv";

    // Установка заголовков HTTP
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    // Запись данных в файл CSV
    $output = fopen('php://output', 'w');
    fwrite($output, "\xEF\xBB\xBF"); // BOM для корректного отображения русских символов
    
    if ($result->num_rows > 0) 
    {
        $headers = array("id", "name", "description", "difficulty"); 
        fputcsv($output, $headers, ';');
        while ($row = $result->fetch_assoc()) 
        {
            fputcsv($output, $row, ';');
        }
    } else 
    {
        echo "0 results";
    }

    fclose($output);
    $conn->close();
?>
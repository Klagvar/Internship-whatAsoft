<?php
	if (!$_POST) exit('No direct script access allowed');
	$data = $_POST["f"];
	if (isset($data["name"]) && isset($data["description"])) {
			//Экранирование name
			$data["name"] = str_replace("<", "&lt;", $data["name"]);
			$data["name"] = str_replace(">", "&gt;", $data["name"]);

			//Экранирование decription
			$data["description"] = str_replace("<", "&lt;", $data["description"]);
			$data["description"] = str_replace(">", "&gt;", $data["description"]);

			//Деэкранирование теков <b></b>, <u></u>, <br> в decription
			$data["description"] = str_replace("&lt;b&gt;", "<b>", $data["description"]);
			$data["description"] = str_replace("&lt;/b&gt;", "</b>", $data["description"]);
			$data["description"] = str_replace("&lt;u&gt;", "<u>", $data["description"]);
			$data["description"] = str_replace("&lt;/u&gt;", "</u>", $data["description"]);
			$data["description"] = str_replace("&lt;br&gt;", "<br>", $data["description"]);

            try {
                $conn = new PDO("mysql:host=localhost;dbname=whatAsoft", "root", "root");
                $sql = "UPDATE directory SET name = :name, description = :description, difficulty = :difficulty WHERE id = :id";
                //определяем prepared statement
                $stmt = $conn->prepare($sql);
                // привязываем параметры к значениям
                $stmt->bindValue(":id", $data["id"]);
                $stmt->bindValue(":name", $data["name"]);
                $stmt->bindValue(":description", $data["description"]);
                if($data["difficulty"] == '')
                    $data["difficulty"] = 3;

                $stmt->bindValue(":difficulty", $data["difficulty"]);
                // выполняем prepared statement
                $affectedRowsNumber = $stmt->execute();

                // если добавлена как минимум одна строка
                if($affectedRowsNumber > 0 ){
                    echo "Data successfully added: name = " .$data["name"] . "; description = " . $data["description"] . "; difficulty= " . $data["difficulty"] ;  
                }
            }
            catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }
?>
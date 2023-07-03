<?php
if(isset($_POST["id"]))
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=u0860712_sandbox3", "u0860712_sand3", "P6c6D9e3");
        $sql = "DELETE FROM directory WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $_POST["id"]);
        $stmt->execute();
        echo json_encode(["success" => true]);
    }
    catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
    }
}
?>
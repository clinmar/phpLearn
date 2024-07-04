<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $sql = "DELETE FROM role WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);

        $param_id = $_GET["id"];

        if ($stmt->execute()) {
            header("location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
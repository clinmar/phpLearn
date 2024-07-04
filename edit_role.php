<?php
include 'db.php';

$roleName = "";
$roleName_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["roleName"]))) {
        $roleName_err = "Please enter a role name.";
    } else {
        $roleName = trim($_POST["roleName"]);
    }

    if (empty($roleName_err)) {
        $sql = "UPDATE role SET name = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $param_roleName, $param_id);

            $param_roleName = $roleName;
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
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $sql = "SELECT * FROM role WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $param_id);

            $param_id = trim($_GET["id"]);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    $roleName = $row["name"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    } else {
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Role</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Edit Role</h2>
        <p>Please edit the role name and submit to update the role.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>" method="post">
            <div class="form-group <?php echo (!empty($roleName_err)) ? 'has-error' : ''; ?>">
                <label>Role Name</label>
                <input type="text" name="roleName" class="form-control" value="<?php echo $roleName; ?>">
                <span class="help-block"><?php echo $roleName_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="roles.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
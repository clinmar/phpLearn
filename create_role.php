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
        $sql = "INSERT INTO role (name) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_roleName);

            $param_roleName = $roleName;

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
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Role</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Create Role</h2>
        <p>Please fill this form to create a role.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($roleName_err)) ? 'has-error' : ''; ?>">
                <label>Role Name</label>
                <input type="text" name="roleName" class="form-control" value="<?php echo $roleName; ?>">
                <span class="help-block"><?php echo $roleName_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
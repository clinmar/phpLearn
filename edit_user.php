<?php
// Include the database connection file
include 'db.php';

// Define variables and initialize with empty values
$name = $age = $role_id = "";
$name_err = $age_err = "";

// Fetch roles from the database
$sql_roles = "SELECT id, name FROM role";
$result_roles = $conn->query($sql_roles);
$roles = [];
if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Retrieve user information based on GET parameter
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Prepare a select statement
    $sql = "SELECT id, name, age, role_id FROM user WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                // Fetch data
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $name = $row["name"];
                $age = $row["age"];
                $role_id = $row["role_id"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate age (optional, can be NULL)
    if (!empty(trim($_POST["age"]))) {
        if (!is_numeric($_POST["age"])) {
            $age_err = "Age must be a number.";
        } else {
            $age = trim($_POST["age"]);
        }
    }

    // Validate role_id
    $role_id = $_POST["role_id"]; // No need to validate if it's coming from dropdown

    // Check input errors before updating in database
    if (empty($name_err) && empty($age_err)) {
        // Prepare an update statement
        $sql = "UPDATE user SET name = ?, age = ?, role_id = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("siii", $param_name, $param_age, $param_role_id, $param_id);

            // Set parameters
            $param_name = $name;
            $param_age = $age;
            $param_role_id = $role_id;
            $param_id = $_GET["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to users list page
                header("location: users.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Edit User</h2>
        <p>Please fill this form to edit the user.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                <span class="help-block"><?php echo $age_err; ?></span>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role_id" class="form-control">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $role_id)
                               echo 'selected="selected"'; ?>><?php echo $role['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="users.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
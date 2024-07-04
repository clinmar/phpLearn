<?php
include ("db.php");

$sql = "SELECT * FROM role";
$result = $conn->query($sql);

?>


<?php
include ("head.php");
?>


<div class="container m-5">
    <div class="row">



        <div class="col-12 col-lg-6">
            <div class="row">

                <div class="col-6">
                    <h4>
                        List of the role

                    </h4>
                </div>
            </div>


            <div class="mb-3">
                <a href="create_role.php" class="btn btn-primary">Create</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_role.php?id=" . $row["id"] . "' class='btn btn-sm btn-primary mr-2'>Edit</a>";
                            echo "<a href='delete_role.php?id=" . $row["id"] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this role?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";

                        }
                    }

                    ?>

                </tbody>
            </table>


        </div>


        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1>
                        Lorem ipsum dolor sit

                    </h1>
                </div>
                <div class="card-body">
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quaerat voluptas excepturi facere
                        cum illum! Nisi laborum labore aspernatur minus, nam nostrum cumque quae error quidem nobis
                        assumenda, incidunt soluta? Delectus!
                    </p>
                </div>
            </div>

        </div>
    </div>

    <?php
    include ("footer.php");
    ?>
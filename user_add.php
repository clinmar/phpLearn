<!DOCTYPE html>
<html lang="en">
<?php
include ("head.php");

?>

<body>

    <div class="container m-5 d-flex justify-content-center">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1>
                        Add user
                    </h1>
                </div>
                <div class="card-body">
                    <form>
                        <label class="form-label">
                            Name
                        </label>
                        <input class="form-control" type="text" required>

                        <label class="form-label">
                            Name
                        </label>
                        <input class="form-control" type="number" required  >


                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <a href="index.php" class="btn btn-primary mt-1 form-control">
                                    Back
                                </a>
                            </div>
                            <div class="col-6 col-lg-6">
                                <button class="btn btn-secondary form-control mt-1">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>


<?php
include ("footer.php");
?>
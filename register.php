
<?php
    session_start();  
   
?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register using hash and salt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <main class="container d-flex justify-content-center">

            <form class="col-md-5 m-5 p-5 formReg" action="process.php" method="post">
                <input type="hidden" name="action" value="register">
<?php
                if(!empty($_SESSION['errors']))
                {
                    foreach($_SESSION['errors'] as $errors)
                    { ?>
                <label class="form-label text-danger"><?=$errors?></label>
<?php               }
                    unset($_SESSION['errors']);
                }
                if(!empty($_SESSION['success']))
                { ?>
                <label class="form-label text-success"><?=$_SESSION['success']?></label>
<?php           } unset($_SESSION['success']) ?>
                <h1>Register page</h1>

                <div class="mb-3 mt-3">
                    <label class="form-label">First Name:</label>
                    <input type="text" class="form-control" placeholder="Enter First Name" name="first_name">
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Last Name:</label>
                    <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name">
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Mobile number:</label>
                    <input type="text" class="form-control" placeholder="Enter Mobile number" name="number">
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" placeholder="Enter password" name="password">
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Password Confirm:</label>
                    <input type="password" class="form-control" placeholder="Enter password" name="password_confirm">
                </div>

                <input type="submit" class="btn btn-primary">
            </form>

        </main>
    </body>
</html>
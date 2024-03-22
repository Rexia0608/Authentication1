
<?php
    session_start();

    unset($_SESSION['logged_in']);
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login sample with hash and salt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <main class="container d-flex justify-content-center">
           
            <form class="col-md-4 m-5 p-5 form-log" action="process.php" method="POST">
                <input type="hidden" name="action" value="login">
                <h1>Login page</h1>
                <div class="mb-3 mt-3">
                    <label class="form-label">Mobile number:</label>
                    <input type="text" class="form-control" placeholder="Enter mobile number" name="number">
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
                </div>

                <div class="form-check mb-3">
<?php
                    if(isset($_SESSION['errors']))
                    {
                        foreach($_SESSION['errors'] as $errors)
                    { ?>
                    <label class="form-label text-danger"><?=$errors?></label>
<?php               }
                        unset($_SESSION['errors']);
                    } ?>

                </div>
                <input type="submit" class="btn btn-primary">
            </form>

        </main>
    </body>
</html>
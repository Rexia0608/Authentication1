
<?php
    session_start();


    if(isset($_SESSION['logged_in']) == true)
    {
          $name_by_user = $_SESSION['first_name'];
    }
    else
    {
        $_SESSION['logged_in'] == false;
        header('Location: index.php');
        die();
    }
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome Page example</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>

        <div class="container d-flex justify-content-center">
            <section class="col-md-5 m-4 p-5 rounded card">
                <h1 class="text-center">Welcome <?=$name_by_user?> </h1>

                    <form action="process.php" method="post">
                    <input type="hidden" name="action" value="changepass">
                        <label class="form-label">Reset you password here</label>
                        <input type="text" class="col-md-8 form-control" placeholder="Enter mobile number" name="number">

                        <?php
                    if(isset($_SESSION['errors']))
                    {
                        foreach($_SESSION['errors'] as $errors)
                    { ?>
                        <label class="form-label text-danger"><?=$errors?></label>
<?php               }
                        unset($_SESSION['errors']);
                    } ?>
<?php                if(!empty($_SESSION['success']))
                    { ?>
                        <label class="form-label text-success"><?=$_SESSION['success']?></label>
<?php               } unset($_SESSION['success']) ?>

                        <div class="footer-form">
                            <input type="submit" class="btn btn-primary mt-2" value="submit">
                            <a href="index.php" class="btn btn-danger mt-2">Log-out</a>
                        </div>
                    </form>
            </section>

        </div>
    </body>
</html>
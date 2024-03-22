<?php

    // connection to db
    require ('connection.php');
    session_start();

    //  checking action post each field of registeration form and sending to validation process
    if(isset($_POST['action']) && $_POST['action'] == "register" )
    {
        register_user($_POST);
    }
    //  checking action post each field of login form and sending this to login process
    else if(isset($_POST['action']) && $_POST['action'] == "login" )
    {
        login_user($_POST);
    }
    else if(isset($_POST['action']) && $_POST['action'] == "changepass" )
    {
        change_user_pass($_POST);
    }
    else
    {
        session_destroy();
        header('Locaion:index.php');
        die();
    }
    

        // registeration function validation for each condition
        function register_user($post)
        {
            $_SESSION['errors'] = array();
            if (empty($_POST['first_name']))
            {
                $_SESSION['errors'][] = "first name can't be empty.";
            }
            if (strlen($_POST['first_name']) < 2)
            {
                $_SESSION['errors'][] = "Your first name is too short. ! !";
            }
            if(is_numeric($_POST['first_name']))
            {
                $_SESSION['errors'][] = "first name must not contain number.";
            }
            if (empty($_POST['last_name']))
            {
                $_SESSION['errors'][] = "last name can't be empty.";
            }
            if (is_numeric($_POST['last_name']))
            {
                $_SESSION['errors'][] = "last name must not contain number.";
            }
            if (strlen($_POST['last_name']) < 2)
            {
                $_SESSION['errors'][] = "Your last name is too short. ! !";
            }
            if (empty($_POST['number']))
            {
                $_SESSION['errors'][] = "Field are empty kindly put your mobile number.!";
            }
            if (!is_numeric($_POST['number']))
            {
                $_SESSION['errors'][] = "Your mobile number must not contain letter or special character.!";
            }
            if (strlen($_POST['number']) !== 11 )
            {
                $_SESSION['errors'][] = "Your mobile number must have 11 digit number.";
            }
            if (substr($_POST['number'], 0, 2) !== '09')
            {
                $_SESSION['errors'][] = "Your mobile number must a proper format of 09123456789";
            }
            if (empty($_POST['password']))
            {
                $_SESSION['errors'][] = "password can't be empty";
            }
            if (strlen($_POST['password']) < 8)
            {
                $_SESSION['errors'][] = "password are too short it should be minimum of 8 character.";
            }
            if ($_POST['password'] !== $_POST['password_confirm'])
            {
                $_SESSION['errors'][] = "Your password didn't match password!";
            }
                header('Location: register.php');

            // -----------------end of validation ----------------------------
            if(count($_SESSION['errors']) > 0)
            {
                header('Location: register.php');
                die();
            }
            else
            {
                //________________ Salt encryption and hash by md5 insert from Db.table ______________________________
                //________reminder the data type of salt column in db, should be string only______________________________________
          
                $number = escape_this_string($_POST['number']);
                $password = escape_this_string($_POST['password']);
                $salt = bin2hex(openssl_random_pseudo_bytes(22));
                $encrypted_password = md5($password . '' . $salt);
                $query = "INSERT INTO `users`(`first_name`, `last_name`, `number`, `password`,`salt`, `created_at`, `updated_at`) VALUES ('{$_POST['first_name']}','{$_POST['last_name']}','{$number}','{$encrypted_password}','{$salt}',NOW(), NOW())";
                run_mysql_query($query);
                $_SESSION['success'] = "Success to register your account.";
                header('Location: register.php');
                die();
            }
        }

        function login_user($post)
        {
        
             //________________ Salt decryption and hash by md5 selecet from Db.table______________________________
            $number = escape_this_string($_POST['number']);
            $password = escape_this_string($_POST['password']);
            $query = "SELECT * FROM users WHERE users.number = '{$number}'";
            $user = fetch_record($query);
            
            if(!empty($user))
            {   
                $encrypted_password = md5($password . '' . $user['salt']);
                if($user['password'] == $encrypted_password)
                {   
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['logged_in'] = true;
                    header('Location: welcome.php');
                    die();
                }
                else if($user['password'] !== $encrypted_password)
                {
                    $_SESSION['errors'][] = "Wrong password it didn't match";
                    header('Location:index.php');
                    die();
                }
                else
                {
                    $_SESSION['errors'][] = "Wrong password!";
                    header('Location:index.php');
                    die();
                }
            }
            else
            {
                $_SESSION['errors'][] = "Account doesn't exist kindly register.!!";
                header('location:index.php');
                die();
            }
        }

        function change_user_pass($post)
        {   
            $_SESSION['success'] = array();
            $_SESSION['errors'] = array();
            if (empty($_POST['number']))
            {
                $_SESSION['errors'][] = "Field are empty kindly put your mobile number.!";
            }
            if (!is_numeric($_POST['number']))
            {
                $_SESSION['errors'][] = "Your mobile number must not contain letter or special character.!";
            }
            if (strlen($_POST['number']) !== 11 )
            {
                $_SESSION['errors'][] = "Your mobile number must have 11 digit number.";
            }
            if (substr($_POST['number'], 0, 2) !== '09')
            {
                $_SESSION['errors'][] = "Your mobile number must a proper format of 09123456789";
            }
            
            // validation checking part
            if(!empty($_SESSION['errors']))
            {
                header('Location: welcome.php');
                die();
            }
            // inserting to db and turn the current pass to default pass village88
            if (empty($_SESSION['errors']) && isset($_SESSION['logged_in']) == true)
            {   

                $default_pass = "village88";
                $current_user = escape_this_string($_SESSION['user_id']);
                $password = escape_this_string($default_pass);
                $salt = bin2hex(openssl_random_pseudo_bytes(22));
                $encrypted_password = md5($password . '' . $salt);
                $number = escape_this_string($_POST['number']);
                $query = "UPDATE `users` SET `number` = '{$number}', `password` = '{$encrypted_password}', `salt` = '{$salt}', `created_at` = NOW(), `updated_at` = NOW()
                WHERE `id` = '$current_user'";
                run_mysql_query($query); 
                $_SESSION['success'] = "Password reset you can use temporary password '$default_pass'";
                header('Location: welcome.php');




                // UPDATE users
                // SET password = value1, salt = value2, ...
                // WHERE condition;

            }
        }
    
?>



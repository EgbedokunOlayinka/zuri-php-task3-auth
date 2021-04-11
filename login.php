<?php
    require_once './index.php';

    if (isset($_SESSION['email'])) {
        header('Location: home.php');
    };

    $msg = '';
    $msgClass = '';

    if (isset($_POST['submit'])) {
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);

        if (!empty($email) && !empty($password)) {
            $filename = 'db.json';

            if (!file_exists($filename)) {
                touch($filename);
            };

            $file = file_get_contents($filename);
            $jsonfile = json_decode($file);

            if ((filesize($filename) == 0 && trim(file_get_contents($filename) == false)) || !(isset($jsonfile->$email))) {
                $msg = 'Incorrect login details';
                $msgClass = 'alert-danger';
            } else {
                if ($password === $jsonfile->$email) {
                    // session_start();
                    $_SESSION["email"] = $email;

                    $email = '';
                    $password = '';

                    header('Location: home.php');
                } else {
                    $msg = 'Incorrect login details';
                    $msgClass = 'alert-danger';
                }
            }
        } else {
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
    
    // collect form data
    // check if not empty
    // check if email is present
    // check if password matches
    // create session
    // redirect to home
?>
    <div class="container my-3">
        <div class="box py-3 mx-auto">
            <h2 class='text-center'>Login</h2> 

            <?php if ($msg !== ''): ?>
                <div class="alert alert-dismissible fade show <?php echo $msgClass; ?>">
                    <strong><?php echo $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method='POST'>
                <div class="my-4">
                    <label class="form-label">Email address</label>
                    <input required type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
                </div>
                <div class="my-4">
                    <label class="form-label">Password</label>
                    <input required minlength='4' type="password" class="form-control" name='password' value="<?php echo isset($_POST['password']) ? $password : ''; ?>">
                </div>
                <div style='margin-top: 3rem'>
                    <input class="btn btn-primary w-100" type='submit' name='submit' value='Submit'>
                </div>
            </form>
        
        </div>
    </div>
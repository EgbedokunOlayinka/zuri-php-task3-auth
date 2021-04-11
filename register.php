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
     $confirm = htmlentities($_POST['confirm']);

     if (!empty($email) && !empty($password) && !empty($confirm)) {
         if ($password === $confirm) {
             $filename = 'db.json';

             if (!file_exists($filename)) {
                 touch($filename);
             };

             $file = file_get_contents($filename);
             $jsonfile = json_decode($file);

             if (!(filesize($filename) == 0 && trim(file_get_contents($filename) == false))) {
                 if (isset($jsonfile->$email)) {
                     $msg = 'Email already exists';
                     $msgClass = 'alert-danger';
                 } else {
                     $jsonfile->$email = $password;
                     $saveFile = file_put_contents($filename, json_encode($jsonfile));

                     $msg = 'Registration successful!';
                     $msgClass = 'alert-success';

                     $email = '';
                     $password = '';
                     $confirm = '';
                 }
             } else {
                 $newArray = [$email => $password];
                 $saveFile = file_put_contents($filename, json_encode($newArray));

                 $msg = 'Registration successful!';
                 $msgClass = 'alert-success';

                 $email = '';
                 $password = '';
                 $confirm = '';
             }
         } else {
             $msg = 'Passwords do not match';
             $msgClass = 'alert-danger';
         }
     } else {
         $msg = 'Please fill in all fields';
         $msgClass = 'alert-danger';
     }
 };
?>

    <div class="container my-3">
        <div class="box py-3 mx-auto">
            <h2 class='text-center'>Register</h2> 

            <?php if ($msg !== ''): ?>
                <div class="alert alert-dismissible fade show <?php echo $msgClass; ?>">
                    <strong><?php echo $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method='POST'>
                <div class="my-4">
                    <label class="form-label">Email address</label>
                    <input required type="email" class="form-control" name='email' value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
                </div>

                <div class="my-4">
                    <label class="form-label">Password</label>
                    <input required minlength='4' type="password" class="form-control" name='password' value="<?php echo isset($_POST['password']) ? $password : ''; ?>">
                </div>

                <div class="my-4">
                    <label class="form-label">Confirm Password</label>
                    <input required minlength='4' type="password" class="form-control" name='confirm' value="<?php echo isset($_POST['confirm']) ? $confirm : ''; ?>">
                </div>

                <div style='margin-top: 3rem'>
                    <input class="btn btn-primary w-100" type='submit' name='submit' value='Submit'>
                </div>
            </form>
        
        </div>
    </div>
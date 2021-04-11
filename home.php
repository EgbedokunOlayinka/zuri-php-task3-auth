<?php
    require_once './index.php';
    // session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: login.php');
    };
?>

<div class="container my-3">
    <div class="box py-3 mx-auto">
        <h2 class='text-center'>Welcome</h2>
        <p class="text-center">
            <?php echo $_SESSION['email']; ?>
        </p> 
    </div>
</div>
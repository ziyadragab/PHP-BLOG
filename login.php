<?php require_once('inc/connection.php'); ?>
<?php require('inc/header.php'); ?>
<?php require('inc/navbar.php'); ?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $message['login']?></h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none"><?php echo $message['back']?></a>
                </div>
            </div>
            <div class="container w-50">

     <?php if(! empty($_SESSION['errors'])):
     foreach($_SESSION['errors'] as $error):
        ?>
        <div class="alert alert-danger">
        <?php echo $error; ?>
        </div>
        <?php endforeach;  endif;  
        unset($_SESSION['errors']);
        ?>
    </div>

            <form method="POST" action="handle/handle-login.php">
    
                <div class="mb-3">
                    <label for="email" class="form-label"><?php echo $message['email']?></label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
    
                <div class="mb-3">
                    <label for="password" class="form-label"><?php echo $message['password']?></label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                
                <button type="submit" class="btn btn-primary" name="submit"><?php echo $message['login']?></button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>
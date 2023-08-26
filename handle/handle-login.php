<?php 

require_once '../inc/connection.php';

if(isset($_POST['submit'])) {
    $email =trim(htmlspecialchars($_POST['email']));
    $password =trim(htmlspecialchars($_POST['password']));

$errors = [];
    if($email==''){
        $errors[]= "email is required";
    }elseif(! filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "enter validate email";
    }

    if($password =="") {
        $errors[] = "password is required";
    }elseif(strlen($password)<6){
        $errors[] = "password must be more than 6";
    }


    if(empty($errors)){
    $query = "select * from users where `email`='$email'";
    $result  = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){
      $user =   mysqli_fetch_assoc($result);
      $oldpassword = $user['password'];
      $is_valid =   password_verify($password,$oldpassword);

      if($is_valid) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['success'] = "welcome ".$user['name'];
        header('location:../index.php');
        exit();
      }else{
        $_SESSION['errors'] = ["crediantals not correct"];
        header('location:../login.php');
        exit();
      }
    }else{
        $_SESSION['errors'] = ["this account not exist"];
        header('location:../login.php');
        exit();
        
    } }else {
        $_SESSION['errors'] = $errors;
        $_SESSION['email'] = $email;
        header('location:../login.php');
        exit();

    }


}else{
    header('location:../login.php');
        exit();

}

// md5 sha1 password_hash  
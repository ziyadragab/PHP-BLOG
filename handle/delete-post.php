<?php

    require_once '../inc/connection.php';

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query="select * from posts where id=$id";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==1){
            $post=mysqli_fetch_assoc($result);
            $image=$post['image'];
            unlink("../uploads/$image");

            $post=mysqli_fetch_assoc($result);
            $image=$post['image'];
            unlink("../uploads/$image");
            $query="delete from posts where id=$id";
            $result=mysqli_query($conn,$query);
            if($result){
            $_SESSION['delete']="The Post Deleted Successfully";

            header("location:../index.php");
            }else{
                $_SESSION['errors']="Error While Deleting";
                header("location:../index.php");

            }
        }else{
            $_SESSION['errors']="Post Not Found";
            header("location:../index.php");
        }
    }else{
        header("location:../index.php");
    }

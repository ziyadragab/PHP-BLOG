<?php
 
require_once('../inc/connection.php');

if (isset($_POST['submit'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));
    $imageName = '';

    $errors = [];

    if (empty($title)) {
        $errors[] = "The Title is Required";
    } elseif (is_numeric($title)) {
        $errors[] = "Title Must be a String";
    }

    if (empty($body)) {
        $errors[] = "The Body is Required";
    } elseif (is_numeric($body)) {
        $errors[] = "Body Must be a String";
    }

    if ($_FILES && isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $tmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $sizeMb = $imageSize / (1024 * 1024);
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $newName = uniqid() . '.' . $imageExtension;

        if ($sizeMb > 1) {
            $errors[] = "Image Must be Less Than 1MB";
        }
    }else{
        $newName='';
    }

    if (empty($errors)) {
        $query = "INSERT INTO posts (`title`, `body`, `image`, `user_id`) VALUES ('$title', '$body', '$newName', 1)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if ($_FILES && isset($_FILES['image'])) {
                move_uploaded_file($tmpName, "../uploads/$newName");
            }

            $_SESSION['success'] = "Post Inserted Successfully";
            header("location: ../index.php");
            exit();
        } else {
            $errors[] = "Failed to Insert Post";
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['title'] = $title;
    $_SESSION['body'] = $body;

    header("location: ../create-post.php");
    exit();
} else {
    header("location: ../index.php");
    exit();
}
?>
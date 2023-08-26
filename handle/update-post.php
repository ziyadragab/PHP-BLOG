<?php
require_once '../inc/connection.php';

if (isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id']; // Retrieve the post ID from the URL parameter
        $title = htmlspecialchars(trim($_POST['title']));
        $body = htmlspecialchars(trim($_POST['body']));
        $imageName = '';

        $errors = [];

        if (!is_string($title)) { // Check if title is not a string
            $errors[] = "Title must be a string";
        }

        if (!is_string($body)) { // Check if body is not a string
            $errors[] = "Body must be a string";
        }

        $query = "SELECT * FROM posts WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $post = mysqli_fetch_assoc($result);
            $oldName = $post['image'];
        } else {
            // Handle the case when the post with the given ID is not found
            $_SESSION['errors'] = "Post not found";
            header("location:../index.php");
            exit();
        }

        if ($_FILES && $_FILES['image']['name']) {
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $tmpName = $image['tmp_name'];
            $imageSize = $image['size'];
            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            // $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $newName = uniqid() . '.' . $imageExtension;
        } else {
            $newName = $oldName;
        }

        if (empty($errors)) {
            $query = "UPDATE posts SET `title`='$title', `body`='$body', `image`='$newName' WHERE `id`='$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION['success'] = "Post updated successfully";

                if (($_FILES['image']['name'])) {
                    // Only move the uploaded file if a new image was selected
                    move_uploaded_file($tmpName, "../uploads/$newName");
                    unlink("../uploads/$oldName");
                }

                header("location:../show-post.php?id=" . $id);
                exit();
            } else {
                $_SESSION['errors'] = 'Error occurred while updating the post';
                header("location:../edit-post.php?id=" . $id);
                exit();
            }
        } else {
            $_SESSION['errors'] = $errors;
            header("location:../edit-post.php?id=" . $id);
            exit();
        }
    } else {
        header("location:../index.php");
        exit();
    }
} else {
    header("location:../index.php");
    exit();
}
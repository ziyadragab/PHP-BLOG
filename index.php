<?php 
require_once('inc/connection.php');
require_once('inc/functions.php');
require_once('inc/header.php');
require_once('inc/navbar.php');

// Display success message if available
if (!empty($_SESSION['success'])) {
  echo '<div class="container w-50"><div class="alert alert-success">' . $_SESSION['success'] . '</div></div>';
  unset($_SESSION['success']);
}

// Display delete message if available
if (!empty($_SESSION['delete'])) {
  echo '<div class="container w-50"><div class="alert alert-danger">' . $_SESSION['delete'] . '</div></div>';
  unset($_SESSION['delete']);
}

// Pagination
$limit = 2;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of posts
$queryOfCount = "SELECT COUNT(id) AS total FROM posts";
$result = mysqli_query($conn, $queryOfCount);
$total = mysqli_fetch_assoc($result)['total'];

// Calculate number of pages
$numberOfPages = ceil($total / $limit);

// Redirect to the first page if an invalid page number is provided
if ($page > $numberOfPages || $page < 1) {
  header("Location: index.php?page=1");
  exit();
}

// Fetch posts for the current page
$query = "SELECT * FROM posts LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container-fluid pt-4">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="d-flex justify-content-between border-bottom mb-5">
        <h3><?php echo $message['all posts']?></h3>
        <div>
          <a href="create-post.php" class="btn btn-sm btn-success"><?php echo $message['add new post']?></a>
        </div> 
      </div>

      <?php if (validPage($page, $numberOfPages)): ?>
        <?php if (!empty($posts)): ?>
          <table class="table">
            <thead>
              <tr>
                <th scope="col"><?php echo $message['title']?></th>
                <th scope="col"><?php echo $message['Published At']?></th>
                <th scope="col"><?php echo $message['Actions']?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($posts as $post): ?>
                <tr>
                  <td><?php echo $post['title']; ?></td>
                  <td><?php echo $post['created_at']; ?></td>
                  <td>
                    <a href="show-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary"><?php echo $message['show']?></a>
                    <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-secondary"><?php echo $message['edit']?></a>
                    <a href="handle/delete-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you really want to delete the post?')"><?php echo $message['delete']?></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="alert alert-info">No Posts Found!</div>
        <?php endif; ?>
      <?php endif; ?>
     
     
      <div class="d-flex justify-content-center">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item <?php if($page==1) echo "disabled" ?> ">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" tabindex="-1" aria-disabled="true"><?php echo $message['Previous']?></a>
    </li>
    <li class="page-item"><a class="page-link" href="#"><?php echo $page; ?>&nbsp; of &nbsp; <?php echo $numberOfPages ?></a></li>
    <li class="page-item <?php if($page==$numberOfPages) echo "disabled" ?> ">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>"><?php echo $message ['next']?></a>
    </li>
  </ul>
</nav>
</div>

    </div>
  </div>
</div>
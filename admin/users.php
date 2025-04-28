<?php
session_start();
include("../connection.php");

// عملية الحذف
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query_check = "SELECT * FROM customers WHERE Customer_id = ?";
    $stmt_check = $con->prepare($query_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $stmt = $con->prepare("DELETE FROM customers WHERE Customer_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully'); window.location.href='users.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error deleting user'); window.location.href='users.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='users.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users</title>
  <link rel="stylesheet" href="../Css/admin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet">
</head>

<body>

<div class="primary-nav">

  <button class="hamburger open-panel nav-toggle">
    <span class="screen-reader-text">Menu</span>
  </button>

  <nav role="navigation" class="menu">

    <a href="#" class="logotype">Story<span>Time</span></a>

    <div class="overflow-container">

      <ul class="menu-dropdown">
        <br>
        <li><a href="admins.php">Admins</a></li>
        <li><a href="add-admin.php">Add new Admin</a></li>
        <li><a href="admin-Book-list.php">Books List</a></li>
        <li><a href="add-book.php">Add Books</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="admin-login.php" onclick="logout()">Logout</a></li>
      </ul>

    </div>

  </nav>

</div>

<div class="new-wrapper">
  <div id="main">
    <div id="main-contents">
      <div>
        <h2 id="title">Story Time Users</h2>
        <hr>

        <?php
        $query = "SELECT * FROM `customers`;";
        $sql = mysqli_query($con, $query);

        if (mysqli_num_rows($sql) > 0) {
          while ($row = mysqli_fetch_array($sql)) {
        ?>
            <div class="admin-name">
              <h3><?php echo htmlspecialchars($row['Customer_UserName']); ?></h3>
              <form action="" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="id" value="<?php echo $row['Customer_ID']; ?>">
                <button type="submit" name="action" value="delete" class="button">
                  <svg viewBox="0 0 448 512" class="svgIcon">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                  </svg>
                </button>
              </form>
            </div>
        <?php
          }
        } else {
          echo "<p>No users found.</p>";
        }
        ?>

      </div>
    </div>
  </div>
</div>

<script src="/Js/admin.js"></script>

<script>
function logout() {
  alert("Logged out successfully");
  <?php unset($_SESSION['Admin_Username']); ?>
}

function confirmDelete() {
  return confirm('Are you sure you want to delete this user?');
}
</script>

</body>
</html>

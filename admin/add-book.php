<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet">
  <title>Home</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../Css/admin.css">
  <link rel="stylesheet" href="../Css/admin-books.css">
</head>

<body>
  <div class="primary-nav">
    <button href="#" class="hamburger open-panel nav-toggle">
      <span class="screen-reader-text">Menu</span>
    </button>
    <nav role="navigation" class="menu">
      <a href="#" class="logotype">Story<span>Time</span></a>
      <div class="overflow-container">
        <ul class="menu-dropdown">
          <br>
          <li><a href="admins.php">Admins</a><span class="icon"><i class="fa fa-dashboard"></i></span></li>
          <li><a href="add-admin.php">Add new Admin</a><span class="icon"><i class="fa fa-envelope"></i></span></li>
          <li><a href="admin-Book-list.php">Books List</a><span class="icon"><i class="fa fa-dashboard"></i></span></li>
          <li><a href="add-book.php">Add Books</a><span class="icon"><i class="fa fa-dashboard"></i></span></li>
          <li><a href="users.php">Users</a><span class="icon"><i class="fa fa-heart"></i></span></li>
          <li><a href="admin-login.php" onclick="logout()">Logout</a><span class="icon"><i class="fa fa-envelope"></i></span></li>
          <script>
            function logout() {
              <?php unset($_SESSION['Admin_Username']) ?>
              alert("Logged out successfully");
            }
          </script>
        </ul>
      </div>
    </nav>
  </div>

  <div class="new-wrapper">
    <div id="main">
      <div id="main-contents">
        <div>
          <h2 id="title">Add a Book</h2>
          <hr>
          <form action="" method="post" enctype="multipart/form-data" class="add-admin-form" style="margin-top: 15px;">
            <input placeholder="Book Title" type="text" name="Book_Title" class="input">
            <input placeholder="Book Description" type="text" name="Book_Description" class="input">
            <input placeholder="Book Genres" type="text" name="Book_Genres" class="input">
            <input placeholder="Book Price" type="number" name="Book_Price" class="input">
            <label for="type">Book Image:</label>
            <input placeholder="Book Image" type="file" name="Book_Image" class="input" accept="image/*">
            <label for="type">Book Type:</label>
            <select name="Book_Type" class="input" style="height: 50px;">
              <option value="Novel">Novel</option>
              <option value="Book">Book</option>
              <option value="Manga">Manga</option>
            </select>

            <button type="submit" name="action" class="add-admin"> Add Book! </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="/Js/admin.js"></script>

  <?php
  include("../connection.php");
  
  if (@$_POST['action']) {
    if ($_POST['action'] == 'submit') {
      $Book_Title = $_POST['Book_Title'];
      $Book_Description = $_POST['Book_Description'];
      $Book_Genres = $_POST['Book_Genres'];
      $Book_Price = $_POST['Book_Price'];
      $Book_Type = $_POST['Book_Type'];

      // Handle the image upload
      $image_name = $_FILES['Book_Image']['name'];
      $image_tmp = $_FILES['Book_Image']['tmp_name'];

      // Get the image extension
      $extension = pathinfo($image_name, PATHINFO_EXTENSION);

      // Generate a unique name for the image
      $new_image_name = uniqid('IMG-', true) . '.' . $extension;

      // Path where the image will be saved
      $upload_path = "../images/books/" . $new_image_name;

      // Move the uploaded image to the server folder
      if (move_uploaded_file($image_tmp, $upload_path)) {
        // Store the image name in the database
        $Book_img = $new_image_name;

        // SQL query to insert book details into database
        $sql = "INSERT INTO books (Book_title, Book_description, Book_price, book_type, Book_genre, Book_img) 
                VALUES ('$Book_Title', '$Book_Description', $Book_Price, '$Book_Type', '$Book_Genres', '$Book_img')";

        if ($con->query($sql) === TRUE) {
          echo "<script>
                  alert('New book has been added successfully');
                  window.location.href = 'add-book.php';
                </script>";
        } else {
          echo "Error: " . $sql . "<br>" . $con->error;
        }
      } else {
        echo "<script>alert('Failed to upload image. Please try again.');</script>";
      }
    }
  }
  ?>
</body>
</html>

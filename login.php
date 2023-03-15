<?php
include('connection.php');

$invalidPassword = False;
$invalidEmail = False;
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $queryLogin = "SELECT * FROM users WHERE email='$email';";
  $resultLogin = $link->queryExec($queryLogin);
  $row = mysqli_fetch_assoc($resultLogin);

  if (mysqli_num_rows($resultLogin) == 1) {
    if ($password == $row['password']) {
      session_destroy();
      session_start();
      $_SESSION['user_id'] = $row['idUser'];
      $_SESSION['first_name'] = $row['firstname'];
      $_SESSION['last_name'] = $row['lastname'];
      $_SESSION['email'] = $row['email'];
      header("Location:index.php");
    } else {
      $invalidPassword = True;
    }
  } else {
    $invalidEmail = True;
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="loginPageStyle.css">
  <title>Document</title>
</head>

<body>
  <section>
    <div class="container-login">
      <h2>CrowFunding Website</h2>
      <?php
      if ($invalidEmail == True) {
        echo "<div role=\"alert\">";
        echo "Error/div>";
      }
      if ($invalidPassword == True) {
        echo "<div role=\"alert\">";
        echo "Error</div>";
      }

      ?>

      <form action="" method="POST" name="loginform">
        <div class="email-con">
          <label for="typeEmailX-2">Email</label>
          <input type="email" name="email" placeholder="Enter email"/>
        </div>
        <div class="pass-con">
          <label for="typePasswordX-2">Password</label>
          <input type="password" name="password" placeholder="Enter Password" />
        </div>

        <div class="button-con">
          <button type="submit" name="login">Login</button>
        </div>
      </form>
    </div>
  </section>
</body>

</html>
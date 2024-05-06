<?php 
  require '../../config/database.php';

  session_start();
  if(isset($_SESSION['is_auth']) and $_SESSION['is_auth'] == true)
  {
    header('Location:'.$url.'/views/user/dashboard.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi User</title>
  <link rel="stylesheet" href="/tugas-11/views/asset/css/form-auth.css">
</head>

<body>
  <div class="container">
    <div class="cover">
      <form name="form-registrasi" action="/tugas-11/app/controllers/AuthController.php?action=register" method="post" onsubmit="return validateRegis()" class="form">
        <div class="head-form">
          <h1 class="title-form">Selamat Datang!</h1>
          <span>Silahkan register akun anda</span>
        </div>
        <div class="flex"><a href="/tugas-11/views/auth/login.php"><hr class="hr-grey"></a><hr class="hr-violet"></div>
        <div class="main-form">
          <div class="email input">
            <label class="label" for="email">Email</label>
            <input class="form-input" type="email" name="email" id="email" autofocus>
            <small class="red-text" id="message-email"></small>
          </div>
          <div class="username input">
            <label class="label" for="username">Username</label>
            <input class="form-input" type="text" name="username" id="username">
            <small class="red-text" id="message-username"></small>
          </div>
          <div class="password input">
            <label class="label" for="password">Password</label>
            <input class="form-input" type="password" name="password" id="password">
            <small class="red-text" id="message-password"></small>
          </div>
          <button type="submit" class="btn-form">Submit</button>
        </div> 
        <div class="footer-form">
          <p>Sudah punya akun ? <a href="/tugas-11/views/auth/login.php">Masuk</a></p>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
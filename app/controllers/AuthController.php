<?php
require "../../app/models/AuthModel.php";

if(isset($_GET['action']) and $_GET['action'] == 'login') {
  AuthController::login();
}
else if(isset($_GET['action']) and $_GET['action'] == 'register') {
  AuthController::register();
}
else if(isset($_GET['action']) and $_GET['action'] == 'logout') {
  AuthController::logout();
}

class AuthController{
  
  static function login(){

    global $url;

    if (empty($_POST["username"])) {
      echo "<script>alert('Kolom username tidak boleh kosong');window.location.href = '/tugas-11/views/auth/login.php'</script>";
      exit(); 
    } 
    else if (empty($_POST["password"])) {
      echo "<script>alert('Kolom password tidak boleh kosong');window.location.href = '/tugas-11/views/auth/login.php'</script>";
      exit();
    }
    if (strlen($_POST["password"]) < 8) {
      echo("<script>alert('Kolom judul minimal input 8 karakter');window.location.href = '/tugas-11/views/auth/login.php'</script>");
      exit();
    }

    $data = AuthModel::getdata($_POST["username"]);

    if ($_POST["username"] != $data[0]['username']) {
      echo("<script>alert('Kolom username salah');window.location.href = '/tugas-11/views/auth/login.php'</script>");
      exit();
    }
    if ($_POST["password"] != $data[0]['password']) {
      echo("<script>alert('Kolom password salah');window.location.href = '/tugas-11/views/auth/login.php'</script>");
      exit();
    }

    session_start();
    $_SESSION["nama_pengguna"] = $data[0]['username'];
    $_SESSION["email"] = $data[0]['email'];
    $_SESSION["id_user"] = $data[0]['id_user'];
    $_SESSION["is_auth"] = true;
    
    header('Location: '.$url.'/views/user/dashboard.php');
    exit();
  }

  static function register(){

    global $url;

    if (empty($_POST["username"])) {
      echo "<script>alert('Kolom username tidak boleh kosong');window.location.href = '/tugas-11/views/auth/register.php'</script>";
      exit(); 
    } 
    else if (empty($_POST["password"])) {
      echo "<script>alert('Kolom password tidak boleh kosong');window.location.href = '/tugas-11/views/auth/register.php'</script>";
      exit();
    }
    else if (empty($_POST["email"])) {
      echo "<script>alert('Kolom email tidak boleh kosong');window.location.href = '/tugas-11/views/auth/register.php'</script>";
      exit();
    }
    if (strlen($_POST["password"]) < 8) {
      echo("<script>alert('Kolom judul minimal input 8 karakter');window.location.href = '/tugas-11/views/auth/register.php'</script>");
      exit();
    }

    $data = AuthModel::getdata($_POST["username"]);

    if ($data[0]['username'] != "") {
      echo("<script>alert('Uesrname sudah dipakai!');window.location.href = '/tugas-11/views/auth/register.php'</script>");
      exit();
    }

    $result = AuthModel::register($_POST['email'], $_POST['username'], $_POST['password']);

    if($result){

      $data = AuthModel::getdata($_POST["username"]);
      session_start();
      $_SESSION["nama_pengguna"] = $data[0]['username'];
      $_SESSION["email"] = $data[0]['email'];
      $_SESSION["id_user"] = $data[0]['id_user'];
      $_SESSION["is_auth"] = true;
    
      header('Location: '.$url.'/views/user/dashboard.php');
      exit();
    }
    else {
      echo("<script>alert('gagal register, ulangi kembali');window.location.href = '/tugas-11/views/auth/register.php'</script>");
      exit();
    }

  }

  static function logout(){
    global $url;
    session_start();
    session_unset();
    session_destroy();
    header('Location:  '.$url.'/views/auth/login.php');
  }
}
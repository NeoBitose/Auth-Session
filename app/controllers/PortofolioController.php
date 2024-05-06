<?php
require "../../app/models/PortofolioModel.php";

if(isset($_GET['action']) and $_GET['action'] == 'create') {
  PortofolioController::create();
}
else if(isset($_GET['action']) and $_GET['action'] == 'update') {
  PortofolioController::update();
}
else if(isset($_GET['action']) and $_GET['action'] == 'delete') {
  PortofolioController::delete();
} 

class PortofolioController{

  static function index(){
    $data = PortofolioModel::read();
    return $data;  }

  public static function create(){
    global $url;

    if (empty($_POST["judul"])) {
      echo "<script>alert('Kolom judul tidak boleh kosong');window.location.href = '/tugas-11/views/user/create.php'</script>";
      exit(); 
    } 
    else if (empty($_POST["deskripsi"])) {
      echo "<script>alert('Kolom deskripsi tidak boleh kosong');window.location.href = '/tugas-11/views/user/create.php'</script>";
      exit();
    } 
    else if (empty($_POST["link"])) {
      echo "<script>alert('Kolom link tidak boleh kosong');window.location.href = '/tugas-11/views/user/create.php'</script>";
      exit();
    } 
    else if (empty($_POST["tanggal"])) {
      echo "<script>alert('Kolom tanggal tidak boleh kosong');window.location.href = '/tugas-11/views/user/create.php'</script>";
      exit();
    }

    if (!preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["judul"])) {
      echo("<script>alert('Kolom judul hanya input huruf dan angka saja');window.location.href = '/tugas-11/views/user/create.php'</script>");
      exit();
    }

    if (strlen($_POST["judul"]) < 5) {
      echo("<script>alert('Kolom judul minimal input 5 karakter');window.location.href = '/tugas-11/views/user/create.php'</script>");
      exit();
    }
    else if (strlen($_POST["judul"]) > 40) {
      echo("<script>alert('Kolom judul maksimal input 40 karakter');window.location.href = '/tugas-11/views/user/create.php'</script>");
      exit();
    }

    if ($_FILES['gambar']['name'] != '') {
      $extension = substr($_FILES['gambar']['name'],strlen($_FILES['gambar']['name'])-4,strlen($_FILES['gambar']['name']));
      $file = md5($_FILES['gambar']['name']).time().$extension;
      $result = move_uploaded_file($_FILES['gambar']['tmp_name'], '../../views/asset/img/'.$file);
      $data = PortofolioModel::create($_POST["judul"],$_POST["deskripsi"],$_POST["link"],$_POST["tanggal"],$file);
      header("Location:".$url."/views/user/portofolio.php");
    } 
    else {
      $data = PortofolioModel::create($_POST["judul"],$_POST["deskripsi"],$_POST["link"],$_POST["tanggal"],null);
      header("Location:".$url."/views/user/portofolio.php");
    }
  }

  public static function detail(){
    $data = PortofolioModel::detail($_GET["id"]);
    return $data;
  }

  public static function update(){
    global $url;

    if (empty($_POST["judul"])) {
      echo "<script>alert('Kolom judul tidak boleh kosong');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>";
      exit(); 
    } 
    else if (empty($_POST["deskripsi"])) {
      echo "<script>alert('Kolom deskripsi tidak boleh kosong');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>";
      exit();
    } 
    else if (empty($_POST["link"])) {
      echo "<script>alert('Kolom link tidak boleh kosong');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>";
      exit();
    } 
    else if (empty($_POST["tanggal"])) {
      echo "<script>alert('Kolom tanggal tidak boleh kosong');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>";
      exit();
    }

    if (!preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["judul"])) {
      echo("<script>alert('Kolom judul hanya input huruf dan angka saja');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>");
      exit();
    }

    if (strlen($_POST["judul"]) < 5) {
      echo("<script>alert('Kolom judul minimal input 5 karakter');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>");
      exit();
    }
    else if (strlen($_POST["judul"]) > 40) {
      echo("<script>alert('Kolom judul maksimal input 40 karakter');window.location.href = '/tugas-11/views/user/update.php?id=".$_POST["id"]."'</script>");
      exit();
    }

    if ($_FILES['gambar']['name'] != '') {
      $extension = substr($_FILES['gambar']['name'],strlen($_FILES['gambar']['name'])-4,strlen($_FILES['gambar']['name']));
      $file = md5($_FILES['gambar']['name']).time().$extension;

      $data = PortofolioModel::detail($_POST["id"]);
      if ($data->gambar_porto != null) {
        if (file_exists('../../views/asset/img/'.$data->gambar_porto)) {
          unlink('../../views/asset/img/'.$data->gambar_porto);
        } 
      }
      
      $result = move_uploaded_file($_FILES['gambar']['tmp_name'], '../../views/asset/img/'.$file);
      $data = PortofolioModel::update($_POST["id"],$_POST["judul"],$_POST["deskripsi"],$_POST["link"],$_POST["tanggal"],$file);
      header("Location:".$url."/views/user/portofolio.php");
    } 
    else {
      $data = PortofolioModel::update($_POST["id"],$_POST["judul"],$_POST["deskripsi"],$_POST["link"],$_POST["tanggal"],null);
      header("Location:".$url."/views/user/portofolio.php");
    }
  }

  public static function delete(){
    global $url;
    $data = PortofolioModel::detail($_GET["id"]);
    if ($data->gambar_porto != null) {
      if (file_exists('../../views/asset/img/'.$data->gambar_porto)) {
        unlink('../../views/asset/img/'.$data->gambar_porto);
      } 
    }
    $data = PortofolioModel::delete($_GET["id"]);
    header("Location:".$url."/views/user/portofolio.php");
  }
}
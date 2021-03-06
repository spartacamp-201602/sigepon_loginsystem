<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!empty($_SESSION['id'])){
  unset($_SESSION['id']);
  header('Location: login.php');
  exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = $_POST['name'];
  $password = $_POST['password'];

  //バリデーション
  $errors = array();
  if ($name == ''){
    $errors[] = 'ユーザネームが未入力です';
  }

  if ($password == ''){
    $errors = 'パスワードが未入力です';
  }

  if(empty($errors)){
    $dbh = connectDatabase();

    // $sql = 'select * from users where';
    // $sql.= 'name = :name and password = :password';
    $sql = "select * from users where name = :name and password = :password";
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":password", $password);

    $stmt->execute();

    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // var_dump($row);

    if($user){
      $_SESSION['id'] = $user['id'];
      header('Location: index.php');
      exit;
    }else{
      $errors[] = 'ユーザーかパスワードが間違っています';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン画面</title>
</head>
<body>
  <h1>ログイン画面です</h1>


 <!--  <?php //if(isset($errors)): ?>
    <div style="color: red; list-style: none;">
      <?php //foreach ($errors as $error): ?>
        <li><?php //echo $error; ?></li>
      <?php //endforeach; ?>
    </div> -->

  <form action="" method="post">
    ユーザネーム: <input type="text" name="name"><br>
    パスワード: <input type="text" name="password"><br>
    <input type="submit" value="ログイン">
  </form>
  <a href="signup.php">新規ユーザー登録はこちら</a>
</body>
</html>

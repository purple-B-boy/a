<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body id="makeAccount">
<section id="login-section">
    <h1 class="pageTitle">SNOWS</h1>
    <h2 class="pageTitle">アカウント作成</h2>
    <div class="form">
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password']; // パスワードはハッシュ化するべきです

  // ユーザー名が既に存在するかチェック
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    echo '<p style="color:red;">このアカウントはすでに使用されています。</p>';
  } else {
    // ユーザー名が存在しない場合、新しいアカウントを作成
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password); // 第二引数のパスワードはハッシュ化するべきです
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header("Location: register_end.php");
    } else {
      echo '<p style="color:red;">ログインに失敗しました。</p>';
    }
  }
  
  $stmt->close();
}

$conn->close();
?>
      <form method="post" action="">
        <p>Username</p> <input type="text" name="username" class="username"><br>
        <p>Password</p> <input type="password" name="password" class="password"><br>
        <input type="submit" value="作成" class="make">
      </form><br>
    </div>
    <ul class="link">
      <li><a href="login.php">ログイン画面に戻る</a></li>
      <li><a href="index.php">ホームに戻る</a></li>
    </ul>
  </section>
</body>
</html>

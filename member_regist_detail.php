<?php
session_start();
require('dbconnect.php');
// ★★
if (!isset($_SESSION['join'])) {
    header ('Location: member_regist.php');
    exit();
}


// ★★
if(!empty($_POST['action'])){
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT); //hash化

    $statement = $db->prepare('INSERT INTO members SET lastname=?,firstname=?,gender=?,prefecture=?,
                               address=?,password=?,email=?');
    $statement->execute(array(
        $_SESSION['join']['lastname'],
        $_SESSION['join']['firstname'],
        $_SESSION['join']['gender'],
        $_SESSION['join']['prefecture'],
        $_SESSION['join']['address'],
        $_SESSION['join']['password'],
        $_SESSION['join']['email'],
        $hash));

    unset($_SESSION['join']);
    header('Location: member_regist_confirm.php');
    exit();
}

// function h($string) {
//     return htmlspecialchars($string, ENT_QUOTES);
//   }

?>

<!------------------------------------------------------------------------------------------------------------------>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報確認画面</title>
</head>
<body>
    <div class="regist-confirm">
    <form action="" method="post">
    <input type="hidden" name="action" value="submit">

            <h1>会員情報確認画面</h1>

            <p>氏名：
            <span class="check"><?php echo (htmlspecialchars($_SESSION['join']['lastname'],$_SESSION['join']['firstname'], ENT_QUOTES)); ?></span>
            </p>
            <br> 
            <p>性別：
            <span class="check"><?php echo (htmlspecialchars($_SESSION['join']['gender'], ENT_QUOTES)); ?></span>
            </p>
            <br> 
            <p>住所：
            <span class="check"><?php echo (htmlspecialchars($_SESSION['join']['prefecture'],$_SESSION['join']['address'], ENT_QUOTES)); ?></span>
            </p>
            <br> 
            <p>パスワード：セキュリティのため非表示</p>
            <br> 
            <p>メールアドレス：</p>
            <span class="check"><?php echo (htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?></span>
            <br> 
            <input type="submit" onclick="location.href='member_regist_confirm.php'" name="regist-btn" value="登録完了" class="button">
            <br> <br> <br>
            <input type="button" onclick="location.href='member_regist.php?action=rewrite'" name="rewrite" value="前に戻る" class="bk-btn">





    </form>
    </div>
    
</body>
</html>
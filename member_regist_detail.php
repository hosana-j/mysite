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
            <h1>会員情報確認画面</h1>
            <p>氏名：<?php echo $_REQUEST['lastname'],$_REQUEST['firstname'];?></p>
            <br> 
            <p>性別：<?php 
                        switch($_REQUEST['gender']){
                            case 'man':
                                echo '男性';
                                break;
                            case'women':
                                echo'女性';
                                break;    
                        } ?></p>
            <br> 
            <p>住所：<?php 
            echo $_REQUEST['prefecture'],$_REQUEST['address'];?></p>
            <br> 
            <p>パスワード：セキュリティのため非表示</p>
            <br> 
            <p>メールアドレス：<?php echo $_REQUEST['mail-address'];?></p>
            <br> 
            <input type="button" onclick="location.href='member_regist_comfirm.php'" id="register-btn" value="登録完了">
            <br> <br> <br>
            <input type="button" onclick="history.back()" id="back-btn" value="前に戻る">

    </div>
    
</body>
</html>
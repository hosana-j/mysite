<?php
require("./dbconnect.php");
session_start();

if (!empty($_POST)) {

    if ($_POST['lastname'] === "") {
        $error['lastname'] = "blank";
    }

    if ($_POST['firstname'] === "") {
        $error['firstname'] = "blank";
    }

    if (strlen($_POST['lastname']) > 20) {
        $error['lastname'] = 'length';
    }

    if (strlen($_POST['firstname']) > 20) {
        $error['firstname'] = 'length';
    }

    if ($_POST['gender'] === "") {
        $error['gender'] = "blank";
    }

    if ($_POST['prefecture'] === "選択してください") {
        $error['prefecture'] = "blank";
    }

    if (strlen($_POST['address'])>100) {
        $error['address'] = 'length';
    }

    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }

    if ($_POST['password-con'] === "") {
        $error['password-con'] = "blank";
    }

    if (strlen($_POST['password']) < 8 && strlen($_POST['password']) > 20) {
        $error['password'] = 'length';
    }

    if (($_POST['password'] != $_POST['password-con']) && ($_POST['password-con'] != "")) {
        $error['password-con'] = 'difference';
    }

    
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }

    if (strlen($_POST['email'])>200) {
        $error['email'] = 'length';
    }


    /* メールアドレスの重複 */
    if (!isset($error)) {
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM members WHERE email=?');
        $member->execute(array(
            $_POST['email']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }

    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   
        header('Location: member_regist_detail.php');  
        exit();
    }

    if(isset($_SESSION['join']) && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'rewrite') ){
        $_POST =$_SESSION['join'];
    }
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES);
  }
?>

<!------------------------------------------------------------------------------------------------>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>会員登録フォーム</title>
</head>


<body>
    <div class="register-form">
        <form action="" method="POST" class="registrationform">
            <h1>会員情報登録フォーム</h1>

            <span>氏名：</span>
            <span>姓</span><input type="text" id="lastname" name="lastname" value="<?php if( !empty($_POST['lastname']) ){ echo $_POST['lastname']; } ?>">
            <span>名</span><input type="text" id="firstname" name="firstname" value="<?php if( !empty($_POST['firstname']) ){ echo $_POST['firstname']; } ?>" >

            <?php if (isset($error['lastname']) && ($error['lastname'] == "blank")) : ?>
                <p class="error">※必須　氏名（姓）を入力してください</p>
            <?php endif; ?>
            <?php if (isset($error['firstname']) && ($error['firstname'] == "blank")) : ?>
                <p class="error">※必須　氏名（名）を入力してください</p>
            <?php endif; ?>
            <?php if (isset($error['lastname']) && ($error['lastname'] == "length")) : ?>
                <p class="error"> 20文字以下で指定してください</p>
            <?php endif; ?>
            <?php if (isset($error['firstname']) && ($error['firstname'] == "length")) : ?>
                <p class="error"> 20文字以下で指定してください</p>
            <?php endif; ?>

            <br> <br>


            <span>性別</span><input type="radio" name="gender" value="men" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "men" ){ echo 'checked'; } ?>>男性
            <input type="radio" name="gender" value="women" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "women" ){ echo 'checked'; } ?>>女性

        
            <?php if (isset($error['gender']) && ($error['gender'] == "blank")) : ?>
                <p class="error">※必須　性別を選択してください"</p>
            <?php endif; ?>


            <?php if (isset($_POST['gender'])) : ?>
                <p class="error"></p>
            <?php else : ?>
                <p class="error">※必須　性別を選択してください</p>
            <?php endif; ?>

            <br> <br>


            <span>住所</span> <span>　都道府県</span>
            <select name="prefecture">
                <?php
                $pref = [
                    '選択してください', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県',
                    '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
                    '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県',
                    '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県',
                    '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'];
                    
                    foreach($pref as $item){
                                echo'<option value="',$item,'">',$item,'</option>';
                    }
                        ?>

            
            </select>
            <?php if (isset($error['prefecture']) && ($error['prefecture'] == "blank")) : ?>
                <p class="error">※必須　都道府県を選択してください</p>
            <?php endif; ?>

            <br><br>


            それ以降の住所　<input type="text" id="address" name="address" value="<?php if( !empty($_POST['address']) ){ echo $_POST['address']; } ?>">
            <?php if (isset($error['password']) && ($error['password'] == "length")) : ?>
                <p class="error">100文字以内で入力してください</p>
            <?php endif; ?>
            <br><br><br>


            <span>パスワード　</span> <input type="password" id="password" name="password" pattern="^[0-9a-zA-Z]{8,20}" value="<?php if( !empty($_POST['password']) ){ echo $_POST['password']; } ?>">
            <?php if (isset($error['password']) && ($error['password'] == "blank")) : ?>
                <p class="password"> パスワードを入力してください</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && ($error['password'] == "length")) : ?>
                <p class="error"> 8文字以上20文字以下で指定してください</p>
            <?php endif; ?>
            <br><br>


            <span>パスワード確認　</span><input type="password" id="password-con" name="password-con" pattern="^[0-9a-zA-Z]{8,20}" value="<?php if( !empty($_POST['password-con']) ){ echo $_POST['password-con']; } ?>">
            <?php if (isset($error['password2']) && ($error['password2'] == "blank")) : ?>
                <p class="error"> パスワードを入力してください</p>
            <?php endif; ?>
            <?php if (isset($error['password2']) && ($error['password2'] == "difference")) : ?>
                <p class="error"> パスワードが上記と違います</p>
            <?php endif; ?>
            <br><br>


            <span>メールアドレス　</span> <input type="email" id="email" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>">
            <?php if (isset($error['email']) && ($error['email'] == "blank")) : ?>
                <p class="error">※必須　メールアドレスを入力してください</p>
            <?php endif; ?>
            <?php if (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                    <p class="error">＊このメールアドレスはすでに登録済みです</p>
                <?php endif ?>
            <?php if (isset($error['email']) && ($error['email'] == "length")) : ?>
                <p class="error"> 200文字以内で指定してください</p>
            <?php endif; ?>
            <br><br>


            <input type="submit" id="comfirm-btn" value="確認画面へ">
        </form>
    </div>
</body>

</html>
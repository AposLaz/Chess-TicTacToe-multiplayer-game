<?php

function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generatePassword($pwd) {
    $hash = generateRandomString(32);
    $encrypted = md5(md5($pwd).$hash);

    return ['password' => $pwd, 'encrypted' => $encrypted, 'hash' => $hash];
    
}
?>

<form action="" method="post">
    Password: <input type="text" name="pwd" value="<?=(isset($_POST['pwd']) ? $_POST['pwd'] : '');?>">
    <input type="submit" name="generate" value="Generate">
</form>
<br>
<?php
if(isset($_POST['generate'])) {
    if(!isset($_POST['pwd']) || empty($_POST['pwd']))
        die('password is empty');
    
    $data = generatePassword($_POST['pwd']);

    echo sprintf('
    Password: %s<br>
    Encrypted: %s<br>
    Hash: %s<br>
    ', $data['password'], $data['encrypted'], $data['hash']);
}
?>
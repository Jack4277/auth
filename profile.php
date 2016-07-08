<?php
if($_POST){
    $username = $_POST['username'];
    $password = md5($_POST['password'].'hash');
    $f = file_get_contents('session.txt');
    $unSerialSession = unserialize($f);
    //var_dump($unSerialSession);
//    echo $username;
//    echo '<br>',$password;
    if($unSerialSession[0]['username'] == $username && $unSerialSession[0]['password'] == $password){
        ini_set('session.gc_maxlifetime',3);
        ini_set('session.cookie_lifetime',3);
        session_start();
        if(empty($_SESSION['username']) && empty($_SESSION['id'])) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $unSerialSession[0]['id'];
        }
        if(ini_get('session.gc_maxlifetime') == 0 && ini_get('session.cookie_lifetime') == 0){ ?>
            <p> Session time is over, please login again</p>
            <?php
            header('Location: http://auth/login.php');
            exit;
        }else{
        ?>
        <h1>Welcome <?php echo $_SESSION['username'] ?></h1>
        <h3>Your id <?php echo $_SESSION['id'] ?></h3>
<?php
            }
    }else{
        header('Refresh: 1.5; URL=http://auth/login.php');
        echo 'Логин или пароль был введен не верно!';
        exit;
    }
}
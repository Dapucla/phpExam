<?php 
$title = "Fegion";
$response = null;
 
// проверка секретного ключа
#$reCaptcha = new ReCaptcha($secret);

// if submitted check response
#if ($_POST["g-recaptcha-response"]) {
#$response = $reCaptcha->verifyResponse(
#        $_SERVER["REMOTE_ADDR"],
#        $_POST["g-recaptcha-response"]
#    );
#}

$data = $_POST;
 
//если кликнули на button
if ( isset($data['do_signup']) )
{
// проверка формы на пустоту полей
    $errors = array();
    if ( trim($data['login']) == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Введите логин</div>';
    }
 
    if ( trim($data['email']) == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Введите Email</div>';
    }
 
    if ( $data['password'] == '' )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Введите пароль</div>';
    }
 
    if ( $data['password_2'] != $data['password'] )
    {
        $errors[] = '<div class="alert alert-info" role="alert">Повторный пароль введен не верно!</div>';
    }
 
    //проверка на существование одинакового логина
    if ( R::count('users', "login = ?", array($data['login'])) > 0)
    {
        $errors[] = '<div class="alert alert-danger" role="alert">Пользователь с таким логином уже существует!</div>';
    }
 
//проверка на существование одинакового email
    if ( R::count('users', "email = ?", array($data['email'])) > 0)
    {
        $errors[] = '<div class="alert alert-danger" role="alert">Пользователь с таким Email уже существует!</div>';
    }
    if (strripos($data['email'], "@") == false){
        $errors[] = '<div class="alert alert-danger" role="alert">Введите корректный E-Mail</div>';
    }
    if ($data['termscheck'] != "ok"){
        $errors[] = '<div class="alert alert-danger" role="alert">Вы не согласились с правилами!</div>';
    }
    if ($response != null && $response->success) {
        
    }else{
      #$errors[] = 'Подтвердите что вы не робот!';
    }

    if ( empty($errors) )
    {
        //ошибок нет, теперь регистрируем
        $user = R::dispense('users');
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->ip = $_SERVER['REMOTE_ADDR'];
        $user->avatar = 'public/usr/images/defaultlogo.png';
        $user->admin = '0';
        $user->subs = '0';
        $user->activation = '0';
        $user->status = '1';
        $user->datesu = date("Y-m-d H:i:s");
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT); 
        //пароль нельзя хранить в открытом виде, 
        //мы его шифруем при помощи функции password_hash для php > 5.6
         
        R::store($user);

        $token=md5($email.time());

        $emailconf = R::dispense('confirmemail');
        $emailconf->email = $data['email'];
        $emailconf->token = $token;
        $emailconf->status = '0';
         
        R::store($emailconf);

        echo '<div style="color:dreen;">Вы успешно зарегистрированы!</div><hr>';
        header('Location: /account/signin');
    }else
    {
        //echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
    }
}
controller::init_view($route, "signup", false, null);
?>
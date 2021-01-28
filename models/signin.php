<?php
$title = "Fegion";

$data = $_POST;
if ( isset($data['do_login']) )
{
    $user = R::findOne('users', 'login = ?', array($data['login']));
    if ( $user )
    {
        //логин существует
        if ( password_verify($data['password'], $user->password) )
        {
            //если пароль совпадает, то нужно авторизовать пользователя
            $_SESSION['auth_perx'] = $user;
            echo '<div style="color:dreen;">Вы авторизованы!<br> 
            Можете перейти на <a href="/">главную</a> страницу.</div><hr>';
            header('Location: /');
        }else{
            $errors[] = '<div class="alert alert-danger" role="alert">Неверно введен пароль!</div>';
        }
 
    }elseif ($usere = R::findOne('users', 'email = ?', array($data['login']))) {
                //логин существует
        if ( password_verify($data['password'], $usere->password) )
        {
          //$emailcheck = R::findOne('confirmemail', 'email = ?', array($data['login']));
          //if ($emailcheck['status'] == '0') {

           // $errors[] = '<div class="alert alert-danger" role="alert">Подтвердите свой E-Mail! Мы вас выслали ссылку с подтверждением!</div>';
          //}else{
            //если пароль совпадает, то нужно авторизовать пользователя
            $_SESSION['auth_perx'] = $usere;
            echo '<div class="alert alert-success" role="alert">Вы авторизованы!</div>';
            header('Location: /');
          //}
        }else{
            $errors[] = '<div class="alert alert-danger" role="alert">Неверно введен пароль!</div>';
        }
 
    }else{
        $errors[] = '<div class="alert alert-danger" role="alert">Пользователь с таким логином или E-Mail не найден!</div>';
    }
     if ( ! empty($errors) )
    {
        //выводим ошибки авторизации
        //echo array_shift($errors);
    }
}
controller::init_view($route, "signin", false, null);
?>
<?
$title = 'Авторизация';
$login  = '';

session_start();
header("HTTP/1.0 401 Unauthorized");
require_once "secure.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim(strip_tags($_POST["login"]));
    $pw = trim(strip_tags($_POST["pw"]));

    $ref = $_GET["ref"] ?? '/eshop/admin';

    if($login && $pw) {
        if($result = userExists($login)) {
            list($_, $hash) = explode(':', $result);
            $hash = str_replace("\n", "", $hash);
            if(checkHash($pw, $hash)) {
                $_SESSION['admin'] = true;
                header("Location: $ref");
                exit;
            } else {
                $title = 'Неправильное имя пользователя или пароль !';
            }
        } else {
            $title = 'Неправильное имя пользователя или пароль!';
        }
    } else {
        $title = "Заполните все поля формы!";
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Авторизация</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?= $title?></h1>
	<form action="<?= $_SERVER['REQUEST_URI']?>" method="post">
		<div>
			<label for="txtUser">Логин</label>
			<input id="txtUser" type="text" name="login" value="<?= $login?>" />
		</div>
		<div>
			<label for="txtString">Пароль</label>
			<input id="txtString" type="password" name="pw" />
		</div>
		<div>
			<button type="submit">Войти</button>
		</div>	
	</form>
</body>
</html>
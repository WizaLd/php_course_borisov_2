<?php
/* Основные настройки */
const DB_HOST = "localhost";
const DB_LOGIN = "root";
const DB_PASSWORD = "root";
const DB_NAME = "gbook";

$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

/* Основные настройки */
function clearStr($data) {
    global $link;
    $data = trim(strip_tags($data));
    return mysqli_real_escape_string($link, $data);
}
/* Сохранение записи в БД */
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = clearStr($_POST["name"]);
  $email = clearStr($_POST["email"]);
  $msg = clearStr($_POST["msg"]);
  $query = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";
  mysqli_query($link, $query);
  header("Location: " . $_SERVER["REQUEST_URI"]);
  exit;

}


/* Сохранение записи в БД */

/* Удаление записи из БД */
if(isset($_GET['del'])) {
    $id = abs((int)$_GET['del']);
    if($id) {
        $sql = "DELETE FROM msgs WHERE id = $id";
        mysqli_query($link, $sql);
    }
}
/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" name="submit" value="Отправить!" />

</form>
<?php
/* Вывод записей из БД */

$query = "SELECT id, name, email, msg, 
                   UNIX_TIMESTAMP(datetime) as dt
            FROM msgs ORDER BY id DESC";

$res = mysqli_query($link, $query);
mysqli_num_rows($res);
while($row = mysqli_fetch_assoc($res)){
    $dt = date("d-m-Y H:i:s", $row["dt"]);
    $msg = nl2br($row["msg"]);
    echo <<<ALOHA
    <p>
      <a href="{$row['email']}">{$row['name']}</a>
      {$dt} написал<br/>{$msg}
    </p>
    <p aling="right">
      <a href="/index.php?id=gbook&del={$row['id']}">Удалить</a>
    </p>
ALOHA;

}

/* Вывод записей из БД */
?>
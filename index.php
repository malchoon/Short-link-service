<?php
$mysqli = new mysqli("localhost", "umax20ht_db", "Maxeyes1234", "umax20ht_db");

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if(isset($_GET)) {
    $newUrl = mb_substr(str_replace('?r=', '', $url), -8);
    $result = $mysqli->query("SELECT original_url FROM shorturl WHERE short_url ='{$newUrl}'");
    if (!$result) {
        return false;
    } else {
        while ($row = $result->fetch_object()) {
            $original_url = $row->original_url;
        }
        if ($original_url) {
            header("Location:".$original_url);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Short link service</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="main-container">
            <div class="main-header-container">
                <h1 class="main-header">Short link service</h1>
            </div>
            <div class="main-form-container">
                <form method="post" class="main-form">
                    <input class="input-link" type="text" placeholder="Введите ссылку" name="link">
                    <input class="input-submit" type="submit" value="Сократить">
                </form>
                <div class="container-result">
                    <div class="result"></div>
                </div>
            </div>
        </div>
        <footer>
            <script src="/js/jquery-3.7.0.min.js"></script>
            <script src="/js/main.js"></script>
        </footer>
    </body>
</html> 
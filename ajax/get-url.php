<?php
if(isset($_POST['link'])){
    class LongUrl{
        private $url;
        public function getUrl()
        {
            return $this->url;
        }
        public function setUrl($url)
        {
            $this->url = $url;
        }
        public function validation($url)
        {
            if(filter_var($url, FILTER_VALIDATE_URL)) {
                return true;
            } else {
                return false;
            }
        }
        public function setShortUrl($url, $mysqli)
        {
            $short_url=substr(md5($url.mt_rand()),0,8);
            $result = $mysqli->query("INSERT INTO shorturl (original_url, short_url) VALUES('{$url}','{$short_url}')");
            if(!$result){
                return 'Ошибка при выполнении запроса: '.$mysqli->error;
            }else{
                return $short_url;
            }
        }
        public function checkLongUrl($url, $mysqli)
        {
            $result = $mysqli->query("SELECT short_url FROM shorturl WHERE original_url ='{$url}'");
            if(!$result){
                return false;
            }else{
                while($row = $result->fetch_object()) {
                    $short_url = $row->short_url;
                }
                if($short_url){
                    return $short_url;
                }
            }
        }
    }

    $mysqli = new mysqli("localhost", "umax20ht_db", "Maxeyes1234", "umax20ht_db");
    if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к базе данных MySQL. Ошибка: ".$mysqli->connect_error;
    }else{
        $url = new LongUrl();
        $url->setUrl($_POST['link']);
        $longUrl = $url->getUrl();
        // Check validation link
        if($url->validation($longUrl)){
            // Check for second using link
            if(!$url->checkLongUrl($longUrl, $mysqli)){
                echo $url->setShortUrl($longUrl, $mysqli);
            }else{
                echo $url->checkLongUrl($longUrl, $mysqli);
            }
        }else{
            echo 'Не является ссылкой';
        }
    }
}else{
    echo 'Ошибка при запросе';
}


<?php
  if($_REQUEST["id"]) {
    $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, $_REQUEST["id"]);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
    exit();
  }
?>

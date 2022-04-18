<?php

function save_news($title, $news, $expire)
{
    $notise = null;
    $userid = 1;
    //loon andmebaasi ühenduse
    //kasutan globaalseid muutujaid, need, mis on loodud väljaspool funktsiooni: $GLOBALS["server_host"]
    $conn = new mysqli ($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    //määran suhtlemise kooditabeli
    $conn->set_charset("utf8");
    //valmistame ette SQL keeles käsu andmete lisamiseks andmetabelisse
    // INSERT INTO vr_news (title, content, expire, userid) VALUES (?,?,?,?)
    $stmt = $conn->prepare("INSERT INTO vr22_news (title, content, expire, userid) VALUES (?,?,?,?)");
    echo $conn->error;
    //s- string i - integer d - decimal
    if ($expire == "") {
        $expire = null;
    }
    $stmt->bind_param("sssi", $title, $news, $expire, $userid);
    if ($stmt->execute()) {
        $notice = "Uudis salvestatud!";
    } else {
        $notice = "Uudise salvestamisel tekkis viga" . $stmt->error;
    }
    //lõpetan käsu
    $stmt->close();
    //sulgen ühenduse
    $conn->close();
    return $notice;
}

function all_news()
{
    $news_html = null;
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT title, content, added 
FROM vr22_news 
where (deleted is null) and (expire > now() or expire is null)
order by added desc 
limit 5");
    //echo $conn->error;
    $stmt->bind_result($title_from_db, $content_from_db, $added_from_db);
    $stmt->execute();
    while ($stmt->fetch()) {
        $news_html .= "<h3>" . $title_from_db . "</h3> \n";
        $news_html .= "<p>Lisatud:" . $added_from_db . "</p> \n";
        $news_html .= "<p>" . $content_from_db . "</p> \n";

    }
    $stmt->close();
    $conn->close();

    return $news_html;
}

    
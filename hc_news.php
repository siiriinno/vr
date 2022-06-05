<?php

function save_news($title, $news, $expire, $photo_id)
{
    $notise = null;
    $userid = $_SESSION["user_id"];
    //loon andmebaasi ühenduse
    //kasutan globaalseid muutujaid, need, mis on loodud väljaspool funktsiooni: $GLOBALS["server_host"]
    $conn = new mysqli ($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    //määran suhtlemise kooditabeli
    $conn->set_charset("utf8");
    //valmistame ette SQL keeles käsu andmete lisamiseks andmetabelisse
    // INSERT INTO vr_news (title, content, expire, userid) VALUES (?,?,?,?)
    $stmt = $conn->prepare("INSERT INTO vr22_news (title, content, expire, userid, photoid) VALUES (?,?,?,?,?)");
    echo $conn->error;
    //s- string i - integer d - decimal
    if ($expire == "") {
        $expire = null;
    }
    $stmt->bind_param("sssii", $title, $news, $expire, $userid, $photo_id);
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
    //$stmt = $conn->prepare("SELECT title, content, added
//FROM vr22_news
//where (deleted is null) and (expire > now() or expire is null)
//order by added desc
//limit 5");
    $stmt = $conn->prepare("SELECT title, content, added, firstname, lastname, filename
FROM vr22_news 
    JOIN vr22_users on vr22_news.userid = vr22_users.id 
    LEFT JOIN vr22_photos on vr22_news.photoid = vr22_photos.id
WHERE (vr22_news.deleted is null) and (expire > now() or expire is null)
ORDER BY vr22_news.id DESC 
LIMIT 5");
    //echo $conn->error;
    $stmt->bind_result($title_from_db, $content_from_db, $added_from_db, $first_name_from_db, $last_name_from_db, $filename_from_db);
    $stmt->execute();
    while ($stmt->fetch()) {
        $news_html .= "<h3>" . $title_from_db . "</h3> \n";
        if ($filename_from_db) {
            $news_html .= "<img src='news_upload_normal/".$filename_from_db."' alt='".$title_from_db."' class='news-img'>";
        }
        $news_html .= "<p>Lisatud:" . $added_from_db . "</p> \n";
        $news_html .= "<p>Autor:" . $first_name_from_db." ". $last_name_from_db . "</p> \n";
        $news_html .= "<p>" . $content_from_db . "</p> \n";

    }
    $stmt->close();
    $conn->close();

    return $news_html;
}


    
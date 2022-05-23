<?php

function all_photos()
{
    $gallery_html = null;
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT vr22_photos.id, vr22_photos.filename, vr22_photos.alttext, vr22_users.firstname, vr22_users.lastname 
FROM vr22_photos 
    JOIN vr22_users ON vr22_photos.userid = vr22_users.id 
WHERE vr22_photos.privacy >= 2 AND vr22_photos.deleted IS NULL 
GROUP BY vr22_photos.id");
    //echo $conn->error;
    $stmt->bind_result($id_from_db, $filename_from_db, $alttext_from_db, $first_name_from_db, $last_name_from_db);
    $stmt->execute();
    while ($stmt->fetch()) {
        $gallery_html .= "<img src=\"gallery_upload_thumb/" . $filename_from_db . "\" alt=\"" . $alttext_from_db . "\" class=\"thumbs\"> \n";
        $gallery_html .= "<p>Autor:" . $first_name_from_db . " " . $last_name_from_db . "</p> \n";
    }
    $stmt->close();
    $conn->close();

    return $gallery_html;
}
function last_photo() {
    $gallery_html = null;
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT vr22_photos.id, vr22_photos.filename, vr22_photos.alttext, vr22_users.firstname, vr22_users.lastname 
FROM vr22_photos 
    JOIN vr22_users ON vr22_photos.userid = vr22_users.id 
WHERE vr22_photos.privacy = 3 AND vr22_photos.deleted IS NULL 
GROUP BY vr22_photos.id
order by vr22_photos.id desc 
limit 1");
    //echo $conn->error;
    $stmt->bind_result($id_from_db, $filename_from_db, $alttext_from_db, $first_name_from_db, $last_name_from_db);
    $stmt->execute();
    while ($stmt->fetch()) {
        $gallery_html .= "<img src=\"gallery_upload_normal/" . $filename_from_db . "\" alt=\"" . $alttext_from_db . "\" class=\"photoframe\"> \n";
        $gallery_html .= "<p>Autor:" . $first_name_from_db . " " . $last_name_from_db . "</p> \n";
    }
    $stmt->close();
    $conn->close();

    return $gallery_html;

}


    
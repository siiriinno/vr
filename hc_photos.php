<?php

function all_photos()
{
    $gallery_html = null;
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT vr22_photos.id, filename, alttext, vr22_photos.created, firstname, lastname, AVG(rating) as AvgValue FROM vr22_photos JOIN vr22_users ON vr22_photos.userid = vr22_users.id LEFT JOIN vr22_photoratings ON vr22_photoratings.photoid = vr22_photos.id WHERE vr22_photos.privacy >= ? AND deleted IS NULL GROUP BY vr22_photos.id DESC LIMIT ?,?");
    //echo $conn->error;
    $stmt->bind_result($id_from_db, $filename_from_db, $alttext_from_db, $first_name_from_db, $last_name_from_db);
    $stmt->execute();
    while ($stmt->fetch()) {
        /* <div class="thumbgallery">
            <img src="gallery_upload thumb/vr_......jpg" alt="" class="thumbs data-id="33"
        <p>Karu Mati</p>
        </div>*/


        $gallery_html .= "<div>";
        $gallery_html .= "<img src=\"gallery_upload_thumb/" . $filename_from_db . "\" alt=\"" . $alttext_from_db . "\" class=\"thumbs\" data-id=\"" . $id_from_db . "\" data-filename=\"" . $filename_from_db . "\">";
        $gallery_html .= "<p>Autor:" . $first_name_from_db . " " . $last_name_from_db . "</p> \n";
        $gallery_html .= "</div>";
    }
    $stmt->close();
    $conn->close();

    return $gallery_html;
}

function last_photo()
{
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


    
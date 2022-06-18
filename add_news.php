<?php
require_once "use_session.php";
require_once "../../cnf.php";
require_once "hc_news.php";
require_once "classes/Photoupload.class.php";
require_once "fnc_photoupload.php";

//require_once "fnc_general.php";
//$_POST
//$_GET
//var_dump($_POST);
//echo $_POST["newsInput"];
$author_name = "Siiri Inno";

$news_input_error = null;
$notice = null;
$title_input = null;
$news_input = "";
$expire_input = null;
$photo_name_prefix = "vr_";
$normal_photo_max_width = 600;
$normal_photo_max_height = 400;
$news_photo_normal_folder = "news_upload_normal/";
$news_photo_orig_folder = "news_upload_orig/";

if (isset($_GET["id"])) {
    $uudis = get_news($_GET["id"]);
    //print_r($uudis);
}

if (isset($_POST["newsSubmit"])) {
    //print_r($_POST);
    //kontrolli kas pilt ka on
    if (isset($uudis)) {
        $news_photo_id = $uudis[5];
    } else {
        $news_photo_id = null;
    }

    if (isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])) {
        $image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);

        if ($image_check !== false) {
            if ($image_check["mime"] == "image/jpeg") {
                $file_type = "jpg";
            }
            if ($image_check["mime"] == "image/png") {
                $file_type = "png";
            }
            if ($image_check["mime"] == "image/gif") {
                $file_type = "gif";
            }
        } else {
            $photo_error = "Valitud fail pole foto";
        }

        $upload = new Photoupload($_FILES["photo_input"], $file_type);
        //loon uue failinime
        $file_name = create_filename($photo_name_prefix, $file_type);
        //suuruse muutmine klassiga
        $upload->resize_photo($normal_photo_max_width, $normal_photo_max_height);
        $photo_upload_notice = "Normaalsuuruses" . $upload->save_image($news_photo_normal_folder . $file_name);
        $upload->save_file($news_photo_orig_folder . $file_name);
        //talletame andmebaasi
        $news_photo_id = store_photo_data($file_name, $_POST["newsInput"], 2);
        if (!intval($news_photo_id)) {
            $news_input_error .= $news_photo_id;
            $news_photo_id = null;
        }
    }
    //kontrollime uudise pealkirja
    if (isset($_POST["newsInput"]) and !empty($_POST["newsInput"])) {
        $news_input = $_POST["newsInput"];
    } else {
        $news_input_error .= "Uudise pealkiri on puudu! ";

    }
    //kontrollime uudise sisu
    if (isset($_POST["titleInput"]) and !empty($_POST["titleInput"])) {
        $news_input = $_POST["newsInput"];
    } else {
        $news_input_error .= "Uudise sisu on puudu! ";

    }

    //neid peaks ka kontrolllima
    $title_input = $_POST["titleInput"];
    $expire_input = $_POST["expireInput"];

    $notice = $news_input_error;
    if (empty($news_input_error)) {
    if (isset($uudis)) {
        $news_id = $uudis[0];
    } else {
        $news_id = -1;
    }
        $notice = save_news($title_input, $news_input, $expire_input, $news_photo_id, $news_id);

    }
}


?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <!-- nüüd on teil senisele lisaks mõõtühikud vw 1% laiusest, vh, vmin 1% väiksemast mõõdust, vmax -->
    <title><?php echo $author_name; ?> koduleht</title>
    <link rel="stylesheet" type="text/css" href="../Styles/general.css">
</head>

<body>
<header>
    <img src="../../~andrus.rinde/media/pic/rif21_banner.png" alt="RIF bänner">
    <h1>Tere <?php echo $author_name; ?> veebirakenduse tund</h1>

    <p></p>
    <details>
        <summary>Selle lehe mõte</summary>
        <p>See on minu õppetöö leht</p>
    </details>

    <!-- article aside -->

    <hr>
</header>
<nav>
    <h2>Olulised lingid</h2>
    <ul>
        <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3.html">Gradient</a></li>
        <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3gradient2.html">Gradient2</a></li>
        <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/Gradient">Gradient uus</a></li>
        <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/vr/show_news.php">Loe uudiseid</a></li>
        <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/vr/add_news.php">Lisa uudiseid</a></li>
    </ul>
</nav>
<main>
    <section>
        <?php
        if (isset($uudis)) { ?>
            <h2>Muuda uudist</h2>
        <?php } else { ?>
            <h2>Lisa uudis</h2>
        <?php } ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="titleInput">Uudise pealkiri</label>
            <input type="text" id="titleInput" name="titleInput" placeholder="Kirjuta siia pealkiri..."
                <?php //lisan uudisele pealkirja teksti muutmise
                if (isset($uudis)) {
                     echo "value=\"".$uudis[1]."\"";
                }
                ?>
            >
            <br>
            <label for="newsInput">Uudise tekst</label><br>
            <textarea id="newsInput" name="newsInput" cols="60" rows="5"
                      placeholder="Kirjuta siia uudise tekst..."><?php //lisan uudisele sisuteksti muutmise
                if (isset($uudis)) {
                    echo $uudis[2];
                }
                ?></textarea>
            <br>
            <?php if (isset($uudis) && isset($uudis[4])) {
                echo "<img src='news_upload_normal/" . $uudis[4] . "' alt='" . $uudis[1] . "' class='news-img'>";
                echo "<br>";
            } ?>
            <label for="photo_input"> Vali pildifail! </label>
            <input type="file" name="photo_input" id="photo_input" accept="image/png, image/gif, image/jpeg">
            <label for="expireInput">Uudise aegumistähtaeg</label>
            <input type="date" id="expireInput" name="expireInput"
                <?php //lisan uudisele pealkirja teksti muutmise
                if (isset($uudis)) {
                    echo "value=\"".$uudis[3]."\"";
                }
                ?>>
            <br>
            <input type="submit" id="newsSubmit" name="newsSubmit" value="Salvesta uudis">
        </form>
        <?php echo "<p>" . $notice . "</p>"; ?>
    </section>
</main>
<hr>
<?php
require_once "pagefooter.php";
?>
   
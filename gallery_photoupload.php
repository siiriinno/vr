<?php
require_once "use_session.php";
require_once "../../cnf.php";
require_once("fnc_general.php");
require_once "fnc_photoupload.php";
require_once "classes/Photoupload.class.php";

//testin klassi kasutamist
require_once "classes/Generic.class.php";
$generic_object = new Generic(8);
//väljastan salajas eväärtuse:
//echo $generic_object->secret_value;
//väljastame avaliku väärtuse
echo "Klassi avalik väärtus on:" . $generic_object->just_value;
$generic_object->reveal();
unset($generic_object);

$photo_error = null;
$photo_upload_notice = null;
$alt_text = null;
$privacy = 1;
$file_name = null;
$file_type = null;
//muutujad mis võiks olla conf failis
$photo_upload_site_limit = 1024 * 1024 * 1.5;
/*$gallery_photo_orig_folder = "gallery_upload_orig/";
$gallery_photo_normal_folder = "gallery_upload_normal/";
$gallery_photo_thumb_folder = "gallery_upload_thumb/";*/
$photo_name_prefix = "vr_";
$normal_photo_max_width = 600;
$normal_photo_max_height = 400;
$thumbnail_width = $thumbnail_height = 100;
$watermark = "hkphotos/vr_watermark.png";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["photo_submit"])) {
        //var_dump($_POST);
        //var_dump($_FILES);
        // kas on olemas pilt
        if (isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])) {
            //kui pilt valitud
            //kas on foto
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
            // kas lubatud suurusega
            if ($photo_error == null and $_FILES["photo_input"]["size"] > $photo_upload_site_limit) {
                $photo_error = "Valitud fail on liiga suur";
            }
            // "puhastan" alt teksti
            if (isset($_POST["alt_input"]) and !empty($_POST["alt_input"])) {
                $alt_text = test_input($_POST["alt_input"]);
                if (empty($alt_text)) {
                    $photo_error = "alt tekst ei ole tekst!";
                }
            } else {
                $photo_error = "alt tekst on tühi!";
            }
            //võiks kontrollida privacy

            //kui kõik on korras, siis laeme üles
            if ($photo_error == null) {

                //võtame kasutusele klassi
                $upload = new Photoupload($_FILES["photo_input"], $file_type);

                //loon uue failinime
                $file_name = create_filename($photo_name_prefix, $file_type);

                //suuruse muutmine
                //$my_temp_image = create_image($_FILES["photo_input"]["tmp_name"], $file_type);
                // $my_normal_image = resize_photo($my_temp_image, $normal_photo_max_width, $normal_photo_max_height);

                //suuruse muutmine klassiga
                $upload->resize_photo($normal_photo_max_width, $normal_photo_max_height);

                //lisan vesimärgi
                $upload->add_watermark($watermark);

                //salvestame vähendatud pildifaili
                //$photo_upload_notice = save_image($my_normal_image, $gallery_photo_normal_folder . $file_name, $file_type);
                $photo_upload_notice = "Normaalsuuruses" . $upload->save_image($gallery_photo_normal_folder . $file_name);

                //thumbnail ka
                //$my_thumb_image = resize_photo($my_temp_image, $thumbnail_width, $thumbnail_height, false);
                //$photo_upload_notice = save_image($my_thumb_image, $gallery_photo_thumb_folder . $file_name, $file_type);
                $upload->resize_photo($thumbnail_width, $thumbnail_height);
                $photo_upload_notice .= " Pisipildi " . $upload->save_image($gallery_photo_thumb_folder . $file_name);

                //kopeerime originaali soovitud kohta
                //move_uploaded_file($_FILES["photo_input"]["tmp_name"], $gallery_photo_orig_folder . $file_name);
                $upload->save_file($gallery_photo_orig_folder . $file_name);

                //talletame andmebaasi
                $photo_upload_notice .= store_photo_data($file_name, $_POST["alt_input"], $_POST["privacy_input"]);

                //tühjendame mälu
                //imagedestroy($my_temp_image);
                //imagedestroy($my_normal_image);
                //laseme klassil minna...lheb käima konstruktor - hävitab elemendid ära
                unset($upload);
            }
        } else {
            $photo_error = "pildifail pole valitud";
        } //kui pilt valitud
        //kas on foto
        if ($photo_upload_notice == null) {
            $photo_upload_notice = $photo_error;
        }
    }
}
?>
    <!DOCTYPE html>
    <html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> teeb veebi</title>
        <link rel="stylesheet" type="text/css" href="../Styles/general.css">
        <script src="javascript/fileCheck.js" defer></script>
    </head>
<body>
    <header>
        <img id="banner" src="../../media/pic/rif21_banner.png" alt="RIF21 bأ¤nner">
        <h1><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> arendab veebi</h1>
        <details>
            <summary>Selle lehe mأµte</summary>
            <p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat materjali!</p>
        </details>

        <hr>
    </header>

<?php include "nav.php"; ?>
<main>
    <section>
        <h2>Foto üleslaadimine</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
              enctype="multipart/form-data">
            <label for="photo_input"> Vali pildifail! </label>
            <input type="file" name="photo_input" id="photo_input" accept="image/png, image/gif, image/jpeg">
            <br>
            <label for="alt_input">Alternatiivtekst (alt): </label>
            <input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst"
                   value="<?php echo $alt_text; ?>">
            <br>
            <input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if ($privacy == 1) {
                echo " checked";
            } ?>>
            <label for="privacy_input_1">Privaatne (ainult mina nأ¤en)</label>
            <br>
            <input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if ($privacy == 2) {
                echo " checked";
            } ?>>
            <label for="privacy_input_2">Sisseloginud kasutajatele</label>
            <br>
            <input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if ($privacy == 3) {
                echo " checked";
            } ?>>
            <label for="privacy_input_3">Avalik (kأµik nأ¤evad)</label>
            <br>
            <input type="submit" name="photo_submit" id="photo_submit" value="Lae pilt üles">
        </form>
        <span id="notice"><?php echo $photo_upload_notice; ?></span>
    </section>
<?php
require_once "pagefooter.php";
?>
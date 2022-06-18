<?php
require_once "use_session.php";
require_once "../../cnf.php";
require_once "hc_photos.php";
$author_name = "Siiri Inno";
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <!-- nüüd on teil senisele lisaks mõõtühikud vw 1% laiusest, vh, vmin 1% väiksemast mõõdust, vmax -->
    <title><?php echo $author_name; ?> koduleht</title>
    <link rel="stylesheet" type="text/css" href="../Styles/general.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://tigu.hk.tlu.ee/~andrus.rinde/2022kevad/vr/styles/modal.css">
    <script src="javascript/modal.js" defer></script>
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
<?php include "nav.php"; ?>
<main>
    <section>
        <!--modaalaken fotode näitamiseks-->
        <dialog id="modal" class="modalarea">
            <span id="modalclose" class="modalclose">&times;</span>
            <div class="modalhorizontal">
                <div class="modalvertical">
                    <p id="modalcaption"></p>
                    <img id="modalimage" src="empty.png" alt="Galeriipilt">

                    <br>
                    <input id="rate1" name="rating" type="radio" value="1"><label for="rate1">1</label>
                    <input id="rate2" name="rating" type="radio" value="2"><label for="rate2">2</label>
                    <input id="rate3" name="rating" type="radio" value="3"><label for="rate3">3</label>
                    <input id="rate4" name="rating" type="radio" value="4"><label for="rate4">4</label>
                    <input id="rate5" name="rating" type="radio" value="5"><label for="rate5">5</label>
                    <button id="storeRating" type="button">Salvesta hinne</button>
                    <br>
                    <p id="avgrating"></p>

                </div>
            </div>
        </dialog>
        <h2>Avalike fotode galerii</h2>
        <div class="thumbgallery">
            <?php echo all_photos(); ?>
        </div>
    </section>
</main>
<hr>
<?php
require_once "pagefooter.php";
?>
   
<?php
require_once "use_session.php";
require_once "../../cnf.php";
require_once "hc_news.php";
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
<?php include "nav.php" ?>
<main>
    <section>
        <h2>Uudised</h2>
        <?php echo all_news(); ?>
    </section>
</main>
<hr>
<?php
require_once "pagefooter.php";
?>
   
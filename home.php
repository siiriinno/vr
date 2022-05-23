<?php
    require_once "use_session.php";
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
        <!--h1>Tere <?php echo $author_name; ?> veebirakenduse tund</h1!-->
        
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
            <li><a href="?logout=1">Logi välja</a></li>
            <li><a href="#media">Meedia veebilehel</a></li>
            <li><a href="#gaudeamus">Üliõpilashümn Gaudeamus</a></li>
            <li><a href="Kodutoo1/index.html">Esimene kodutöö</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3.html">Gradient</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3gradient2.html">Gradient2</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/Gradient">Gradient uus</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/vr/show_news.php">Loe uudiseid</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/vr/add_news.php">Lisa uudiseid</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/vr/gallery_photoupload.php">Piltide üleslaadimine</a></li>
        </ul>
    </nav>
    <main>
        <section>
            <h2>Avaleht</h2>

        </section>
    </main>
    <hr>
    <?php
        require_once "pagefooter.php";
    ?>
   
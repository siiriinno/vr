<?php
require_once "use_session.php";
require_once "../../cnf.php";
require_once "hc_news.php";
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


if (isset($_POST["newsSubmit"])) {
    //print_r($_POST);
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

        $notice = save_news($title_input, $news_input, $expire_input);

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
        <h2>Lisa uudis</h2>
        <form method="POST">
            <label for="titleInput">Uudise pealkiri</label>
            <input type="text" id="titleInput" name="titleInput" placeholder="Kirjuta siia pealkiri...">
            <br>
            <label for="newsInput">Uudise tekst</label><br>
            <textarea id="newsInput" name="newsInput" cols="60" rows="5"
                      placeholder="Kirjuta siia uudise tekst..."></textarea>
            <br>
            <label for="expireInput">Uudise aegumistähtaeg</label>
            <input type="date" id="expireInput" name="expireInput">
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
   
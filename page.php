<?php
    require_once "fnc_general.php";
    $author_name = "Siiri Inno";

    //piltide katalood
    $photo_dir = "hkphotos/";
    $all_files = read_dir_content($photo_dir);
    /*print_r($all_files);*/
    $allowed_photo_types = ["image/jpeg", "image/png"];
    $photo_files = check_if_photo($all_files, $photo_dir, $allowed_photo_types);

    //näitame üht juhuslikku fotot
    
    $photo_count = count($photo_files);
    /*echo $photo_count;*/
    $random_num = mt_rand(0, $photo_count - 1);
    $photo_html = "\n" .'<img src="' .$photo_dir .$photo_files[$random_num] . '" alt = Haapsalu kolledz"
    class="photoframe">' ."\n";

    $photo_list = [];
    for ($i = 0; $i < 3; $i ++) {
        $random_num = mt_rand(0, $photo_count - 1);  
       while ( in_array($random_num, $photo_list)) {
        $random_num = mt_rand(0, $photo_count - 1);  
       }
       $photo_list[]= $random_num;
    }
    //print_r($photo_list);
    //print_r($photo_files);

    $full_time_now = date("d.m.Y H:i:s");
    $weekday_now = date("N");
    /*echo $weekday_now;*/
    $hours_now = date("H");
    //echo $hours_now;
    $weekday_names_et = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
    $day_category  = "lihtsalt päev";
    if($weekday_now <= 5){
        $day_category = "kooli - või tööpäev";
            }
        else {
            $day_category = "puhkepäev";
    }

    $semester_begin = new DateTime("2022-1-31");
    $semester_end = new Datetime("2022-6-30");
    $semester_duration = $semester_begin->diff($semester_end);
     //echo $semester_duration;
    $semester_duration_days = $semester_duration->format("%r%a");
    //echo $semester_duration_days;
    $from_semester_begin = $semester_begin->diff(new DateTime("now"));
    $from_semester_begin_days = $from_semester_begin->format("%r%a");

    if($from_semester_begin_days > 0) {
        if ($from_semester_begin_days <= $semester_duration_days) {
    $semester_meter = "\n" . '<p>Semester edeneb: <meter min="0" max="' .$semester_duration_days .'" value="' .$from_semester_begin_days .'"></meter>.</p>';
        }
        else {
            $semester_meter = "\n <p>Semester om lõppenud </p> \n";
        }
    }
        elseif ($from_semester_begin_days === 0) { 
            $semester_meter = "\n <p>Semester algab täna!</p> \n";

        }
        else 
        { $semester_meter = "\n <p>Semestri alguseni on jäänud " . (abs($from_semester_begin_days)  + 1)."päeva!</p> \n";
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
            <li><a href="#media">Meedia veebilehel</a></li>
            <li><a href="#gaudeamus">Üliõpilashümn Gaudeamus</a></li>
            <li><a href="Kodutoo1/index.html">Esimene kodutöö</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3.html">Gradient</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/css3gradient2.html">Gradient2</a></li>
            <li><a href="https://tigu.hk.tlu.ee/~siiri.inno/Gradient">Gradient uus</a></li>
        </ul>
    </nav>
    <main>
        <section class="largertext">
            <h2>Veebis saab kasutada</h2>
            <p>Lehe avamise hetk <?php echo $weekday_names_et[$weekday_now-1] .", " .$full_time_now.", on ". $day_category;?>.</p>
            <p>Praegu on <?php 
            if ($hours_now < 7) {
                echo "uneaeg";
            } 
            elseif ($hours_now < 17) {
                echo "tööaeg";
            }
            elseif ($hours_now < 22) {
                echo "õhtune aeg";
            }
            else {
                echo "magamamineku aeg";
            }
            ?>.</p>
            <?Php echo $semester_meter;
            ?>

            <ol>
                <li>Teksti
                    <ul>
                        <li>Pealkirju</li>
                        <li>Tavateksti</li>
                        <li>Listi ehk loendeid</li>
                    </ul>
                </li>
                <li>Graafikat</li>
                <li>Heli</li>
                <li>Videot</li>
            </ol>
        </section>
        <section>
            <h2>Vaated Haapsalu Kolledžile</h2>
            <?php
            for ($i = 0; $i < 3; $i ++) {
               $photo_html = "\n" .'<img src="' .$photo_dir .$photo_files[$photo_list[$i]] . '" alt = Haapsalu kolledz"
                class="photoframe">' ."\n"; 
                echo $photo_html; 
        }
            ?>
            
        </section>

    </main>
    <hr>
    <?php
        require_once "pagefooter.php";
    ?>
   
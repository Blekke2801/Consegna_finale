<?php
require "../utility/Functions.php";
//pagina in cui viene visualizzato il biglietto selezionato
sec_session_start();
$prenotato = false;
if (isset($_POST["prenota"]) && $_POST["prenota"] == "true") { //se l'utente arriva dalla pagina di prenotazione viene eseguita la prenotazione, poi vengono visualizzati i biglietti
    if (is_array($_POST["posto"])) {
        $idB = array();
        $i = 0;
        foreach ($_POST["posto"] as $posto) {
            $idB[$i] = prenota($_POST["ID_table"], $posto);
            $i++;
        }
    } else {
        $idB = prenota($_POST["ID_table"], $_POST["posto"]);
    }
    $prenotato = true;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.ico" />
    <link rel="stylesheet" href="../utility/css/pageBiglietto.css">
    <title>Prenota!</title>
</head>

<body>

    <div class="subnav">
        <a class="btn" href="Home.php">Home</a>
    </div>
    <?php
    //il pagamento viene eseguito(se online) dopo aver controllato se il biglietto è disponibile o no
    if ($prenotato) {
        echo "<h1>Pagamento eseguito con successo!</h1>";
        foreach ($idB as $biglietto) {
            echo "<h1>Il tuo biglietto:</h1>";
            if ($biglietto != false) {
                $t = biglietti($biglietto);
                $TimeTable = prendi_orari(null, $t[3]);
                $film = take_film_prenota($TimeTable[5]);
                $titolo = $film[1];
                $genere = $film[2];
                $data = $TimeTable[1];
                $ora = $TimeTable[2];
                $posto = $t[2];
                $sala = $TimeTable[3];
                echo '<div class="biglietto"><h3>' . $titolo . '</h3><h4>Genere: ' . $genere . '</h4><h4>Data: ' . $data . '</h4><h4>Ora: ' . $ora . '</h4><h4>Sala:' . $sala . '</h4><h4>Posto:' . $posto . '</h4><h4>Codice QR:</h4>';
                $url = urlencode("ticketBooked.php?id=" . $biglietto);
                echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $url . '&choe=UTF-8" alt="qr"/></div>';
            } else {
                echo "<div class='biglietto'><h4>Biglietto già prenotato o non disponibile</h4></div>";
            }
        }
    } else {
        if (isset($_GET["id"])) {
            $biglietto = $_GET["id"];
        } else {
            header("Location:Home.php?site=fisico");
        }
        $t = biglietti($biglietto);
        $TimeTable = prendi_orari(null, $t[3]);
        $film = take_film_prenota($TimeTable[5]);
        $titolo = $film[1];
        $genere = $film[2];
        $data = $TimeTable[1];
        $ora = $TimeTable[2];
        $posto = $t[2];
        $sala = $TimeTable[3];
        echo '<div class="biglietto"><h3>' . $titolo . '</h3><h4>Genere: ' . $genere . '</h4><h4>Data: ' . $data . '</h4><h4>Ora: ' . $ora . '</h4><h4>Sala: ' . $sala . '</h4><h4>Posto: ' . $posto . '</h4><h4>Codice QR:</h4>';
        $url = urlencode("ticketBooked.php?id=" . $biglietto);
        echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $url . '&choe=UTF-8" alt="qr"/></div>';
    }

    ?>
    </div>
</body>

</html>
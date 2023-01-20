<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Calendrier</title>
</head>

<body>

    <div class="title">
        <h1><img src="assets/img/calendrier.png" alt="icon_calendar">Calendrier</h1>
    </div>

    <div class='selectedmonth'><?= $date ?></div>

    <div id="container">
        <form action="" method="GET">

            <label for="calendar">Choisir un mois et une année :</label>

            <select name="month" id="calendar">
                <option disable selected value="">-- Mois --</option>
                <?php

                foreach ($months as $month) { ?>
                    <option value="<?= $month ?>" <?= (isset($_GET['month']) && ($_GET['month'] === $month)) ? "selected" : '' ?>> <?= $month ?></option>
                <?php } ?>
            </select>

            <select name="years" id="calendar">
                <option disable selected value="">-- Année --</option>
                <?php
                for ($year = 2025; $year >= 1925; $year--) { ?>
                    <option value="<?= $year ?>" <?= (isset($_GET['year']) && ($_GET['year'] === $year)) ? "selected" : '' ?>> <?= $year ?></option>
                <?php } ?>
            </select>

            <input type="submit" value="Choisir">
        </form>

        <div class="grid">
            <?php
            $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            foreach ($days as $day) { ?>

                <div class='days'>
                    <div class='day'><?= $day ?></div>
                </div>

            <?php }
            for ($i = 1; $i < $numberofthefirstday; $i++) { ?>
                <div class='items gray' data-title=''></div>
                <?php }

            for ($j = 0; $j <= $nbofdaysinmonth - 1; $j++) {
                $uniqtimestamp = $timestampfirst + ($j * 86400);

                $uniqnameoftheday = date('l j F Y', $uniqtimestamp);
                $uniqnameoftheday = str_replace($dayus, $dayfr, $uniqnameoftheday);
                $uniqnameoftheday = str_replace($monthus, $months, $uniqnameoftheday);

                if ($uniqtimestamp === $today) { ?>
                    <div class='items blue' data-title='<?= $uniqnameoftheday ?>'>
                        <div class='day'><?= date('j', $uniqtimestamp) ?></div>
                        <div class='item' data-desc="Aujourd'hui">Aujourd'hui</div>
                    </div>
                <?php } elseif (array_key_exists($uniqtimestamp, $holidates)) { ?>
                    <div class='items red' data-title='<?= $uniqnameoftheday ?>'>
                        <div class='day'><?= date('j', $uniqtimestamp) ?></div>
                        <?php foreach ($holidates[$uniqtimestamp] as $values) { ?>
                            <div class='item' data-desc='<?= $values ?>'><?= $values ?></div>
                        <?php } ?>
                    </div>
                <?php } elseif (array_key_exists($uniqtimestamp, $appointementdates)) { ?>
                    <div class='items green' data-title='<?= $uniqnameoftheday ?>'>
                        <div class='day'><?= date('j', $uniqtimestamp) ?></div>
                        <?php foreach ($appointementdates[$uniqtimestamp] as $values) { ?>
                            <div class='item' data-desc='<?= $values ?>'><img src="assets/img/rendez-vous.png" alt="icon_rendez-vous"><?= $values ?></div>
                        <?php } ?>
                    </div>
                <?php } elseif (array_key_exists($uniqtimestamp, $birthdates)) { ?>
                    <div class='items yellow' data-title='<?= $uniqnameoftheday ?>'>
                        <div class='day'><?= date('j', $uniqtimestamp) ?></div>
                        <?php foreach ($birthdates[$uniqtimestamp] as $values) { ?>
                            <div class='item' data-desc='<?= $values ?>'><img src="assets/img/birthday.png" alt="icon_birthday"><?= $values ?></div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class='items' data-title=''>
                        <div class='day'><?= date('j', $uniqtimestamp) ?></div>
                        <div class='item'> </div>
                    </div>
                <?php }
            }

            for ($k = $numberofthelastday; $k < 7; $k++) { ?>
                <div class='items gray' data-title=''></div>
            <?php } ?>
        </div>
    </div>

    <div class="modal">
        <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2 class="modaltitle"></h2>
                <p class="modaldesc"></p>
        </div>
    </div>
    

    <script src="assets/js/script.js"></script>
</body>

</html>
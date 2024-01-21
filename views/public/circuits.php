<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

$ini = parse_ini_file("config/keys.ini");

require_once ("views/partials/public/news_cards.php");
require_once("controllers/auth/auth.php");

const COL_CARD = "col-12 col-sm-6 col-lg-4 col-xl-3";

// JSON required, instead of web scraping, in order to achieve accuracy in weather API location
$circuits = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "\controllers\calendar\circuits.json"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calendar 2024</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/news.css">

    <?php include("views/partials/head.php"); ?>
</head>

<body class="bg-dark">
    <div class="container-fluid">

        <!-- Nav -->
        <?php include ("views/partials/navbar.php");?>

        <main>
            <br>
            <div class="d-flex justify-content-between align-items-center">

                <div class="title text-light">
                    <span class="text-light h2 d-flex justify-content-start align-items-center">
                        <button type="button" onclick="statistics()" style="border: unset; padding-left: 20px" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red"><span class="material-symbols-outlined">chevron_left</span></button>
                        <span style="font-size: 20px">2023 Statistics</span>
                    </span>
                </div>

                <div class="title text-light">
                    <span class="text-light h2 d-flex justify-content-start align-items-center">
                        2024 Calendar
                    </span>
                </div>

                <div class="title text-light">
                    <span class="text-light h2 d-flex justify-content-start align-items-center"">
                    <span style="font-size: 20px">2024 Drivers</span>
                    <button type="button" onclick="drivers()" style="border: unset; padding-right: 20px" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red"><span class="material-symbols-outlined">chevron_right</span></button>
                </div>
            </div>

            <div class="row">
                <?php if (count($circuits) > 0) { ?>
                    <?php foreach ($circuits as $circuit) { ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 d-flex align-items-stretch py-3">
                            <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                                <div class="card-img">
                                    <img style="height: 200px; width: 350px; object-fit: cover; " src="<?php echo htmlentities($circuit->img_url); ?>" class="card-img-top" alt="<?php echo htmlentities($circuit->alt); ?>">
                                </div>
                                <div class="card-body d-flex align-items-end">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between card-title">
                                            <h6 class="text-danger"><?php echo htmlentities($circuit->gp_name); ?></h6>
                                            <h6><?php echo htmlentities($circuit->race_date); ?></h6>
                                        </div>
                                        <div class="d-flex justify-content-between align-content-center">
                                            <div>
                                                <span id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-main"></span>
                                                <span id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-icon"></span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="my-auto" id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-temp"></span>
                                                <span class="my-auto" id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-time"></span>

                                            </div>
                                        </div>
                                        <hr>
                                        <p class="card-text">
                                            Round: <?php echo "<strong>" . htmlentities($circuit->round) . "</strong>/" . count($circuits); ?>
                                            <br>
                                            Circuit name: <strong><?php echo htmlentities($circuit->circuit_name); ?></strong>
                                            <br>
                                            Location: <strong class="location"><?php echo htmlentities($circuit->circuit_place); ?></strong>
                                            <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert border-light text-dark fade show d-flex align-items-center justify-content-center mt-4 col-12" role="alert">
                        <span class="material-symbols-outlined">description</span>
                        <span class="mx-2">
                            <b>INFO</b>&nbsp;| No Data available!
                        </span>
                    </div>
                <?php } ?>
            </div>
        </main>
    </div>
<script src="/f1_project/assets/js/navigate.js"></script>
<script>
    const API_KEY = "<?php echo $ini["API_KEY"]; ?>";
</script>
<script src="/f1_project/assets/js/calendar.js"></script>
</body>
</html>
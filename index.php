<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

$lat = 50.03;
$lon = 22.04;
$url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true";

$weatherData = @file_get_contents($url);
$temp = "?";
$wcode = null;

if ($weatherData) {
    $json = json_decode($weatherData, true);
    if (isset($json["current_weather"])) {
        $temp = round($json["current_weather"]["temperature"]);
        $wcode = $json["current_weather"]["weathercode"];
    }
}

function descWeather($code)
{
    $mapa = [
        0 => "Bezchmurnie",
        1 => "Gl. bezchmurnie",
        2 => "Czesciowe zachmurz.",
        3 => "Zachmurzenie",
        45 => "Mgla",
        61 => "Deszcz",
        71 => "Snieg",
        95 => "Burza",
    ];
    return $mapa[$code] ?? "Brak danych";
}

$time = date("H:i:s");
$date = date("d.m.Y");

$template = file_get_contents(__DIR__ . "/main.wml");
echo strtr($template, [
    "{CZAS}" => $time,
    "{DATA}" => $date,
    "{TEMP}" => $temp,
    "{OPIS_POGODY}" => descWeather($wcode),
]);

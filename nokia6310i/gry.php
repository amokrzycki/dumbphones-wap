<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

// Detect the correct folder path for games
$folder = __DIR__ . "/gry/";
if (!is_dir($folder)) {
    $folder = __DIR__ . "/nokia6310i/gry/";
}

$pliki = glob($folder . "*.jad");
if ($pliki === false) {
    $pliki = [];
}
sort($pliki);

$liczbaGier = count($pliki);
// Number of games per page
$perPage = 5;

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}

$totalPages = (int) ceil($liczbaGier / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$plikiStrony = array_slice($pliki, $offset, $perPage);

$listaGier = "";
foreach ($plikiStrony as $plik) {
    $nazwa = basename($plik, ".jad");
    $listaGier .= "<a href=\"gry/{$nazwa}.jad\">{$nazwa}</a><br/>\n";
}

if (empty($pliki)) {
    $listaGier = "Brak gier w katalogu.<br/>";
} else {
    // Add pagination controls if there is more than one page
    if ($totalPages > 1) {
        $listaGier .= "<br/>Strona {$page} z {$totalPages}<br/>\n";
        $links = [];
        if ($page > 1) {
            $prev = $page - 1;
            $links[] = "<a href=\"gry.php?page={$prev}\">&lt; Poprzednia</a>";
        }
        if ($page < $totalPages) {
            $next = $page + 1;
            $links[] = "<a href=\"gry.php?page={$next}\">Nastepna &gt;</a>";
        }
        $listaGier .= implode(" | ", $links) . "<br/>\n";
    }
}

$szablon = file_get_contents(__DIR__ . "/gry.wml");
echo strtr($szablon, [
    "{LICZBA_GIER}" => $liczbaGier,
    "{LISTA_GIER}" => $listaGier,
]);

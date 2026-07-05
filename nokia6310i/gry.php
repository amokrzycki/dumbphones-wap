<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

$folder = __DIR__ . "/gry/";
if (!is_dir($folder)) {
    $folder = __DIR__ . "/nokia6310i/gry/";
}

$files = glob($folder . "*.jad");
if ($files === false) {
    $files = [];
}
sort($files);

$countOfGames = count($files);

$perPage = 5;

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}

$totalPages = (int) ceil($countOfGames / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$pageFiles = array_slice($files, $offset, $perPage);

$gamesList = "";
foreach ($pageFiles as $file) {
    $name = basename($file, ".jad");
    $gamesList .= "<a href=\"gry/{$name}.jad\">{$name}</a><br/>\n";
}

if (empty($files)) {
    $gamesList = "Brak gier w katalogu.<br/>";
} else {
    // Add pagination controls if there is more than one page
    if ($totalPages > 1) {
        $gamesList .= "<br/>Strona {$page} z {$totalPages}<br/>\n";
        $links = [];
        if ($page > 1) {
            $prev = $page - 1;
            $links[] = "<a href=\"gry.php?page={$prev}\">&lt; Poprzednia</a>";
        }
        if ($page < $totalPages) {
            $next = $page + 1;
            $links[] = "<a href=\"gry.php?page={$next}\">Nastepna &gt;</a>";
        }
        $gamesList .= implode(" | ", $links) . "<br/>\n";
    }
}

$template = file_get_contents(__DIR__ . "/gry.wml");
echo strtr($template, [
    "{COUNT_OF_GAMES}" => $countOfGames,
    "{GAMES_LIST}" => $gamesList,
]);

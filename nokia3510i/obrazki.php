<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

$folder = __DIR__ . "/obrazki/";
if (!is_dir($folder)) {
    $folder = __DIR__ . "/nokia3510i/obrazki/";
}

$files = glob(
    $folder . "*.{jpg,jpeg,png,gif,bmp,JPG,JPEG,PNG,GIF,BMP}",
    GLOB_BRACE,
);
if ($files === false) {
    $files = [];
}
sort($files);

$countOfPics = count($files);

$perPage = 5;

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}

$totalPages = (int) ceil($countOfPics / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$pageFiles = array_slice($files, $offset, $perPage);

$picsList = "";
foreach ($pageFiles as $plik) {
    $name = basename($plik);
    $nameWithoutExt = pathinfo($plik, PATHINFO_FILENAME);
    $urlEncoded = rawurlencode($name);
    $picsList .= "<a href=\"obrazki/{$urlEncoded}\">{$nameWithoutExt}</a><br/>\n";
}

if (empty($files)) {
    $picsList = "Brak obrazkow w katalogu.<br/>";
} else {
    // Add pagination controls if there is more than one page
    if ($totalPages > 1) {
        $picsList .= "<br/>Strona {$page} z {$totalPages}<br/>\n";
        $links = [];
        if ($page > 1) {
            $prev = $page - 1;
            $links[] = "<a href=\"obrazki.php?page={$prev}\">&lt; Poprzednia</a>";
        }
        if ($page < $totalPages) {
            $next = $page + 1;
            $links[] = "<a href=\"obrazki.php?page={$next}\">Nastepna &gt;</a>";
        }
        $picsList .= implode(" | ", $links) . "<br/>\n";
    }
}

$template = file_get_contents(__DIR__ . "/obrazki.wml");
echo strtr($template, [
    "{COUNT_OF_PICS}" => $countOfPics,
    "{PICS_LIST}" => $picsList,
]);

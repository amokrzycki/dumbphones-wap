<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

// Detect the correct folder path for images
$folder = __DIR__ . "/obrazki/";
if (!is_dir($folder)) {
    $folder = __DIR__ . "/nokia3510i/obrazki/";
}

$pliki = glob(
    $folder . "*.{jpg,jpeg,png,gif,bmp,JPG,JPEG,PNG,GIF,BMP}",
    GLOB_BRACE,
);
if ($pliki === false) {
    $pliki = [];
}
sort($pliki);

$liczbaObrazkow = count($pliki);
// Number of images per page
$perPage = 5;

$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}

$totalPages = (int) ceil($liczbaObrazkow / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$plikiStrony = array_slice($pliki, $offset, $perPage);

$listaObrazkow = "";
foreach ($plikiStrony as $plik) {
    $nazwa = basename($plik);
    $nazwaBezRoz = pathinfo($plik, PATHINFO_FILENAME);
    $urlEncoded = rawurlencode($nazwa);
    $listaObrazkow .= "<a href=\"obrazki/{$urlEncoded}\">{$nazwaBezRoz}</a><br/>\n";
}

if (empty($pliki)) {
    $listaObrazkow = "Brak obrazkow w katalogu.<br/>";
} else {
    // Add pagination controls if there is more than one page
    if ($totalPages > 1) {
        $listaObrazkow .= "<br/>Strona {$page} z {$totalPages}<br/>\n";
        $links = [];
        if ($page > 1) {
            $prev = $page - 1;
            $links[] = "<a href=\"obrazki.php?page={$prev}\">&lt; Poprzednia</a>";
        }
        if ($page < $totalPages) {
            $next = $page + 1;
            $links[] = "<a href=\"obrazki.php?page={$next}\">Nastepna &gt;</a>";
        }
        $listaObrazkow .= implode(" | ", $links) . "<br/>\n";
    }
}

$szablon = file_get_contents(__DIR__ . "/obrazki.wml");
echo strtr($szablon, [
    "{LICZBA_OBRAZKOW}" => $liczbaObrazkow,
    "{LISTA_OBRAZKOW}" => $listaObrazkow,
]);

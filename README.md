# Sajson WAP

Simple PHP WAP site for classic Nokia 3510i and 6310i phones. It shows current weather in Rzeszów plus game and image lists from device directories.

## Run

Requires PHP with `allow_url_fopen` enabled to fetch weather from Open-Meteo.

```sh
php -S localhost:8000
```

Open `http://localhost:8000/index.php` in a browser or WAP emulator.

## Contents

- `index.php` — homepage, date, time, and weather
- `nokia3510i/` — games (`gry/`) and images (`obrazki/`)
- `nokia6310i/` — games (`gry/`)

Add `.jad` files to a `gry/` directory and images to `nokia3510i/obrazki/`. Lists paginate five items per page.

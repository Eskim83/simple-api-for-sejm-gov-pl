# Sejm.gov.pl PHP API Client

Prosty klient PHP do publicznego API Sejmu RP (X kadencja) – **bez autoryzacji, bez zależności zewnętrznych**. Pozwala na pobieranie informacji o posłach, klubach, posiedzeniach itp. przez HTTP GET.

## Funkcje

* Wysyłanie zapytań GET do endpointów Sejm API:
  `https://api.sejm.gov.pl/sejm/term10/`
* Obsługa parametrów zapytania
* Zwraca dane jako zdekodowana tablica PHP
* Obsługa błędów sieciowych i HTTP (np. 404)

## Instalacja

Wystarczy skopiować plik `Client.php` do własnego projektu i użyć z przestrzeni nazw `Sejm`.

```bash
# struktura katalogów (przykład)
your_project/
├── Sejm/
│   └── Client.php
├── example.php
```

## Przykład użycia

Poniższy kod pobiera informacje o pośle numer 1 (X kadencja):

```php
<?php

include_once "Sejm/Client.php";

$client = new Sejm\Client();

// Przykładowe informacje o pośle nr 1
$result = $client->request('MP/1');

print_r($result);

?>
```

Przykładowy wynik (`$result`):

```php
Array
(
    [data] => Array
        (
            [accusativeName] => ...
            [active] => 1
            [birthDate] => ...
            // ...
        )
    // ...
)
```

## Opis metody

### `request($endpoint, $params = [], $accept = 'application/json'): array`

* **\$endpoint** – ścieżka np. `MP/1` lub `MP`
* **\$params** – (opcjonalnie) tablica parametrów GET
* **\$accept** – (opcjonalnie) nagłówek Accept, domyślnie `application/json`
* Zwraca: **array** (zdekodowana odpowiedź API)
* Wyrzuca: **Exception** przy błędach HTTP/sieciowych

## Przykładowe endpointy Sejm API

* `MP` – lista posłów
* `MP/{id}` – dane posła (np. `MP/1`)
* `CLUB` – lista klubów i kół
* `SITTING` – lista posiedzeń

**Dokumentacja:** [https://api.sejm.gov.pl/sejm.html](https://api.sejm.gov.pl/sejm.html)

## Obsługa błędów

Metoda `request()` rzuca `Exception` w przypadku błędów HTTP (np. 404, 400) oraz błędów cURL.

## Wymagania

* PHP 7.4 lub nowszy
* Rozszerzenie cURL (standardowo dostępne w większości instalacji PHP)

## Licencja

MIT / open source – korzystaj dowolnie.

---

**Autor:** [Eskim83 / Maciej](https://eskim.pl)
**Kontakt:** [info@eskim.pl](mailto:info@eskim.pl)
**Donate:** [https://buymecoffee.com/eskim](https://buymecoffee.com/eskim)

---

Chcesz coś poprawić/ulepszyć? [Stwórz issue lub PR na GitHubie](https://github.com/Eskim83) (repozytorium utwórz sam, bo w tej chwili nie ma).

---

Masz pytania, uwagi lub znalazłeś błąd – napisz, zweryfikuję!

# Webbshop Projekt med Laragon

## Beskrivning
En enkel webbshop byggd med PHP, MySQL, HTML och CSS, som använder Laragon som utvecklingsmiljö. Användare kan bläddra genom produkter, lägga beställningar och se orderhistorik.

![alt text](https://ibb.co/yNJt1pc)
![alt text](https://ibb.co/bNS4rdn)

![store_view](https://github.com/Betttina/databashantering/assets/125275847/20b893ab-6ff4-435b-90ca-d2d9d4c33834)
![admin_view](https://github.com/Betttina/databashantering/assets/125275847/79cd7787-3dd6-4482-a361-78c2f36a244a)


## Systemkrav
- Laragon installerat (https://laragon.org/download/)
- PHP 7.0 eller senare
- MySQL-databas
- Webbläsare

## Installationsinstruktioner
1. Klona projektet från GitHub.
2. Öppna Laragon och starta Apache och MySQL.
3. Skapa en MySQL-databas och importera SQL-dumpen från `database2.sql`.
4. Konfigurera databasanslutningsinställningarna i `config.php`.
5. Öppna projektet i din webbläsare genom att besöka `http://webbshop.test`.

## Användarhandledning
Store_view:
1. Besök webbshopen.
2. Bläddra igenom produkterna.
3. Lägg till produkter och beställningsinfo genom ett formulär.
4. Slutför beställningen genom att skicka formuläret och orderbekräftelse visas.

Admin_view:
1. Besök admin panel.
2. Bläddra genom kunder med tillhörande beställningar och ordervaror.
3. Hantera beställningar genom att uppdatera order-status eller ta bort beställningen.

## Projektstruktur
- `index.php`: Huvudwebbsidan.
- `css/`: Stilar för webbgränssnittet.
- `includes/`: PHP-includes och hjälpfunktioner.
- `views/store_view/`: Butik-gränssnitt för produkt-visning och lägga beställningar.
- `views/admin_view/`: Admin-gränssnitt för hantering av beställningar.

## Databasstruktur
- `customers`: Kundinformation.
- `products`: Produktinformation.
- `orders`: Beställningsinformation.
- `order_items`: Detaljer om produkter i varje beställning/ordervaror.
- `media`: Produktbilder.

## Licens
Detta projekt är licensierat under MIT-licensen.



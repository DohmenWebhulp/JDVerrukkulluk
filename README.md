<!--Logo -->
![homepage](assets/img/logo-v2.png)
<!-- Headings -->
# De Verrukkulluk website

Dit is de website gemaakt door mij voor het project Verrukkulluk. In dit project heb ik een website gemaakt die verschillende recepten toont met bijbehorende informatie. De eerste weken was ik bezig met ERD's en ASD's te maken om de data structuur inzichtelijk te maken. Tevens ging ik aan de slag met php en een databse voor de backend kant van de website. De laatste twee weken gingen vooral over het inrichten van de website (frontend) en de verbinding leggen met de backend via onder andere forms en ajax calls. Dat laatste is een aardige manier om meteen gegevens in de database te kunnen opslaan zonder de pagina te hoeven herladen.

![homepage](screenshots/carousel.PNG)
![homepage](screenshots/recepten.PNG)

## Structuur 

De site bestaat uit het main frame dat gekoppeld kan worden aan 4 verschillende pagina's, te weten:

* De Homepage.
* De Detailpagina.
* De Boodschappenlijst.
* De Gebruikerspagina.

___
___

## Technologieën

* MySQL Database
* PHP
* HTML
* CSS
* Bootstrap
* FontAwesome
* JQuery
* JavaScript

Met HTML en CSS, gebruik makend van de bootstrap package, heb ik de webpagina vormgegeven. Bootstrap zorgt tevens voor de Carousel en tab toggle voor de ingrediënten, bereidingswijze en opmerkingen. Jquery maakt de dynamiek van de site makkelijker. Hierin zijn ook de ajax calls opgenomen voor de waardering en favorieten. FontAwesome levert herkenbare icoontjes om te gebruiken.

## Methoden en Technieken

![methoden](screenshots/verruk_ERD.png)
![methoden](screenshots/verruk_ASD.png)
## Main Frame

Aan het main frame zijn alle pagina's verbonden. Bovenaan het frame kunt U het Logo en de Carousel zien, met de Carousel scrollend door alle recepten. Ook is er rechtsboven een zoekfunctie, die zoekt op trefwoorden (substrings) aanwezig in de informatie over een bepaald recept. Een druk op enter laat alle recepten zien die de opgegeven substring hebben.

De Agenda en de Login zijn gesitueerd aan de linkerzijde. Hierin kan men inloggen als de gebruiker in de database kan worden gevonden. Anders wordt er een nieuwe gebruiker gecreëerd en dan toegevoegd aan de database, mits de email of gebruikersnaam al niet bestaat. Hierna wordt de gebruiker doorgestuurd naar de Gebruikerspagina.

Onderaan vindt men de contactinformatie van de site.

___

## Homepage

De homepage ziet er als volgt uit:

![homepage](screenshots/hamburger.jpg)

Op de homepage zijn alle recepten te zien samen met wat informatie, bestaande uit:

* Een foto van het recept.
* Het aantal personen.
* Het aantal Calorieën .
* De prijs van het recept.
* De titel van het recept.
* De gemiddelde waardering.
* Een korte omschrijving.

Ook is er onderaan een knop die de gebruiker doorstuurt naar de Detailpagina van het desbetreffende recept.

___

## Detailpagina

![detailpage](screenshots/detail.PNG)
![detailpage](screenshots/ingredss.PNG)

Op de Detailpagina staan naast de informatie op de homepage nog meer details over het recept, waaronder

* Het Type Keuken waarin het recept is gemaakt.
* Het Type Voedsel wat het recept representeert.
* Een mogelijkheid voor de gebruiker het recept toe te voegen aan zijn of haar favorietenlijstje.
* Een knop Op Lijst.
* Een tab met:
    * Ingrediënten nodig voor het maken van het recept.
    * De Bereidingswijze voor het recept.
    * Opmerkingen van gebruikers.

Wanneer de gebruiker het recept toevoegt aan zijn favorietenlijstje, wordt de gebruiker direct toegevoegd aan de database. Tegelijkertijd wordt het hartje gevuld. De gebruiker kan dit ongedaan maken door nog een keer op het nu volle hart te klikken.

Klikt men op de knop Op Lijst, dan wordt men doorgestuurd naar de Boodschappenlijst.

### _Ingrediënten_

In de tab Ingrediënten staan alle ingrediënten die horen bij het desbetreffende recept. Elke Ingrediëntregel bestaat uit:

* Een foto van het ingrediënt.
* De titel van het ingrediënt.
* Een korte beschrijving van het ingrediënt.
* De hoeveelheid die aangeeft hoeveel er nodig is van dit ingrediënt om het recept te maken.

### _Bereidingswijze_

In de tab Bereidingswijze staat het stappenplan voor het maken van het recept.

### _Opmerkingen_

In de tab Opmerkingen vindt men beoordelingen van bepaalde gebruikers over het recept.

___

## Boodschappenlijst

![boodschappen](screenshots/boodscreenshot.PNG)

Op de boodschappenlijst staan alle ingrediënten van die recepten waarvan de gebruiker op de knop Op Lijst heeft geklikt op de Detailpagina. Tevens worden deze ingrediënten dan toegevoegd aan de database. Naast de ingrediëntinformatie staat op de lijst:

* Het aantal eenheden nodig van hetzelfde ingrediënt
* De totale prijs van alle eenheden van het betreffende ingrediënt.
* De optie om het ingrediënt van het lijstje te gooien.

Tevens staat onderaan de totale prijs van alle ingrediënten.

# Reflektioner ja222qm

1. Vad tror Du vi har för skäl till att spara det skrapade datat i JSON-format?
För att JSON är språk-oberoende och lätt, alltså kan alla använda formatet och det belastar så lite som möjligt. Dessutom kan man enkelt validera formatet och får en för både människor och maskiner lättläslig struktur.

2. Olika jämförelsesiter är flitiga användare av webbskrapor. Kan du komma på fler typer av tillämplingar där webbskrapor förekommer?
Stora företag som hämtar data om produkter, tjänster och användarvanor m.m. Även siter som fungerar som databaser av information eller statistik för tex ett online spel är detta användbart. 
Tex. så är det många som har skrapat info från League of Legends live services, för att få ut statistik om spelade matcher och senaste nyheter. Detta orsakade problem för deras live stabilitet och Riot (utvecklaren av spelet) har därför skapat ett API för att hämta ut den typen av info.

3. Hur har du i din skrapning underlättat för serverägaren?
Jag har indetifierat mig i curl requestet för att inte röra till i statistiken och fixat så att scriptet inte körs om det inte gått mer än 5 minuter sedan senaste hämtningen.

4. Vilka etiska aspekter bör man fundera kring vid webbskrapning?
Man bör fundera på vem som äger informationen och tänka på att inte tjäna pengar på andras verk.

5. Vad finns det för risker med applikationer som innefattar automatisk skrapning av webbsidor? Nämn minst ett par stycken!
Risken finns att du blir stämd om du inte följer en sidas terms of use, de kan ha uppdaterat dessa sedan du gjorde din skrapa. Kan även hända att sidan du skrapar ändrar om i sin struktur vilket leder till att din skrapa inte fungerar och därmed kanske din applikation slutar fungera, eller ger missvisande information. 
Du kan också hållas ansvarig för saker som dyker upp i din applikation men är postat av någon annan site, tex kränkande skämt eller bedrägeri.

6. Tänk dig att du skulle skrapa en sida gjord i ASP.NET WebForms. Vad för extra problem skulle man kunna få då?
Dels är html strukturen väldigt rörig och skiljer sig beroende på klient vilket gör det svårare att hitta rätt information. Sen måste du även hålla koll på viewstate och skicka med information i post när det händer saker på sidan.

7. Välj ut två punkter kring din kod du tycker är värd att diskutera vid redovisningen. Det kan röra val du gjort, tekniska lösningar eller lösningar du inte är riktigt nöjd med.
Skulle definitivt kunna finslipa koden för att kontrollera om skrapningen skall göras eller inte. Är rätt nöjd med min Scraper klass som håller koll på all information om den hämtade informationen, kunde kanske även sköta sparningen/hämtningen av JSON.
Gjorde även en version med hjälp av simplehtmldom men upptäckte att denna var långsammare än curl med xpath.

8. Hitta ett rättsfall som handlar om webbskrapning. Redogör kort för detta.
Mars 2013 blev Andrew Weev Auernheimer dömd för att ha gjort ett skript som via ett företags (AT&T) server hämtade ut dess iPad-användares email adresser. De fick tag på 114 000 adresser genom att besöka en url där de genererade möjliga kombinationer av en iPads unika IIC-ID.
Många tycker att det var fel att döma honom eftersom informationen inte var krypterat eller skyddad på något sätt, utan låg helt öppet för vem som helst att besöka bara genom att testa sig fram till de olika unika nycklarna.

9. Känner du att du lärt dig något av denna uppgift?
Ja! En bra lärdom i att hämta ut information från webbsiter och vilka problem man kan möta. Fastnade lite för ofta på php/xpath syntaxen dock. De resursfilmer som fanns var bra, hade gärna haft demon på flera alternativ av teknik.
Tex kunde länken till node-tutorialen finnas på laborations-sidan då stora delar av labb-tiden hade gått när materialet för peer instruction 2 lades ut.
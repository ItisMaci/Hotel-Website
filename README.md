**CHANGES**

- Main folder zu /Hotel-Website/ geändert und alle urls geupdatet
- login und signup sind jetzt mit includes eingebunden
- signup male/female radios zu einer drop-down auswahl geändert, um mehrere Auswahlmöglichkeiten zu ermöglichen

**Reservierungen**
- Reservierungen sollten jetzt voll funktionsfähig sein

**Admin Bereich**
- admin Bereich kann jetzt Reservierungen filtern und bearbeiten mit edit_booking.php
- habe user und booking id's zu 'readonly' gemacht, damit man nicht versehentlich die Id ändert

**is_admin and active in login.inc.php**
- musste vor beiden ein (int) setzen, damit die Werte tatsächlich wieder int sind, keine Ahnung warum diese Werte aufeinmal
  als String representiert wurde, aber habe es eben damit gelöst

**LOGIN**
- admin pw: 123
- user pw: 123

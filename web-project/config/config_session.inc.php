<?php

// Sichert die Verwendung von Cookies für Sitzungen (Session Management)
// Diese Einstellung verhindert, dass Sitzungs-IDs über die URL übertragen werden
ini_set('session.use_only_cookies', 1);

// Aktiviert den strengen Modus, um zu verhindern, dass ungültige Sitzungs-IDs akzeptiert werden
ini_set('session.use_strict_mode', 1);

// Legt die Parameter für das Session-Cookie fest
session_set_cookie_params([
    // Legt die Lebensdauer des Session-Cookies auf 1800 Sekunden (30 Minuten) fest
    'lifetime' => 1800,
    // Domain, für die das Cookie gültig ist. Hier wird "localhost" verwendet.
    'domain' => 'localhost',
    // Der Pfad, für den das Cookie gültig ist (Root-Pfad)
    'path' => '/',
    // Das Cookie wird nur über sichere HTTPS-Verbindungen gesendet
    'secure' => true,
    // Das Cookie ist nur über HTTP(S) und nicht über JavaScript zugänglich
    'httponly' => true
]);

// Startet die Sitzung (Session) oder nimmt sie wieder auf
session_start();

if (isset($_SESSION["user_id"])) {
    // Überprüft, ob die Sitzung kürzlich regeneriert wurde
    if (!isset($_SESSION["last_regeneration"])) {
        // Regeneriert die Sitzungs-ID für eingeloggte Benutzer
        regenerate_seesion_id_loggedin();
    } else {
        // Definiert das Intervall für die Regeneration der Sitzungs-ID (in Sekunden)
        $interval = 60 * 30; // 30 Minuten
        // Überprüft, ob das definierte Intervall vergangen ist
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_seesion_id_loggedin();
        }
    }
} else {
    // Überprüft, ob die Sitzung kürzlich regeneriert wurde
    if (!isset($_SESSION["last_regeneration"])) {
        // Regeneriert die Sitzungs-ID für Gäste
        regenerate_seesion_id();
    } else {
        // Definiert das Intervall für die Regeneration der Sitzungs-ID (in Sekunden)
        $interval = 60 * 30; // 30 Minuten
        // Überprüft, ob das definierte Intervall vergangen ist
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_seesion_id();
        }
    }
}

// Funktion zur Regeneration der Sitzungs-ID und Aktualisierung des Zeitstempels
function regenerate_seesion_id() {
    // Generiert eine neue Sitzungs-ID
    session_regenerate_id(true);
    // Aktualisiert den Zeitpunkt der letzten ID-Regeneration
    $_SESSION["last_regeneration"] = time();
}

// Funktion zur Regeneration der Sitzungs-ID für eingeloggte Benutzer
function regenerate_seesion_id_loggedin() {
    $userId = $_SESSION["user_id"];

    // Generiert eine neue Sitzungs-ID
    session_regenerate_id(true);

    // Erstellt eine benutzerdefinierte Sitzungs-ID (optional)
    $newSessionId = session_create_id($userId . '_');
    $_SESSION["last_regeneration"] = time();

    // Speichert die benutzerdefinierte Sitzungs-ID für Debugging oder Überprüfung
    $_SESSION["custom_session_id"] = $newSessionId;
}

?>

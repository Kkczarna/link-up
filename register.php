<?php
// Włączamy pełne raportowanie błędów
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. POŁĄCZENIE
// Upewnij się, że 'Uzytkownicy' to nazwa BAZY DANYCH (tej z lewej strony w phpMyAdmin)
$conn = mysqli_connect('localhost', 'root', '', 'Uzytkownicy');

if (!$conn) {
    die("<h3>BŁĄD POŁĄCZENIA: " . mysqli_connect_error() . "</h3>");
}

// 2. DANE
$imie = $_POST['imie'] ?? 'BRAK';
$nazwisko = $_POST['nazwisko'] ?? 'BRAK';
$plec = $_POST['plec'] ?? '';
$data_urodzenia = $_POST['data_urodzenia'] ?? '1900-01-01';
$nr_telefon = $_POST['telefon'] ?? '000';
$email = $_POST['email'] ?? 'brak@maila.pl';
$haslo = $_POST['password'] ?? 'haslo';

// 3. BUDOWANIE ZAPYTANIA
// Uwaga na wielkość liter w nazwie tabeli! Na Macu 'Uzytkownicy' to nie to samo co 'uzytkownicy'.
// Zakładam, że Twoja TABELA też nazywa się 'Uzytkownicy' (z dużej litery).
$sql = "INSERT INTO Uzytkownicy (imie, nazwisko, plec, data_urodzenia, nr_telefon, email, haslo) 
        VALUES ('$imie', '$nazwisko', '$plec', '$data_urodzenia', '$nr_telefon', '$email', '$haslo')";

//DIAGNOSTYKA
echo "<h2>Diagnostyka:</h2>";
echo "<strong>Połączono z bazą danych:</strong> " . $conn->host_info . "<br>";
echo "<strong>Próba wykonania zapytania SQL:</strong><br>";
echo "<div style='background: #eee; padding: 10px; border: 1px solid #999; font-family: monospace;'>$sql</div><br>";

// 4. WYKONANIE
if (mysqli_query($conn, $sql)) {
    echo "<h2 style='color: green;'>KOMUNIKAT: Sukces! Rekord dodany (według PHP).</h2>";
    echo "<p>Idź teraz do phpMyAdmin i kliknij przycisk <strong>Przeglądaj</strong> (Browse) w tabeli.</p>";
} else {
    echo "<h2 style='color: red;'>BŁĄD SQL:</h2>";
    echo mysqli_error($conn);
}

mysqli_close($conn);
?>
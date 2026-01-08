<?php
// WŁĄCZAMY WIDOCZNOŚĆ BŁĘDÓW (usuń te linie po zakończeniu prac nad stroną)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 1. KONFIGURACJA BAZY
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "Uzytkownicy"; // Nazwa Twojej BAZY DANYCH

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}

// 2. ODBIERANIE DANYCH
if (isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 

    // 3. ZAPYTANIE SQL
    // WAŻNE: Upewnij się, że nazwa tabeli (tutaj 'Uzytkownicy') jest poprawna!
    // Często tabela nazywa się 'uzytkownicy' (małą literą), a baza 'Uzytkownicy'.
    $sql = "SELECT * FROM Uzytkownicy WHERE email='$email' AND haslo='$pass'";
    
    $result = mysqli_query($conn, $sql);

    // --- TUTAJ BYŁ POTENCJALNY BŁĄD 500 ---
    // Sprawdzamy, czy zapytanie w ogóle zadziałało
    if (!$result) {
        // Jeśli zapytanie ma błąd (np. zła nazwa tabeli), wyświetl go:
        die("Błąd zapytania SQL: " . mysqli_error($conn)); 
    }

    // 4. WERYFIKACJA
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        $_SESSION['zalogowany'] = true;
        
        header("Location: main.html"); 
        exit();
    } else {
        echo "<h3 style='color:red; text-align:center; margin-top:50px;'>Błędny email lub hasło!</h3>";
        // Wyświetlamy dla pewności co wpisano (tylko do testów)
        // echo "<p align='center'>Szukano: $email / $pass</p>"; 
        
        header("refresh:3;url=login.html");
    }
} else {
    header("Location: login.html");
}

mysqli_close($conn);
?>
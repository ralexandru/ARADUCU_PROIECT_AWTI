<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Conexiune la baza de date(informatii conexiune)
$db = new PDO('mysql:host=localhost;dbname=proiect_awti', 'root', '');

$lastEventId = isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0;

while (true) {
    $stmt = $db->prepare("SELECT * FROM melodie WHERE MelodieId > :lastEventId");
    $stmt->bindParam(':lastEventId', $lastEventId, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "id: " . $row['MelodieId'] . PHP_EOL;
        echo "data: " . json_encode($row) . PHP_EOL;
        echo PHP_EOL;
        ob_flush();
        flush();

        $lastEventId = $row['MelodieId'];
    }

    sleep(1); // Adaugare delay
}
?>

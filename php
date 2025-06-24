<?php
$host = 'localhost';
$dbname = 'school_club';
$username = 'root';
$password = " ";

try {
    $pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname",username: $username, password: $password);
    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
 die ("Connection failed: ". $e->getMessage());
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add'])) {
   $stmt = $pdo->prepare(query: "INSERT INTO events (title, description, location, event_date, status) VALUES (?, ?, ?, ?, ?)");
   $stmt->execute(params: [$_POST['title'], $_POST['description'],$_POST['location'], $_POST['event_date'], $_POST['status'] ]);
   $message = "Event added successfully!";
}
if(isset($_POST["update"])) {
$stmt = $pdo->prepare(query:"UPDATE events SET title = ?, description = ?, location = ?, event_date = ?, status = ? WHERE event_id = ?");
$stmt->execute(params: [$_POST['title'], $_POST['description'], $_POST['location'], $_POST['event_date'], $_POST['status'], $_POST['event_id']]);
$message = "Event updated successfully!";
}
if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare(query: "DELETE FROM events WHERE event_id=?");
        $stmt->execute(params: [$_POST['event_id']]);
        $message = "Event deleted successfully!";
    }
}
$stmt = $pdo->prepare(query:"SELECT * FROM events");
$events = $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
?>

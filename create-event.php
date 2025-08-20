<?php
include 'db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = trim($_POST['location']);
    $themeColor = isset($_POST['themeColor']) ? $_POST['themeColor'] : '#6C63FF';

    // Handle image upload
    $bannerPath = null;
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['banner']['name']);
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile)) {
            $bannerPath = $targetFile;
        }
    }

    if (empty($title) || empty($date) || empty($time)) {
        die("Title, date, and time are required.");
    }

    $sql = "INSERT INTO events (title, description, date, time, location, theme_color, banner) VALUES (:title, :description, :date, :time, :location, :theme_color, :banner)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':date' => $date,
        ':time' => $time,
        ':location' => $location,
        ':theme_color' => $themeColor,
        ':banner' => $bannerPath
    ]);

    header("Location: success.php");
    exit();
}
?>

<?php
session_start();
require_once '../functions.php';

header('Content-Type: application/json');

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Validasi input
if (!isset($_POST['icon']) || !isset($_POST['title']) || !isset($_POST['description'])) {
    echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$icon = trim($_POST['icon']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);

try {
    if ($id) {
        // Update fitur yang sudah ada
        $stmt = $conn->prepare("UPDATE features SET icon = ?, title = ?, description = ? WHERE id = ?");
        $result = $stmt->execute([$icon, $title, $description, $id]);
    } else {
        // Tambah fitur baru
        $stmt = $conn->prepare("INSERT INTO features (icon, title, description) VALUES (?, ?, ?)");
        $result = $stmt->execute([$icon, $title, $description]);
    }

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Fitur berhasil disimpan']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan fitur']);
    }
} catch (PDOException $e) {
    error_log("Error in save_feature.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
    ]);
}
?> 
<?php
session_start();
require_once '../functions.php';

header('Content-Type: application/json');

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID fitur tidak valid!']);
    exit;
}

$id = (int)$_GET['id'];

try {
    // Ambil data fitur
    $stmt = $conn->prepare("SELECT * FROM features WHERE id = ?");
    $stmt->execute([$id]);
    $feature = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($feature) {
        echo json_encode(['success' => true, 'feature' => $feature]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fitur tidak ditemukan']);
    }
} catch (PDOException $e) {
    error_log("Error in get_feature.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
    ]);
}
?> 
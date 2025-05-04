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
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID fitur tidak valid!']);
    exit;
}

$id = (int)$_POST['id'];

try {
    // Cek apakah fitur ada sebelum dihapus
    $checkStmt = $conn->prepare("SELECT id FROM features WHERE id = ?");
    $checkStmt->execute([$id]);
    
    if (!$checkStmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Fitur tidak ditemukan']);
        exit;
    }

    // Hapus fitur dari database
    $stmt = $conn->prepare("DELETE FROM features WHERE id = ?");
    $result = $stmt->execute([$id]);

    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Fitur berhasil dihapus']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus fitur: Tidak ada baris yang terpengaruh']);
    }
} catch (PDOException $e) {
    error_log("Error in delete_feature.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("Error in delete_feature.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?> 
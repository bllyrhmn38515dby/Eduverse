<?php
session_start();
require_once '../functions.php';

// Cek apakah user sudah login dan memiliki role admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$response = ['success' => false, 'message' => ''];

try {
    // Ambil ID dari POST
    $id = $_POST['id'] ?? '';
    
    if (empty($id)) {
        throw new Exception('ID user tidak valid!');
    }

    // Cek apakah user yang akan dihapus adalah admin
    $user = getUser($id);
    if ($user && $user['role'] === 'admin') {
        throw new Exception('Tidak dapat menghapus user dengan role admin!');
    }

    // Hapus user
    if (deleteUser($id)) {
        $response['success'] = true;
        $response['message'] = 'User berhasil dihapus!';
    } else {
        throw new Exception('Gagal menghapus user!');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 
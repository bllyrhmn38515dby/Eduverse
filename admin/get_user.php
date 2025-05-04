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
    // Ambil ID dari GET
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        throw new Exception('ID user tidak valid!');
    }

    // Ambil data user
    $user = getUser($id);
    
    if ($user) {
        // Hapus password dari response
        unset($user['password']);
        $response['success'] = true;
        $response['user'] = $user;
    } else {
        throw new Exception('User tidak ditemukan!');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 
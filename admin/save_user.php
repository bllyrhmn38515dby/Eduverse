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
    // Ambil data dari POST
    $id = $_POST['id'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($username) || empty($email) || empty($nama_lengkap) || empty($role)) {
        throw new Exception('Semua field wajib diisi!');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Format email tidak valid!');
    }

    if (empty($id)) {
        // Create new user
        if (empty($password)) {
            throw new Exception('Password wajib diisi untuk user baru!');
        }
        
        if (createUser($username, $password, $email, $nama_lengkap, $role)) {
            $response['success'] = true;
            $response['message'] = 'User berhasil ditambahkan!';
        } else {
            throw new Exception('Gagal menambahkan user. Username atau email mungkin sudah digunakan.');
        }
    } else {
        // Update existing user
        if (updateUser($id, $username, $email, $nama_lengkap, $role)) {
            if (!empty($password)) {
                updateUserPassword($id, $password);
            }
            $response['success'] = true;
            $response['message'] = 'User berhasil diperbarui!';
        } else {
            throw new Exception('Gagal memperbarui user. Username atau email mungkin sudah digunakan.');
        }
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?> 
<?php
session_start();
require 'kontak_data.php';

define('USERNAME', 'admin');
define('PASSWORD', '123456');

function validate_kontak($data) {
    $errors = [];
    if (empty($data['nama'])) {
        $errors[] = 'Nama harus diisi.';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $data['nama'])) {
        $errors[] = 'Nama hanya boleh mengandung huruf dan spasi.';
    }
    if (empty($data['npm'])) {
        $errors[] = 'NPM harus diisi.';
    } elseif (!preg_match("/^[0-9]+$/", $data['npm'])) {
        $errors[] = 'NPM hanya boleh mengandung angka.';
    }
    if (empty($data['prodi'])) {
        $errors[] = 'Program Studi harus dipilih.';
    }
    if (empty($data['telepon'])) {
        $errors[] = 'Nomor telepon harus diisi.';
    } elseif (!preg_match("/^[0-9]+$/", $data['telepon'])) {
        $errors[] = 'Nomor telepon hanya boleh mengandung angka.';
    }
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    return $errors;
}
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === USERNAME && $password === PASSWORD) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['login_error'] = 'Username atau password salah!';
        header('Location: index.php');
        exit();
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (!isset($_POST['login'])) {
        header('Location: index.php');
        exit();
    }
}
if (isset($_POST['tambah_kontak'])) {
    $input_data = [
        'nama' => trim($_POST['nama'] ?? ''),
        'npm' => trim($_POST['npm'] ?? ''),
        'prodi' => trim($_POST['prodi'] ?? ''),
        'semester' => trim($_POST['semester'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
    ];
    
    $errors = validate_kontak($input_data);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $input_data;
        header('Location: dashboard.php');
        exit();
    }
    
    $kontak_list = get_kontak_data();
    
    $new_id = empty($kontak_list) ? 1 : max(array_keys($kontak_list)) + 1;
    
    $new_kontak = $input_data;
    $new_kontak['id'] = $new_id;
    
    $kontak_list[$new_id] = $new_kontak;
    save_kontak_data($kontak_list);

    header('Location: dashboard.php');
    exit();
}
if (isset($_POST['edit_kontak'])) {
    $id = $_POST['id'] ?? null;
    $input_data = [
        'nama' => trim($_POST['nama'] ?? ''),
        'npm' => trim($_POST['npm'] ?? ''),
        'prodi' => trim($_POST['prodi'] ?? ''),
        'semester' => trim($_POST['semester'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
    ];
    
    if (!$id) {
        header('Location: dashboard.php');
        exit();
    }

    $errors = validate_kontak($input_data);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $input_data;
        header('Location: edit.php?id=' . $id);
        exit();
    }
    
    $kontak_list = get_kontak_data();
    
    $kontak_list[$id] = array_merge($kontak_list[$id], $input_data);
    
    save_kontak_data($kontak_list);

    header('Location: dashboard.php');
    exit();
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'] ?? null;

    if ($id) {
        $kontak_list = get_kontak_data();
        
        if (isset($kontak_list[$id])) {
            unset($kontak_list[$id]); 
            save_kontak_data($kontak_list);
        }
    }

    header('Location: dashboard.php');
    exit();
}
?>
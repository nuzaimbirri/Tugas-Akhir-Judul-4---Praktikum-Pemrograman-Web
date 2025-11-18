<?php
session_start();
require 'kontak_data.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$kontak_list = get_kontak_data();
$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_input']);
$prodi_list = [
    'TI' => 'Teknik Informatika',
    'TE' => 'Teknik Elektro'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Kontak Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-100 min-h-screen">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-8 py-4 border-b border-cyan-500/30">
            <div>
                <h2 class="text-4xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Sistem Kontak JTE</h2>
                <p class="text-slate-400 text-sm mt-1">Manajemen Data Mahasiswa JTE</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-slate-300 text-sm">Welcome</p>
                    <p class="text-cyan-400 font-semibold text-lg"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <a href="aksi.php?logout=1" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-red-500/50 transition duration-200">
                    Logout
                </a>
            </div>
        </div>
        
        <div class="bg-gradient-to-b from-slate-800 to-slate-800/50 shadow-xl rounded-2xl p-8 mb-8 border border-cyan-500/20 backdrop-blur-sm">
            <h3 class="text-2xl font-bold mb-6 text-cyan-400">Tambah Data Mahasiswa Baru</h3>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-500/10 border-l-4 border-red-500 text-red-300 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold text-red-400">Validasi Gagal:</p>
                    <ul class="list-disc ml-5 text-sm mt-2">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="aksi.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                
                <div>
                    <label for="nama" class="block text-cyan-400 font-medium mb-2 text-sm">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" 
                           value="<?php echo htmlspecialchars($old_input['nama'] ?? ''); ?>" 
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
                </div>
                
                <div>
                    <label for="npm" class="block text-cyan-400 font-medium mb-2 text-sm">NPM (Hanya Angka)</label>
                    <input type="number" id="npm" name="npm" 
                           value="<?php echo htmlspecialchars($old_input['npm'] ?? ''); ?>" 
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
                </div>

                <div>
                    <label for="prodi" class="block text-cyan-400 font-medium mb-2 text-sm">Program Studi</label>
                    <select id="prodi" name="prodi" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
                        <option value="" class="bg-slate-700">-- Pilih Prodi --</option>
                        <?php foreach ($prodi_list as $value => $label): ?>
                            <option value="<?php echo $value; ?>" class="bg-slate-700"
                                <?php echo (isset($old_input['prodi']) && $old_input['prodi'] == $value) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="telepon" class="block text-cyan-400 font-medium mb-2 text-sm">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" 
                           value="<?php echo htmlspecialchars($old_input['telepon'] ?? ''); ?>" 
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
                </div>

                <div>
                    <label for="email" class="block text-cyan-400 font-medium mb-2 text-sm">Email (Opsional)</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" 
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition">
                </div>
                
                <div>
                    <label for="semester" class="block text-cyan-400 font-medium mb-2 text-sm">Semester</label>
                    <input type="number" id="semester" name="semester" 
                           value="<?php echo htmlspecialchars($old_input['semester'] ?? ''); ?>" 
                           min="1" max="14"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition">
                </div>

                <div class="md:col-span-3 flex justify-end">
                    <input type="submit" name="tambah_kontak" value="Simpan Data Mahasiswa" 
                           class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-2 px-8 rounded-lg cursor-pointer transition duration-200 shadow-lg shadow-green-500/50">
                </div>
            </form>
        </div>
        
        <h3 class="text-2xl font-bold mb-6 text-slate-100 border-l-4 border-cyan-500 pl-4">Daftar Mahasiswa Terdaftar <span class="text-cyan-400">(<?php echo count($kontak_list); ?>)</span></h3>
        <div class="bg-gradient-to-b from-slate-800 to-slate-800/50 shadow-lg rounded-2xl overflow-x-auto border border-cyan-500/20">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-slate-700/50 border-b border-cyan-500/30">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            NPM
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            Prodi
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            Semester
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            Telepon
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-cyan-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kontak_list)): ?>
                        <?php foreach ($kontak_list as $kontak): ?>
                            <tr class="hover:bg-slate-700/50 border-b border-slate-700/50 transition duration-200">
                                <td class="px-5 py-4 bg-transparent text-sm font-medium text-slate-100">
                                    <?php echo htmlspecialchars($kontak['nama']); ?>
                                </td>
                                <td class="px-5 py-4 bg-transparent text-sm text-slate-300">
                                    <?php echo htmlspecialchars((string)($kontak['npm'] ?? '-')); ?>
                                </td>
                                <td class="px-5 py-4 bg-transparent text-sm text-slate-300">
                                    <?php 
                                    $kode_prodi = $kontak['prodi'] ?? '-';
                                    echo htmlspecialchars($prodi_list[$kode_prodi] ?? $kode_prodi); 
                                    ?>
                                </td>
                                <td class="px-5 py-4 bg-transparent text-sm text-slate-300">
                                    <?php echo htmlspecialchars((string)($kontak['semester'] ?? '-')); ?>
                                </td>
                                <td class="px-5 py-4 bg-transparent text-sm text-slate-300">
                                    <?php echo htmlspecialchars($kontak['telepon']); ?>
                                </td>
                                <td class="px-5 py-4 bg-transparent text-sm whitespace-nowrap">
                                    <a href="edit.php?id=<?php echo $kontak['id']; ?>" class="text-cyan-400 hover:text-cyan-300 font-semibold mr-4 transition duration-200">Edit</a>
                                    <a href="aksi.php?hapus=<?php echo $kontak['id']; ?>" onclick="return confirm('Yakin ingin menghapus data <?php echo htmlspecialchars($kontak['nama']); ?>?')" class="text-red-400 hover:text-red-300 font-semibold transition duration-200">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400 bg-transparent">Belum ada data mahasiswa yang terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
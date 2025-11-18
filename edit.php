<?php
session_start();
require 'kontak_data.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'] ?? null;
$kontak_list = get_kontak_data();

if (!$id || !isset($kontak_list[$id])) {
    header('Location: dashboard.php');
    exit();
}
$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_input']);
$kontak = $kontak_list[$id];
if (!empty($old_input)) {
    $kontak = array_merge($kontak, $old_input);
}
$prodi_list = [
    'TI' => 'Teknik Informatika',
    'SI' => 'Sistem Informasi',
    'TK' => 'Teknik Komputer',
    'EL' => 'Teknik Elektro'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-100 min-h-screen p-8">
    <div class="max-w-3xl mx-auto bg-gradient-to-b from-slate-800 to-slate-800/50 p-8 rounded-2xl shadow-2xl border border-cyan-500/20 backdrop-blur-sm">
        <div class="mb-8">
            <a href="dashboard.php" class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold mb-4 inline-block transition">← Kembali ke Dashboard</a>
            <h2 class="text-3xl font-bold mb-2 border-b border-cyan-500/30 pb-4">
                <span class="text-slate-300">Edit Data: </span>
                <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent"><?php echo htmlspecialchars($kontak['nama']); ?></span>
            </h2>
        </div>
        
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

        <form action="aksi.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($kontak['id']); ?>">
            
            <div>
                <label for="nama" class="block text-cyan-400 font-medium mb-2 text-sm">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($kontak['nama']); ?>" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
            </div>
            
            <div>
                <label for="npm" class="block text-cyan-400 font-medium mb-2 text-sm">NPM</label>
                <input type="number" id="npm" name="npm" value="<?php echo htmlspecialchars($kontak['npm'] ?? ''); ?>" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
            </div>

            <div>
                <label for="prodi" class="block text-cyan-400 font-medium mb-2 text-sm">Program Studi</label>
                <select id="prodi" name="prodi" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
                    <option value="" class="bg-slate-700">-- Pilih Prodi --</option>
                    <?php foreach ($prodi_list as $value => $label): ?>
                        <option value="<?php echo $value; ?>" class="bg-slate-700"
                            <?php echo (isset($kontak['prodi']) && $kontak['prodi'] == $value) ? 'selected' : ''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="semester" class="block text-cyan-400 font-medium mb-2 text-sm">Semester</label>
                <input type="number" id="semester" name="semester" value="<?php echo htmlspecialchars($kontak['semester'] ?? ''); ?>" min="1" max="14" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition">
            </div>
            
            <div>
                <label for="telepon" class="block text-cyan-400 font-medium mb-2 text-sm">Nomor Telepon</label>
                <input type="tel" id="telepon" name="telepon" value="<?php echo htmlspecialchars($kontak['telepon']); ?>" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
            </div>

            <div>
                <label for="email" class="block text-cyan-400 font-medium mb-2 text-sm">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($kontak['email'] ?? ''); ?>" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition">
            </div>

            <div class="md:col-span-2 flex justify-end space-x-4 mt-6">
                <a href="dashboard.php" class="bg-slate-700 hover:bg-slate-600 text-slate-100 font-bold py-2 px-8 rounded-lg transition duration-200 border border-slate-600">Batal</a>
                <input type="submit" name="edit_kontak" value="Simpan Perubahan" class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold py-2 px-8 rounded-lg cursor-pointer transition duration-200 shadow-lg shadow-cyan-500/50">
            </div>
        </form>
    </div>
</body>
</html>
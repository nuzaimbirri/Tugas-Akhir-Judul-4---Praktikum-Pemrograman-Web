<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kontak Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-gradient-to-b from-slate-800 to-slate-900 p-10 rounded-2xl shadow-2xl border border-cyan-500/30">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent mb-2">Sistem Kontak JTE</h2>
            <p class="text-slate-300 text-sm">Manajemen Data Mahasiswa</p>
        </div>
        <p class="text-center text-slate-400 mb-6">Silakan login untuk melanjutkan.</p>
        
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['login_error']; ?></span>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form action="aksi.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-cyan-400 text-sm font-semibold mb-2">Username</label>
                <input type="text" id="username" name="username" value="admin" class="shadow-lg appearance-none bg-slate-700 border border-slate-600 rounded-lg w-full py-3 px-4 text-slate-100 leading-tight focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-cyan-400 text-sm font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" value="123456" class="shadow-lg appearance-none bg-slate-700 border border-slate-600 rounded-lg w-full py-3 px-4 text-slate-100 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition" required>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="login" class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline w-full transition duration-200 shadow-lg shadow-cyan-500/50">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</body>
</html>
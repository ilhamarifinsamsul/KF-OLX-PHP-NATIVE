<?php
session_start();
require __DIR__ . '/config.php';

$errors = [];
$old = ['email' => ''];
$needLoginMsg = isset($_GET['need']) ? 'Silakan login untuk melanjutkan.' : '';
$redirectAfter = trim($_GET['redirect'] ?? '');
// sanitize redirect target (relative path only)
if ($redirectAfter !== '' && (preg_match('/^https?:/i', $redirectAfter) || strpos($redirectAfter, '//') === 0)) {
    $redirectAfter = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $old['email'] = $email;

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if ($password === '') {
        $errors[] = 'Password wajib diisi.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id, name, email, password, whatsapp FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Email atau password salah.';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_whatsapp'] = $user['whatsapp'] ?? null;
            $_SESSION['flash'] = 'Berhasil login';
            if ($redirectAfter !== '') {
                header('Location: ' . $redirectAfter);
            } else {
                header('Location: index.php');
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk - KF OLX</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <main>
    <section class="bg-white border-b text-center">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Masuk ke KF OLX</h1>
        <p class="text-gray-600">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>
      </div>
    </section>

    <section class="py-10">
      <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6 shadow-sm">
          <?php if ($needLoginMsg): ?>
            <div class="mb-4 rounded-md border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3 text-sm">
              <?php echo htmlspecialchars($needLoginMsg, ENT_QUOTES, 'UTF-8'); ?>
            </div>
          <?php endif; ?>
          <?php if (!empty($errors)): ?>
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
              <?php foreach ($errors as $e): ?>
                <div><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <form action="" method="post" class="space-y-4" novalidate>
            <?php if ($redirectAfter !== ''): ?>
              <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirectAfter, ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>
            <div>
              <label for="email" class="block text-sm font-medium mb-1">Email</label>
              <input type="email" id="email" name="email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="nama@email.com" required value="<?php echo htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div>
              <label for="password" class="block text-sm font-medium mb-1">Password</label>
              <div class="relative">
                <input type="password" id="password" name="password" class="w-full rounded-md border border-gray-300 pr-10 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 grid place-items-center text-gray-500 hover:text-gray-700" aria-label="Toggle password" data-toggle="password" data-target="password" aria-pressed="false">
                  <span class="pointer-events-none">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                  </span>
                </button>
              </div>
            </div>
            <div class="flex items-center justify-between">
              <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span>Ingat saya</span>
              </label>
              <a href="#" class="text-sm text-emerald-700 hover:underline">Lupa password?</a>
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Masuk</button>
          </form>

          <div class="mt-6 text-sm text-center text-gray-600">
            Belum punya akun?
            <a href="register.php" class="text-emerald-700 font-semibold hover:underline">Daftar</a>
          </div>

          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center"><div class="w-full border-t"></div></div>
              <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-2 text-gray-500">atau masuk dengan</span>
              </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
              <button class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C33.64,6.053,29.051,4,24,4C12.955,4,4,12.955,4,24 s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.371,15.108,18.839,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C33.64,6.053,29.051,4,24,4C16.318,4,9.656,8.63,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.768-1.977,13.285-5.196l-6.132-5.177C29.155,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.277-7.946l-6.49,5.002C9.551,39.798,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.103,5.623c0.001-0.001,0.002-0.001,0.003-0.002 l6.132,5.177C36.86,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                Google
              </button>
              <button class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.59l-.467 3.622h-3.123V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg>
                Facebook
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="border-t bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm">
        <div>
          <div class="font-semibold mb-3">KF olx</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Tentang kami</a></li>
            <li><a href="#" class="hover:text-emerald-700">Karir</a></li>
            <li><a href="#" class="hover:text-emerald-700">Blog</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Bantuan</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Pusat bantuan</a></li>
            <li><a href="#" class="hover:text-emerald-700">Syarat & Ketentuan</a></li>
            <li><a href="#" class="hover:text-emerald-700">Kebijakan Privasi</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Kategori</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Mobil</a></li>
            <li><a href="#" class="hover:text-emerald-700">Motor</a></li>
            <li><a href="#" class="hover:text-emerald-700">Properti</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Ikuti kami</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Instagram</a></li>
            <li><a href="#" class="hover:text-emerald-700">Facebook</a></li>
            <li><a href="#" class="hover:text-emerald-700">Twitter</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-8 text-xs text-gray-500">© <?php echo date('Y'); ?> KF olx. All rights reserved.</div>
    </div>
  </footer>

  <script>
    (function(){
      const btn = document.getElementById('mobileMenuButton');
      const menu = document.getElementById('mobileMenu');
      if (btn && menu) {
        btn.addEventListener('click', function(){
          const isHidden = menu.classList.contains('hidden');
          menu.classList.toggle('hidden');
          btn.setAttribute('aria-expanded', String(isHidden));
        });
      }
      const togglers = document.querySelectorAll('[data-toggle="password"]');
      togglers.forEach(function(t){
        t.addEventListener('click', function(){
          const targetId = t.getAttribute('data-target');
          const input = document.getElementById(targetId);
          if (!input) return;
          const isPassword = input.getAttribute('type') === 'password';
          input.setAttribute('type', isPassword ? 'text' : 'password');
          t.setAttribute('aria-pressed', String(isPassword));
        });
      });
    })();
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courty - Temukan Lapangan Olahraga Terbaik</title>
    <!-- Load Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Konfigurasi Tailwind untuk menggunakan font Inter -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #EBE1D8; /* Background Color: #EBE1D8 */
        }
        /* CSS untuk menyembunyikan scrollbar horizontal di mobile (opsional, untuk estetika) */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
    </style>
</head>
<body class="antialiased">

    <!-- Header (Navigation Bar) -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <!-- Branding/Logo -->
            <a href="<?php echo site_url('App/index'); ?>" class="text-2xl font-extrabold text-[#926699] tracking-tight">Courty.</a>
            
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="<?php echo site_url('App/index'); ?>" class="text-gray-600 hover:text-[#926699] transition duration-150">Home</a>
                <a href="<?php echo site_url('App/venue'); ?>" class="text-gray-600 hover:text-[#926699] transition duration-150">Venue</a>
                <a href="<?php echo site_url('App/about'); ?>" class="text-gray-600 hover:text-[#926699] transition duration-150">About Us</a>
                <?php if ($this->session->userdata('role') == 1): ?>
                    <!-- Tambahkan link Admin Dashboard jika role = 1 (Super Admin) -->
                    <a href="<?php echo site_url('Admin/dashboard'); ?>" class="text-sm font-semibold text-white bg-indigo-500 px-3 py-1 rounded-lg hover:bg-indigo-600 transition duration-150">Admin Panel</a>
                <?php endif; ?>
                <?php if ($this->session->userdata('role') == 3): ?>
                    <!-- Link Partner Dashboard untuk Role 3 -->
                    <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="text-sm font-semibold text-white bg-[#B9CF32] px-3 py-1 rounded-lg hover:bg-[#a6bd2e] transition duration-150">Dashboard Mitra</a>
                <?php endif; ?>
            </nav>
            
            <!-- User & Partner Actions -->
            <div class="flex items-center space-x-4">
                
                <?php if ($this->session->userdata('logged_in')): ?>
                    <!-- Jika sudah login -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600 hidden sm:block">Halo, <?php echo $this->session->userdata('name'); ?>!</span>
                        <a href="<?php echo site_url('Auth/logout'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600 transition duration-150">Logout</a>
                    </div>
                <?php else: ?>
                    <!-- Jika belum login -->
                    <!-- LINK DAFTAR MITRA BARU -->
                    <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition duration-150 hidden sm:block">Daftar Mitra</a>
                    <a href="<?php echo site_url('Auth/login'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-[#926699] rounded-lg shadow-md hover:bg-[#7d5583] transition duration-150">Login / Register</a>
                <?php endif; ?>
                
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="md:hidden text-gray-600 hover:text-[#926699] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-4 space-y-1 bg-white border-t">
            <a href="<?php echo site_url('App/index'); ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Home</a>
            <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Venue</a>
            <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">About Us</a>
            <?php if ($this->session->userdata('logged_in')): ?>
                <?php if ($this->session->userdata('role') == 1): ?>
                    <a href="<?php echo site_url('Admin/dashboard'); ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-indigo-500 hover:bg-indigo-50">Admin Panel</a>
                <?php endif; ?>
                <a href="<?php echo site_url('Auth/logout'); ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-red-500 hover:bg-red-50">Logout</a>
            <?php else: ?>
                <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Daftar Mitra</a>
                <a href="<?php echo site_url('Auth/login'); ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-[#926699] hover:bg-gray-50">Login / Register</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <?php
    // Menampilkan pesan Flash Data di area konten utama (sebelum dimuatnya view spesifik)
    if ($this->session->flashdata('error_access')) {
        echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error_access') . '</div>';
    }
    
    if (isset($content)) {
        // Memuat view yang namanya disimpan di dalam variabel $content
        $this->load->view($content);
    } else {
        echo '<p class="text-gray-500 text-center">Konten tidak ditemukan atau belum didefinisikan.</p>';
    }
    ?>
    </main> 

    <!-- Footer -->
    <footer class="bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Brand Info -->
                <div>
                    <h5 class="text-xl font-bold mb-4">Courty.</h5>
                    <p class="text-sm text-gray-400">Pilihan terpercaya untuk reservasi lapangan olahraga Anda.</p>
                </div>
                <!-- Links 1 -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#B9CF32]">Cari Lapangan</a></li>
                        <li><a href="#" class="hover:text-[#B9CF32]">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-[#B9CF32]">Bantuan</a></li>
                    </ul>
                </div>
                <!-- Links 2 -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#B9CF32]">About Us</a></li>
                        <li><a href="#" class="hover:text-[#B9CF32]">Karir</a></li>
                        <li><a href="#" class="hover:text-[#B9CF32]">Hubungi Kami</a></li>
                    </ul>
                </div>
                <!-- Partner -->
                <div>
                    <h5 class="text-lg font-semibold mb-4">Untuk Mitra</h5>
                    <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="text-sm text-gray-400 hover:text-[#B9CF32]">Daftar Mitra</a>
                    <p class="mt-2 text-xs text-gray-500">Ingin bergabung? <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="text-[#B9CF32] hover:underline">Daftar Sekarang</a></p>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                &copy; 2025 Courty. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // JavaScript untuk Toggle Menu Mobile
        document.getElementById('menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // JavaScript untuk simulasi Geolocation (Kunci fitur Haversine)
        function getGeolocation() {
            const statusElement = document.getElementById('geo-status');
            const locationInput = document.getElementById('search_query');
            statusElement.textContent = 'Mencari lokasi Anda...';
            
            // Simulasi API Geolocation Browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        // Mengisi input utama dengan koordinat yang ditemukan
                        locationInput.value = `(${lat.toFixed(4)}, ${lon.toFixed(4)}) - Lokasi Terdeteksi`;
                        statusElement.textContent = 'Lokasi GPS Anda berhasil ditemukan.';
                        // Di sini data lat/lon akan dikirim ke backend CodeIgniter
                    },
                    function(error) {
                        statusElement.textContent = 'Gagal menemukan lokasi GPS. Silakan masukkan secara manual.';
                        console.error("Geolocation Error:", error.message);
                    }
                );
            } else {
                statusElement.textContent = 'Browser Anda tidak mendukung Geolocation.';
            }
        }
    </script>
</body>
</html>
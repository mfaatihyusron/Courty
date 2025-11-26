<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courty - Temukan Lapangan Olahraga Terbaik</title>
    <!-- Load Tailwind CSS via CDN --><script src="https://cdn.tailwindcss.com"></script>
    <!-- Konfigurasi Tailwind untuk menggunakan font Inter --><style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFFFFF; /* DIUBAH: Background utama body menjadi putih, agar Hero bisa full-width */
        }
        /* CSS untuk menyembunyikan scrollbar horizontal di mobile (opsional, untuk estetika) */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        /* Definisikan warna kustom Tailwind */
        .bg-main { background-color: #926699; }
        .text-main { color: #926699; }
        .bg-action { background-color: #347048; } /* Hijau gelap untuk tombol */
        .text-action { color: #347048; }
        .bg-soft { background-color: #EBE1D8; } /* Warna krem lembut */
    </style>
    <!-- Memastikan ikon Font Awesome dimuat untuk visualisasi --><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="antialiased">

    <!-- Header (Navigation Bar) - Menggunakan skema warna baru: Background Putih, Aksi #926699 --><header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <!-- Branding/Logo --><a href="<?php echo site_url('App/index'); ?>" class="text-2xl font-extrabold text-main tracking-tight">Courty.</a>
            
            <!-- Desktop Menu --><nav class="hidden md:flex space-x-8 items-center">
                <a href="<?php echo site_url('App/index'); ?>" class="text-gray-600 hover:text-main font-medium transition duration-150">Home</a>
                <a href="<?php echo site_url('App/venue'); ?>" class="text-gray-600 hover:text-main font-medium transition duration-150">Venue</a>
                
                <!-- MENU BARU: PESANAN SAYA (Hanya muncul jika login) -->
                <?php if ($this->session->userdata('logged_in')): ?>
                    <a href="<?php echo site_url('Booking/my_orders'); ?>" class="text-gray-600 hover:text-main font-medium transition duration-150">Pesanan Saya</a>
                <?php endif; ?>

                <a href="<?php echo site_url('App/about'); ?>" class="text-gray-600 hover:text-main font-medium transition duration-150">About Us</a>
                
                <?php if ($this->session->userdata('role') == 3): ?>
                    <!-- Link Partner Dashboard untuk Role 3 --><a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="text-sm font-semibold text-white bg-action px-3 py-1 rounded-full hover:bg-[#2e5d3c] transition duration-150">Dashboard Mitra</a>
                <?php endif; ?>
                
                <?php if ($this->session->userdata('role') == 3): ?>
                    <!-- Link Lihat Pesanan Masuk (Mitra) --><a href="<?php echo site_url('Mitra/orders'); ?>" class="text-sm font-semibold text-action border border-action px-3 py-1 rounded-full hover:bg-green-50 transition duration-150">Order Masuk</a>
                <?php endif; ?>
            </nav>
            
            <!-- User & Partner Actions --><div class="flex items-center space-x-4">
                
                <?php if ($this->session->userdata('logged_in')): ?>
                    <!-- Jika sudah login --><div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600 hidden sm:block">Halo, <?php echo $this->session->userdata('name'); ?>!</span>
                        <a href="<?php echo site_url('Auth/logout'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-full shadow-md hover:bg-red-600 transition duration-150">Logout</a>
                    </div>
                <?php else: ?>
                    <!-- Jika belum login --><a href="<?php echo site_url('Auth/login'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-main rounded-full shadow-md hover:bg-[#7d5583] transition duration-150 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login / Register
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Menu Button --><button id="menu-button" class="md:hidden text-gray-600 hover:text-main focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Dropdown --><div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-4 space-y-1 bg-white border-t">
            <a href="<?php echo site_url('App/index'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Home</a>
            <a href="<?php echo site_url('App/venue'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Venue</a>
            
            <!-- MENU MOBILE BARU: PESANAN SAYA -->
            <?php if ($this->session->userdata('logged_in')): ?>
                <a href="<?php echo site_url('Booking/my_orders'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Pesanan Saya</a>
            <?php endif; ?>

            <a href="<?php echo site_url('App/about'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">About Us</a>
            
            <?php if ($this->session->userdata('role') == 3): ?>
                <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-action hover:bg-[#2e5d3c]">Dashboard Mitra</a>
                <a href="<?php echo site_url('Mitra/orders'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-action border border-action mt-2">Order Masuk</a>
            <?php endif; ?>
            
            <?php if (!$this->session->userdata('logged_in')): ?>
                <a href="<?php echo site_url('Auth/login'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-main hover:bg-[#7d5583]">Login / Register</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Content Wrapper - Disusun ulang agar hero bisa full-width --><div class="min-h-screen">
    <?php
    // Menampilkan pesan Flash Data di area konten utama
    if ($this->session->flashdata('error_access')) {
        echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error_access') . '</div>';
    }
    
    if (isset($content)) {
        // Memuat view yang namanya disimpan di dalam variabel $content
        $this->load->view($content);
    } else {
        echo '<p class="text-gray-500 text-center mt-10">Konten tidak ditemukan atau belum didefinisikan.</p>';
    }
    ?>
    </div> 

    <!-- Footer - Menggunakan warna gelap (#926699) --><footer class="bg-main py-12 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Brand Info --><div>
                    <h5 class="text-xl font-bold mb-4">Courty.</h5>
                    <p class="text-sm text-soft">Pilihan terpercaya untuk reservasi lapangan olahraga Anda.</p>
                </div>
                <!-- Links 1 --><div>
                    <h5 class="text-lg font-semibold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm text-soft">
                        <li><a href="#" class="hover:text-action">Cari Lapangan</a></li>
                        <li><a href="#" class="hover:text-action">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-action">Bantuan</a></li>
                    </ul>
                </div>
                <!-- Links 2 --><div>
                    <h5 class="text-lg font-semibold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-sm text-soft">
                        <li><a href="#" class="hover:text-action">About Us</a></li>
                        <li><a href="#" class="hover:text-action">Karir</a></li>
                        <li><a href="#" class="hover:text-action">Hubungi Kami</a></li>
                    </ul>
                </div>
                <!-- Partner --><div>
                    <h5 class="text-lg font-semibold mb-4">Untuk Mitra</h5>
                    <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="text-sm text-soft hover:text-action">Daftar Mitra</a>
                    <p class="mt-2 text-xs text-white/70">Ingin bergabung? <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="text-action font-bold hover:underline">Daftar Sekarang</a></p>
                </div>
            </div>
            <div class="mt-12 border-t border-[#7d5583] pt-8 text-center text-sm text-soft/60">
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
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
            background-color: #FFFFFF;
        }
        /* CSS untuk menyembunyikan scrollbar horizontal di mobile */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Definisikan warna kustom Tailwind */
        .bg-main { background-color: #926699; }
        .text-main { color: #926699; }
        .bg-action { background-color: #347048; }
        .text-action { color: #347048; }
        .bg-soft { background-color: #EBE1D8; }
        
        /* Gaya untuk indikator halaman aktif */
        .nav-link-active {
            font-weight: 700;
            position: relative;
        }
        /* Warna dot indikator menyesuaikan parent color nanti via JS/PHP helper class, 
           tapi default-nya kita set main color untuk general */
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px; 
            border-radius: 50%;
            background-color: #926699;
            box-shadow: 0 0 5px #926699;
        }

        /* Override warna dot saat di mode transparan (background gelap) */
        .navbar-transparent .nav-link-active {
            color: white !important;
        }
        .navbar-transparent .nav-link-active::after {
            background-color: #926699; /* Tetap ungu atau putih sesuai selera */
            box-shadow: 0 0 5px white;
        }

        /* Style untuk navbar saat sticky/scrolled/solid */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .navbar-scrolled .nav-link {
            color: #4b5563 !important; /* Text Gray-600 */
        }
        .navbar-scrolled .nav-link-active {
            color: #926699 !important;
        }
        .navbar-scrolled .logo-text {
            color: #926699 !important;
        }
        .navbar-scrolled .menu-btn-icon {
            color: #4b5563 !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="antialiased">

    <?php 
    // === LOGIKA NAVBAR DINAMIS ===
    $class = $this->router->fetch_class();
    $method = $this->router->fetch_method();
    $current_route = strtolower($class . '/' . $method);

    // Daftar halaman yang memiliki navbar transparan (yang ada di menu)
    // Sesuaikan dengan link yang ada di navigasi
    $transparent_pages = [
        'app/index',
        'app/venue',
        'app/about',
        'booking/my_orders',
        'mitra/partner_dashboard',
        'mitra/orders',
        'admin/dashboard' // Tambahkan dashboard admin agar transparan juga (opsional)
    ];

    $is_transparent = in_array($current_route, $transparent_pages);

    // Tentukan kelas CSS awal berdasarkan halaman
    if ($is_transparent) {
        // Mode Transparan (Absolute)
        $header_class = 'absolute top-0 left-0 right-0 z-50 transition duration-300 navbar-transparent';
        $text_class = 'text-white';
        $logo_class = 'text-white';
        $content_padding = ''; // Tidak ada padding karena hero image naik ke atas
    } else {
        // Mode Solid (Fixed/Scrolled Style dari awal)
        $header_class = 'fixed top-0 left-0 right-0 z-50 transition duration-300 navbar-scrolled shadow-lg';
        $text_class = 'text-gray-600';
        $logo_class = 'text-main'; // Warna ungu
        $content_padding = 'pt-20'; // Tambah padding agar konten tidak ketutup navbar
    }
    ?>

    <!-- Header -->
    <header id="main-header" class="<?= $header_class ?>">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <!-- Branding/Logo -->
            <a href="<?php echo site_url('App/index'); ?>" class="text-2xl font-extrabold <?= $logo_class ?> tracking-tight logo-text transition duration-300">Courty.</a>
            
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8 items-center">
                <?php
                $nav_items = [
                    'Home' => 'index',
                    'Venue' => 'venue',
                    'About Us' => 'about',
                ];
                
                foreach ($nav_items as $name => $m):
                    $is_active = ($method == $m && $class == 'App'); // Sederhana cek active
                    $active_class = $is_active ? 'nav-link-active' : 'nav-link';
                    // Gunakan $text_class dinamis
                ?>
                    <a href="<?php echo site_url('App/' . $m); ?>" 
                       class="<?= $text_class ?> hover:text-main font-medium transition duration-150 <?= $active_class ?>">
                        <?php echo $name; ?>
                    </a>
                <?php endforeach; ?>
                
                <?php if ($this->session->userdata('logged_in')): ?>
                    <a href="<?php echo site_url('Booking/my_orders'); ?>" class="nav-link <?= $text_class ?> hover:text-main font-medium transition duration-150 <?= ($current_route == 'booking/my_orders') ? 'nav-link-active' : '' ?>">Pesanan Saya</a>
                <?php endif; ?>

                <!-- MENU ROLE 3: MITRA -->
                <?php if ($this->session->userdata('role') == 3): ?>
                    <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="text-sm font-semibold text-white bg-action px-3 py-1 rounded-full hover:bg-[#2e5d3c] transition duration-150">Dashboard Mitra</a>
                    <a href="<?php echo site_url('Mitra/orders'); ?>" class="text-sm font-semibold text-action border border-white px-3 py-1 rounded-full bg-white hover:bg-gray-100 transition duration-150">Order Masuk</a>
                <?php endif; ?>

                <!-- MENU ROLE 1: ADMIN (BARU) -->
                <?php if ($this->session->userdata('role') == 1): ?>
                    <a href="<?php echo site_url('Admin/dashboard'); ?>" class="text-sm font-semibold text-white bg-indigo-600 px-3 py-1 rounded-full hover:bg-indigo-700 transition duration-150 shadow-sm">Dashboard Admin</a>
                <?php endif; ?>
            </nav>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <div class="flex items-center space-x-4">
                        <span class="nav-link <?= $text_class ?> hover:text-main font-medium transition duration-150 hidden sm:block">Halo, <?php echo $this->session->userdata('name'); ?>!</span>
                        <a href="<?php echo site_url('Auth/logout'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-full shadow-md hover:bg-red-600 transition duration-150">Logout</a>
                    </div>
                <?php else: ?>
                    <!-- Link Daftar Mitra (Jika Belum Login) -->
                    <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="hidden md:block text-sm font-semibold <?= $text_class ?> hover:text-main transition duration-150 nav-link">Daftar Mitra</a>
                    <a href="<?php echo site_url('Auth/login'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-main rounded-full shadow-md hover:bg-[#7d5583] transition duration-150 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login / Register
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="<?= $text_class ?> hover:text-main focus:outline-none transition duration-300 menu-btn-icon md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-4 space-y-1 bg-white border-t shadow-lg">
            <a href="<?php echo site_url('App/index'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Home</a>
            <a href="<?php echo site_url('App/venue'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Venue</a>
            <?php if ($this->session->userdata('logged_in')): ?>
                <a href="<?php echo site_url('Booking/my_orders'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Pesanan Saya</a>
            <?php endif; ?>
            <a href="<?php echo site_url('App/about'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">About Us</a>
            <?php if (!$this->session->userdata('logged_in')): ?>
                <a href="<?php echo site_url('Mitra/partner_register_step1'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-main hover:bg-gray-50">Daftar Mitra</a>
            <?php endif; ?>
            
            <!-- Mobile Menu Mitra -->
            <?php if ($this->session->userdata('role') == 3): ?>
                <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-action hover:bg-[#2e5d3c]">Dashboard Mitra</a>
                <a href="<?php echo site_url('Mitra/orders'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-action border border-action mt-2">Order Masuk</a>
            <?php endif; ?>

            <!-- Mobile Menu Admin (BARU) -->
            <?php if ($this->session->userdata('role') == 1): ?>
                <a href="<?php echo site_url('Admin/dashboard'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 mt-2">Dashboard Admin</a>
            <?php endif; ?>

            <?php if (!$this->session->userdata('logged_in')): ?>
                <a href="<?php echo site_url('Auth/login'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-main hover:bg-[#7d5583]">Login / Register</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Content Wrapper -->
    <!-- Tambahkan padding-top jika navbar mode solid agar konten tidak ketutup -->
    <div class="min-h-screen <?= $content_padding ?>">
    <?php
    if ($this->session->flashdata('error_access')) {
        echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error_access') . '</div>';
    }
    
    if (isset($content)) {
        $this->load->view($content);
    } else {
        echo '<p class="text-gray-500 text-center mt-10">Konten tidak ditemukan.</p>';
    }
    ?>
    </div> 

    <!-- Footer -->
    <footer class="bg-main py-12 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">Courty.</h5>
                    <p class="text-sm text-soft">Pilihan terpercaya untuk reservasi lapangan olahraga Anda.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm text-soft">
                        <li><a href="#" class="hover:text-action">Cari Lapangan</a></li>
                        <li><a href="#" class="hover:text-action">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-action">Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-sm text-soft">
                        <li><a href="#" class="hover:text-action">About Us</a></li>
                        <li><a href="#" class="hover:text-action">Karir</a></li>
                        <li><a href="#" class="hover:text-action">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
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
        // Pass variabel PHP ke JS untuk logika scroll
        const isTransparentPage = <?php echo $is_transparent ? 'true' : 'false'; ?>;

        document.getElementById('menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Hanya jalankan efek scroll jika di halaman transparan
        if (isTransparentPage) {
            window.addEventListener('scroll', function() {
                const header = document.getElementById('main-header');
                const links = header.querySelectorAll('.nav-link');
                const logo = header.querySelector('.logo-text');
                const menuButton = header.querySelector('.menu-btn-icon');
                const activeLink = header.querySelector('.nav-link-active');
                
                if (window.scrollY > 50) {
                    // Saat discroll ke bawah -> Ubah jadi Putih
                    header.classList.add('fixed', 'navbar-scrolled', 'shadow-lg');
                    header.classList.remove('absolute', 'navbar-transparent');
                    
                    logo.classList.remove('text-white');
                    // logo.classList.add('text-main'); // Handled by CSS .navbar-scrolled .logo-text

                    menuButton.classList.remove('text-white');
                    // menuButton.classList.add('text-gray-600');

                    links.forEach(link => {
                        link.classList.remove('text-white');
                        // link.classList.add('text-gray-600');
                    });
                    
                    if (activeLink) {
                        activeLink.classList.remove('text-white');
                    }
                } else {
                    // Kembali ke atas -> Transparan lagi
                    header.classList.remove('fixed', 'navbar-scrolled', 'shadow-lg');
                    header.classList.add('absolute', 'navbar-transparent');
                    
                    logo.classList.add('text-white');
                    menuButton.classList.add('text-white');
                    
                    links.forEach(link => {
                        link.classList.add('text-white');
                    });

                    if (activeLink) {
                        activeLink.classList.add('text-white');
                    }
                }
            });
        }

        function getGeolocation() {
            const locationInput = document.getElementById('search_query');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        if(locationInput) locationInput.value = `(${lat.toFixed(4)}, ${lon.toFixed(4)}) - Lokasi Terdeteksi`;
                    },
                    function(error) {
                        console.error("Geolocation Error:", error.message);
                    }
                );
            }
        }
    </script>
</body>
</html>
<!-- BANNER SECTION -->
<section class="relative h-72 overflow-hidden shadow-md mb-10">
    <!-- Background Image (Lapangan Outdoor/Sport Center) -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://tangerangkota.go.id/assets/storage/files/photos/37535gairah-olahraga-meningkat-sederet-gor-di-kota-tangerang-full-booked-hingga-akhir-tahun-37535.jpeg');">
        <div class="absolute inset-0 bg-purple-900/70"></div> <!-- Overlay Ungu Gelap -->
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center text-center pt-16">
        <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight mb-4">
            Jelajahi <span class="text-[#B9CF32]">Venue</span>
        </h1>
        <p class="text-lg sm:text-xl text-purple-100 max-w-2xl mx-auto font-light">
            Temukan lapangan olahraga terbaik, bandingkan harga, dan booking jadwal Anda sekarang.
        </p>
    </div>
</section>

<main class="min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Unified Search Bar - Lebih Kompak dari Homepage -->
        <div class="max-w-4xl mx-auto bg-white p-3 rounded-2xl shadow-lg border border-gray-100 mb-16 -mt-8 relative z-10">
            <!-- PERUBAHAN KRITIS: Mengubah action form ke App/venue dengan GET method (akan dialihkan di Controller) -->
            <form action="<?= site_url('App/venue') ?>" method="GET" class="flex items-center space-x-2">
                <!-- Search Input (Venue/Sport/Location) -->
                <div class="relative flex-grow">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    
                    <input type="text" id="search_venue_name" name="search_venue_name" placeholder="Cari nama venue, olahraga, atau lokasi..." class="w-full pl-10 pr-4 py-3 text-base border-none rounded-xl focus:ring-1 focus:ring-main transition duration-150 focus:outline-none bg-gray-50">
                </div>
                
                <!-- Search Button -->
                <button type="submit" class="px-6 py-3 bg-cta text-white font-bold text-base rounded-xl shadow-md hover:bg-cta-dark transition duration-150 flex-shrink-0">
                    Cari
                </button>
            </form>
        </div>

        <!-- Kategori Olahraga -->
        <div class="mt-8 mb-16 py-4">
            <div class="flex space-x-6 overflow-x-auto pb-2 scrollbar-hide justify-center">
                
                <a href="<?= site_url('App/view_sport_category/futsal/sepakbola') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">⚽</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Futsal/Sepakbola</span>
                </a>

                <a href="<?= site_url('App/view_sport_category/badminton') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">🏸</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Badminton</span>
                </a>
                
                <a href="<?= site_url('App/view_sport_category/basket') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">🏀</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Basket</span>
                </a>
                
                <a href="<?= site_url('App/view_sport_category/voli') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">🏐</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Voli</span>
                </a>
                
                <a href="<?= site_url('App/view_sport_category/tenis') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">🎾</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Tenis</span>
                </a>

                <a href="<?= site_url('App/view_sport_category/renang') ?>" class="flex-shrink-0 flex flex-col items-center justify-start w-32 group">
                    <div class="flex items-center justify-center p-5 h-28 w-28 bg-white rounded-full shadow-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl border border-gray-50 group-hover:border-[#926699]">
                        <span class="text-4xl">🏊</span>
                    </div>
                    <span class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Renang</span>
                </a>
            </div>
        </div>

        <!-- REKOMENDASI SECTION 1: TRENDING -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-[#926699] pl-3">🔥 Trending Saat Ini</h2>
            <p class="text-gray-600 mb-6 pl-4">Venue yang paling banyak dipesan minggu ini.</p>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide px-2">
                
                <?php if (isset($trending_venues) && is_array($trending_venues) && count($trending_venues) > 0): ?>
                <?php foreach ($trending_venues as $venue): ?>
                
                <!-- Venue Card REAL DATA -->
                <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                   class="flex-shrink-0 w-72 bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 group border border-gray-100">
                    <!-- Gambar -->
                    <div class="relative">
                        <img src="<?= base_url($venue['link_profile_img']) ?>" 
                             alt="Venue <?= html_escape($venue['venue_name']) ?>" 
                             class="w-full h-40 object-cover group-hover:opacity-90 transition duration-300"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/347048/FFFFFF?text=<?= urlencode($venue['venue_name']) ?>';">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold text-[#926699] shadow-sm">
                            Trending
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 truncate" title="<?= html_escape($venue['venue_name']) ?>">
                            <?= html_escape($venue['venue_name']) ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 truncate flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <?= html_escape($venue['address']) ?>
                        </p>
                        
                        <div class="mt-3 flex justify-between items-end border-t border-gray-100 pt-3">
                            <div>
                                <p class="text-xs text-gray-500">Mulai dari</p>
                                <p class="font-bold text-[#B9CF32] text-lg">Rp <?= number_format($venue['min_price'], 0, ',', '.') ?></p>
                            </div>
                            <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                <?= $venue['court_count'] ?> Lapangan
                            </span>
                        </div>
                    </div>
                </a>

                <?php endforeach; ?>
                <?php else: ?>
                <div class="w-full text-center p-8 bg-gray-50 rounded-xl">
                    <p class="text-gray-500">Belum ada data trending venue.</p>
                </div>
                <?php endif; ?>
                
            </div>
        </section>
        
        <!-- REKOMENDASI SECTION 3: JARAK TERDEKAT (Menggunakan Data Asli) -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-blue-500 pl-3">📍 Terdekat dari Anda</h2>
            <p class="text-gray-600 mb-6 pl-4">Venue yang paling mudah dijangkau saat ini (Simulasi Data).</p>
            
            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide px-2">
                <!-- Menggunakan loop yang sama untuk menampilkan 'Real Data' di section ini -->
                <?php if (isset($trending_venues) && is_array($trending_venues)): ?>
                <?php foreach (array_reverse($trending_venues) as $venue): // Menggunakan array_reverse agar urutannya beda sedikit ?>
                    
                    <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                       class="flex-shrink-0 w-72 bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 group border border-gray-100">
                        <img src="<?= base_url($venue['link_profile_img']) ?>" 
                             alt="<?= html_escape($venue['venue_name']) ?>" 
                             class="w-full h-40 object-cover group-hover:opacity-90 transition duration-300"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/2196F3/FFFFFF?text=Venue';">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?= html_escape($venue['venue_name']) ?></h3>
                            <p class="text-sm text-blue-600 font-semibold mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                1.<?= rand(2, 9) ?> km
                            </p>
                            <div class="text-xs text-gray-500 mt-1 truncate"><?= html_escape($venue['address']) ?></div>
                        </div>
                    </a>

                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- REKOMENDASI SECTION 4: RATING TERTINGGI (Menggunakan Data Asli) -->
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-yellow-400 pl-3">🌟 Rating Tertinggi</h2>
            <p class="text-gray-600 mb-6 pl-4">Venue dengan ulasan terbaik dari seluruh pengguna Courty.</p>
            
            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide px-2">
                <!-- Menggunakan loop yang sama untuk menampilkan 'Real Data' di section ini -->
                <?php if (isset($trending_venues) && is_array($trending_venues)): ?>
                <?php foreach ($trending_venues as $venue): ?>
                    
                    <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                       class="flex-shrink-0 w-72 bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 group border border-gray-100">
                        <img src="<?= base_url($venue['link_profile_img']) ?>" 
                             alt="<?= html_escape($venue['venue_name']) ?>" 
                             class="w-full h-40 object-cover group-hover:opacity-90 transition duration-300"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/FFC107/FFFFFF?text=Top+Rated';">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?= html_escape($venue['venue_name']) ?></h3>
                            <div class="flex items-center mt-2">
                                <span class="text-yellow-400 flex">
                                    &#9733;&#9733;&#9733;&#9733;&#9733;
                                </span>
                                <span class="text-sm text-gray-600 ml-2 font-bold">5.0</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Fasilitas lengkap & bersih.</p>
                        </div>
                    </a>

                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
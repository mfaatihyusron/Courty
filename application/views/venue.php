<main class="min-h-screen pt-10 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Title & Unified Search Bar -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900">Jelajahi Lapangan Olahraga</h1>
                <p class="mt-2 text-lg text-gray-500">Temukan, lihat detail, dan reservasi tempat terbaik.</p>
            </div>

            <!-- Unified Search Bar - Lebih Kompak dari Homepage -->
            <div class="max-w-4xl mx-auto bg-white p-3 rounded-2xl shadow-lg border border-gray-100 mb-16">
                <form class="flex items-center space-x-2">
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

            <!-- Category Bar Section -->
                <div class="mt-8 mb-12 py-4">
                    <!-- Wrapper untuk horizontal scrolling di mobile dan centering di desktop -->
                    <div class="flex space-x-6 overflow-x-auto pb-2 scrollbar-hide justify-center">
                        
                        <!-- Category Item 1: Futsal/Sepakbola -->
                        <a href="<?= site_url('App/view_sport_category/futsal/sepakbola') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">⚽</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Futsal/Sepakbola</span>
                        </a>
                        
                        <!-- Category Item 2: Badminton -->
                        <a href="<?= site_url('App/view_sport_category/badminton') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏸</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Badminton</span>
                        </a>
                        
                        <!-- Category Item 3: Basket -->
                        <a href="<?= site_url('App/view_sport_category/basket') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏀</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Basket</span>
                        </a>
                        
                        <!-- Category Item 4: Voli -->
                        <a href="<?= site_url('App/view_sport_category/voli') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏐</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Voli</span>
                        </a>
                        
                        <!-- Category Item 5: Tenis -->
                        <a href="<?= site_url('App/view_sport_category/tenis') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🎾</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Tenis</span>
                        </a>

                         <!-- Category Item 6: Renang -->
                        <a href="<?= site_url('App/view_sport_category/renang') ?>" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏊</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Renang</span>
                        </a>
                    </div>
                </div>

            <!-- REKOMENDASI SECTION 1: TRENDING (Sesuai Referensi) -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">🔥 Trending Saat Ini</h2>
                <p class="text-gray-600 mb-6">Venue yang paling banyak dipesan minggu ini.</p>
                
                <!-- Horizontal Scroll Container -->
                <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                    
                    <!-- MEMULAI LOOPING DATA DARI CONTROLLER -->
                    <?php if (isset($trending_venues) && is_array($trending_venues) && count($trending_venues) > 0): ?>
                    <?php foreach ($trending_venues as $venue): 
                        // Perhatikan bahwa data dari Model.php adalah array, bukan object, jadi aksesnya $venue['key']
                    ?>
                    
                    <!-- Venue Card DINAMIS -->
                    <!-- PENAMBAHAN KELAS HOVERING di sini -->
                    <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                       class="flex-shrink-0 w-72 bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-t-main 
                              cursor-pointer transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 group">
                        <!-- Menggunakan link_profile_img dari DB. Jika kosong, gunakan placeholder. -->
                        <img src="<?= base_url($venue['link_profile_img']) ?>" 
                             alt="Venue <?= $venue['venue_name'] ?>" 
                             class="w-full h-40 object-cover group-hover:opacity-90 transition duration-300"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/347048/FFFFFF?text=<?= urlencode($venue['venue_name']) ?>';">
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate" title="<?= $venue['venue_name'] ?>">
                                <?= $venue['venue_name'] ?>
                            </h3>
                            <!-- Menampilkan Olahraga yang Ditawarkan dan Harga Termurah -->
                            <p class="text-sm text-gray-500 mt-1 truncate">
                                Olahraga: <span class="font-medium text-gray-700"><?= $venue['sports_offered'] ?: 'N/A' ?></span>
                            </p>
                            <p class="text-sm text-gray-500 mt-1 truncate">
                                Mulai dari: <span class="font-bold text-main">Rp <?= number_format($venue['min_price'], 0, ',', '.') ?></span>
                            </p>
                            <!-- Rating/Lokasi bisa ditambahkan nanti, sementara kita gunakan data yang ada -->
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-600">Total Lapangan: <?= $venue['court_count'] ?></span>
                            </div>
                        </div>
                    </a>

                    <?php endforeach; ?>
                    
                    <?php else: ?>
                    <!-- Pesan jika tidak ada data -->
                    <div class="w-full text-center p-8 bg-gray-50 rounded-xl">
                        <p class="text-gray-500">Mohon maaf, data trending venue belum tersedia.</p>
                    </div>
                    <?php endif; ?>
                    <!-- AKHIR DARI LOOPING DATA -->

                    <!-- Hapus atau ubah cards dummy statis di bawah ini -->
                    <!-- Venue Card (Template) -->
                    <!-- Card dummy 1, 2, 3, 4, 5, 6, 7, 8 sudah dihapus dan diganti dengan looping di atas -->
                </div>
            </section>

            <!-- REKOMENDASI SECTION 2: DIGUNAKAN SEBELUMNYA (USER HISTORY) -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">🔄 Venue yang Pernah Anda Pesan</h2>
                <p class="text-gray-600 mb-6">Pesan ulang dengan cepat venue favorit Anda.</p>
                
                <!-- Horizontal Scroll Container -->
                <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                    
                    <!-- Venue Card (Template) -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/FFC107/FFFFFF?text=Venue+Langganan" alt="Venue Langganan 1" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">Champion Futsal A</h3>
                            <p class="text-sm text-gray-500 mt-1 truncate">Terakhir dipesan: 2 Hari Lalu</p>
                            <button class="mt-2 w-full py-2 text-sm text-white bg-cta rounded-lg hover:bg-cta-dark transition duration-150">Pesan Ulang Cepat</button>
                        </div>
                    </div>
                    
                    <!-- Venue Card 2 -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/00BCD4/FFFFFF?text=Venue+Langganan+2" alt="Venue Langganan 2" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">Kolam Renang Tirta</h3>
                            <p class="text-sm text-gray-500 mt-1 truncate">Terakhir dipesan: 1 Bulan Lalu</p>
                            <button class="mt-2 w-full py-2 text-sm text-white bg-cta rounded-lg hover:bg-cta-dark transition duration-150">Pesan Ulang Cepat</button>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- REKOMENDASI SECTION 3: JARAK TERDEKAT (HAERSINE LOGIC) -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">📍 Terdekat dari Anda</h2>
                <p class="text-gray-600 mb-6">Venue yang paling mudah dijangkau saat ini (menggunakan data Geolocation).</p>
                
                <!-- Horizontal Scroll Container -->
                <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                    
                    <!-- Venue Card (Template) -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/E91E63/FFFFFF?text=Venue+Terdekat" alt="Venue Terdekat 1" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">Badminton XYZ</h3>
                            <p class="text-sm text-gray-500 mt-1 text-main font-semibold">Jarak: 1.2 km</p>
                            <div class="text-xs text-gray-500">Jl. Mawar No. 1, Bogor</div>
                        </div>
                    </div>
                    
                    <!-- Venue Card 2 -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/F06292/FFFFFF?text=Venue+Terdekat+2" alt="Venue Terdekat 2" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">GOR Futsal B</h3>
                            <p class="text-sm text-gray-500 mt-1 text-main font-semibold">Jarak: 2.5 km</p>
                            <div class="text-xs text-gray-500">Jl. Kebon Jeruk, Jakarta Barat</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- REKOMENDASI SECTION 4: RATING TERTINGGI (DATA ANALYSIS/BI) -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">🌟 Rating Tertinggi</h2>
                <p class="text-gray-600 mb-6">Venue dengan ulasan terbaik dari seluruh pengguna Courty.</p>
                
                <!-- Horizontal Scroll Container -->
                <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                    
                    <!-- Venue Card (Template) -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/26A69A/FFFFFF?text=Venue+5+Star" alt="Venue 5 Star 1" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">Tennis Court Premier</h3>
                            <div class="flex items-center mt-2">
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="text-sm text-gray-600 ml-2">5.0</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Layanan bintang lima.</p>
                        </div>
                    </div>
                    
                    <!-- Venue Card 2 -->
                    <div class="flex-shrink-0 w-72 bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                        <img src="https://placehold.co/400x250/8D6E63/FFFFFF?text=Venue+4+5+Star" alt="Venue 4.5 Star 2" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">GOR Serbaguna Sentosa</h3>
                            <div class="flex items-center mt-2">
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star">&#9733;</span>
                                <span class="rating-star text-gray-300">&#9733;</span>
                                <span class="text-sm text-gray-600 ml-2">4.8</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Fasilitas terbaik di kelasnya.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
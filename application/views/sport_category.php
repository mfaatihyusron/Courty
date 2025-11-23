<main class="min-h-screen pt-10 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Title & Tagline Dinamis -->
            <div class="text-center mb-12">
                <!-- Data Binding: Menggunakan variabel $nama_olahraga dari Controller -->
                <h1 class="text-4xl font-extrabold text-gray-900">
                    Pusat Reservasi Lapangan <span class="text-main"><?= $nama_olahraga ?></span>
                </h1>
                <p class="mt-2 text-lg text-gray-500">Temukan slot waktu tercepat dan terdekat untuk bermain <?= $nama_olahraga ?>.</p>
            </div>

            <!-- Unified Search Bar (Disimpan dari Venue List) -->
            <div class="max-w-4xl mx-auto bg-white p-3 rounded-2xl shadow-lg border border-gray-100 mb-16">
                <form class="flex items-center space-x-2">
                    <!-- Search Input (Venue Name) -->
                    <div class="relative flex-grow">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        
                        <input type="text" id="search_venue_name" name="search_venue_name" placeholder="Cari venue <?= $nama_olahraga ?> terdekat atau nama GOR..." class="w-full pl-10 pr-4 py-3 text-base border-none rounded-xl focus:ring-1 focus:ring-main transition duration-150 focus:outline-none bg-gray-50">
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="px-6 py-3 bg-cta text-white font-bold text-base rounded-xl shadow-md hover:bg-cta-dark transition duration-150 flex-shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Daftar Venue Lapangan (Spesifik Olahraga) -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Lapangan <?= $nama_olahraga ?> Tersedia Saat Ini</h2>
                
                <!-- Grid untuk Menampilkan Venue Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Perulangan data PHP untuk menampilkan cards Venue -->
                    <?php if (isset($venue_list) && !empty($venue_list)): ?>
                        <?php foreach ($venue_list as $venue): ?>
                            
                            <!-- Venue Card Dihasilkan dari data database -->
                            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-t-main cursor-pointer hover:shadow-2xl transition duration-300">
                                <!-- Data Binding untuk Gambar -->
                                <img src="<?= isset($venue->image_url) ? $venue->image_url : 'https://placehold.co/400x250/926699/FFFFFF?text=COURTY' ?>" alt="<?= $venue->venue_name ?>" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <!-- Data Binding untuk Nama Venue -->
                                    <h3 class="text-xl font-semibold text-gray-900 truncate"><?= $venue->venue_name ?></h3>
                                    <!-- Data Binding untuk Detail Lokasi -->
                                    <p class="text-sm text-gray-500 mt-1 truncate">Lokasi: <?= $venue->distance ?> km | Lapangan: <?= $venue->court_count ?></p>
                                    
                                    <div class="flex items-center mt-2">
                                        <!-- Ini harus di-looping berdasarkan rating actual -->
                                        <span class="rating-star">&#9733;</span>
                                        <span class="rating-star">&#9733;</span>
                                        <span class="rating-star">&#9733;</span>
                                        <span class="rating-star text-gray-300">&#9733;</span>
                                        <span class="rating-star text-gray-300">&#9733;</span>
                                        <span class="text-xs text-gray-600 ml-2">(<?= $venue->review_count ?> reviews)</span>
                                    </div>
                                    <button class="mt-4 w-full py-2 text-sm text-white bg-[#926699] rounded-lg hover:bg-[#7d5583] transition duration-150">Pilih Slot Waktu</button>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Pesan jika tidak ada venue ditemukan (Conditional Rendering) -->
                        <div class="col-span-3 text-center py-10 bg-gray-100 rounded-xl">
                            <p class="text-lg text-gray-700 font-semibold">Maaf, belum ada venue <?= $nama_olahraga ?> yang terdaftar.</p>
                            <p class="text-sm text-gray-500 mt-2">Silakan coba olahraga lain atau daftar sebagai Mitra!</p>
                        </div>
                    <?php endif; ?>
                    
                </div>

            </section>


        </div>
    </main>

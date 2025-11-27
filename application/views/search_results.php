<div class="bg-gray-50 min-h-screen pb-16">
    <!-- Search Banner/Header -->
    <section class="bg-white border-b border-gray-200 shadow-sm py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">
                Hasil Pencarian
            </h1>
            <p class="text-lg text-gray-600">
                Menampilkan venue untuk kata kunci: <span class="font-bold text-[#926699]">"<?= html_escape($search_query) ?>"</span>
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        
        <?php if (empty($venue_list)): ?>
            <div class="text-center py-20 bg-white rounded-xl shadow-lg border border-gray-100">
                <svg class="w-16 h-16 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-xl font-bold text-gray-900">Venue Tidak Ditemukan</h3>
                <p class="text-gray-600 mt-2">Coba kata kunci lain atau cek ejaan Anda.</p>
            </div>
        <?php else: ?>
            <h2 class="text-xl font-bold text-gray-800 mb-6">Ditemukan <?= count($venue_list) ?> Venue:</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($venue_list as $venue): ?>
                    
                    <!-- Venue Card -->
                    <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                       class="bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 group border border-gray-100">
                        <!-- Gambar -->
                        <div class="relative">
                            <?php 
                            $img_src = base_url($venue['link_profile_img']);
                            if (empty($venue['link_profile_img']) || $venue['link_profile_img'] == 'placeholder.jpg' || (file_exists($venue['link_profile_img']) === false)) {
                                $img_src = "https://placehold.co/400x250/926699/FFFFFF?text=" . urlencode($venue['venue_name']);
                            }
                            ?>
                            <img src="<?= $img_src ?>" 
                                 alt="Venue <?= html_escape($venue['venue_name']) ?>" 
                                 class="w-full h-40 object-cover group-hover:opacity-90 transition duration-300">
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
            </div>
        <?php endif; ?>

    </div>
</div>
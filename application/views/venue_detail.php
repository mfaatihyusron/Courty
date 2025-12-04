<div class="bg-gray-50 min-h-screen pb-12">
    <!-- Header / Breadcrumb Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="<?= site_url('App/index') ?>" class="text-gray-400 hover:text-[#926699] transition-colors">Home</a></li>
                    <li><span class="text-gray-300">/</span></li>
                    <li><span class="text-gray-600 font-medium" aria-current="page">Detail Venue</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        
        <!-- HEADER VENUE & HERO IMAGE -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
            <div class="relative h-64 md:h-96 w-full">
                <?php 
                $img_src = base_url($venue['link_profile_img']);
                if (empty($venue['link_profile_img']) || $venue['link_profile_img'] == 'placeholder.jpg') {
                    $img_src = "https://placehold.co/1200x600/926699/FFFFFF?text=" . urlencode($venue['venue_name']);
                }
                ?>
                <img src="<?php echo $img_src; ?>" alt="<?php echo html_escape($venue['venue_name']); ?>" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 md:p-8 text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2 tracking-tight"><?php echo html_escape($venue['venue_name']); ?></h1>
                    <p class="text-white/90 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <?php echo html_escape($venue['address']); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI (Content Utama) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Info & Deskripsi -->
                <section class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
                    <div class="flex flex-wrap gap-4 mb-6 text-sm">
                        <div class="bg-green-50 text-green-700 px-4 py-2 rounded-full font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Buka: <?php echo html_escape($venue['opening_time']); ?> - <?php echo html_escape($venue['closing_time']); ?>
                        </div>
                        <a href="<?php echo html_escape($venue['maps_url']); ?>" target="_blank" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full font-semibold hover:bg-blue-100 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Google Maps
                        </a>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 mb-3">Tentang Venue</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed whitespace-pre-wrap">
                        <?php echo html_escape($venue['description']); ?>
                    </div>
                </section>

                <!-- Daftar Lapangan -->
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="bg-[#926699] w-2 h-8 mr-3 rounded-full"></span>
                        Pilih Lapangan
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <?php if (!empty($courts)): ?>
                            <?php foreach ($courts as $index => $court): ?>
                                <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 flex flex-col sm:flex-row gap-5">
                                    <!-- Foto Lapangan -->
                                    <div class="w-full sm:w-48 h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-200">
                                        <?php 
                                        $court_img_src = base_url($court['profile_photo']);
                                        if (empty($court['profile_photo']) || !file_exists($court['profile_photo'])) {
                                            $court_img_src = "https://placehold.co/400x300/e2e8f0/94a3b8?text=" . urlencode($court['sport_name']);
                                        }
                                        ?>
                                        <img src="<?php echo $court_img_src; ?>" alt="Court" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    </div>
                                    
                                    <!-- Detail -->
                                    <div class="flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-md mb-2">
                                                        <?php echo html_escape($court['sport_name']); ?>
                                                    </span>
                                                    <h3 class="text-lg font-bold text-gray-900">
                                                        <?php echo html_escape($court['court_name']); ?>
                                                    </h3>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs text-gray-500">Mulai dari</p>
                                                    <p class="text-xl font-bold text-[#B9CF32]">
                                                        Rp <?php echo number_format($court['price_per_hour'], 0, ',', '.'); ?>
                                                    </p>
                                                    <p class="text-xs text-gray-400">/ jam</p>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2 line-clamp-2"><?php echo html_escape($court['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-10 bg-white rounded-xl shadow-sm">
                                <p class="text-gray-500">Belum ada lapangan yang tersedia.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

            </div>

            <!-- KOLOM KANAN (Booking Form Sticky) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-[#926699] p-4 text-white text-center">
                            <h3 class="font-bold text-lg">Booking Lapangan</h3>
                            <p class="text-purple-100 text-sm">Cek ketersediaan real-time</p>
                        </div>
                        
                        <div class="p-6">
                            <!-- PERUBAHAN: Action diarahkan ke Booking/create -->
                            <form action="<?= site_url('Booking/create') ?>" method="POST" class="space-y-5">
                                
                                <!-- Pilih Lapangan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lapangan</label>
                                    <div class="relative">
                                        <select id="court_id" name="court_id" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#926699] focus:border-transparent appearance-none transition-all" required>
                                            <option value="" data-price="0">-- Pilih Lapangan --</option>
                                            <?php if (!empty($courts)): ?>
                                                <?php foreach ($courts as $court): ?>
                                                    <!-- data-price attribute for JS calculation -->
                                                    <option value="<?php echo $court['id_court']; ?>" 
                                                            data-price="<?php echo $court['price_per_hour']; ?>">
                                                        <?php echo html_escape($court['court_name']); ?> (<?php echo html_escape($court['sport_name']); ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal (Default: Hari Ini) -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Main</label>
                                    <input type="date" id="booking_date" name="booking_date" 
                                           min="<?php echo date('Y-m-d'); ?>"
                                           value="<?php echo date('Y-m-d'); ?>" 
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#926699] focus:border-transparent transition-all" required>
                                </div>

                                <!-- Jam & Durasi Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                        <input type="time" id="start_time" name="start_time" 
                                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#926699] focus:border-transparent transition-all" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                                        <div class="relative">
                                            <select id="duration" name="duration" class="w-full pl-4 pr-8 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#926699] focus:border-transparent appearance-none transition-all" required>
                                                <option value="1">1 Jam</option>
                                                <option value="2">2 Jam</option>
                                                <option value="3">3 Jam</option>
                                                <option value="4">4 Jam</option>
                                                <option value="5">5 Jam</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Total Price Display -->
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-600">Total Harga</span>
                                    <span id="total_price_display" class="text-xl font-bold text-[#B9CF32]">Rp 0</span>
                                </div>

                                <button type="submit" class="w-full py-4 text-base font-bold text-white bg-gradient-to-r from-[#926699] to-[#7d5583] rounded-xl shadow-lg hover:shadow-xl hover:translate-y-[-2px] transition-all duration-200 flex justify-center items-center group">
                                    Cek Ketersediaan & Booking
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                                
                                <p class="text-center text-xs text-gray-400 mt-2">
                                    <i class="fas fa-lock mr-1"></i> Pembayaran Aman & Terpercaya
                                </p>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Help Box -->
                    <div class="mt-6 bg-[#f0fdf4] rounded-xl p-4 border border-green-100 flex items-start gap-3">
                        <div class="text-green-600 mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-green-800">Butuh Bantuan?</h4>
                            <p class="text-xs text-green-700 mt-1">Hubungi admin venue jika Anda ingin booking untuk event turnamen.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- SCRIPT: Auto Calculate Total Price -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const courtSelect = document.getElementById('court_id');
        const durationSelect = document.getElementById('duration');
        const totalPriceDisplay = document.getElementById('total_price_display');

        function calculateTotal() {
            // Ambil opsi yang dipilih
            const selectedOption = courtSelect.options[courtSelect.selectedIndex];
            
            // Ambil harga dari atribut data-price (default 0 jika tidak ada)
            const pricePerHour = selectedOption.getAttribute('data-price') || 0;
            const duration = durationSelect.value || 0;

            // Hitung total
            const total = parseInt(pricePerHour) * parseInt(duration);

            // Format ke Rupiah
            const formattedTotal = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            // Update display (Jika total 0, tampilkan Rp 0 secara manual agar rapi)
            if (total > 0) {
                totalPriceDisplay.textContent = formattedTotal;
            } else {
                totalPriceDisplay.textContent = 'Rp 0';
            }
        }

        // Pasang event listener
        courtSelect.addEventListener('change', calculateTotal);
        durationSelect.addEventListener('change', calculateTotal);
    });
</script>
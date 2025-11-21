<main>
        <!-- Hero Section (Fokus Pencarian) -->
        <section class="relative bg-white pt-16 pb-24 sm:pt-24 sm:pb-32 lg:pb-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                
                <!-- Tagline -->
                <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900 leading-tight">
                    Temukan Lapangan Terbaik <span class="text-[#926699]">di Sekitarmu</span>
                </h1>
                <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
                    Reservasi semi-otomatis yang pasti. Cek ketersediaan lapangan, konfirmasi cepat oleh Mitra GOR.
                </p>

                <!-- Category Bar Section -->
                <div class="mt-8 mb-12 py-4">
                    <!-- Wrapper untuk horizontal scrolling di mobile dan centering di desktop -->
                    <div class="flex space-x-6 overflow-x-auto pb-2 scrollbar-hide justify-center">
                        
                        <!-- Category Item 1: Futsal/Sepakbola -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">⚽</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Futsal/Sepakbola</span>
                        </a>
                        
                        <!-- Category Item 2: Badminton -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏸</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Badminton</span>
                        </a>
                        
                        <!-- Category Item 3: Basket -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏀</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Basket</span>
                        </a>
                        
                        <!-- Category Item 4: Voli -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏐</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Voli</span>
                        </a>
                        
                        <!-- Category Item 5: Tenis -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🎾</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Tenis</span>
                        </a>

                         <!-- Category Item 6: Renang -->
                        <a href="#" class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 bg-gray-50 rounded-xl shadow-md border-2 border-transparent hover:border-[#926699] transition duration-200 group w-28 sm:w-32">
                            <span class="text-3xl sm:text-4xl">🏊</span>
                            <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-[#926699] text-center">Renang</span>
                        </a>
                        
                    </div>
                </div>


                <!-- Terpadu Search Bar (Mengadopsi Fungsionalitas Ayo.co.id) -->
                <div class="mt-12 max-w-6xl mx-auto bg-white p-4 sm:p-5 rounded-3xl shadow-2xl border border-gray-100 transition duration-300 hover:shadow-xl">
                    <form class="flex flex-col md:flex-row items-center md:space-x-4 space-y-4 md:space-y-0">
                        
                        <!-- 1. Unified Search Input (Venue/Sport/Location) -->
                        <div class="relative flex-grow w-full md:w-2/5">
                            <label for="search_query" class="sr-only">Cari Venue/Lokasi</label>
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            
                            <input type="text" id="search_query" name="search_query" placeholder="Venue, Olahraga, atau Lokasi..." class="w-full pl-12 pr-4 py-3 text-base border-none rounded-2xl focus:ring-1 focus:ring-[#926699] transition duration-150 focus:outline-none bg-gray-50">
                        </div>
                        
                        <!-- 2. Date Selector -->
                        <div class="relative w-full md:w-1/5">
                            <label for="booking_date" class="sr-only">Tanggal</label>
                            <input type="date" id="booking_date" name="booking_date" class="w-full pl-10 pr-4 py-3 text-base border-none rounded-2xl focus:ring-1 focus:ring-[#926699] transition duration-150 focus:outline-none bg-gray-50">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>

                        <!-- 3. Time Range Selector -->
                        <div class="relative w-full md:w-1/5">
                            <label for="time_range" class="sr-only">Jam</label>
                            <select id="time_range" name="time_range" class="w-full pl-10 pr-4 py-3 text-base border-none rounded-2xl appearance-none focus:ring-1 focus:ring-[#926699] transition duration-150 focus:outline-none bg-gray-50">
                                <option value="">Pilih Jam</option>
                                <option value="morning">Pagi (06:00 - 12:00)</option>
                                <option value="afternoon">Siang (12:00 - 17:00)</option>
                                <option value="evening">Sore/Malam (17:00 - Selesai)</option>
                            </select>
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        
                        <!-- 4. Search Button -->
                        <button type="submit" class="w-full md:w-1/5 px-4 py-3 bg-[#B9CF32] text-white font-bold text-base rounded-2xl shadow-lg hover:bg-[#a1b62a] transition duration-150 flex-shrink-0">
                            Cari Lapangan
                        </button>
                    </form>
                </div>
                
                <!-- Geolocation Button (Dipindah ke bawah search bar untuk kejelasan) -->
                <div class="mt-4 flex justify-center items-center space-x-2">
                    <button type="button" class="text-sm font-semibold text-gray-600 hover:text-[#926699] transition duration-150" onclick="getGeolocation()">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Gunakan Lokasi Saya Sekarang
                    </button>
                    <p id="geo-status" class="text-sm text-gray-500"></p>
                </div>

            </div>
        </section>

        <!-- How It Works (Penjelasan Workflow Semi-Otomatis) -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Alur Kerja Reservasi Courty</h2>
                <p class="mt-4 text-lg text-gray-500">Kami menjamin keakuratan dengan proses konfirmasi Mitra GOR yang cepat.</p>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                    
                    <!-- Step 1: Cari & Request -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-b-4 border-t-[#926699] border-b-white transition duration-300 hover:shadow-xl">
                        <div class="w-12 h-12 mx-auto bg-purple-100 text-[#926699] rounded-full flex items-center justify-center text-2xl font-bold">1</div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Cari & Kirim Permintaan (Pending)</h3>
                        <p class="mt-4 text-gray-500">Pilih lapangan dan slot waktu yang Anda inginkan. Pesanan Anda akan berstatus **Pending** menunggu persetujuan Mitra GOR.</p>
                    </div>

                    <!-- Step 2: Konfirmasi Mitra -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-b-4 border-t-[#F87B1B] border-b-white transition duration-300 hover:shadow-xl">
                        <div class="w-12 h-12 mx-auto bg-orange-100 text-[#F87B1B] rounded-full flex items-center justify-center text-2xl font-bold">2</div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Konfirmasi Cepat oleh Mitra</h3>
                        <p class="mt-4 text-lg text-gray-500">Mitra GOR akan memeriksa ketersediaan akhir dan menyetujui. Anda akan mendapat notifikasi **Confirmed** (Siap Bayar).</p>
                    </div>

                    <!-- Step 3: Bayar & Main -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-b-4 border-t-[#347048] border-b-white transition duration-300 hover:shadow-xl">
                        <div class="w-12 h-12 mx-auto bg-green-100 text-[#347048] rounded-full flex items-center justify-center text-2xl font-bold">3</div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Bayar & Selesai (Completed)</h3>
                        <p class="mt-4 text-lg text-gray-500">Selesaikan pembayaran dalam **Payment Deadline** (Batas Waktu). Reservasi Anda resmi **Completed** dan terjamin.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Featured Venues (Placeholder) -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 text-center">Rekomendasi Lapangan Terbaik</h2>
                <p class="mt-2 text-lg text-gray-500 text-center">Venue dengan rating dan pelayanan tertinggi.</p>

                <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Venue Card 1 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/1e293b/FFFFFF?text=Futsal+Arena" alt="Futsal Arena" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h4 class="text-xl font-semibold text-gray-900">Gedung Futsal Juara</h4>
                            <p class="text-sm text-gray-500 mt-1">Futsal, Basket | 3.5 km dari Anda</p>
                            <button class="mt-4 w-full py-2 text-sm text-white bg-[#926699] rounded-lg hover:bg-[#7d5583] transition duration-150">Lihat Detail & Slot</button>
                        </div>
                    </div>
                    
                    <!-- Venue Card 2 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/374151/FFFFFF?text=Badminton+Court" alt="Badminton Court" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h4 class="text-xl font-semibold text-gray-900">GOR Jaya Badminton</h4>
                            <p class="text-sm text-gray-500 mt-1">Badminton | 5.8 km dari Anda</p>
                            <button class="mt-4 w-full py-2 text-sm text-white bg-[#926699] rounded-lg hover:bg-[#7d5583] transition duration-150">Lihat Detail & Slot</button>
                        </div>
                    </div>
                    
                    <!-- Venue Card 3 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/10b981/FFFFFF?text=Basket+Hall" alt="Basket Hall" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h4 class="text-xl font-semibold text-gray-900">Gelanggang Basket Emas</h4>
                            <p class="text-sm text-gray-500 mt-1">Basket | 12.1 km dari Anda</p>
                            <button class="mt-4 w-full py-2 text-sm text-white bg-[#926699] rounded-lg hover:bg-[#7d5583] transition duration-150">Lihat Detail & Slot</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

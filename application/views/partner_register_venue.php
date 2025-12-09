<div class="max-w-xl mx-auto py-12">
    <div class="bg-white p-8 md:p-10 shadow-2xl rounded-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-[#926699] mb-2">Daftar Mitra (Step 2/2)</h1>
        <p class="text-gray-600 mb-6">Lengkapi data Venue (Lapangan) Anda dan unggah foto profil.</p>

        <?php 
        // Menampilkan pesan error atau sukses dari session
        if ($this->session->flashdata('error')) {
            echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error') . '</div>';
        }
        if ($this->session->flashdata('success')) {
            echo '<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">' . $this->session->flashdata('success') . '</div>';
        }
        ?>

        <!-- PENTING: Menggunakan form_open_multipart untuk upload file -->
        <?php echo form_open_multipart('Mitra/partner_register_step2'); ?>
            
            <div class="mb-5">
                <label for="venue_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Venue/Lapangan</label>
                <input type="text" name="venue_name" id="venue_name" value="<?php echo set_value('venue_name'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Contoh: GOR Jaya Sakti">
                <?php echo form_error('venue_name', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <div class="mb-5">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Alamat fisik Venue"><?php echo set_value('address'); ?></textarea>
                <?php echo form_error('address', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Venue</label>
                <textarea name="description" id="description" rows="3" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Jelaskan jenis lapangan, fasilitas, dan keunggulan Venue Anda."><?php echo set_value('description'); ?></textarea>
                <?php echo form_error('description', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <!-- INPUT UNTUK UPLOAD FOTO -->
            <div class="mb-5">
                <label for="link_profile_img" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil Venue (Max 2MB, JPEG/PNG)</label>
                <input type="file" name="link_profile_img" id="link_profile_img" 
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" 
                       accept="image/jpeg, image/png, image/jpg">
                <p class="mt-1 text-xs text-gray-500">Unggah foto terbaik Venue Anda.</p>
            </div>


            <div class="mb-5">
                <label for="maps_url" class="block text-sm font-medium text-gray-700 mb-1">URL Google Maps</label>
                <input type="url" name="maps_url" id="maps_url" value="<?php echo set_value('maps_url'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Link Google Maps Venue Anda">
                <?php echo form_error('maps_url', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>


            <!-- Jam Operasional -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                    <input type="time" name="opening_time" id="opening_time" value="<?php echo set_value('opening_time', '08:00'); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]">
                    <?php echo form_error('opening_time', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
                <div>
                    <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup</label>
                    <input type="time" name="closing_time" id="closing_time" value="<?php echo set_value('closing_time', '22:00'); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]">
                    <?php echo form_error('closing_time', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
            </div>

            <!-- Koordinat Lokasi DIHAPUS -->

            <button type="submit" 
                    class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#B9CF32] hover:bg-[#a6bd2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B9CF32] transition duration-150">
                Selesaikan Pendaftaran Mitra
            </button>
        <?php echo form_close(); ?>
        
    </div>
</div>
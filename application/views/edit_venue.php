<div class="max-w-xl mx-auto py-12">
    <div class="bg-white p-8 md:p-10 shadow-2xl rounded-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-green-500 mb-2">Edit Detail Venue</h1>
        <p class="text-gray-600 mb-6">Perbarui informasi Venue/GOR: <?php echo html_escape($venue['venue_name']); ?></p>

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
        <?php echo form_open_multipart('Mitra/edit_venue'); ?>
            
            <div class="mb-5">
                <label for="venue_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Venue/Lapangan</label>
                <input type="text" name="venue_name" id="venue_name" 
                       value="<?php echo set_value('venue_name', $venue['venue_name']); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" 
                       placeholder="Contoh: GOR Jaya Sakti">
                <?php echo form_error('venue_name', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <div class="mb-5">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" 
                       placeholder="Alamat fisik Venue"><?php echo set_value('address', $venue['address']); ?></textarea>
                <?php echo form_error('address', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Venue</label>
                <textarea name="description" id="description" rows="3" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" 
                       placeholder="Jelaskan jenis lapangan, fasilitas, dan keunggulan Venue Anda."><?php echo set_value('description', $venue['description']); ?></textarea>
                <?php echo form_error('description', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <!-- INPUT UNTUK UPLOAD FOTO (Opsional) -->
            <div class="mb-5 p-4 border border-dashed rounded-lg bg-gray-50">
                <label for="link_profile_img" class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Profil Venue (Opsional)</label>
                <p class="text-xs text-gray-500 mb-2">Foto saat ini: <a href="<?php echo base_url($venue['link_profile_img']); ?>" target="_blank" class="text-green-500 hover:underline"><?php echo html_escape($venue['link_profile_img']); ?></a></p>
                <input type="file" name="link_profile_img" id="link_profile_img" 
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none p-2" 
                       accept="image/jpeg, image/png, image/jpg">
                <p class="mt-1 text-xs text-gray-500">Unggah foto baru jika ingin mengganti.</p>
            </div>


            <div class="mb-5">
                <label for="maps_url" class="block text-sm font-medium text-gray-700 mb-1">URL Google Maps</label>
                <input type="url" name="maps_url" id="maps_url" 
                       value="<?php echo set_value('maps_url', $venue['maps_url']); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" 
                       placeholder="Link Google Maps Venue Anda">
                <?php echo form_error('maps_url', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>


            <!-- Jam Operasional -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                    <input type="time" name="opening_time" id="opening_time" 
                           value="<?php echo set_value('opening_time', $venue['opening_time']); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <?php echo form_error('opening_time', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
                <div>
                    <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup</label>
                    <input type="time" name="closing_time" id="closing_time" 
                           value="<?php echo set_value('closing_time', $venue['closing_time']); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <?php echo form_error('closing_time', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                Simpan Perubahan Venue
            </button>
            <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="mt-3 w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                Batal
            </a>
        <?php echo form_close(); ?>
        
    </div>
</div>
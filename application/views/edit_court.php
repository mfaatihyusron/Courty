<div class="max-w-xl mx-auto py-12">
    <div class="bg-white p-8 md:p-10 shadow-2xl rounded-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-indigo-500 mb-2">Edit Lapangan #<?php echo html_escape($court['id_court']); ?></h1>
        <p class="text-gray-600 mb-6">Perbarui detail untuk lapangan **<?php echo html_escape($court['sport_name']); ?>** Anda.</p>

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
        <?php echo form_open_multipart('Mitra/edit_court/' . $court['id_court']); ?>
            
            <!-- Jenis Olahraga -->
            <div class="mb-5">
                <label for="id_sport" class="block text-sm font-medium text-gray-700 mb-1">Jenis Olahraga</label>
                <select name="id_sport" id="id_sport" 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Jenis Olahraga --</option>
                    <?php 
                    if (!empty($sports)) {
                        foreach ($sports as $sport) {
                            $selected = set_select('id_sport', $sport['id_sport'], ($sport['id_sport'] == $court['id_sport']));
                            echo '<option value="' . $sport['id_sport'] . '" ' . $selected . '>' . html_escape($sport['name']) . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Data Sport tidak ditemukan.</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('id_sport', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <!-- Harga per Jam -->
            <div class="mb-5">
                <label for="price_per_hour" class="block text-sm font-medium text-gray-700 mb-1">Harga per Jam (Rp)</label>
                <input type="number" name="price_per_hour" id="price_per_hour" 
                       value="<?php echo set_value('price_per_hour', $court['price_per_hour']); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       placeholder="Contoh: 50000">
                <?php echo form_error('price_per_hour', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lapangan</label>
                <textarea name="description" id="description" rows="3" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       placeholder="Detail tentang lapangan ini (misalnya, indoor/outdoor, jenis permukaan)."><?php echo set_value('description', $court['description']); ?></textarea>
                <?php echo form_error('description', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <!-- INPUT UNTUK UPLOAD FOTO COURT -->
            <div class="mb-6 p-4 border border-dashed rounded-lg bg-gray-50">
                <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Lapangan (Opsional)</label>
                <p class="text-xs text-gray-500 mb-2">Foto saat ini: <a href="<?php echo base_url($court['profile_photo']); ?>" target="_blank" class="text-indigo-500 hover:underline"><?php echo html_escape($court['profile_photo']); ?></a></p>
                <input type="file" name="profile_photo" id="profile_photo"
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none p-2" 
                       accept="image/jpeg, image/png, image/jpg">
                <p class="mt-1 text-xs text-gray-500">Unggah foto baru jika ingin mengganti.</p>
            </div>

            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                Simpan Perubahan Lapangan
            </button>
            <a href="<?php echo site_url('Mitra/partner_dashboard'); ?>" class="mt-3 w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                Batal
            </a>
        <?php echo form_close(); ?>
        
    </div>
</div>
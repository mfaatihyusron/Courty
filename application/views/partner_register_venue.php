<div class="max-w-xl mx-auto py-12">
    <div class="bg-white p-8 md:p-10 shadow-2xl rounded-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-[#926699] mb-2">Daftar Mitra (Step 2/2)</h1>
        <p class="text-gray-600 mb-6">Lengkapi data Venue (Lapangan) Anda.</p>

        <?php 
        // Menampilkan pesan error atau sukses dari session
        if ($this->session->flashdata('error')) {
            echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error') . '</div>';
        }
        if ($this->session->flashdata('success')) {
            echo '<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">' . $this->session->flashdata('success') . '</div>';
        }
        ?>

        <?php echo form_open('praktek/partner_register_step2'); ?>
            
            <div class="mb-5">
                <label for="venue_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Venue/Lapangan</label>
                <input type="text" name="venue_name" id="venue_name" value="<?php echo set_value('venue_name'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Contoh: GOR Jaya Sakti">
                <?php echo form_error('venue_name', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-5">
                <label for="telp_venue" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Venue</label>
                <input type="text" name="telp_venue" id="telp_venue" value="<?php echo set_value('telp_venue'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Nomor yang bisa dihubungi untuk reservasi">
                <?php echo form_error('telp_venue', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
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

            <!-- Koordinat Lokasi -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude (Lintang)</label>
                    <input type="text" name="lat" id="lat" value="<?php echo set_value('lat'); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                           placeholder="Contoh: -6.2088">
                    <?php echo form_error('lat', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
                <div>
                    <label for="lon" class="block text-sm font-medium text-gray-700 mb-1">Longitude (Bujur)</label>
                    <input type="text" name="lon" id="lon" value="<?php echo set_value('lon'); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                           placeholder="Contoh: 106.8456">
                    <?php echo form_error('lon', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#B9CF32] hover:bg-[#a6bd2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B9CF32] transition duration-150">
                Selesaikan Pendaftaran Mitra
            </button>
        <?php echo form_close(); ?>
        
    </div>
</div>
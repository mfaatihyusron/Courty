<div class="flex justify-center items-center py-10">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h2 class="text-3xl font-bold text-center text-[#926699] mb-6">Daftar Akun Baru</h2>
        <p class="text-center text-gray-500 mb-8">Temukan lapangan olahraga terbaik dengan Courty.</p>

        <?php 
        // Menampilkan pesan error atau sukses menggunakan flashdata
        if ($this->session->flashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $this->session->flashdata('success'); ?></span>
            </div>
        <?php endif; 
        if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
        <?php endif; 
        
        // Membuka form yang akan di-submit ke controller praktek/register
        echo form_open('praktek/register', ['class' => 'space-y-5']); 
        ?>

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Nama lengkap Anda">
                <!-- Tampilkan error validasi untuk Nama -->
                <?php echo form_error('name', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="contoh@mail.com">
                <!-- Tampilkan error validasi untuk Email -->
                <?php echo form_error('email', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>
            
            <!-- Nomor Telepon (telp) -->
            <div>
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" id="telp" name="telp" value="<?php echo set_value('telp'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="08123456789">
                <!-- Tampilkan error validasi untuk Telepon -->
                <?php echo form_error('telp', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Minimal 6 karakter">
                <!-- Tampilkan error validasi untuk Password -->
                <?php echo form_error('password', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="passconf" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="passconf" name="passconf" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Ulangi password Anda">
                <!-- Tampilkan error validasi untuk Konfirmasi Password -->
                <?php echo form_error('passconf', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" 
                    class="w-full py-3 px-4 bg-[#926699] text-white font-semibold rounded-lg shadow-md hover:bg-[#7d5583] transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#926699] focus:ring-offset-2">
                Daftar Sekarang
            </button>
            
        <?php echo form_close(); ?>

        <div class="mt-6 text-center text-sm">
            <p class="text-gray-600">Sudah punya akun? <a href="<?php echo site_url('Auth/login'); ?>" class="font-medium text-[#926699] hover:text-[#7d5583]">Login di sini</a></p>
        </div>
    </div>
</div>
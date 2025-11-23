<div class="max-w-xl mx-auto py-12">
    <div class="bg-white p-8 md:p-10 shadow-2xl rounded-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-[#926699] mb-2">Daftar Mitra (Step 1/2)</h1>
        <p class="text-gray-600 mb-6">Lengkapi data personal Anda untuk mendaftar sebagai Admin Venue.</p>

        <?php 
        // Menampilkan pesan error atau sukses dari session
        if ($this->session->flashdata('error')) {
            echo '<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">' . $this->session->flashdata('error') . '</div>';
        }
        if ($this->session->flashdata('success')) {
            echo '<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">' . $this->session->flashdata('success') . '</div>';
        }
        ?>

        <?php echo form_open('praktek/partner_register_step1'); ?>
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Nama Lengkap Anda">
                <?php echo form_error('name', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="email@example.com">
                <?php echo form_error('email', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-5">
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telp" id="telp" value="<?php echo set_value('telp'); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Contoh: 081234567890">
                <?php echo form_error('telp', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Minimal 6 karakter">
                <?php echo form_error('password', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>
            
            <div class="mb-6">
                <label for="passconf" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="passconf" id="passconf" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#926699] focus:border-[#926699]" 
                       placeholder="Ulangi Password">
                <?php echo form_error('passconf', '<p class="text-red-500 text-xs mt-1">', '</p>'); ?>
            </div>

            <button type="submit" 
                    class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#926699] hover:bg-[#7d5583] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#926699] transition duration-150">
                Lanjutkan ke Pendaftaran Venue (Step 2)
            </button>
        <?php echo form_close(); ?>
        
        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun mitra? <a href="<?php echo site_url('praktek/login'); ?>" class="font-medium text-[#926699] hover:text-[#7d5583]">Login di sini</a>
        </p>
    </div>
</div>
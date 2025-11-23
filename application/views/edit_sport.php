<div class="max-w-md mx-auto py-12">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h2 class="text-3xl font-bold text-indigo-500 mb-6">Edit Jenis Olahraga</h2>
        <p class="text-gray-600 mb-4">Mengedit ID Sport: #<?php echo html_escape($sport['id_sport']); ?></p>

        <?php 
        if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
        <?php endif; 
        
        echo form_open('praktek/edit_sport/' . $sport['id_sport'], ['class' => 'space-y-5']); 
        ?>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Olahraga</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo set_value('name', $sport['name']); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       placeholder="Contoh: Sepak Bola">
                <?php echo form_error('name', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
            </div>

            <button type="submit" 
                    class="w-full py-3 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Simpan Perubahan
            </button>
            <a href="<?php echo site_url('praktek/admin_dashboard'); ?>" class="mt-3 w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                Batal
            </a>
            
        <?php echo form_close(); ?>
    </div>
</div>
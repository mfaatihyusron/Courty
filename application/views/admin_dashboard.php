<div class="py-6">
    <h1 class="text-4xl font-bold text-[#926699] mb-2">Dashboard Super Admin</h1>
    <p class="text-gray-600 mb-8">Selamat datang di panel administrasi Courty. Anda memiliki hak akses penuh untuk mengelola pengguna dan data olahraga.</p>
    
    <!-- Bagian Pesan Flash Data -->
    <?php 
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
    ?>

    <!-- ============================================== -->
    <!-- TABEL 1: DAFTAR PENGGUNA (USERS) -->
    <!-- ============================================== -->
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden border border-gray-100 mb-12">
        <div class="p-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-800">1. Daftar Pengguna Terdaftar (Tabel Users)</h3>
            <p class="text-sm text-gray-500">Total pengguna: <?php echo count($users); ?></p>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Telepon
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo $user['id_user']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo html_escape($user['name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo html_escape($user['email']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo html_escape($user['telp']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php 
                                        $role_text = 'User Biasa';
                                        $role_color = 'bg-gray-100 text-gray-800';
                                        if ($user['role'] == 1) {
                                            $role_text = 'Super Admin';
                                            $role_color = 'bg-indigo-100 text-indigo-800';
                                        } elseif ($user['role'] == 2) {
                                            $role_text = 'Sport Admin';
                                            $role_color = 'bg-pink-100 text-pink-800';
                                        } elseif ($user['role'] == 3) {
                                            $role_text = 'Admin Venue';
                                            $role_color = 'bg-green-100 text-green-800';
                                        }
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $role_color; ?>">
                                        <?php echo $role_text; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Akhir Tabel -->
    </div>
    
    <!-- ============================================== -->
    <!-- TABEL 2: DAFTAR OLAHRAGA (SPORT MANAGEMENT) -->
    <!-- ============================================== -->
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden border border-gray-100">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800">2. Manajemen Jenis Olahraga (Tabel Sport)</h3>
            <a href="<?php echo site_url('Admin/add_sport'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-[#B9CF32] rounded-lg shadow-md hover:bg-[#a6bd2e] transition duration-150">
                + Tambah Olahraga Baru
            </a>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/6">
                            Nama Olahraga
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($sports)): ?>
                        <?php foreach ($sports as $sport): ?>
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo $sport['id_sport']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo html_escape($sport['name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center space-x-2">
                                    <a href="<?php echo site_url('Admin/edit_sport/' . $sport['id_sport']); ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                    
                                    <a href="#" 
                                       onclick="confirmDelete('<?php echo site_url('Admin/delete_sport/' . $sport['id_sport']); ?>', '<?php echo html_escape($sport['name']); ?>')" 
                                       class="text-red-600 hover:text-red-900 font-medium ml-3">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada jenis olahraga terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Akhir Tabel -->
    </div>

</div>

<!-- Modal Konfirmasi Hapus (Custom UI, BUKAN alert()) - Digunakan untuk menghapus Sport -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Konfirmasi Penghapusan Olahraga</h3>
        <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus olahraga <strong id="sport-name-display"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="document.getElementById('delete-modal').classList.add('hidden');" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Batal</button>
            <a id="delete-confirm-link" href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Hapus</a>
        </div>
    </div>
</div>

<script>
function confirmDelete(deleteUrl, sportName) {
    document.getElementById('sport-name-display').textContent = '"' + sportName + '"';
    document.getElementById('delete-confirm-link').href = deleteUrl;
    document.getElementById('delete-modal').classList.remove('hidden');
    document.getElementById('delete-modal').classList.add('flex');
}
</script>
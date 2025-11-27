<!-- BANNER SECTION -->
<section class="relative h-64 overflow-hidden shadow-md">
    <!-- Background Image Abstract Tech/Office -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-blue-900/80"></div> <!-- Overlay Biru Gelap -->
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center text-center sm:text-left">
        <h1 class="text-4xl font-extrabold text-white mb-2">Dashboard Admin</h1>
        <p class="text-lg text-blue-100 max-w-2xl">
            Panel kontrol pusat untuk mengelola data pengguna, olahraga, dan sistem Courty.
        </p>
    </div>
</section>

<!-- KONTEN UTAMA -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-10">
    
    <!-- Bagian Pesan Flash Data -->
    <?php 
    if ($this->session->flashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6" role="alert">
            <span class="block sm:inline"><?php echo $this->session->flashdata('success'); ?></span>
        </div>
    <?php endif; 
    if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6" role="alert">
            <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
        </div>
    <?php endif; 
    ?>

    <!-- ============================================== -->
    <!-- TABEL 1: DAFTAR PENGGUNA (USERS) -->
    <!-- ============================================== -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 mb-12">
        <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Daftar Pengguna</h3>
                <p class="text-sm text-gray-500">Semua akun terdaftar di sistem.</p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">Total: <?php echo count($users); ?></span>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#<?php echo $user['id_user']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium"><?php echo html_escape($user['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo html_escape($user['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo html_escape($user['telp']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php 
                                        $role_text = 'User Biasa';
                                        $role_class = 'bg-gray-100 text-gray-800';
                                        if ($user['role'] == 1) {
                                            $role_text = 'Super Admin';
                                            $role_class = 'bg-indigo-100 text-indigo-800';
                                        } elseif ($user['role'] == 2) {
                                            $role_text = 'Sport Admin';
                                            $role_class = 'bg-pink-100 text-pink-800';
                                        } elseif ($user['role'] == 3) {
                                            $role_text = 'Admin Venue';
                                            $role_class = 'bg-green-100 text-green-800';
                                        }
                                    ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $role_class; ?>">
                                        <?php echo $role_text; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 italic">Belum ada pengguna terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ============================================== -->
    <!-- TABEL 2: DAFTAR OLAHRAGA (SPORT MANAGEMENT) -->
    <!-- ============================================== -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Manajemen Kategori Olahraga</h3>
                <p class="text-sm text-gray-500">Data jenis olahraga yang didukung sistem.</p>
            </div>
            <a href="<?php echo site_url('Admin/add_sport'); ?>" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#B9CF32] rounded-lg shadow-md hover:bg-[#a6bd2e] transition duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Olahraga
            </a>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/6">Nama Olahraga</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($sports)): ?>
                        <?php foreach ($sports as $sport): ?>
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center bg-gray-50"><?php echo $sport['id_sport']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold"><?php echo html_escape($sport['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center space-x-3">
                                    <a href="<?php echo site_url('Admin/edit_sport/' . $sport['id_sport']); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="#" onclick="confirmDelete('<?php echo site_url('Admin/delete_sport/' . $sport['id_sport']); ?>', '<?php echo html_escape($sport['name']); ?>')" class="text-red-600 hover:text-red-900 font-semibold">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500 italic">Belum ada jenis olahraga terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 transform transition-all scale-100">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Olahraga?</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus <strong id="sport-name-display" class="text-gray-800"></strong>? Tindakan ini permanen.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="document.getElementById('delete-modal').classList.add('hidden');" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Batal</button>
            <a id="delete-confirm-link" href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">Hapus</a>
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
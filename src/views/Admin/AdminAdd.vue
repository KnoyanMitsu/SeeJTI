<template>
  <div class="container">
    <div>
      <h1 class="text-2xl font-semibold">Form Tambah Data User</h1>
    </div>

    <div class="w-100 p-8 mt-12 shadow-md rounded-2xl">
      <form @submit.prevent="submitForm">
        <!-- Nama -->
        <div class="mb-4">
          <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
          <input v-model="nama" type="text" id="nama" name="nama" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Username -->
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input v-model="username" type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan username" required>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input v-model="password" type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan password" required>
        </div>

        <!-- NIM -->
        <div class="mb-4">
          <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
          <input v-model="nim" type="text" id="nim" name="nim" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan NIM" required>
        </div>

        <!-- Kelas -->
        <div class="mb-4">
          <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
          <input v-model="kelas" type="text" id="kelas" name="kelas" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan kelas" required>
        </div>

        <!-- Level -->
        <div class="mb-4">
          <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
          <select v-model="level" id="level" name="level" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
            <option value="Admin">Admin</option>
            <option value="Mahasiswa">Mahasiswa</option>
          </select>
        </div>

        <!-- Button Group -->
        <div class="flex justify-end gap-6 mt-6">
          <button type="submit" class="px-6 py-2 bg-[#F05529] text-white rounded-lg hover:bg-[#FCAA93] hover:text-[#F05529] focus:outline-none focus:ring-2 focus:ring-blue-500">
            Simpan
          </button>
          <button type="reset" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</template>


<style>
.w-100 {
    width: 731px /* 384px */;
}
</style>

<script>
import axios from '../../api/api';
import router from '../../router';

export default {
  data() {
    return {
      username: '',
      password: '',
      nama: '',
      nim: '',
      kelas: '',
      level: 'Admin', // Default level
      pesan: '',
    };
  },
  methods: {
    async submitForm() {
      try {
        const payload = {
          username: this.username,
          password: this.password,
          nama: this.nama,
          nim: this.nim,
          kelas: this.kelas,
          level: this.level,
        };

        const response = await axios.post(
          'http://localhost:8000/CreateUser.php',
          payload,
          {
            withCredentials: true, // Jika perlu mengirim cookies
            headers: {
              'Content-Type': 'application/json',
            },
          },
        );

        if (response.data.status === 'success') {
          alert('Nambah User Berhasil');
          router.push({ name: 'users' }); // Redirect ke halaman admin
        } else {
          alert(`Gagal menambah user: ${response.data}`);
        }
      } catch (error) {
        console.error('Terjadi kesalahan saat menambah user:', error);
        alert('Terjadi kesalahan, silakan coba lagi.');
      }
    },
  },
};
</script>

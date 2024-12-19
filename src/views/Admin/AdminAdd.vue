<template>
    <div class = "container ">
        <div >
            <h1 class = "text-2xl font-semibold">Form Tambah Data User</h1>
        </div>

        <div class = "w-100 p-8 mt-12 shadow-md rounded-2xl ">
    <form @submit.prevent="submitForm">
    <!-- Form 1: Nama Lengkap -->
    <div class="mb-4">
      <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
      <input v-model="username" type="text" id="nama" name="nama" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
    </div>

    <div class="mb-4">
      <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
      <input v-model="name" type="text" id="nama" name="nama" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
    </div>

    <!-- Form 2: NIM -->
    <div class="mb-4">
      <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
      <input v-model="nim" type="text" id="nim" name="nim" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan NIM" required>
    </div>

    <!-- Form 3: Password -->
    <div class="mb-4">
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input v-model="password" type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan password" required>
    </div>

    <!-- Dropdown: Mahasiswa / Ketua Kelas -->
    <div class="mb-4">
      <label for="role" class="block text-sm font-medium text-gray-700">Pilih Role</label>
      <select v-model="role" id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg " required>
        <option value="mahasiswa">Mahasiswa</option>
        <option value="ketua_kelas">Ketua Kelas</option>
      </select>
    </div>

    <!-- Button Group -->
    <div class="flex justify-end gap-6  mt-6">
      <!-- Simpan Button -->
      <button type="submit" class="px-6 py-2 bg-[#F05529] text-white rounded-lg hover:bg-[#FCAA93] hover:text-[#F05529] focus:outline-none focus:ring-2 focus:ring-blue-500">
        Simpan
      </button>

      <!-- Batal Button -->
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
import axios from '../../api/api'
import router from '../../router'

export default {
  data() {
    return {
      name: '',
      password: '',
      nim: '',
      role: '',
      username: '',
      pesan: '',
    }
  },
  methods: {
    async login() {
      try {
        const response = await axios.post(
          'http://localhost:8000/CreateUser.php',
          {
            username: this.username,
            name: this.name,
            password: this.password,
            nim: this.nim,
            role: this.role,
          },
          {
            withCredentials: true,
          },
        )

        if (response.data == 'berhasil') {
          this.pesan = 'Nambah User Berhasil'
          router.push({ name: 'admin' })
        } else {
          this.pesan = 'Login gagal : ' + response.data
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.pesan = 'Terjadi kesalahan saat login : ' + error.response.data
        } else {
          console.error('Error Details : ', error)
          this.pesan = 'Terjadi kesalahan saat login'
        }
      }
    },
  },
}
</script>

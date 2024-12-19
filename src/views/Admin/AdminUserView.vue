<script setup>
// import LoadingWidget from '@/widget/LoadingWidget.vue'
import { VsxIcon } from 'vue-iconsax'
import WarningModal from './Widget/WarningModal.vue'
</script>
<script>
import axios from '../../api/api'
let cachedUser = null
export default {
  data() {
    return {
      user: [],
      success: false,
      showModal: false, // Tambahkan ini
      selectedUserId: null, // Untuk menyimpan ID pengguna yang dipilih
    }
  },
  methods: {
    showDeleteModal(userId) {
    this.selectedUserId = userId; // Simpan ID pengguna
    this.showModal = true; // Tampilkan modal
  },
    async deleteUser() {
    if (!this.selectedUserId) {
      alert("ID pengguna tidak valid!");
      return;
    }

    const payload = {
      id_user: this.selectedUserId, // Data yang dikirim sesuai format JSON
    };

    try {
      const response = await axios.post('http://localhost:8000/DeleteUser.php', payload, {
        headers: {
          'Content-Type': 'application/json', // Pastikan header sesuai
        },
        withCredentials: true, // Kirim cookies jika diperlukan
      });

      if (response.data && response.data.status === 'success') {
        alert(response.data.message || 'Pengguna berhasil dihapus');
        // Hapus pengguna dari daftar berdasarkan ID
        this.user = this.user.filter((item) => item.id_user !== this.selectedUserId);
      } else {
        throw new Error(response.data.message || 'Gagal menghapus pengguna');
      }
    } catch (error) {
      console.error('Error deleting user:', error);
      alert('Terjadi kesalahan saat menghapus pengguna.');
    } finally {
      // Reset modal dan ID pengguna
      this.showModal = false;
      this.selectedUserId = null;
    }
  },
    async fetchUser() {
      const maxRetries = 0
      let attempt = 0

      // Jika data sudah ada di cache, gunakan cache
      if (cachedUser) {
        this.setUserData(cachedUser)
        return
      }

      try {
        const response = await axios.get('http://localhost:8000/ListUser.php', {
          withCredentials: true, // Kirim cookies
        })
        if (response.data && response.data.users) {
          cachedUser = response.data.users
          this.setUserData(cachedUser)
        } else {
          console.error('Invalid API Response:', response.data)
          throw new Error('Invalid response')
        }
      } catch (error) {
        console.error(`Error fetching user data (attempt ${attempt}):`, error)
        if (attempt >= maxRetries) {
          console.error('Max retries reached. Unable to fetch user data.')
        }
      }
    },
    setUserData(data) {
      this.user = data
    },
  },
  created() {
    this.fetchUser()
  },
}
</script>

<template>
  <div class="container mx-auto">
    <div class="justify-end flex">
      <router-link
        to="/admin/tambahuser"
        type="submit"
        class="w-30align-middle px-4 py-2 text-white bg-[#F05529] rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
        ><VsxIcon iconName="Add" :size="24" color="white" type="linear" />
        Tambah pengguna
      </router-link>
    </div>
    <div class="grid mt-16">
      <div
        class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-4 border-2 rounded-t-2xl"
      >
        <div class="align-middle flex justify-center">
          <p>Nama Lengkap</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>NIM</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Role</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Aksi</p>
        </div>
      </div>
      <div
        v-for="(item, index) in user"
        class="grid py-3 gap-3 grid-cols-4 border-2 items-center"
      >
        <div class="align-middle flex justify-center">
          <p>{{ item.name }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nim }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.level }}</p>
        </div>
        <div class="align-middle flex gap-2 justify-center">
          <button
            type="submit"
            class="w-28 align-middle gap-2 border-2 px-4 py-2 text-black rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
          >
            <VsxIcon iconName="Edit" :size="24" color="black" type="linear" />
            Edit
          </button>
          <button
            @click="showDeleteModal(item.id)"
            type="submit"
            class="w-28 align-middle gap-2 px-4 py-2 text-white bg-[#F05529] rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
          >
            <VsxIcon iconName="Trash" :size="24" color="white" type="linear" />
            Hapus
          </button>
        </div>
      </div>
      <WarningModal
        :isVisible="showModal"
        title="Hapus Pengguna"
        confirmText="Hapus"
        message="Apakah Anda yakin ingin menghapus pengguna ini?"
        @confirm="deleteUser"
        @cancel="showModal = false"
      />
    </div>
  </div>
</template>

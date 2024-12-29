<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
import axios from '../api/api'
export default {
  methods: {
    async fetchRoomRequests() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get(
          'http://localhost:8000/PermintaanRuang.php',
          {
            withCredentials: true,
          },
        )

        if (response.data.status === 'success') {
          this.roomRequests = response.data.peminjaman
        } else {
          throw new Error(response.data.message || 'Failed to fetch data')
        }
      } catch (error) {
        console.error('Error fetching room requests:', error)
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
  },
  data() {
    return {
      roomRequests: [],
      loading: false,
      error: null,
    }
  },
  mounted() {
    setInterval(() => {
      this.fetchRoomRequests()
    },10000)
  },
  created() {
    this.fetchRoomRequests()
  },
}
</script>

<template>
  <NavbarComponent />
  <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
    <NavClassroom />
  </nav>
  <div class="container mx-auto overflow-hidden">
    <div
        class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-7  border-2 rounded-t-2xl"
      >
        <div class="align-middle flex justify-center">
          <p>Mata Kuliah</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Ruangan</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Hari</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Jam</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Kelas</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Nama Mahasiswa</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Aksi</p>
        </div>
      </div>
  <div
        v-for="(item, index) in roomRequests"
        class="grid py-3 gap-3 grid-cols-7 border-2 items-center"
        :key="`request-${index}`"
      >
        <div class="align-middle flex justify-center">
          <p>{{ item.matkul || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.ruangan || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nama_hari || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.waktu || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.kelas || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nama || 'N/A' }}</p>
        </div>
        <div class="align-middle flex gap-2 justify-center">
          <!-- Show status if already processed -->
          <div
            v-if="item.status !== 'belum acc'"
            :class="[
              'px-4 py-2 rounded-full text-white',
              item.status === 'disetujui' ? 'bg-green-500' : 'bg-red-500',
            ]"
          >
            {{ item.status }}
          </div>
          </div>
        </div>
  </div>
</template>

<style></style>

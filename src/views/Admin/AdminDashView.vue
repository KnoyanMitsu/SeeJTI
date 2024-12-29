<script setup>
import { VsxIcon } from 'vue-iconsax'
</script>

<script>
import axios from '../../api/api'

export default {
  data() {
    return {
      countMahasiswa: 0,
      countJadwal: 0,
      countRequest: 0,
      latestRequests: [],
      isLoading: true,
      error: null,
    }
  },
  methods: {
    async fetchLatestRequests() {
      try {
        console.log('Fetching latest requests...') // Debug log
        this.isLoading = true
        const response = await axios.get(
          'http://localhost:8000/LatestPeminjaman.php',
          {
            withCredentials: true,
          },
        )

        console.log('Response:', response.data) // Debug log

        if (response.data.status === 'success') {
          this.latestRequests = response.data.peminjaman
        } else {
          throw new Error(
            response.data.message || 'Failed to fetch latest requests',
          )
        }
      } catch (error) {
        console.error('Error fetching latest requests:', error)
        this.error = error.message
      } finally {
        this.isLoading = false
      }
    },

    async fetchMahasiswaCount() {
      try {
        const response = await axios.get(
          'http://localhost:8000/jumlahmahasiswa.php',
          {
            withCredentials: true,
          },
        )
        if (response.data && response.data.total) {
          this.countMahasiswa = parseInt(response.data.total)
        }
      } catch (error) {
        console.error('Error fetching mahasiswa count:', error)
      }
    },

    async fetchJadwalCount() {
      try {
        const response = await axios.get(
          'http://localhost:8000/jumlahjadwal.php',
          {
            withCredentials: true,
          },
        )
        if (response.data && response.data.total) {
          this.countJadwal = parseInt(response.data.total)
        }
      } catch (error) {
        console.error('Error fetching jadwal count:', error)
      }
    },

    async fetchRequestCount() {
      try {
        const response = await axios.get(
          'http://localhost:8000/jumlahrequest.php',
          {
            withCredentials: true,
          },
        )
        if (response.data && response.data.total) {
          this.countRequest = parseInt(response.data.total)
        }
      } catch (error) {
        console.error('Error fetching request count:', error)
      }
    },
  },
  async mounted() {
    console.log('Component mounted') // Debug log
    await this.fetchMahasiswaCount()
    await this.fetchJadwalCount()
    await this.fetchRequestCount()
    await this.fetchLatestRequests()
  },
}
</script>

<template>
  <div class="container mx-auto">
    <!-- Cards section -->
    <div class="grid gap-16 grid-cols-3">
      <router-link
        to="/admin/users"
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md cursor-pointer hover:bg-gray-50"
      >
        <VsxIcon iconName="People" :size="32" color="black" type="linear" />
        <h1 class="text-2xl font-bold font-sans">
          {{ countMahasiswa }} Mahasiswa
        </h1>
      </router-link>

      <router-link
        to="/admin/ruang"
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md cursor-pointer hover:bg-gray-50"
      >
        <VsxIcon
          iconName="MessageQuestion"
          :size="32"
          color="black"
          type="linear"
        />
        <h1 class="text-2xl font-bold font-sans">
          {{ countRequest }} Permintaan Peminjaman
        </h1>
      </router-link>

      <router-link
        to="/admin/jadwal"
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md cursor-pointer hover:bg-gray-50"
      >
        <VsxIcon iconName="Calendar" :size="32" color="black" type="linear" />
        <h1 class="text-2xl font-bold font-sans">
          {{ countJadwal }} Jadwal Aktif
        </h1>
      </router-link>
    </div>

    <!-- Loading state -->
    <div v-if="isLoading" class="text-center py-4">Loading...</div>

    <!-- Error state -->
    <div v-else-if="error" class="text-red-500 text-center py-4">
      {{ error }}
    </div>

    <!-- Latest Requests Table -->
    <div v-else class="grid mt-16">
      <div
        class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-6 border-2 rounded-t-2xl"
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
          <p>Status</p>
        </div>
      </div>

      <!-- Table Body -->
      <div
        v-for="(item, index) in latestRequests"
        :key="`request-${index}`"
        class="grid py-3 gap-3 grid-cols-6 border-2 items-center"
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
          <div
            :class="[
              'px-4 py-2 rounded-full text-white',
              item.status === 'disetujui'
                ? 'bg-green-500'
                : item.status === 'ditolak'
                  ? 'bg-red-500'
                  : 'bg-yellow-500',
            ]"
          >
            {{ item.status }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  padding: 1rem;
}
</style>

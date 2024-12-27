<script setup>
// import LoadingWidget from '@/widget/LoadingWidget.vue'
import { VsxIcon } from 'vue-iconsax'
</script>

<script>
import axios from '../../api/api'

let cachedMahasiswaCount = null // Cache untuk jumlah mahasiswa
let cachedRuangKosongCount = null // Cache untuk jumlah mahasiswa
let cachedJadwalCount = null

export default {
  data() {
    return {
      countMahasiswa: 0,
      countJadwal: 0,
      countRuangKosong: 0, // Jumlah mahasiswa
      isLoading: true, // Status loading
      error: null, // Simpan pesan error
    }
  },
  methods: {
    async fetchJadwalCount() {
      // Cek cache
      if (cachedJadwalCount !== null) {
        this.setJadwalCount(cachedJadwalCount)
        return
      }

      try {
        this.isLoading = true
        const response = await axios.get(
          'http://localhost:8000/jumlahjadwal.php',
          {
            withCredentials: true, // Kirim cookies jika diperlukan
          },
        )

        if (response.data && response.data.total) {
          cachedJadwalCount = parseInt(response.data.total, 10) // Simpan ke cache
          this.setJadwalCount(cachedJadwalCount)
        } else {
          throw new Error('Invalid response from server')
        }
      } catch (error) {
        console.error('Error fetching RuangKosong count:', error)
        this.error = 'Gagal memuat jumlah mahasiswa.'
      } finally {
        this.isLoading = false
      }
    },
    async fetchRuangKosongCount() {
      // Cek cache
      if (cachedRuangKosongCount !== null) {
        this.setRuangKosongCount(cachedRuangKosongCount)
        return
      }

      try {
        this.isLoading = true
        const response = await axios.get(
          'http://localhost:8000/jumlahruangkosong.php',
          {
            withCredentials: true, // Kirim cookies jika diperlukan
          },
        )

        if (response.data && response.data.total) {
          cachedRuangKosongCount = parseInt(response.data.total, 10) // Simpan ke cache
          this.setRuangKosongCount(cachedRuangKosongCount)
        } else {
          throw new Error('Invalid response from server')
        }
      } catch (error) {
        console.error('Error fetching RuangKosong count:', error)
        this.error = 'Gagal memuat jumlah mahasiswa.'
      } finally {
        this.isLoading = false
      }
    },
    async fetchMahasiswaCount() {
      // Cek cache
      if (cachedMahasiswaCount !== null) {
        this.setMahasiswaCount(cachedMahasiswaCount)
        return
      }

      try {
        this.isLoading = true
        const response = await axios.get(
          'http://localhost:8000/jumlahmahasiswa.php',
          {
            withCredentials: true, // Kirim cookies jika diperlukan
          },
        )

        if (response.data && response.data.total) {
          cachedMahasiswaCount = parseInt(response.data.total, 10) // Simpan ke cache
          this.setMahasiswaCount(cachedMahasiswaCount)
        } else {
          throw new Error('Invalid response from server')
        }
      } catch (error) {
        console.error('Error fetching mahasiswa count:', error)
        this.error = 'Gagal memuat jumlah mahasiswa.'
      } finally {
        this.isLoading = false
      }
    },
    setMahasiswaCount(count) {
      this.countMahasiswa = count // Set jumlah mahasiswa
    },
    setRuangKosongCount(count) {
      this.countRuangKosong= count // Set jumlah mahasiswa
    },
    setJadwalCount(count) {
      this.countJadwal= count // Set jumlah mahasiswa
    },
  },
  created() {
    this.fetchMahasiswaCount()
    this.fetchRuangKosongCount()
    this.fetchJadwalCount()

  },
}
</script>

<template>
  <div class="container mx-auto">
    <div class="grid gap-16 grid-cols-3">
      <router-link
        to="/admin/users"
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md cursor-pointer"
      >
        <VsxIcon iconName="People" :size="32" color="black" type="linear" />
        <h1 class="text-2xl font-bold font-sans">
          {{ countMahasiswa }} Mahasiswa
        </h1>
      </router-link>
      <div
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md"
      >
        <VsxIcon iconName="Buildings" :size="32" color="black" type="linear" />
        <h1 class="text-2xl font-bold font-sans">{{ countRuangKosong }} Ruang Kosong</h1>
      </div>
      <div
        class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md"
      >
        <VsxIcon iconName="Calendar" :size="32" color="black" type="linear" />
        <h1 class="text-2xl font-bold font-sans">{{ countJadwal }} Jadwal Aktif</h1>
      </div>
    </div>
    <div class="grid mt-16">
      <div class="grid py-3 gap-3 grid-cols-3 border-2 rounded-t-2xl">
        <div class="align-middle flex justify-center">
          <p>Nama Ruang</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Jam</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Kang Request</p>
        </div>
      </div>
      <div class="grid py-3 gap-3 grid-cols-3 border-2 rounded-b-2xl">
        <div class="align-middle flex justify-center">
          <p>Nama Ruang</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Jam</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Kang Request</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Nama Ruang</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Jam</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Kang Request</p>
        </div>
      </div>
    </div>
  </div>
</template>

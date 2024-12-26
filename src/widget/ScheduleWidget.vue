<script>
import Role from '@/controller/Role'
import axios from '../api/api'
export default {
  props: {
    nama: {
      type: String,
      required: true,
    },
    dosen: {
      type: String,
      required: true,
    },
    jam: {
      type: String,
      required: true,
    },
    kelas: {
      type: String,
      required: true,
    },
    ruang: {
      type: String,
      required: true,
    },
    status: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      role: '',
      selectedOption: null,
    }
  },
  mounted() {
    const roleInstance = new Role()
    setInterval(() => {
      this.role = roleInstance.role
    }, 1000)
    this.selectOption(this.status)
  },
  methods: {
    async selectOption(option) {
      this.loading = true
      this.selectedOption = option
      try {
        const response = await axios.post(
          'http://localhost:8000/updateStatus.php',
          {
            ruang: this.ruang,
            kelas: this.kelas,
            status: option,
          },
          {
            withCredentials: true,
          },
        )
        if (response.data === 'Berhasil') {
          this.$emit('refresh')
        }
      } catch (error) {
        console.log(error)
        this.loading = false
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

<template>
  <div class="bg-white shadow-md rounded-md mx-auto lg:w-full mb-7">
    <div class="ml-5 mr-4">
      <h1 class="text-3xl font-bold mt-7">{{ nama }}</h1>
      <p class="font-bold text-gray-600 mt-3">{{ dosen }}</p>
      <div class="grid grid-cols-2 gap-4 mt-3">
        <div
          class="inline-flex border-2 border-dashed border-yellow-300 p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Kelas:</p>
          <p class="font-bold ml-2">{{ kelas }}</p>
        </div>
        <div
          class="inline-flex border-2 border-dashed border-yellow-300 p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Jam:</p>
          <p class="font-bold ml-2">{{ jam }}</p>
        </div>
        <div
          class="inline-flex border-2 border-dashed border-yellow-300 p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Ruang:</p>
          <p class="font-bold ml-2">{{ ruang }}</p>
        </div>
      </div>
    </div>
    <div
      v-if="role === 'mahasiswa'"
      class="mt-8 p-3 text-center font-semibold"
      :class="{
        'bg-red-600 text-white': selectedOption === 'Tidak Ada',
        'bg-green-600 text-white': selectedOption === 'Ada',
      }"
    >
      <p v-if="selectedOption === 'Ada'" class="text-white inline_block">Kuliah Ada</p>
      <p v-if="selectedOption === 'Tidak Ada'" class="text-white inline_block">Tidak Ada Kuliah</p>
    </div>
    <div v-if="role === 'ketua'" class="mb-2">
      <hr class="mt-8" />
      <div
        class="p-3 mt-2 h-full text-center font-semibold grid grid-cols-2 gap-4"
      >
        <button
          @click="selectOption('Tidak Ada')"
          :class="{
            'bg-red-600 text-white': selectedOption === 'Tidak Ada',
            'cursor-not-allowed': loading,
          }"
          class="p-3 rounded-md font-semibold"
        >
          Tidak Ada Kuliah
        </button>
        <button
          @click="selectOption('Ada')"
          :class="{
            'bg-green-600 text-white': selectedOption === 'Ada',
            'cursor-not-allowed': loading,
          }"
          class="p-3 rounded-md font-semibold"
        >
          Kuliah Ada
        </button>
      </div>
      <div class="mt-30 bg-gray-200 rounded-md">
        <div
          :class="{
            'bg-red-600': selectedOption === 'Tidak Ada',
            'bg-green-600': selectedOption === 'Ada',
          }"
          :style="{
            width: selectedOption ? '100%' : '0%',
          }"
          class="h-4 rounded-md"
        ></div>
      </div>
    </div>
  </div>
</template>

<style>
button {
  transition: all 0.3s ease;
}
</style>

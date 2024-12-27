<script setup></script>

<script>
import axios from '../../api/api'
export default {
  data() {
    return {
      tableHeaders: [], // Untuk header tabel
      tableData: [], // Untuk data isi tabel
      showconfirmmodal: false,
      selectedFile: null,
      uploadMessage: '',
      uploadSuccess: false,
    }
  },
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0]
      if (!file || file.type !== 'text/csv') {
        this.uploadMessage = 'Harap unggah file CSV yang valid.'
        return
      }
      this.selectedFile = file

      const reader = new FileReader()
      reader.onload = e => {
        const text = e.target.result
        this.parseCSV(text)
      }
      reader.readAsText(file)
    },
    async uploadCSV() {
      if (!this.selectedFile) {
        this.uploadMessage = 'Silakan pilih file CSV.'
        this.uploadSuccess = false
        return
      }

      const formData = new FormData()
      formData.append('csvFile', this.selectedFile)

      try {
        const response = await axios.post(
          'http://localhost:8000/dangerousAPI/importUser.php',
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          },
        )

        this.uploadMessage = response.data.message
        this.uploadSuccess = response.data.success
        this.$router.push({ name: 'users' }).then(() => {
          this.$nextTick(() => {
            this.fetchUser()
          })
        })
      } catch (error) {
        console.error('Error saat upload:', error)
        this.uploadMessage = 'Gagal mengunggah file CSV.'
        this.uploadSuccess = false
      }
    },
    parseCSV(data) {
      const rows = data.split('\n') // Pisahkan setiap baris
      this.tableHeaders = rows[0].split(',') // Header adalah baris pertama
      this.tableData = rows.slice(1).map(row => row.split(',')) // Data adalah baris setelah header
    },
  },
}
</script>

<template>
  <div class="container mx-auto">
    <h1 class="text-2xl font-bold">Import CSV ke User</h1>
    <p class="mb-5 text-red-900">
      Peringatan: Pastikan anda melakukan backup terlebih dahulu dengan Export
      User ke CSV
    </p>
    <div class="justify-between">
      <form @submit.prevent="uploadCSV">
        <p
          v-if="uploadMessage"
          :class="{ success: uploadSuccess, error: !uploadSuccess }"
        >
          {{ uploadMessage }}
        </p>
        <div class="flex mb-8 items-center justify-center w-full">
          <label
            for="dropzone-file"
            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50"
          >
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg
                class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 16"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                />
              </svg>
              <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="font-semibold">Klik untuk upload</span>
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                hanya support format: CSV
              </p>
            </div>
            <input
              id="dropzone-file"
              type="file"
              @change="handleFileUpload"
              accept=".csv"
              class="hidden"
            />
          </label>
        </div>
        <div v-if="tableData.length" class="flex justify-end gap-6">
          <button
            type="submit"
            class="px-6 py-2 bg-[#F05529] text-white rounded-lg hover:bg-[#FCAA93] hover:text-[#F05529] focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Upload
          </button>
        </div>
      </form>
      <div>
        <div v-if="tableData.length">
          <h1 class="text-2xl font-bold">Preview dari CSV User</h1>
          <p>Total User: {{ tableData.length - 1 }}</p>
          <p class="mb-8">
            Perlu diperhatikan jika data tidak sesuai maka datanya salah
          </p>
          <div>
            <div
              class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-6 border-2 rounded-t-2xl"
            >
              <div class="align-middle flex justify-center">username</div>
              <div class="align-middle flex justify-center">password</div>
              <div class="align-middle flex justify-center">nama</div>
              <div class="align-middle flex justify-center">nim</div>
              <div class="align-middle flex justify-center">kelas</div>
              <div class="align-middle flex justify-center">role</div>
            </div>
          </div>
          <div>
            <div
              class="grid py-3 gap-3 grid-cols-6 border-2 items-center"
              v-for="(row, rowIndex) in tableData"
              :key="rowIndex"
            >
              <div
                class="align-middle flex justify-center"
                v-for="(cell, cellIndex) in row"
                :key="cellIndex"
              >
                {{ cell }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

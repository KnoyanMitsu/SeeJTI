<script>
import Role from '@/controller/Role'
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
  },
  data() {
    return {
      role: '',
    }
  },
  mounted() {
    const roleInstance = new Role()
    setInterval(() => {
      this.role = roleInstance.role
    })
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
      class="mt-8 p-3 text-center font-semibold bg-[#00CB1E]"
    >
      <p class="text-white inline_block">Kuliah Ada</p>
    </div>
    <div class="mb-2" v-if="role === 'ketua'">
      <hr class="mt-8" />
      <div class="p-3  mt-2 text-center font-semibold grid grid-cols-2">
        <p class="text-red-600 inline_block">Tidak ada Kuliah</p>
        <p class="text-green-600 inline_block">Kuliah Ada</p>
      </div>
    </div>
  </div>
</template>

<style></style>

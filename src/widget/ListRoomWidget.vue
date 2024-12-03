<script>
import Role from '@/controller/Role'
export default {
  props: {
    jam: {
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
      <h1 class="text-3xl font-bold mt-7">{{ ruang }}</h1>
      <p class="font-bold text-gray-600 mt-3">{{ ruang }}</p>
      <div
        class="inline-flex border-2 border-dashed border-yellow-300 p-2 rounded-md items-center"
      >
        <p class="font-bold text-gray-600">Jam:</p>
        <p class="font-bold ml-2">{{ jam }}</p>
      </div>
    </div>
  </div>
</template>

<style></style>

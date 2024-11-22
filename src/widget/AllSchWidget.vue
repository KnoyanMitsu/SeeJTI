<script>
export default{
  props:{
    nama:{
      type: String,
      required: true
    },
    jam:{
      type: String,
      required: true
    },
    kelas:{
      type: String,
      required: true
    },
    ruang:{
      type: String,
      required: true
    }
  }
}
</script>


<template>
  <div class=" mx-auto w-full mb-7   ">
    <div class="ml-5 mr-4 mb-7">
      <h1 class="text-3xl font-bold mt-7">{{ nama }}</h1>
      <p class="font-bold text-gray-600 mt-3">RPP - Tatap Muka</p>
      <div class="grid grid-cols-2 gap-4 mt-3">
        <div
          class="inline-flex border-2 border-dashed border-yellow-300 p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Kelas:</p>
          <p class="font-bold ml-2">{{ kelas }}</p>
        </div>
        <div
          class="inline-flex border-2 border-dashed border-yellow-300  p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Jam:</p>
          <p class="font-bold ml-2">{{ jam }}</p>
        </div>
        <div
          class="inline-flex border-2 border-dashed border-yellow-300  p-2 rounded-md items-center"
        >
          <p class="font-bold text-gray-600">Ruang:</p>
          <p class="font-bold ml-2">{{ ruang }}</p>
        </div>
      </div>
    </div>
  </div>
</template>


<style>

</style>

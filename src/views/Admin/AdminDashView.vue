<script setup>
import LoadingWidget from '@/widget/LoadingWidget.vue'
import { VsxIcon } from 'vue-iconsax'

</script>

<script> 

</script>

<template>
  <div class ="container mx-auto">
  <div class="grid gap-16 grid-cols-3 ">
    <div class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md ">
      <VsxIcon iconName="People" :size="32" color="black" type="linear" />
      <h1 class="text-2xl font-bold font-sans">100 Mahasiswa</h1>
    </div>
    <div class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md  ">
      <VsxIcon iconName="Buildings" :size="32" color="black" type="linear" />
      <h1 class="text-2xl font-bold font-sans">2 Ruang Kosong</h1>
    </div>
    <div class="h-36 gap-5 items-center justify-center flex w-auto border-2 rounded-2xl shadow-md ">
      <VsxIcon iconName="Calendar" :size="32" color="black" type="linear" />
      <h1 class="text-2xl font-bold font-sans">50 Jadwal Aktif</h1>
    </div>
  </div>
  <div class="grid mt-16">
    <div class ="grid py-3 gap-3 grid-cols-3 border-2 rounded-t-2xl">
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
    <div class ="grid py-3 gap-3 grid-cols-3 border-2 rounded-b-2xl">
      
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

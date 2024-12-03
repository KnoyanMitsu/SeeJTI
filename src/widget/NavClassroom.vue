<template>
  <div class="flex">

  </div>
  <div class="flex text-white font-bold items-center text-center mb-3 mt-3">
    <ul class="font-semibold flex col gap-16">
      <li class="flex items-center gap-2">
          <vs-icon icon="home"></vs-icon>
          <router-link to="/">Home</router-link>
      </li>
      <li class="flex items-center gap-2">
        <vs-icon icon="book"></vs-icon>
        <router-link to="/jadwal/kelas">Jadwal Perkuliahan</router-link>
      </li>
      <li class="flex items-center gap-2">
          <vs-icon icon="domain"></vs-icon>
          <router-link to="/jadwal/kosong">Ruang kosong</router-link>
      </li>
    </ul>
  </div>
  <div class="flex"></div>
</template>

<script setup>
import { VsxIcon } from 'vue-iconsax';
</script>

<script>
import Role from '@/controller/Role';

export default {
  data() {
    return {
      role: '',
    };
  },
  mounted() {
    const roleInstance = new Role();
    setInterval(() => {
      this.role = roleInstance.role;
    })
  }
};
</script>
<template>
  <div class="flex">

  </div>
  <div class="flex text-white font-bold items-center text-center mb-3 mt-3">
    <ul class="font-semibold flex col gap-16">
      <li class="flex items-center gap-2">
          <VsxIcon iconName="Home2" class="inline-block" :size="24" type="bold" />
          <router-link to="/">Home</router-link>
      </li>
      <li class="flex items-center gap-2">
        <VsxIcon iconName="Book1" class="inline-block" :size="24" type="bold" />
        <router-link to="/jadwal/kelas">Jadwal Perkuliahan</router-link>
      </li>
      <li v-if="role === 'ketua'" class="flex items-center gap-2">
        <VsxIcon iconName="Building" class="inline-block" :size="24" type="bold" />
          <router-link to="/jadwal/kosong">Ruang kosong</router-link>
      </li>
    </ul>
  </div>
  <div class="flex"></div>
</template>

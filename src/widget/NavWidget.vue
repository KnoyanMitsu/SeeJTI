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

<template v-if="role === 'ketua'" >
  <div class="grid lg:grid-cols-2 gap-4 mx-auto md:grid-cols-2">
    <router-link to="/jadwal/kelas" class="w-60 bg-white rounded-md shadow-md">
      <div class="flex flex-col ml-7">
        <div class="text-gray-700 mb-2 mt-7">
          <vs-icon icon="book"></vs-icon>
        </div>

      <p class="text-2xl font-semibold text-gray-800">
          Jadwal <br />
          Perkuliahan
        </p>
      </div>
      <div class="flex mt-7">
        <div class="h-1 w-1/3 bg-blue-900"></div>
        <div class="h-1 w-1/3 bg-orange-500"></div>
        <div class="h-1 w-1/3 bg-yellow-500"></div>
      </div>
    </router-link>

    <div>

      <router-link to="jadwal/kosong">
        <div class="w-60 bg-white rounded-lg shadow-md">
          <div class="flex flex-col ml-7">
            <div class="text-gray-700 mb-2 mt-7">
              <vs-icon icon="building"></vs-icon>
            </div>
            <p class="text-2xl font-semibold text-gray-800">
              Ruang <br />
              Kosong
            </p>
          </div>
          <div class="flex mt-7">
            <div class="h-1 w-1/3 bg-blue-900"></div>
            <div class="h-1 w-1/3 bg-orange-500"></div>
            <div class="h-1 w-1/3 bg-yellow-500"></div>
          </div>
        </div>
      </router-link>
    </div>
  </div>
</template>

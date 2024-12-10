<script setup>
import { VsxIcon } from 'vue-iconsax'
</script>

<template>
  <div class="h-screen w-80 p-4">
    <div class="flex flex-col justify-between h-full">
      <div>
        <ul class="mt-4">
          <li class="my-2">
            <router-link
              to="/admin/dashboard"
              class="block p-5 hover:bg-gray-700 hover:text-white rounded-md"
            >
              <VsxIcon
                iconName="Home2"
                class="inline-block"
                :size="24"
                color="#0E1F43"
                type="bold"
              />
              <p class="inline-block ml-2">Beranda</p>
            </router-link>
          </li>
          <li class="my-2">
            <router-link
              to="/admin/jadwal"
              class="block p-5 hover:bg-gray-700 hover:text-white rounded-md"
            >
              <VsxIcon
                iconName="Book1"
                class="inline-block"
                :size="24"
                color="#0E1F43"
                type="bold"
              />
              <p class="inline-block ml-2">Jadwal</p>
            </router-link>
          </li>
          <li class="my-2">
            <router-link
              to="/admin/ruang"
              class="block p-5 hover:bg-gray-700 hover:text-white rounded-md"
            >
              <VsxIcon
                iconName="Building"
                class="inline-block"
                :size="24"
                color="#0E1F43"
                type="bold"
              />
              <p class="inline-block ml-2">Ruang Kosong</p>
            </router-link>
          </li>
          <li class="my-2">
            <div class="relative">
              <div to="/admin/users" class="block p-1 px-5 rounded-md">
                <VsxIcon
                  iconName="FolderAdd"
                  class="inline-block"
                  :size="24"
                  color="#0E1F43"
                  type="bold"
                />
                <p class="inline-block ml-2">Data</p>
              </div>
              <div class="absolute right-0 w-60 py-1 px-2 text-sm">
                <router-link
                  to="/admin/users"
                  class="block p-2 my-2 hover:bg-gray-700 hover:text-white rounded-md"
                >
                  <VsxIcon
                    iconName="UserEdit"
                    class="inline-block"
                    :size="24"
                    color="#0E1F43"
                    type="bold"
                  />
                  <p class="inline-block ml-2">Edit Data User</p></router-link
                >
                <router-link
                  to="/admin/calendar"
                  class="block p-2 my-2 hover:bg-gray-700 hover:text-white rounded-md"
                >
                  <VsxIcon
                    iconName="NoteAdd"
                    class="inline-block"
                    :size="24"
                    color="#0E1F43"
                    type="bold"
                  />
                  <p class="inline-block ml-2">Tambah Jadwal</p></router-link
                >
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped>
.router-link-active {
  background-color: #f3f6f9;
}
.router-link-active:hover {
  color: black;
}
</style>

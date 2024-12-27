<script setup>
// import LoadingWidget from '@/widget/LoadingWidget.vue'
import { VsxIcon } from 'vue-iconsax'
import WarningModal from './Widget/WarningModal.vue'
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
</script>
<script>
import axios from '../../api/api'
let cachedUser = null
export default {
  mounted() {
    this.fetchUser();
  },
  data() {
    return {
      user: [],
      success: false,
      showModal: false,
      selectedUserId: null,
      showDangerousModal: false,
      finalRegret: false,
      lastResort: false
    }
  },
  methods: {
    async exportCSV() {
      try {
        const response = await axios.get("http://localhost:8000/exportUser.php", {
          responseType: "blob", // Respons file biner
        });

        const blob = new Blob([response.data], { type: "text/csv" });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "user.csv");
        document.body.appendChild(link);
        link.click();
        link.remove();
      } catch (error) {
        console.error("Gagal mengekspor CSV:", error);
      }
    },
    async DeleteAll() {
      try {
        const response = await axios.delete('http://localhost:8000/dangerousAPI/deleteAllUser.php', {}, {
          headers: {
            'Content-Type': 'application/json', // Pastikan header sesuai
          },
          withCredentials: true, // Kirim cookies jika diperlukan
        });
        if (response.data && response.data.status === 'success') {
          alert(response.data.message || 'Pengguna berhasil dihapus');
          this.user = [];
          this.fetchUser();
          this.lastResort = false
          window.location.reload()
        } else {
          this.lastResort = false
          alert(response.data.message || 'Gagal menghapus pengguna');
          throw new Error(response.data.message || 'Gagal menghapus pengguna');
        }
      } catch (error) {
        console.error('Gagal menghapus pengguna:', error);
      }
    },
    showDeleteModal(userId) {
    this.selectedUserId = userId; // Simpan ID pengguna
    this.showModal = true; // Tampilkan modal
  },

  showDeleteAllModal() {
    this.showDangerousModal = true;
  },
  showLastResortModal() {
    this.finalRegret = true
  },
  showTheLastResortModal() {
    this.lastResort = true
  },
    async deleteUser() {
    if (!this.selectedUserId) {
      alert("ID pengguna tidak valid!");
      return;
    }

    const payload = {
      id_user: this.selectedUserId, // Data yang dikirim sesuai format JSON
    };

    try {
      const response = await axios.post('http://localhost:8000/DeleteUser.php', payload, {
        headers: {
          'Content-Type': 'application/json', // Pastikan header sesuai
        },
        withCredentials: true, // Kirim cookies jika diperlukan
      });

      if (response.data && response.data.status === 'success') {
        alert(response.data.message || 'Pengguna berhasil dihapus');
        // Hapus pengguna dari daftar berdasarkan ID
        this.fetchUser()
        this.user = this.user.filter((item) => item.id_user !== this.selectedUserId);
      } else {
        throw new Error(response.data.message || 'Gagal menghapus pengguna');
      }
    } catch (error) {
      console.error('Error deleting user:', error);
      alert('Terjadi kesalahan saat menghapus pengguna.');
    } finally {
      // Reset modal dan ID pengguna
      this.showModal = false;
      this.selectedUserId = null;
    }
  },
    async fetchUser() {
      const maxRetries = 0
      let attempt = 0

      // Jika data sudah ada di cache, gunakan cache
      if (cachedUser) {
        this.setUserData(cachedUser)
        return
      }

      try {
        const response = await axios.get('http://localhost:8000/ListUser.php', {
          withCredentials: true, // Kirim cookies
        })
        if (response.data && response.data.users) {
          cachedUser = response.data.users
          this.setUserData(cachedUser)
        } else {
          console.error('Invalid API Response:', response.data)
          throw new Error('Invalid response')
        }
      } catch (error) {
        console.error(`Error fetching user data (attempt ${attempt}):`, error)
        if (attempt >= maxRetries) {
          console.error('Max retries reached. Unable to fetch user data.')
        }
      }
    },
    setUserData(data) {
      this.user = data
    },
  },
  created() {
    this.fetchUser()
  },

}
</script>

<template>
  <div class="container mx-auto">
    <div class="justify-end flex">
      <router-link
        to="/admin/tambahuser"
        type="submit"
        class="w-30align-middle px-4 py-2 text-white bg-[#F05529] rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
        ><VsxIcon iconName="Add" :size="24" color="white" type="linear" />
        Tambah pengguna
      </router-link>
      <div class="flex gap-5">
          <Menu as="button" class="relative ml-3">
            <MenuButton as="button" class="">
              <VsxIcon
                class="inline-block "
                iconName="HambergerMenu"
                :size="32"
                color="black"
                type="bulk"

              />
              <p class="inline-block ml-2 tracking-tight py-2 font-bold">Menu</p>
            </MenuButton>
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems
                class="absolute right-0 z-30 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
              >
                <div class="py-1">
                  <MenuItems>
                    <div class="">
                      <button
                        @click="exportCSV"
                        :class="[
                          'text-gray-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Export User ke CSV
                      </button>
                      <hr />
                      <p
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Zona Berbahaya
                      </p>
                      <hr />
                      <router-link
                        to="/admin/importuser"
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Import user ke CSV (Hapus kecuali admin dan tambah semua user)
                      </router-link>
                      <button
                        @click="showDeleteAllModal()"
                        :class="[
                          'text-red-700',
                          'block w-full px-4 py-2 text-left text-sm',
                        ]"
                      >
                        Hapus semua user
                      </button>
                    </div>
                  </MenuItems>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </div>
    </div>
    <div class="grid mt-16">
      <div
        class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-4 border-2 rounded-t-2xl"
      >
        <div class="align-middle flex justify-center">
          <p>Nama Lengkap</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>NIM</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Role</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Aksi</p>
        </div>
      </div>
      <div
        v-for="(item, index) in user"
        class="grid py-3 gap-3 grid-cols-4 border-2 items-center"
        :key="`${user}-${index}`"
      >
        <div class="align-middle flex justify-center">
          <p>{{ item.name }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nim }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.level }}</p>
        </div>
        <div class="align-middle flex gap-2 justify-center">
          <button
            type="submit"
            class="w-28 align-middle gap-2 border-2 px-4 py-2 text-black rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
          >
            <VsxIcon iconName="Edit" :size="24" color="black" type="linear" />
            Edit
          </button>
          <button
            @click="showDeleteModal(item.id)"
            type="submit"
            class="w-28 align-middle gap-2 px-4 py-2 text-white bg-[#F05529] rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
          >
            <VsxIcon iconName="Trash" :size="24" color="white" type="linear" />
            Hapus
          </button>
        </div>
      </div>
      <WarningModal
        :isVisible="showModal"
        title="Hapus Pengguna"
        confirmText="Hapus"
        message="Apakah Anda yakin ingin menghapus pengguna ini?"
        @confirm="deleteUser"
        @cancel="showModal = false"
      />
      <WarningModal
        :isVisible="showDangerousModal"
        title="Hapus Semua User"
        confirmText="Hapus"
        message="Apakah Anda yakin ingin menghapus semua user?"
        @confirm="showLastResortModal()"
        @cancel="showDangerousModal = false"
      />
      <WarningModal
        :isVisible="finalRegret"
        title="PERINGATAN TERAKHIR"
        confirmText="Hapus"
        message="Apa kamu benar benar yakin? ini membuat semua user dihapus secara permanen dan tidak dapat dikembalikan. jika ingin menghapus pastikan Anda sudah Export user ke CSV. Apakah Anda yakin ingin menghapus semua user?"
        @confirm="showTheLastResortModal()"
        @cancel="finalRegret = false"
      />
      <WarningModal
        :isVisible="lastResort"
        title="LAST RESORT!!!!!!"
        confirmText="Hapus"
        message="Peringatan terakhir. ini membuat semua user dihapus secara permanen dan tidak dapat dikembalikan. jika ingin menghapus pastikan Anda sudah Export user ke CSV. Apakah Anda yakin ingin menghapus semua user?"
        @confirm="DeleteAll()"
        @cancel="lastResort = false"
      />
    </div>
  </div>
</template>

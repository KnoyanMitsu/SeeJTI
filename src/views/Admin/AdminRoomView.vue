<script setup>
import { VsxIcon } from 'vue-iconsax'
import WarningModal from './Widget/WarningModal.vue'
</script>

<script>
import axios from '../../api/api'

export default {
  name: 'AdminRoomView',
  data() {
    return {
      roomRequests: [],
      showModal: false,
      selectedRequestId: null,
      loading: false,
      error: null,
      modalAction: null,
      modalTitle: '',
      modalMessage: '',
      modalConfirmText: '',
    }
  },
  methods: {
    async fetchRoomRequests() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get(
          'http://localhost:8000/PermintaanRuang.php',
          {
            withCredentials: true,
          },
        )

        if (response.data.status === 'success') {
          this.roomRequests = response.data.peminjaman
        } else {
          throw new Error(response.data.message || 'Failed to fetch data')
        }
      } catch (error) {
        console.error('Error fetching room requests:', error)
        this.error = error.message
      } finally {
        this.loading = false
      }
    },

    approveRequest(requestId) {
      console.log('Approving request:', requestId)
      this.selectedRequestId = requestId
      this.modalAction = 'approve'
      this.modalTitle = 'Setujui Permintaan'
      this.modalMessage =
        'Apakah Anda yakin ingin menyetujui permintaan ruang ini?'
      this.modalConfirmText = 'Setujui'
      this.showModal = true
    },

    rejectRequest(requestId) {
      console.log('Rejecting request:', requestId)
      this.selectedRequestId = requestId
      this.modalAction = 'reject'
      this.modalTitle = 'Tolak Permintaan'
      this.modalMessage =
        'Apakah Anda yakin ingin menolak permintaan ruang ini?'
      this.modalConfirmText = 'Tolak'
      this.showModal = true
    },

    async handleModalConfirm() {
      try {
        const status = this.modalAction === 'approve' ? 'disetujui' : 'ditolak'
        console.log('Sending request with:', {
          id_peminjaman: this.selectedRequestId,
          status: status,
        })

        const response = await axios.post(
          'http://localhost:8000/UpdateStatusPeminjaman.php',
          {
            id_peminjaman: this.selectedRequestId,
            status: status,
          },
          {
            withCredentials: true,
            headers: {
              'Content-Type': 'application/json',
            },
          },
        )

        if (response.data.status === 'success') {
          // Update local data
          const index = this.roomRequests.findIndex(
            item => item.id_peminjaman === this.selectedRequestId,
          )
          if (index !== -1) {
            this.roomRequests[index].status = status
          }
          // Tambahkan alert sukses
          alert('Status berhasil diperbarui')
        } else {
          throw new Error(response.data.message || 'Failed to update status')
        }
      } catch (error) {
        console.error('Error updating request:', error)
        this.error = error.message
        // Tambahkan alert error
        alert('Gagal memperbarui status: ' + error.message)
      } finally {
        this.showModal = false
        this.selectedRequestId = null
        this.modalAction = null
      }
    },
  },
  mounted() {
    setInterval(() => {
      this.fetchRoomRequests()
    },10000)
  },
  created() {
    this.fetchRoomRequests()
  },
}
</script>

<template>
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Permintaan Ruang</h2>

    <!-- Loading state -->
    <div v-if="loading" class="text-center py-4">Loading...</div>

    <!-- Error state -->
    <div v-else-if="error" class="text-red-500 text-center py-4">
      {{ error }}
    </div>

    <!-- Data table -->
    <div v-else class="grid mt-16 overflow-hidden">
      <!-- Table Header -->
      <div
        class="bg-[#FFD6CA] grid py-3 gap-3 grid-cols-7 border-2 rounded-t-2xl"
      >
        <div class="align-middle flex justify-center">
          <p>Mata Kuliah</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Ruangan</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Hari</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Jam</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Kelas</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Nama Mahasiswa</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>Aksi</p>
        </div>
      </div>

      <!-- Table Body -->
      <div
        v-for="(item, index) in roomRequests"
        class="grid py-3 gap-3 grid-cols-7 border-2 items-center"
        :key="`request-${index}`"
      >
        <div class="align-middle flex justify-center">
          <p>{{ item.matkul || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.ruangan || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nama_hari || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.waktu || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.kelas || 'N/A' }}</p>
        </div>
        <div class="align-middle flex justify-center">
          <p>{{ item.nama || 'N/A' }}</p>
        </div>
        <div class="align-middle flex gap-2 justify-center">
          <!-- Show status if already processed -->
          <div
            v-if="item.status !== 'Pending'"
            :class="[
              'px-4 py-2 rounded-full text-white',
              item.status === 'disetujui' ? 'bg-green-500' : 'bg-red-500',
            ]"
          >
            {{ item.status }}
          </div>

          <!-- Show action buttons if not yet processed -->
          <template v-else>
            <button
              @click="approveRequest(item.id_peminjaman)"
              type="button"
              class="w-28 align-middle gap-2 px-4 py-2 text-white bg-green-500 rounded-full hover:bg-green-600 flex items-center justify-center space-x-2"
            >
              <VsxIcon
                iconName="TickCircle"
                :size="24"
                color="white"
                type="linear"
              />
              Setujui
            </button>
            <button
              @click="rejectRequest(item.id_peminjaman)"
              type="button"
              class="w-28 align-middle gap-2 px-4 py-2 text-white bg-[#F05529] rounded-full hover:bg-[#FEA127] flex items-center justify-center space-x-2"
            >
              <VsxIcon
                iconName="CloseCircle"
                :size="24"
                color="white"
                type="linear"
              />
              Tolak
            </button>
          </template>
        </div>
      </div>
    </div>

    <!-- Warning Modal for actions -->
    <WarningModal
      :isVisible="showModal"
      :title="modalTitle"
      :confirmText="modalConfirmText"
      :message="modalMessage"
      @confirm="handleModalConfirm"
      @cancel="showModal = false"
    />
  </div>
</template>

<style scoped>
.container {
  padding: 1rem;
}
</style>

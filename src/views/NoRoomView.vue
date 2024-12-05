<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import Calendar from '@/widget/CalendarWidget.vue'
import ListRoomWidget from '@/widget/ListRoomWidget.vue'
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { ref } from 'vue'
// import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

// Kontrol visibilitas dialog
const open = ref(false)
export default {
  mounted() {
    const clockInstance = new Date()

    setInterval(() => {
      this.year = clockInstance.year
      this.month = clockInstance.month
      this.day = clockInstance.date
    }, 1)
  },
  data() {
    return {
      year: '',
      month: '',
      day: '',
    }
  },
  components: {
    Calendar,
  },
}
</script>

<template>
  <NavbarComponent />
  <nav class="flex bg-[#0E1F43] item-center justify-between flex-warp p mb-10">
    <NavClassroom />
  </nav>

  <div
    class="xl:grid xl:grid-cols-2 md:grid-cols-1 container mx-auto grid-flow-col gap-x-32 md:gap-x-32"
  >
    <div class="col-span-1">
      <p class="font-semibold text-lg mb-5">{{ month }}</p>

      <Calendar :year="year" :month="month" />
    </div>
    <div class="md:mt-5">
      <div>
        <h1 class="font-semibold text-lg mb-2">Ruang Kosong</h1>
        <p class="text-[#7A7979]">{{ day }}</p>
      </div>
      <div>
        <div
          class="grid mt-6 gap-5 2xl:grid-cols-3 lg:mx-20 lg:grid-cols-2 md:grid-cols-1 col-span-2"
        >
          <ListRoomWidget
            v-for="(item, index) in filteredDay"
            :key="index"
            :jam="item.time"
            :ruang="item.room"
          />
        </div>
        <p>Ruang yang dipilih</p>
        <p class="font-semibold">None</p>
      </div>
      <div class="flex justify-end">
        <button
          @click="open = true"
          type="submit"
          class="px-4 py-2 text-white bg-[#F05529] rounded-md hover:bg-[#FEA127]"
        >
          Request Pindah Ruang
        </button>
      </div>
    </div>
  </div>

  <!-- Dialog -->
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="open = false">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <p class="mb-3">Nama Matkul</p>
                <select name="room" id="" class="bg-gray-100 rounded-md mb-4 w-full">
                  <option value="sim">Test</option>
                </select>
                <p class="mb-3">Nama Ruang</p>
                <select name="room" id="" class="bg-gray-100 rounded-md mb-4 w-full">
                  <option value="sim">Test</option>
                </select>
                <p class="mb-3">Hari</p>
                <input type="text" class="bg-gray-100 rounded-md mb-4 w-full" />
                <p class="mb-3">Jam</p>
                <div class="flex">
                  <input type="text" class="bg-gray-100 rounded-md mb-4 w-full mr-3" />
                  <input type="text" class="bg-gray-100 rounded-md mb-4 w-full" />
                </div>
                <p class="mb-3">Kelas</p>
                <input type="text" class="bg-gray-100 rounded-md mb-4 w-full" />
              </div>

              <div class="bg-white px-4 py-3 sm:flex justify-center sm:px-6">
                <button
                  @click="open = true"
                  type="submit"
                  class="px-4 py-2 text-white bg-[#F05529] rounded-full mb-4 hover:bg-[#FEA127]"
                >
                  Kirim Permintaan
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<style></style>

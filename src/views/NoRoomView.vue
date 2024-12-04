<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import Calendar from '@/widget/CalendarWidget.vue'
import ListRoomWidget from '@/widget/ListRoomWidget.vue'
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
import { ref } from 'vue'
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

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
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <ExclamationTriangleIcon
                      class="size-6 text-red-600"
                      aria-hidden="true"
                    />
                  </div>
                  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <DialogTitle
                      as="h3"
                      class="text-base font-semibold text-gray-900"
                    >
                      Deactivate account
                    </DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        Are you sure you want to deactivate your account? All of
                        your data will be permanently removed. This action
                        cannot be undone.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button
                  type="button"
                  class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                  @click="open = false"
                >
                  Deactivate
                </button>
                <button
                  type="button"
                  class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                  @click="open = false"
                  ref="cancelButtonRef"
                >
                  Cancel
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

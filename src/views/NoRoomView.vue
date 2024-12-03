<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import Calendar from '@/widget/CalendarWidget.vue'
import NavClassroom from '@/widget/NavClassroom.vue';
import ListRoomWidget from '@/widget/ListRoomWidget.vue';
</script>

<script>
export default {
  mounted() {
    const clockInstance = new Date()

    setInterval(() => {
      this.year = clockInstance.year
      this.month = clockInstance.month
      this.day = clockInstance.date
    },1)
  },
  data() {
    return {
      year: '',
      month: '',
      day: ''
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
      <NavClassroom/>
  </nav>

  <div class="xl:grid xl:grid-cols-2 md:grid-cols-1 container mx-auto  grid-flow-col gap-x-32 md:gap-x-32">
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
        <div class="grid mt-6 gap-5 2xl:grid-cols-3 lg:mx-20 lg:grid-cols-2  md:grid-cols-1 col-span-2">
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
                type="submit"
                class=" px-4 py-2 text-white bg-[#F05529] rounded-md hover:bg-[#FEA127]"
              >
              Request Pindah Ruang
              </button>
      </div>
    </div>
  </div>
</template>

<style></style>

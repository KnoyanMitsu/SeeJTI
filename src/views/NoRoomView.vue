<script setup>
import NavbarComponent from '@/components/NavbarComponent.vue'
import Date from '@/controller/Date'
import Calendar from '@/widget/CalendarWidget.vue'
<<<<<<< HEAD
import NavClassroom from '@/widget/NavClassroom.vue'
</script>

<script>
=======
import NavClassroom from '@/widget/NavClassroom.vue';
import ListRoomWidget from '@/widget/ListRoomWidget.vue';
</script>

<script>
import schedule from '@/data/dummy/schedule.json'
>>>>>>> main
export default {
  mounted() {
    const clockInstance = new Date()

    setInterval(() => {
      this.year = clockInstance.year
      this.month = clockInstance.month
      this.day = clockInstance.date
<<<<<<< HEAD
    }, 1)
=======
    },1)
>>>>>>> main
  },
  data() {
    return {
      year: '',
      month: '',
<<<<<<< HEAD
      day: '',
=======
      day: ''
>>>>>>> main
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
<<<<<<< HEAD
    <NavClassroom />
=======
      <NavClassroom/>
>>>>>>> main
  </nav>

  <div class="grid grid-cols-2">
    <div class="">
      <p class="font-semibold text-lg mb-5">{{ month }}</p>

      <Calendar :year="year" :month="month" />
    </div>
    <div>
      <div>
        <h1 class="font-semibold text-lg mb-2">Ruang Kosong</h1>
        <p class="text-[#7A7979]">{{ day }}</p>
      </div>
<<<<<<< HEAD
      <div>Todo: this list room</div>
      <div>Todo: This Ruang yang di pilih and button Request Pindah Ruang</div>
=======
      <div>
        <div class="grid mt-6 gap-5 2xl:grid-cols-3 lg:mx-20 lg:grid-cols-2  md:grid-cols-1">
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
      <div>
        Todo: This Ruang yang di pilih and button Request Pindah Ruang
      </div>
>>>>>>> main
    </div>
  </div>
</template>

<style></style>

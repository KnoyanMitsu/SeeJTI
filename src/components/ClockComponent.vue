<template>
  <div class="text-center">
    <h1 class="text-xl font-bold text-black">{{ date}}</h1>
    <h1 class="text-9xl font-bold text-black">{{ currentTime}}</h1>

  </div>
</template>

<script>
export default {
  data() {
    return {
      currentTime: '',
      date: '',
      days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
      months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    };
  },
  mounted() {
    this.updateTime();
    setInterval(this.updateTime, 1000);
  },
  methods: {
    updateTime() {
      const now = new Date();
      const hours = now.getHours();
      const minutes = now.getMinutes();
      const day = now.getDate();
      const month = now.getMonth();
      const year = now.getFullYear();
      const dayName = this.days[now.getDay()];
      const monthName = this.months[month];
      this.date = `${dayName}, ${day} ${monthName} ${year}`;
      this.currentTime = `${hours.toString().padStart(2, '0')}.${minutes.toString().padStart(2, '0')}`;
    }
  }
};
</script>

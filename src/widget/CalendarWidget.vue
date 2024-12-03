<template>
  <div class="{{ classname }}">
    <table>
      <thead>
        <tr>
          <th v-for="day in daysOfWeek" :key="day">{{ day }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(week, index) in calendar" :key="index">
          <td v-for="day in week" :key="day" :class="{ empty: !day }">
            <p class="mb-5">{{ day || '' }}</p>
            <span
            class="inline-flex bg-green-200 rounded-full px-3 py-1 items-center text-sm font-semibold text-green-700 mt-5 mb-2 mr-2"
            >2 Ruangan
          </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    classname: {
      type: String,
    },
    year: {
      type: Number,
      required: true,
    },
    month: {
      type: String, // Nama bulan diterima dalam format string
      required: true,
    },
  },
  data() {
    return {
      daysOfWeek: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
      calendar: [],
      months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    };
  },
  methods: {
    generateCalendar(year, monthName) {
      const monthIndex = this.months.indexOf(monthName); // Ubah nama bulan menjadi index
      if (monthIndex === -1) {
        console.error('Nama bulan tidak valid:', monthName);
        return [];
      }

      const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();
      const startDay = new Date(year, monthIndex, 1).getDay();

      const dates = [];
      let week = new Array(7).fill(null);

      // Isi minggu pertama
      for (let i = startDay, date = 1; i < 7; i++, date++) {
        week[i] = date;
      }
      dates.push(week);

      // Isi minggu berikutnya
      for (let date = week[startDay] + 1; date <= daysInMonth; ) {
        week = new Array(7).fill(null);
        for (let i = 0; i < 7 && date <= daysInMonth; i++, date++) {
          week[i] = date;
        }
        dates.push(week);
      }

      return dates;
    },
    updateCalendar() {
      this.calendar = this.generateCalendar(this.year, this.month);
    },
  },
  watch: {
    // Regenerate calendar setiap `year` atau `month` berubah
    year: 'updateCalendar',
    month: 'updateCalendar',
  },
  created() {
    this.updateCalendar();
  },
};
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
td {
  border: 1px solid #ddd;

  padding: 10px;
  height: 30px;
  width: 30px;
}
th {
  text-align: center;
  font-size: 15px;
  line-height: 1;
  font-weight: normal;
}
.empty {
  background-color: #f9f9f9;
}
</style>

// Clock.ts
export default class Clock {
  currentTime: string = '';
  day: string = '';
  date: string = '';
  days: string[] = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  months: string[] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  constructor() {
    this.updateTime();
    setInterval(() => this.updateTime(), 1000);
  }

  updateTime() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const day = now.getDate();
    const month = now.getMonth();
    const year = now.getFullYear();
    const dayName = this.days[now.getDay()];
    const monthName = this.months[month];

    this.day = dayName;
    this.date = `${dayName}, ${day} ${monthName} ${year}`;
    this.currentTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
  }
}

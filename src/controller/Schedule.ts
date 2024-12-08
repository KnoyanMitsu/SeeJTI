import { ref } from 'vue';
import axios from '../api/api';
import Clock from '@/controller/Date';

let cachedSchedules = null;

export default function useScheduleComponent() {
  const schedules = ref([]); // Data jadwal
  const selectedClass = ref(''); // Kelas yang dipilih
  const classList = ref([]);
  const day = ref('');
  const success = ref(false); // Status keberhasilan pengambilan data

  const fetchSchedules = async () => {
    const maxRetries = 10;
    let attempt = 0;
    let successFetch = false;

    if (cachedSchedules) {
      setScheduleData(cachedSchedules);
      return;
    }
    while (attempt < maxRetries && !successFetch) {
      try {
        const response = await axios.get('http://localhost:8000/classJSON.php', { withCredentials: true });
        if (response.data && response.data.classes) {
          cachedSchedules = response.data.classes;
          setScheduleData(cachedSchedules);
          success.value = true;
          successFetch = true;
        } else {
          console.error('Invalid API Response:', response.data);
          throw new Error('Invalid response');
        }
      } catch (error) {
        attempt++;
        console.error(`Error fetching schedules (attempt ${attempt}):`, error);
        if (attempt >= maxRetries) {
          console.error('Max retries reached. Unable to fetch schedules.');
        }
      }
    }
  };

  const setScheduleData = (data) => {
    schedules.value = data;
    classList.value = data.map(c => c.name);
    if (classList.value.length > 0) {
      selectedClass.value = classList.value[0]; // Default pilih kelas pertama
    }
  };

  const filteredSchedule = () => {
    const selectedClassSchedule = schedules.value.find(item => item.name === selectedClass.value);
    return selectedClassSchedule ? selectedClassSchedule.schedule : {};
  };

  const filteredDay = () => {
    return day.value ? filteredSchedule()[day.value] || [] : [];
  };

  const clockInstance = new Clock();
  setInterval(() => {
    day.value = clockInstance.day;
  }, 1000);

  return {
    schedules,
    selectedClass,
    classList,
    day,
    success,
    fetchSchedules,
    filteredSchedule,
    filteredDay,
  };
}

<script>
import axios from '../api/api';
import HomeView from './HomeView.vue';
import GuestView from './GuestView.vue';

export default {
  data() {
    return {
      role: '', // Untuk menyimpan peran (mahasiswa, ketua, atau guest)
    };
  },
  components: {
    HomeView,
    GuestView,
  },
  methods: {
    async checkAuth() {
      try {
        const response = await axios.get('http://localhost:8000/checkAuth.php', {
          withCredentials: true, // Kirim cookies
        });
        if (response.data === 'mahasiswa' || response.data === 'ketua') {
          this.role = 'login'; // Jika peran adalah mahasiswa/ketua
        } else {
          this.role = 'guest'; // Jika bukan mahasiswa/ketua
        }
      } catch (error) {
        console.error('Error during auth check:', error);
        this.role = 'guest'; // Anggap sebagai guest jika terjadi error
      }
    },
  },
  computed: {
    currentView() {
      return this.role === 'login' ? 'HomeView' : 'GuestView';
    },
  },
  created() {
    this.checkAuth(); // Panggil metode auth saat komponen dibuat
  },
};
</script>

<template>
  <component :is="currentView" />
</template>

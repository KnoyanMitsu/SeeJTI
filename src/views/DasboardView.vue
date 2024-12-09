<script>
import axios from '../api/api';
import HomeView from './HomeView.vue';
import GuestView from './GuestView.vue';
export default {
  data() {
    return {
      role: '',
    }
  },
  components: {
    HomeView,
    GuestView
  },
  methods: {
    async checkAuth() {
      try {
        const response = await axios.get('http://localhost:8000/checkAuth.php',{withCredentials: true,})
        if (response.data === 'mahasiswa' || response.data === 'ketua') {
          this.role = 'login'
        }else {
          this.role = 'guest'
        }
      } catch (error) {
        console.log(error)
      }
    },
  },
  computed: {
    currentView() {
      return this.role === 'login' ? 'HomeView' : 'GuestView';
      // return this.role === 'login' ? 'GuestView' : 'HomeView' ;
    },
  },
  created() {
    this.checkAuth()
  },
}
</script>

<template>
  <component :is="currentView" />
</template>

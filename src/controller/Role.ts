import axios from '../api/api';
export default class Role {
  role: string = '';


  constructor() {
    this.updateRole();
  }

  updateRole() {
    async () => {
      try {
        const response = await axios.get('http://localhost:8000/checkAuth.php');
        if (response.data === 'berhasil') {
          this.role = 'ketua';
        } else {
          this.role = 'mahasiswa';
        }
      } catch (error) {
        console.log(error);
      }
    };
  }
}

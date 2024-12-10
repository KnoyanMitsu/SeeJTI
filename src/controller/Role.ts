import axios from '../api/api';
export default class Role {
  role: string = '';

  constructor() {
    this.updateRole().then((role) => {
      this.role = role;
    });
  }

  async updateRole() {
    try {
      const response = await axios.get('http://localhost:8000/checkAuth.php',{withCredentials: true,});
      if (response.data === 'ketua') {
        return 'ketua';
      } else if (response.data === 'mahasiswa') {
        return 'mahasiswa';
      }else{
        return 'admin';
      }
    } catch (error) {
      console.log(error);
    }
  }
}


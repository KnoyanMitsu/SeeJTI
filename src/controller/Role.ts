export default class Role {
  role: string = '';


  constructor() {
    this.updateRole();
  }

  updateRole() {
    // kalau mau ganti admin dan user disini
    this.role = 'mahasiswa';
  }
}

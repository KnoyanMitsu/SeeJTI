<template>
    <div class = "container ">
        <div >
            <h1 class = "text-2xl font-semibold">Form Tambah Data User</h1>
        </div>

        <div class = "w-100 p-8 mt-12 shadow-md rounded-2xl "> 
            <form >
    <!-- Form 1: Nama Lengkap -->
    <div class="mb-4">
      <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
    </div>

    <!-- Form 2: NIM -->
    <div class="mb-4">
      <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
      <input type="text" id="nim" name="nim" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan NIM" required>
    </div>

    <!-- Form 3: Password -->
    <div class="mb-4">
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan password" required>
    </div>

    <!-- Dropdown: Mahasiswa / Ketua Kelas -->
    <div class="mb-4">
      <label for="role" class="block text-sm font-medium text-gray-700">Pilih Role</label>
      <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg " required>
        <option value="mahasiswa">Mahasiswa</option>
        <option value="ketua_kelas">Ketua Kelas</option>
      </select>
    </div>

    <!-- Button Group -->
    <div class="flex justify-end gap-6  mt-6">
      <!-- Simpan Button -->
      <button type="submit" class="px-6 py-2 bg-[#F05529] text-white rounded-lg hover:bg-[#FCAA93] hover:text-[#F05529] focus:outline-none focus:ring-2 focus:ring-blue-500">
        Simpan
      </button>
      
      <!-- Batal Button -->
      <button type="reset" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Batal
      </button>
    </div>
  </form>
        </div>
    </div> 
</template>

<style>
.w-100 {
    width: 731px /* 384px */;
}
</style>
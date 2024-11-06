<template>
  <body>
    <div class="flex">
      <div class="container items-center h-screen flex justify-center">
        <form action="#" method="post" class="m-2">
          <h1 class="text-4xl font-bold">Login</h1>
          <span
            class="inline-flex bg-green-200 rounded px-3 py-1 items-center text-sm font-semibold text-green-700 mt-5 mb-5 mr-2"
            >Login menggunakan akun Siakad
            <span class="material-symbols-outlined ml-2"> info </span>
          </span>

          <label
            for="username"
            class="block text-gray-700 text-sm font-bold mb-2"
            >Username</label
          >
          <input
            placeholder="Masukan NIM/NIP"
            type="text"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-3"
            name="username"
            id="username"
          />
          <label
            for="password"
            class="block text-gray-700 text-sm font-bold mb-2"
            >Password</label
          >
          <input
            placeholder="Masukan Password"
            type="password"
            name="password"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="password"
          />
          <div class="flex justify-end mt-2 mb-5">
            <a
              href="https://siakad.polinema.ac.id/recovery_password"
              class="text-sm text-blue-800 hover:text-blue-600"
              >Lupa Password?</a
            >
          </div>
          <button
            type="submit"
            class="bg-gray-800 text-white py-2 px-4 w-full rounded focus:outline-none focus:shadow-outline"
          >
            Login
          </button>
        </form>
      </div>
      <div class="h-screen w-screen">
        <img
          src="../assets/Logo/versi 6.png"
          alt="Gedung JTI"
          class="w-full h-full object-cover"
        />
      </div>
    </div>
  </body>
</template>

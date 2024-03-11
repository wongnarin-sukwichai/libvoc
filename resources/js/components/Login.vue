<template>
    <div
        class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
    >
        <div class="w-full max-w-md space-y-8">
            <div>
                <img
                    class="mx-auto h-24 w-auto bg-gray-800 p-4 rounded-lg"
                    :src="logo"
                    alt="Your Company"
                />
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="login()">
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="email-address" class="sr-only"
                            >Email address</label
                        >
                        <input
                            type="email"
                            required
                            class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            placeholder="Email"
                            v-model="auth.email"
                        />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input
                            type="password"
                            required
                            class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            placeholder="Password"
                            v-model="auth.password"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between"></div>

                <div>
                    <button
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        เข้าสู่ระบบ
                    </button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    data() {
        return {
            logo: "/img/library.png",
            auth: {
                email: "",
                password: "",
            },
            showError: "",
        };
    },
    methods: {
        async login() {
            this.showError = false;
            try {
                await this.$store.dispatch("login", this.auth); //dispatch ส่งค่าไปยัง store ของ vuex
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "เข้าสู่ระบบเรียบร้อย",
                    showConfirmButton: false,
                    timer: 1500,
                });
                this.$router.push({ name: "home" }); //หากสำเร็จให้เปิด router ชื่อ home แบบ SPA
            } catch (e) {
                Swal.fire({
                    icon: "error",
                    title: "ผิดพลาด",
                    text: "ไม่สามารถเข้าระบบได้, กรุณาติดต่อเจ้าหน้าที่",
                    timer: 1500,
                });
            }
        },
    },
};
</script>

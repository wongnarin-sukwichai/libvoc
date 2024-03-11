<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- component -->
        <div
            class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5"
        >
            <table
                class="w-full border-collapse bg-white text-left text-sm text-gray-500"
            >
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            ID
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            ชื่อ-นามสกุล
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            วันที่
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            เวลา
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            ประเภทผู้ใช้
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            หมวดหมู่
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            รายละเอียด
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            สถานะ
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="divide-y divide-gray-100 border-t border-gray-100"
                >
                    <tr
                        class="hover:bg-sky-50 cursor-pointer"
                        v-for="(post, index) in postList.data"
                        :key="index"
                        @click="getDetail(post.id)"
                    >
                        <td class="px-6 py-4">{{ post.id }}</td>
                        <th
                            class="flex gap-3 px-6 py-4 font-normal text-gray-900"
                        >
                            <div class="text-sm">
                                <div class="font-medium text-gray-700">
                                    {{ post.name }} ****
                                </div>
                                <div class="text-gray-400"
                                v-if="post.email !== null"
                                >
                                    {{ post.email.substring(0,3) }}****
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{ momentDate(post.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ momentTime(post.created_at) }} น.
                        </td>
                        <td class="px-6 py-4">
                            {{ showType(post.type) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ showConcern(post.concern) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ post.detail }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <p
                                :class="
                                    post.stat === 1
                                        ? 'text-sky-400'
                                        : post.stat === 2
                                        ? 'text-yellow-400'
                                        : post.stat === 3
                                        ? 'text-orange-300'
                                        : 'text-green-400'
                                "
                            >
                                {{ showStat(post.stat) }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center">
            <TailwindPagination
                :data="postList"
                @pagination-change-page="getPost"
            >
            </TailwindPagination>
        </div>

        <div class="flex justify-end m-5">
            <button
                class="border rounded-lg p-2 bg-teal-400 hover:bg-teal-500 text-white text-sm"
                @click="showModal()"
            >
                ส่งเรื่อง
            </button>
        </div>
    </div>

    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="isModalShow"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    >
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"
                                >
                                    <form @submit.prevent="sendPost()">
                                        <div
                                            class="grid gap-6 mb-6 lg:grid-cols-2"
                                        >
                                            <div>
                                                <label
                                                    for="first_name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >ชื่อ</label
                                                >
                                                <input
                                                    type="text"
                                                    id="first_name"
                                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    required
                                                    v-model="dataPost.name"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    for="last_name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >นามสกุล</label
                                                >
                                                <input
                                                    type="text"
                                                    id="last_name"
                                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    required
                                                    v-model="dataPost.lastname"
                                                />
                                            </div>

                                            <div>
                                                <label
                                                    for="company"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >ประเภท</label
                                                >
                                                <div class="relative">
                                                    <select
                                                        class="text-sm p-3 cursor-pointer block appearance-none w-full bg-white border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                        required
                                                        v-model="dataPost.type"
                                                    >
                                                        <option
                                                            disabled
                                                            value=""
                                                        >
                                                            กรุณาเลือก...
                                                        </option>
                                                        <option
                                                            v-for="(
                                                                type, index
                                                            ) in typeList"
                                                            :key="index"
                                                            :value="type.id"
                                                        >
                                                            {{
                                                                type.type_title
                                                            }}
                                                        </option>
                                                    </select>
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                                    >
                                                        <svg
                                                            class="fill-current h-4 w-4"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20"
                                                        >
                                                            <path
                                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    for="phone"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    หมวดหมู่</label
                                                >
                                                <div class="relative">
                                                    <select
                                                        class="text-sm p-3 cursor-pointer block appearance-none w-full bg-white border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                        required
                                                        v-model="
                                                            dataPost.concern
                                                        "
                                                    >
                                                        <option
                                                            disabled
                                                            value=""
                                                        >
                                                            กรุณาเลือก...
                                                        </option>
                                                        <option
                                                            v-for="(
                                                                concern, index
                                                            ) in concernList"
                                                            :key="index"
                                                            :value="concern.id"
                                                        >
                                                            {{
                                                                concern.concern_title
                                                            }}
                                                        </option>
                                                    </select>
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                                    >
                                                        <svg
                                                            class="fill-current h-4 w-4"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20"
                                                        >
                                                            <path
                                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-6">
                                            <label
                                                for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                >ข้อมูลติดต่อ</label
                                            >
                                            <input
                                                type="text"
                                                id="email"
                                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="** เว้นว่างได้ **"
                                                v-model="dataPost.email"
                                            />
                                        </div>
                                        <div class="mb-6">
                                            <label
                                                for="confirm_password"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                >รายละเอียด</label
                                            >
                                            <textarea
                                                class="w-full border border-gray-300 rounded-lg p-2"
                                                v-model="dataPost.detail"
                                                required
                                            ></textarea>
                                        </div>

                                        <div
                                            class="py-1 sm:flex sm:flex-row-reverse"
                                        >
                                            <button
                                                type="submit"
                                                class="inline-flex w-full justify-center rounded-md bg-teal-400 hover:bg-teal-500 px-3 py-2 text-sm text-white shadow-sm sm:ml-3 sm:w-auto"
                                            >
                                                บันทึก
                                            </button>
                                            <button
                                                type="button"
                                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white hover:bg-gray-100 px-3 py-2 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                                @click="closeDetail()"
                                            >
                                                ยกเลิก
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import "boxicons";
import Swal from "sweetalert2";
import moment from "moment";
import "moment/dist/locale/th";
moment.locale("th");
import { TailwindPagination } from "laravel-vue-pagination";

export default {
    mounted() {
        this.getType();
        this.getConcern();
        this.getPost();
        this.getStat();
    },
    data() {
        return {
            isModalShow: false,
            dataPost: {
                name: "",
                lastname: "",
                email: "",
                type: "",
                concern: "",
                detail: "",
            },
            typeList: "",
            concernList: "",
            postList: [],
            statList: "",
        };
    },
    methods: {
        showModal() {
            this.isModalShow = true;
        },
        closeDetail() {
            this.isModalShow = false;
        },
        getType() {
            axios
                .get("/api/type")
                .then((response) => {
                    this.typeList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getConcern() {
            axios
                .get("/api/concern")
                .then((response) => {
                    this.concernList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getPost(page = 1) {
            axios
                .get("/api/post?page=" + page)
                .then((response) => {
                    this.postList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getStat() {
            axios
                .get("/api/stat")
                .then((response) => {
                    this.statList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getDetail(id) {
            this.$router.push("/detail/" + id);
        },
        async sendPost() {
            try {
                await this.$store.dispatch("storePost", this.dataPost);
                this.isModalShow = false;
                await Swal.fire({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    text: "เนื้อหาของท่านอยู่ในขั้นตอนรอการตรวจสอบความเหมาะสมจากทางเจ้าหน้าที ขอบคุณครับ/ค่ะ",
                    icon: "success",
                    timer: 10000,
                });
                this.getPost();
            } catch (err) {
                Swal.fire({
                    icon: "error",
                    title: "ผิดพลาด",
                    text: "ไม่สามารถบันทึกข้อมูลได้, กรุณาติดต่อเจ้าหน้าที่",
                    timer: 1500,
                });
            }
        },
        momentDate(data) {
            return moment(data).add(543, "years").format("LL");
        },
        momentTime(data) {
            return moment(data).format("LT");
        },
        showType(data) {
            return this.typeList[data - 1].type_title;
        },
        showConcern(data) {
            return this.concernList[data - 1].concern_title;
        },
        showStat(data) {
            return this.statList[data - 1].stat_title;
        },
    },
    components: {
        TailwindPagination,
    },
};
</script>

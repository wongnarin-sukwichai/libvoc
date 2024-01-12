<template>
    <div class="mx-auto sm:px-6 lg:px-8">
        <!-- component -->
        <div
            class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5"
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
                        <th
                            scope="col"
                            class="px-6 py-4 font-medium text-gray-900"
                        >
                            เผยแพร่
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="divide-y divide-gray-100 border-t border-gray-100"
                >
                    <tr v-for="(post, index) in postList.data" :key="index">
                        <td class="px-6 py-4">{{ post.id }}</td>
                        <td
                            class="flex gap-3 px-6 py-4 font-normal text-gray-900"
                        >
                            <div class="text-sm">
                                <div class="font-medium text-gray-700">
                                    {{ post.name }} {{ post.lastname }}
                                </div>
                                <div class="text-gray-400">
                                    {{ post.email }}
                                </div>
                            </div>
                        </td>
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
                        <td
                            class="px-6 py-4 hover:bg-sky-50 cursor-pointer"
                            @click="getDetail(post.id)"
                        >
                            {{ post.detail }}
                        </td>
                        <td class="px-6 py-4">
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
                        <td class="px-6 py-4">
                            <box-icon
                                v-if="post.public === 0"
                                name="block"
                                color="#ef4444"
                                class="cursor-pointer"
                                animation="tada-hover"
                                @click.self="upPost(post.id, 1)"
                            ></box-icon>
                            <box-icon
                                v-else
                                name="check-circle"
                                color="#84cc16"
                                class="cursor-pointer"
                                animation="tada-hover"
                                @click="upPost(post.id, 0)"
                            ></box-icon>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end m-5">
            <TailwindPagination
                :data="postList"
                @pagination-change-page="getPost"
            >
            </TailwindPagination>
        </div>
    </div>
</template>

<script>
import "boxicons";
import moment from "moment";
import "moment/dist/locale/th";
moment.locale("th");
import { TailwindPagination } from "laravel-vue-pagination";
import Swal from "sweetalert2";

export default {
    mounted() {
        this.getType();
        this.getConcern();
        this.getPost();
        this.getStat();
    },
    data() {
        return {
            typeList: "",
            concernList: "",
            postList: [],
            statList: "",
        };
    },
    methods: {
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
                .get("/api/admin?page=" + page)
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
        async upPost(id, code) {
            axios
                .get("/api/upPost/" + id + "/" + code)
                .then((response) => {
                    this.getPost();
                    Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "บันทึกข้อมูลเรียบร้อย",
                    showConfirmButton: false,
                    timer: 1500,
                });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getDetail(id) {
            this.$router.push("/adminDetail/" + id);
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

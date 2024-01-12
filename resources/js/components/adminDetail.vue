<template>
    <div class="flex justify-center mt-8">
        <router-link to="/home">
            <button
                class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded-full shadow-lg inline-flex item-center"
            >
                <box-icon
                    name="chevrons-left"
                    color="white"
                    size="xs"
                ></box-icon>
                <span class="text-sm">กลับหน้าหลัก</span>
            </button>
        </router-link>
    </div>
    <div class="flex justify-center mb-20 mt-8">
        <div class="w-1/2">
            <!-- Post -->
            <div class="flex">
                <div class="flex flex-col items-center mr-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 border rounded-full"
                        >
                            <box-icon
                                name="chevron-down"
                                color="#64748b"
                            ></box-icon>
                        </div>
                    </div>
                    <div class="w-px h-full bg-gray-300"></div>
                </div>
                <div class="pb-8">
                    <p class="mb-2 text-xl font-bold text-gray-600">
                        {{ momentDate(postDetail.created_at) }}
                    </p>
                    <div
                        class="block p-6 border-2 border-sky-300 rounded-lg shadow-lg max-w-md"
                    >
                        <p class="text-gray-700 mb-6 text-lg">
                            {{ postDetail.detail }}
                        </p>
                        <div class="flex italic justify-end text-gray-400">
                            <box-icon
                                type="solid"
                                name="quote-left"
                                size="xs"
                                class="pr-1"
                                color="#9ca3af"
                            ></box-icon>
                            {{ postDetail.name }} {{ postDetail.lastname }}
                            <box-icon
                                type="solid"
                                name="quote-right"
                                size="xs"
                                class="pl-1"
                                color="#9ca3af"
                            ></box-icon>
                        </div>
                        <font class="italic font-xs text-gray-300 justify-end">
                            {{ postDetail.email }}
                        </font>
                    </div>
                </div>
            </div>

            <!-- Comment -->
            <div v-if="commentList !== null">
                <div
                    class="flex"
                    v-for="(comment, index) in commentList"
                    :key="index"
                >
                    <div class="flex flex-col items-center mr-4">
                        <div>
                            <div
                                class="flex items-center justify-center w-10 h-10 border rounded-full"
                            >
                                <box-icon
                                    name="chevron-down"
                                    color="#64748b"
                                ></box-icon>
                            </div>
                        </div>
                        <div class="w-px h-full bg-gray-300"></div>
                    </div>
                    <div
                        class="block p-6 mt-6 rounded-lg shadow-lg max-w-md border-2"
                        :class="comment.status !== 2 ? 'border-orange-300' : 'border-green-300'"
                    >
                        <p class="text-gray-700 mb-6 text-lg">
                            {{ comment.detail }}
                        </p>
                        <div class="flex italic justify-end text-gray-400">
                            <box-icon
                                type="solid"
                                name="quote-left"
                                size="xs"
                                class="pr-1"
                                color="#9ca3af"
                            ></box-icon>
                            {{ comment.name }} {{ comment.surname }}
                            <box-icon
                                type="solid"
                                name="quote-right"
                                size="xs"
                                class="pl-1"
                                color="#9ca3af"
                            ></box-icon>
                        </div>
                        <font class="italic font-xs text-gray-300 justify-end">
                            {{ comment.dep_title }}
                        </font>
                    </div>
                </div>
            </div>

            <!-- Add Comment -->
            <div class="flex" v-if="postDetail.stat !== 4">
                <div class="flex flex-col items-center mr-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 border rounded-full"
                        >
                            <box-icon
                                name="chevron-down"
                                color="#64748b"
                            ></box-icon>
                        </div>
                    </div>
                    <div class="w-px h-full bg-gray-300"></div>
                </div>

                <div class="pt-8">
                    <div
                        class="box-border h-48 w-64 p-4 border-4 border-dashed hover:border-gray-300 cursor-pointer"
                        @click="showModal()"
                    >
                        <div class="flex justify-center py-12">
                            <box-icon
                                name="plus"
                                color="#d1d5db"
                                size="lg"
                            ></box-icon>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Done -->
            <div class="flex" v-if="postDetail.stat === 4">
                <div class="flex flex-col items-center mr-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 border rounded-full bg-green-400"
                        >
                            <box-icon name="check" color="white"></box-icon>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="mb-2 text-lg font-semibold text-gray-600">
                        ดำเนินการเสร็จสิ้น
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Show -->
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

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    >
                        <div class="bg-white px-4 pt-5 sm:p-4 sm:pb-2">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="message-dots"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                    >
                                        รายละเอียด :</label
                                    >
                                    <textarea
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="detail"
                                        required
                                        v-model="dataComment.detail"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white px-4 pb-4 sm:p-4 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="buildings"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >กลุ่มงาน :
                                    </label>
                                    <select
                                        id="countries"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required
                                        v-model="dataComment.forward"
                                    >
                                        <option disabled value="">
                                            กรุณาเลือก...
                                        </option>
                                        <option
                                            v-for="(dep, index) in depList"
                                            :key="index"
                                            :value="dep.id"
                                        >
                                            {{ dep.dep_title }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                type="button"
                                class="inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm text-white shadow-sm hover:bg-green-600 sm:ml-3 sm:w-auto"
                                @click="sendComplete()"
                            >
                                ดำเนินการเสร็จสิ้น
                            </button>
                            <button
                                type="button"
                                class="inline-flex w-full justify-center rounded-md bg-sky-400 px-3 py-2 text-sm text-white shadow-sm hover:bg-sky-500 sm:ml-3 sm:w-auto"
                                @click="sendForward()"
                            >
                                ส่งมอบเรื่องไปยังกลุ่มงาน
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm text-gray-900 shadow-sm hover:bg-gray-200 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                @click="closeDetail()"
                            >
                                ออก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import "boxicons";
import moment from "moment";
import "moment/dist/locale/th";
moment.locale("th");
import Swal from "sweetalert2";

export default {
    mounted() {
        this.getPost();
        this.getDep();
        this.getComment();
    },
    data() {
        return {
            isModalShow: false,
            id: this.$route.params.id,
            postDetail: "",
            commentList: "",
            statList: "",
            depList: "",
            dataComment: {
                refID: this.$route.params.id,
                detail: "",
                forward: "",
            },
        };
    },
    methods: {
        showModal() {
            this.isModalShow = true;
        },
        closeDetail() {
            this.isModalShow = false;
        },
        async getPost() {
            axios.get("/api/post/" + this.id).then((response) => {
                this.postDetail = response.data;
            });
        },
        getComment() {
            axios.get("/api/comment/" + this.id).then((response) => {
                this.commentList = response.data;
            });
        },
        getDep() {
            axios.get("/api/dep").then((response) => {
                this.depList = response.data;
            });
        },
        async sendForward() {
            Swal.fire({
                title: "ส่งมอบเรื่องไปยังกลุ่มงาน",
                text: "ยืนยันการส่งมอบหรือไม่?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        this.$store.dispatch("storeForward", this.dataComment);
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "บันทึกข้อมูลเรียบร้อย",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.closeDetail();
                        this.$router.push({ name: "home" });
                    } catch (err) {
                        Swal.fire({
                            icon: "error",
                            title: "ผิดพลาด",
                            text: "ไม่สามารถบันทึกข้อมูลได้, กรุณาติดต่อเจ้าหน้าที่",
                            timer: 1500,
                        });
                    }
                }
            });
        },
        async sendComplete() {
            Swal.fire({
                title: "ดำเนินการแล้วเสร็จ",
                text: "ยืนยันการดำเนินการแล้วเสร็จหรือไม่?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        this.$store.dispatch("storeComplete", this.dataComment);             
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "บันทึกข้อมูลเรียบร้อย",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.closeDetail();
                        this.$router.push({ name: "home" });
                    } catch (err) {
                        Swal.fire({
                            icon: "error",
                            title: "ผิดพลาด",
                            text: "ไม่สามารถบันทึกข้อมูลได้, กรุณาติดต่อเจ้าหน้าที่",
                            timer: 1500,
                        });
                    }
                }
            });
        },
        momentDate(data) {
            return moment(data).add(543, "years").format("LL");
        },
        momentTime(data) {
            return moment(data).format("LT");
        },
    },
};
</script>

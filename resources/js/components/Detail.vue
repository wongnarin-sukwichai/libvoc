<template>
    <div class="flex justify-center mt-2">
        <router-link to="/">
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

    <!-- Post -->
    <div class="flex justify-center mb-48 mt-8">
        <div class="">
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
                            {{ postDetail.name }}
                            <box-icon
                                type="solid"
                                name="quote-right"
                                size="xs"
                                class="pl-1"
                                color="#9ca3af"
                            ></box-icon>
                        </div>
                        <font class="italic font-xs text-gray-300 justify-end"
                        v-if="postDetail.email !== null"
                        >
                            {{ postDetail.email }}**** 
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
</template>

<script>
import "boxicons";
import moment from "moment";
import "moment/dist/locale/th";
moment.locale("th");

export default {
    mounted() {
        this.getPost();
        this.getDep();
        this.getComment();
    },
    data() {
        return {
            id: this.$route.params.id,
            postDetail: "",
            commentList: "",
            statList: "",
            depList: "",
        };
    },
    methods: {
        getPost() {
            axios.get("/api/post/" + this.id).then((response) => {
                this.postDetail = response.data;
                this.postDetail.email = this.postDetail.email.substring(0,3);
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
        momentDate(data) {
            return moment(data).add(543, "years").format("LL");
        },
        momentTime(data) {
            return moment(data).format("LT");
        },

    },
};
</script>

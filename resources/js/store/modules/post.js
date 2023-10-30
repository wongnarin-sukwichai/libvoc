
export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
            post: null,
        };
    },
    getters: {

    },
    mutations: {

    },
    actions: {
       
        async storePost({ dispatch }, payload) {
            //async มาคู่กับ await เสมอ | dispatch เป็นการรับข้อมูลจาก function จาก .vue ในที่นี้รับจาก Login.vue
            //console.log(payload);
            try {
                await axios.get("/sanctum/csrf-cookie"); //await การ process ข้อมูลโดยบังคับให้ต้องรอ กระบวนการนี้เสร็จก่อนจึงจะสามารถไปทำ process อื่นๆได้

                await axios
                    .post("/api/post", payload) //ไปที่ routes->api->login
                    .then((response) => {
                       
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (e) {
                throw e;
            }
        },

    },
};

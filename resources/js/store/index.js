import { createStore } from "vuex";
import user from "./modules/user";
import post from "./modules/post";
import comment from "./modules/comment";

const store = createStore({
    modules: {
        user,
        post,
        comment
    }
})

export default store
import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import user from "./modules/user";
import post from "./modules/post";
import comment from "./modules/comment";

const store = createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        user,
        post,
        comment,
    },
});

export default store;

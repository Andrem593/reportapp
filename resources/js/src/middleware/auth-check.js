import store from "../store/store";

export default async ({ to, from, next }) => {
    try {
        await store.dispatch("fetchUser");
        if (!store.getters["check"]) {
            return next({
                name: "login",
            });
        }
    } catch (error) {
        console.log(error);
    }
};

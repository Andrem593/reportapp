import axios from "axios";

const actions = {
    // /////////////////////////////////////////////
    // COMPONENTS
    // /////////////////////////////////////////////

    // Vertical NavMenu
    updateVerticalNavMenuWidth({ commit }, width) {
        commit("UPDATE_VERTICAL_NAV_MENU_WIDTH", width);
    },

    // VxAutoSuggest
    updateStarredPage({ commit }, payload) {
        commit("UPDATE_STARRED_PAGE", payload);
    },

    // The Navbar
    arrangeStarredPagesLimited({ commit }, list) {
        commit("ARRANGE_STARRED_PAGES_LIMITED", list);
    },
    arrangeStarredPagesMore({ commit }, list) {
        commit("ARRANGE_STARRED_PAGES_MORE", list);
    },

    // /////////////////////////////////////////////
    // UI
    // /////////////////////////////////////////////

    toggleContentOverlay({ commit }) {
        commit("TOGGLE_CONTENT_OVERLAY");
    },
    updateTheme({ commit }, val) {
        commit("UPDATE_THEME", val);
    },

    // /////////////////////////////////////////////
    // User/Account
    // /////////////////////////////////////////////

    updateUserInfo({ commit }, payload) {
        commit("UPDATE_USER_INFO", payload);
    },
    doLogin({ commit }, username) {
        commit("doLogin", username);
    },
    doLogout({ commit }) {
        commit("doLogout");
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get("/api/user");
            commit('FETCH_USER_SUCCESS', { user: data });
            commit("UPDATE_USER_INFO", data);                        
        } catch (e) {
            commit('FETCH_USER_FAILURE');
        }
    },
};

export default actions;

import {createStore} from 'vuex';

const store = createStore({
    state: {
        user: null,
        authenticatedUserFlag: false
    },
    mutations: {
        setUser (state, user) {
            state.user = user;
        },
        changeAuthenticatedUserFlag(state) {
            state.authenticatedUserFlag = !state.authenticatedUserFlag;
        }
    },
    getters: {
        user(state) {
            return state.user;
        },
        authenticatedUserFlag(state) {
            return state.authenticatedUserFlag;
        }
    }
});

export default store;
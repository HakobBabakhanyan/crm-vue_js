import {initialState} from './state'
const mutations = {
    reset (state) {
        const s = initialState;
        Object.keys(s).forEach(key => {
            state[key] = s[key]
        })
    }
};

export default mutations;

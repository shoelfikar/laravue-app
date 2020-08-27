import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    bankEdit: []
  },
  mutations: {
    getBank(state, data) {
      state.bankEdit = data
    }
  },
  actions: {
    createNewBank(data) {
      axios.post('http://localhost:8000/api/bank', data)
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    getBankData(context, data) {
      context.commit('getBank', data)
    }
  }
})
import axios from 'axios';
import { createStore } from 'vuex'


// Create a new store instance.
const store = createStore({
    state: {
        genres: [],
        shows: [],
        load: false,
        dropDown: false,
        user: [],
        auth: false,
        checkedAuth: false,
        overlay: false,
        error: []
    },

    getters: {
        genre(state) {
            return state.genres;
        },
    },

    mutations: {
        genre(state,payload) 
        {
            state.genres = payload;
        }
    },

    actions: {

        genres({state,commit})
        {
            new Promise((resolve,reject) => {
                return axios.post('/genre').then((res) => {
                    commit('genre',res.data);
                    resolve(res);
                })
            })
        },

        /***
         * @param {payload.type payload.sort payload.page}
         * @return { promise } 
         */

        getShows({},payload)
        {
            console.log(payload);
            return new Promise((resolve,reject) => {                
                axios.post(`/show/${payload.type}/${payload.page}/${payload.sort}`).then((res) => {
                    resolve(res.data)
                })
            }).catch((err) => {
                 throw err;
            })
        },

        /**
         * @param {payload.type,payload.id}
         * @return {promise}
         */

        getShow({},payload)
        {
            return new Promise((resolve,reject)=>{
                axios.post(`/show/find/${payload.type}/${payload.id}`,{provider: ['credits','videos','watch/providers','recommendations']}).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    console.error(error);
                })
            }).catch((err) => {
                throw err
            })
        },

         /**
         * @param {payload.id}
         * @return {promise}
         */

        getShowsCat({},payload)
        {
            console.log(payload);

            return new Promise((resolve,reject) => {
                axios.post(`/show/category/${payload.type}/1/${payload.id}`).then((res) => {
                    resolve(res.data)
                }).catch((error) => {
                    console.error(error);
                })
            }).catch((err) => {
                console.error(err);
            })
        },

         /**
         * @param {payload.id}
         * @return {promise}
         */
        person({},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post(`/show/person/${payload.id}`).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    console.error(error);
                })
            }).catch((err) => {
                console.error(err);
            })
        },

          /**
         * @param {payload.id}
         * @return {promise}
         */
        getLoadCategory({},payload)
        {
            console.log('asd');
            return new Promise((resolve,reject)=> {
                let url = (payload.id > 0) ? `/show/category/${payload.type}/${payload.page}/${payload.id}` : `/show/category/${payload.type}/${payload.page}`;
                axios.post(`${url}`,{next:true}).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    this
                })
            })
        },

        /**
         * 
         * @param {*} payload 
         * @returns {Promise}
         */
        searchGet({},payload)
        {
           let next = (payload.next !== undefined) ? payload.next : false ;
           console.log(next);
           return new Promise((resolve,reject) => {
                axios.post(`/show/search/multi/${payload.searchKey}`,{
                    next:  next,
                    page:  payload.page
                }).then((res) => {
                    resolve(res.data)
                }).catch((error) => {
                    console.error(error);
                })
           })
        },

        action({},payload)
        {
            axios.post(`/action`,payload).then((res) => {
                console.log(res);
            })
        },

        //UserManagment

        /**
         * @param {payload.name payload.email payload.password payload.password_confirmation}
         * @return {Json}
         */

        register({state},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/register',payload).then((res) => {
                    if(res.data.success) state.user = res.data.payload;
                    resolve(res.data)
                }).catch(function (error) {
                    state.error = [];
                    state.error = error.response.data.errors;
                })
            })
        },

        /**
         * @param {payload.email payload.password}
         * @return {Json}
         */
        login({state},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/login',payload).then((res) => {
                    if(res.data.success) state.user = res.data.payload; 
                    resolve(res.data)
                }).catch((error) => {
                    console.error(error);
                })
            })
        },

        /**
         * 
         * @param {*} payload 
         * @returns {Promise}
         */
        forget({},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/forget',payload).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    console.error(error)
                })
            })
        },

        validResetToken({},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/valid',payload).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    console.error(error);
                })
            })
        },

        reset({state},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/reset',payload).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    state.error = [];
                    state.error = error.response.data.errors;
                });
            })
        },

        user({state})
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/auth').then((res) => {
                    if(res.data.success) state.user = res.data.payload;
                    resolve(res.data);
                }).catch((error) => {
                    console.error(error);
                })
            })
        },

        password({state},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/password',payload).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    state.error = error.response.data.errors;
                })
            })
        },

        modify({state},payload)
        {
            return new Promise((resolve,reject) => {
                axios.post('/users/modify',payload).then((res) => {
                    resolve(res.data);
                }).catch((error) => {
                    state.error = error.response.data.errors;
                })
            })
        },

        delete({state},payload)
        {
            axios.get('/users/delete',payload).then((res) => {
                state.user = []
                resolve(res.data);
            }).catch((error) => {
                console.log(error);
            })
        }

    }
});
export default store;
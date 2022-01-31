import router from "./router";
import store from "./store";
import {
    notify
} from "@kyvg/vue3-notification";

export default {
    capFirstLetter(val) {
        return val.charAt(0).toUpperCase() + val.slice(1);
    },

    getFirstLetters(val) {
        let short = '';
        val = val.split(' ');
        val.forEach(element => {
            short += element.charAt(0).toUpperCase();
        });
        return short;
    },

    getRandColor() {
        let colors = [];
        for (var i = 0; i < 3; i++) {
            let rand = Math.floor(Math.random() * 255);
            colors.push(rand);
        }
        let color = `${colors[0],colors[1],colors[2],0}`
        return `rgba(${colors[0]+','+colors[1]+','+colors[2]+','+'0.6'})`
    },

    chunk(arr, chunk) {
        let index = 0;
        let arrBack = [];

        if (typeof arr == 'object') {
            let arrRefind;
            for (const key in arr) {
                arrRefind.push(arr[key]);
            }
        }

        if (typeof chunk == 'number') {

            if (typeof arr == 'array') {
                let chunkFun = () => {
                    let spliced = arr.splice(index, chunk);
                    arrBack.push(spliced);
                    return arrBack;
                    if (arr.length !== 0) {
                        chunkFun();
                    } else {
                        console.log(arrBack);
                        return arrBack;
                    }

                }
                chunkFun()
            }

        } else throw 'Chunked value must be a number'
    },

    actions(payload) {
        if (store.state.user.name !== undefined) {
            if (!this.actionCheck(payload.id, payload.type, payload.show_type)) {
                this.actionAdd(payload.id, payload.show_type, payload.type, payload.show);
            } else {
                this.actionRemove(payload.id, payload.show_type, payload.type);
            }
            store.dispatch('action', payload);
        } else {
            notify({
                type: "error",
                text: 'You need to login to cast this action'
            });
            router.push({
                name: 'login'
            });
        }
    },

    actionCheck(id, val, type) {
        if (store.state.user.name !== undefined) {
            console.log(val,store.state.user,'here')
            console.log(store.state.user);
            let set = store.state.user[val];

            if (set.length > 0) {
                let found = set.find((x) => {
                    return x.show_identifier == id && x.show_type == type;
                });
                return (found !== undefined) ? true : false;
            } else return false;
        }
    },

    actionAdd(id, type, val, show) {
        let set = store.state.user[val];
        let showData = {
            identifier: show.id,
            type: type,
            name: show.name ?? show.title,
            image: show.poster_path ?? null
        }
        set.push({
            show_identifier: id,
            show_type: type,
            shows: showData
        });
    },

    actionRemove(id, type, val) {
        let set = store.state.user[val];
        let index = set.findIndex((x) => {
            return x.show_identifier == id && x.show_type == type;
        });


        if (index > -1) {
            set.splice(index, 1);
        }
    }

};

import { createApp } from 'vue';
import router from './router.js';
import store  from './store.js';
import plugin from './collectors.js';
import VueSplide from '@splidejs/vue-splide';
import '@splidejs/splide/dist/css/themes/splide-skyblue.min.css';
import VueProgressBar from "@aacassandra/vue3-progressbar";
import HoltDateFormater from 'holtdataformater';
import Notifications from '@kyvg/vue3-notification'
import actions from './actions.js';
import "vue-toastification/dist/index.css";



const options = {
    color: "#00dc89",
    failedColor: "#874b4b",
    thickness: "2.5px",
    transition: {
      speed: "0.2s",
      opacity: "0.6s",
      termination: 300,
    },
    autoRevert: true,
    location: "left",
    inverse: false,
};




import AppComponent from './components/App.vue'

import {mapActions} from 'vuex';

let holtOptions = {
    shortTrack: true,
    longTrack: false,
    percies: false,
    formate: true
}

let app = createApp({
    components: {
        AppComponent,
    },
    data() {
        return {
            windowPerformace: window.performance.timeOrigin
        }
    },
    watch() 
    {
        windowPerformace()
        {
            console.log(this.windowPerformace)
        }
    },
    methods: {
        ...mapActions ([
            'genres'
        ])
    },

    mounted() {
        this.genres();
    }
});

app.use(router)
   .use(plugin)
   .use(store)
   .use(VueSplide)
   .use(VueProgressBar, options)
   .use(HoltDateFormater,holtOptions)
   .use(Notifications)
   .use(actions)
   .mount("#app")
<template>
    <div class="display">
        <div class="rg-container" v-if="!this.$store.state.load">
            <div class="filter d-flex">
                <div class="selector mt-4" @click=" openGenre =! openGenre;openSort = false">
                    <div class="selector-text p-1 d-flex zIndex4">
                        <i class="ri-arrow-drop-down-line fs-20 rotate-trans" :class="{'rotate': openGenre}"></i>
                        <p class="mb-0 d-flex align-items-center fs-12  fw-600 pr-2">
                            {{ sort }}
                        </p>
                    </div>
                    <transition name="list">
                        <ul class="navbar-nav p-1 zIndex3 selector-nav drop-nav zIndex4" v-if="openGenre">
                            <router-link v-for="(gen,index) in genre[type]" :key="index" :to="{name:'display',params:{type:type,id:index}}" class="fs-13 text-white" >
                                <li class="p-2">
                                    {{ gen }}
                                </li>
                            </router-link>
                        </ul>
                    </transition>
                </div>
                <div class="selector mt-4 ml-3" @click=" openSort =! openSort;openGenre = false">
                    <div class="selector-text p-1 d-flex zIndex4">
                        <i class="ri-arrow-drop-down-line fs-20 rotate-trans" :class="{'rotate': openSort}"></i>
                        <p class="mb-0 text-capitalize d-flex align-items-center pr-2 fs-12 fw-600">
                            {{ type }}
                        </p>
                    </div>
                    <transition name="list">
                        <ul class="navbar-nav p-2 zIndex3 drop-nav zIndex4" v-if="openSort">
                            <router-link :to="{name:'display',params:{type:'movie'}}" class="fs-12 fw-600 text-white">
                                <li class="selected p-2">
                                    Movies
                                </li>
                            </router-link>
                            <router-link :to="{name:'display',params:{type:'tv'}}" class="fs-12 fw-600 text-white">
                                <li class=" p-2">
                                    Tv
                                </li>
                            </router-link>
                        </ul>
                    </transition>
                </div>
            </div>
            <div class="w-50 mt-4" :class="{'w-100': window.innerWidth < 992}">
                <h1 class="text-whity fs-14">Full List of All Movies Available Streaming Available in the UK </h1>
                <p class="text-gray fs-13">Wondering where you can watch that movie streaming online? Below is every
                    movie
                    available to stream online.
                    By default, the list is ranked by popularity, but you can filter by Reelgood score, IMDB rating,
                    release
                    year, or streaming service to find what to watch faster.</p>
            </div>
            <div class="show-container action-container mb-3">
                <div class="row sec mb-3">
                    <div class="col-xl-3  col-md-6  col-lg-4 mt-3 position-relative" v-for="(show,index) in shows" :key="index">
                        <lg-box :show="show"></lg-box>
                    </div>
                </div>
                <button class="m-auto d-block more d-flex align-items-center fs-12 " data-bind="/movie/" @click="getLoad()" :class="{'active': loading}">
                    Load More
                    <div class="loader d-flex ml-2" :class="{'loader-animation': loading}">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
        <div class="rg-container row">
            
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';
import lgBox from '../Boxes/lg-box.vue';

export default {
    data() {
       return {
           openSort: false,
           openGenre: false,
           shows: [],
           window: window,
           page: 1,
           sort: 'All',
           loading: false,
           empty: false
       } 
    },

    props: {
        id: {
            default: ''
        },
        type: {
            default: 'movie'
        }
    },

    components: {
        'lg-box': lgBox
    },

    computed: {
        ...mapGetters([
            'genre'
        ]),
        sort() {
            if(this.genre[this.type] !== undefined) {
                if(this.genre[this.type].hasOwnProperty(this.id))
                {
                    return this.genre[this.type][this.id];
                } else {
                    if(this.id == undefined) {

                    } else {
                        return 'All'
                    }
                }
            }
        },
    },

    methods: {
        ...mapActions([
            'getLoadCategory'
        ]),
        getLoad() {
            this.loading = true;
            this.getLoadCategory({
                id: this.id,
                type: this.type,
                page: this.page
            }).then((res) => {
                res.forEach((e) => {
                    this.shows.push(e);
                });
                this.page = this.page + 2;
                this.loading = false;
                
            }).then(()=>{
                 window.scrollTo({
                    top: window.scrollY +  window.screen.availHeight,
                    behavior: 'smooth'
                })
            });

        }
    },
    mounted() {
        this.$store.state.load = true;
        this.getLoadCategory({
            id: this.id,
            type: this.type,
            page: this.page
        }).then((res) => {
            this.shows = res;
            this.$store.state.load = false;
            this.page = this.page + 2;
            if(this.shows.length == 0)
            {
                this.empty = true;
            }
        });

        window.addEventListener('click',(e) => {
            if(!e.target.closest('.drop-nav') && !e.target.closest('.selector')) 
            {
                this.openSort = false;
                this.openGenre = false;
            } 
        });
    }

}
</script>
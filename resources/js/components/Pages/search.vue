<template>
    <div class="search screen_height">
        <div class="rg-container">
            <div class="show-container action-container mb-3" v-if="!this.$store.state.load">
                <div class="row sec mb-3">
                    <div class="col-xl-3  col-md-6  col-lg-4 mt-3 position-relative search-box" v-for="(show,index) in shows" :key="index">
                        <sw-box :show="show"></sw-box>
                    </div>
                </div>
                <button class="m-auto d-block more d-flex align-items-center fs-12 " data-bind="/movie/" @click="getLoad()" :class="{'active': loading}" v-if="!allLoad">
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
import swBox from '../Boxes/sw-box.vue';

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
           empty: false,
           allLoad: false
       } 
    },

    props: {
        search: {
            default: ''
        },
        type: {
            default: 'movie'
        }
    },

    components: {
        'sw-box': swBox
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
            'getLoadCategory',
            'searchGet'
        ]),
        getLoad() {
            this.loading = true;
            this.searchGet({
                searchKey: this.search,
                next: true,
                page: this.page
            }).then((res) => {
            this.allLoad = (res.length < 20) ? true : false;
            res.forEach((e) => {
                this.shows.push(e);
            });
            this.page++;
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
        this.searchGet({
            searchKey: this.search,
            next: true,
            page: this.page
        }).then((res) => {
            this.shows = res;
            this.$store.state.load = false;
            this.page++;
            console.log(this.page);
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
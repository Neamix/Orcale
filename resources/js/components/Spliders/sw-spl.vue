<template>
   <div class="sw-splider">
        <!-- Loader -->
        <transition name="list">
            <sw-skeleton v-if="skeleton"></sw-skeleton>
        </transition>
        <!-- Data Slider -->
        {{  }}
        <h3 class="sec-title fs-12 fw-600" v-if="title && Object.keys(this.shows).length > 0">{{ title }}</h3>
        <transition name="list">
            <Splide :options="options" v-if="!skeleton">
                <SplideSlide v-for="(show,index) in shows" :key="index">
                    <sw-box :show="show"></sw-box>
                </SplideSlide>
            </Splide>
        </transition>
   </div>
</template>

<script>
import axios from 'axios';
import swSkeleton from '../skeletons/sw-skeleton.vue'
import swBox from '../Boxes/sw-box.vue';
import { mapActions, mapGetters } from 'vuex'

export default ({
    props: {
        'type': {
            'required': false,
            validator(value) {
              let arr = ['person','movie','tv'];
              let check = arr.find((x) => {return x == value })   
              if(check == undefined) {
                throw 'Not a valid type valid types =>  [tv,movie,person]'
              }
            }
        },
        'provided': {
            default: []
        },
        'genre': {
            default: false
        },
        'genre_id': {
            
        },
        'sort': {
            default: 'popular'
        },
        'title': {

        }
    },
    data() {
        return {
            shows: [],
            genraSet: {18:'Action'},
            skeleton: true,
            options: {
                rewind: true,
                perPage: 8,
                pagination: false,
                breakpoints: {
                    1400: {
                        perPage: 7,
                    },

                    1200: {
                        perPage: 6
                    },

                    1100: {
                        perPage: 5
                    },

                    992: {
                        perPage: 4
                    },

                   700: {
                        perPage: 3
                    },

                    580: {
                        perPage: 2
                    }
                }
            }
        }
    },

    components: {
        'sw-skeleton': swSkeleton,
        'sw-box': swBox
    },

    computed: {
        sortBy() {
            if(this.sort == undefined) {
                return 'popular'
            } else {
                return this.sort;
            }
        }
    },

    methods: {
        ...mapActions([
            'getShows',
            'getShowsCat'
        ])
    }, 

    mounted() {
        console.log('here');
        if(this.provided.length == 0 && !this.genre){
            this.getShows({
                type: this.type,
                sort: this.sort,
                page: 1
            }).then((res) => {
                this.skeleton = false;
                this.shows = res.results;
            });
        } else if(this.genre) {
            this.getShowsCat({
                type: this.type,
                id: this.genre_id
            }).then((res) => {
                this.shows = res.results;
                console.log(this.shows)
                this.skeleton = false;
            });
        } else {
            this.shows = this.provided.results;
            this.skeleton = false;
        }   
    }
})
</script>

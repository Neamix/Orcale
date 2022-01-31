<template>
   <div class="sw-splider">
       <!-- Loader -->
       <transition name="list">
           <med-skeleton v-if="skeleton"></med-skeleton>
       </transition>
       <!-- Data Slider -->
       <transition name="list">
           <Splide :options="options" v-if="!skeleton">
               <SplideSlide v-for="(show,index) in shows" :key="index">
                    <med-box :show="show"></med-box>    
               </SplideSlide>
        </Splide>
       </transition>
   </div>
</template>

<script>
import mdSkeleton from '../skeletons/sw-skeleton.vue'
import mdBox from '../Boxes/med-box.vue';

import { mapActions, mapGetters } from 'vuex'

export default ({
    props: {
        'type': {
            'required': true,
            validator(value) {
              let arr = ['person','movie','tv'];
              let check = arr.find((x) => {return x == value })   
              if(check == undefined) {
                throw 'Not a valid type valid types =>  [tv,movie,person]'
              }
            }
        },
        'sort': {
            default: 'popular'
        }
    },
    data() {
        return {
            shows: [],
            genraSet: {18:'Action'},
            skeleton: true,
            options: {
                rewind: false,
                perPage: 5,
                pagination: false,
                padding: { top: 10, bottom: 20 },
                breakpoints: {
                    1100: {
                        perPage: 5
                    },

                    992: {
                        perPage: 3
                    },

                   700: {
                        perPage: 2
                    },

                    580: {
                        perPage: 1
                    }
                }
            }
        }
    },

    components: {
        'med-skeleton': mdSkeleton,
        'med-box': mdBox
    },

    computed: {
        ...mapGetters([
            'genre'
        ]),

        chunkedItems () {
            
        },

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
           'getShows'
       ])
    }, 

    mounted() {
        this.getShows({
            type: this.type,
            sort: this.sort,
            page: 1
        }).then((res) => {
            this.skeleton = false;
            this.shows = res.results;
        });
    }
})
</script>

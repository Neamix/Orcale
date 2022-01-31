<template>
    <div class="sw-splider">
        <!-- Loader -->
        <transition name="list">
            <pr-skeleton v-if="skeleton"></pr-skeleton>
        </transition>
        <!-- Data Slider-->
        <transition name="list">
            <Splide :options="options" v-if="!skeleton">
                <SplideSlide v-for="(show,index) in shows" :key="index">
                    <div class="collection ml-2 mt-2" v-for="(collection,index) in show" :key="index">
                        <router-link :to="{name:'person',params:{id: collection.id}}">
                            <div class="actor-circle mb-2 d-flex  align-items-center">
                                <div class="letters d-flex justify-content-center align-items-center fs-12 color-wh" :style="{'background-color': this.collector.getRandColor()}">
                                    {{ collector.getFirstLetters(collection['name']) }}
                                </div>
                                <p class="mb-0 pl-2 fs-12">{{collection['name']}}</p>
                            </div>
                        </router-link>
                    </div>
                </SplideSlide>
            </Splide>
        </transition>
    </div>
</template>

<script>
import axios from 'axios';
import prSkeleton from '../skeletons/pr-skeleton.vue'
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
        },
        'provided': {
            default: []
        }
    },
    data() {
        return {
            shows: [],
            skeleton: true,
            options: {
                rewind: false,
                perPage: 5,
                pagination: false,
                breakpoints: {
                    1400: {
                        perPage: 5,
                    },

                    1100: {
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
        'pr-skeleton': prSkeleton,
    },

    computed: {
        ...mapGetters([
            'genre'
        ]),

        chunkedItems () {
            
        },
    },

    methods: {
       ...mapActions([
           'getShows'
       ])
    }, 

     mounted() {
        if(this.provided.length == 0)
        {
            this.getShows({
                type: this.type,
                sort: 'popular',
                page: 1
            }).then((res) => {
                this.skeleton = false;
                this.shows = res;
            });
        } else {
            this.shows = this.provided;
            this.skeleton = false;
        }
    }
})
</script>

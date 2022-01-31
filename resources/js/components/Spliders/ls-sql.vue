<template>
   <div class="sw-splider">
       <!-- Data Slider -->
       <transition name="list">
           <Splide :options="options">
               <SplideSlide v-for="(show,index) in shows" :key="index">
                    <ls-box :show="show"></ls-box>    
               </SplideSlide>
        </Splide>
       </transition>
   </div>
</template>

<script>
import lsBox from '../Boxes/ls-box.vue';

export default ({
    props: {
        shows: {
           require: true
        }
    },
    data() {
        return {
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
        'ls-box': lsBox
    },

    props: {
        shows: {
            require: true
        }
    }
})
</script>

<template>
    <div class="person screen_height-semi" v-if="per.hasOwnProperty('name')">
        <div class="name actor-info">
            <div class="rg-container mt-5">
                <div class="d-flex person-container">
                    <div class="person-circle d-flex justify-content-center align-item-center" v-if="per.name" :style="{'background-color': this.collector.getRandColor()}">
                        <span class="d-flex justify-content-center align-items-center fs-14">{{ collector.getFirstLetters(per.name) }}</span>
                    </div>
                    <div class="full-info">
                        <p class="ml-3 color-wh fs-12 fw-600 mb-0">{{ per.name }}</p>
                        <p class="ml-3  fs-12 color-wh">Birthday:
                            <span v-if="per.birthday" v-HoltFormater:[formate]="per.birthday" class="text-whity"></span>
                            <span v-else class="text-whity">Not Set</span>
                            <span v-if="per.birthday && per.place_of_birth" class="text-whity"> at {{ per.place_of_birth }}</span>
                        </p>
                        <div class="mt-2">
                            <p class="ml-3  fs-12 color-wh">Department:
                                <span v-if="per.known_for_department"  class="text-whity">{{ per.known_for_department }}</span>
                                <span v-else class="text-whity">Not Set</span>
                            </p>
                        </div>
                        <p v-if="per.biography" class="fs-13 text-whity pl-3 mb-0 person-read" :class="{'person-read-vis-all': more}">
                            {{ per.biography }}
                        </p>
                        <p class="fs-13 text-whity pl-3" v-else>No Biography</p>
                        <span class="fs-12 fw-600  pl-3 color-wh read-btn" v-if="per.biography.length > 782" @click="more =! more">
                            Read 
                            <span v-if="!more">more</span>
                            <span v-if="more">less</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="rg-container mt-5">
            <!-- people -->
            <section class="mt-4 sec" v-if="per.combined_credits.cast">
                <h3 class="sec-title fs-12 fw-600">Known For</h3>
                <sw-sql :provided="{'results': per.combined_credits.cast}" ></sw-sql>
           </section>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import swSql from '../Spliders/sw-spl.vue'

export default {
    props: {
        'id': {
            require: true
        }
    },
    data() {
        return {
            per: [],
            more: false,
            formate: 'dd  ww  yy',
    
        }
    }, 
    components: {
        'sw-sql': swSql,
    }, 
    methods: {
        ...mapActions([
            'person'
        ])
    },
    mounted() 
    {
        this.$store.state.load = true;
        this.person({
            id: this.id
        }).then((res) => {
            this.per = res;
            this.$store.state.load = false;
        });
    }
}
</script>
<template>
    <div class="sw-box-md position-relative w-100 p-2">
        <div class="sw-card-container position-relative w-100">
            <img :src="'http://image.tmdb.org/t/p/w500/'+show.poster_path" alt="show-img" class="w-100 h-100"  v-if="show.poster_path">
            <img src="https://drive.google.com/uc?export=view&id=1kuB2sBVgWwdxm2CVsBdaLZiTp89LKjgq" class="w-100 h-100" v-else alt="image">
            <!-- Box information -->
            <div class="position-absolute top-0 w-100 h-100 top-0 p-2 d-flex justify-content-between align-items-start sw-box-layer">
                <router-link :to="{name:'show', params: {id:show.id,type:type}}" class="w-100 h-100 position-absolute top-0 left-0 zIndex2 dir-link">
                    <div class="position-absolute h-100 d-flex justify-content-end flex-column p-2 fs-12 color-wh">
                        <p class="fs-12 fw-600 mb-0" v-if="show['title']">{{ show['title'] }}</p>
                        <p class="fs-12 fw-600 mb-0" v-if="show['name']">{{ show['name'] }}</p>
                        <ul class="genre p-0 nav" v-if="show['genre_ids']">
                            <li v-for="(gen,index) in show['genre_ids']" :key="index" class="fs-10 color-sv  mb-0 fit-it d-inline-block">
                                <span v-if="genre[type] && genre[type][gen]">{{ genre[type][gen] }}</span>
                                <span class="pr-1 pl-0"></span>
                            </li>
                        </ul>
                    </div>
                </router-link>
                <router-link :to="{name:'show',params:{type:show.media_type,id:show['id']}}" class="ml-auto zIndex4"  v-if="show.media_type && show.media_type !== 'person'">
                    <p class="mb-0 type zIndex4">{{ show.media_type }}</p>
                </router-link>
                <router-link :to="{name:'person',params:{type:'person',id:show['id']}}" class="ml-auto zIndex4"  v-if="show.media_type && show.media_type == 'person'">
                    <p class="mb-0 type">{{ show.media_type }}</p>
                </router-link>
                <!-- Action Btns -->
                <div class="position-absolute top-0 pt-2 mini-container">
                    <div class="position-relative zIndex3">
                        <div class="mini d-flex align-items-center pl-2 pr-2 align-items-center  mb-1 action"
                        @click="collector.actions({id: show['id'],show_type: type,type: 'track',short:'tr',show:show})" 
                        :class="{'active': this.collector.actionCheck(show['id'],'track',type)}"
                        v-if="type == 'tv'">
                            <i class="ri-send-plane-line fw-bold fs-10"></i>
                            <span class="pl-3 mr-3 fs-11 ">Track</span>
                        </div>
                        <div class="mini d-flex align-items-center pl-2 pr-2 align-items-center  mb-1 action" v-if="type == 'movie'" 
                        @click="collector.actions({id: show['id'],show_type: type,type: 'want_to_see',short:'wts',show:show})" 
                        :class="{'active': this.collector.actionCheck(show['id'],'want_to_see',type)}"
                        >
                            <i class="ri-add-line fw-bold"></i>
                            <span class="pl-3 mr-3 fs-11 ">Want to see</span>
                        </div>
                        <div class="mini d-flex align-items-center pl-2 pr-2 align-items-center  mb-1 action"
                            v-if="type == 'movie'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'seen_all',short:'sn',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'seen_all',type)}"
                            >
                            <i class="ri-check-line fw-bold"></i>
                            <span class="pl-3 mr-3 fs-11 ">Seen it</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    props: {
        'show': {
            'required': true
        },
    },
    computed: {
        ...mapGetters([
            'genre'
        ]),
        type() {
            return (this.show.name !== undefined) ? (this.show['first_air_date']) ? 'tv' : 'person' : 'movie';
        }
    },
    mounted() {
    }
}
</script>

<template>
    <div class="lgshowbox main-container">
        <div class="lgimg w-100 position-relative ">
            <router-link :to="{name:'show',params:{'type': type,'id':show.id}}" class="w-100 h-100 position-absolute top-0 left-0 zIndex2"></router-link>
            <div class="position-absolute top-0 p-1 mini-container">
                <div class="position-relative zIndex3">
                    <div class="mini d-flex align-items-center pl-2 pr-2 align-items-center  mb-1 action"
                        v-if="type == 'tv'"
                        @click="collector.actions({id: show['id'],show_type: type,type: 'track',short:'tr',show:show})" 
                        :class="{'active': this.collector.actionCheck(show['id'],'track',type)}">
                        <i class="ri-send-plane-line fw-bold fs-10"></i>
                        <span class="pl-3 mr-3 fs-11 ">Track</span>
                    </div>
                    <div class="mini d-flex align-items-center pl-2 pr-2 align-items-center  mb-1 action"
                        v-if="type == 'movie'"
                        @click="collector.actions({id: show['id'],show_type: type,type: 'want_to_see',short:'wts',show:show})" 
                        :class="{'active': this.collector.actionCheck(show['id'],'want_to_see',type)}">
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
           <div class="poster">
                <div class="img-poster w-100 h-100" :style="{'background-image': `url('https://image.tmdb.org/t/p/w500/${this.show.poster_path}')`}" v-if="show.poster_path"></div>
               <div class="img-poster" :style="{'background': 'https://drive.google.com/uc?export=view&id=1kuB2sBVgWwdxm2CVsBdaLZiTp89LKjgq'}" v-else></div>
           </div>

        </div>
        <div class="lgshowinfo">
            <div class="lgshowinfocontainer">
                <router-link :to="{name:'show',params:{'type': type,'id':show.id}}" class="w-100 h-100 position-absolute top-0 left-0 zIndex2"></router-link>
                <div class="p-3">
                    <h2 class="fs-14 text-white" v-if="show.name">{{ show.name }}</h2>
                    <h2 class="fs-14 text-white" v-if="show.title">{{ show.title }}</h2>
                    <div class="voting d-flex align-items-center">
                        <img class="star"
                            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNCIgaGVpZ2h0PSIxMyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJhIiB4MT0iMjkuMTkyJSIgeDI9Ijc1LjQyNiUiIHkxPSIwJSIgeTI9IjEwMCUiPjxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiNGOUVFQUMiLz48c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNEQkE1MDYiLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48cGF0aCBmaWxsPSJ1cmwoI2EpIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik01OTIgNDI5LjVsLTQuMTE0IDIuMTYzLjc4NS00LjU4MS0zLjMyOC0zLjI0NSA0LjYtLjY2OUw1OTIgNDE5bDIuMDU3IDQuMTY4IDQuNi42NjktMy4zMjggMy4yNDUuNzg1IDQuNTgxeiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTU4NSAtNDE5KSIvPjwvc3ZnPg==" alt="image">
                        <p class="mb-0 fs-11 text-whity ml-2">
                            <span class="fs-14 text-white"></span> {{ show.vote_average }} out 10
                        </p>
                        <p class="ml-2 fs-11 text-whity mb-0">
                            <span class="text-white" v-if="show.popularity">Popularity:
                                <span class="text-whity">{{show.popularity}}</span>
                            </span>
                        </p>
                    </div>
                    <div class="d-flex">
                        <p class="text-whity fs-11 mt-2 d-flex">
                            <span class="text-white">Categories: </span>
                            <ul class="genre p-0 nav pl-2" v-if="show['genre_ids'].length > 0">
                                <li v-for="(gen,index) in show['genre_ids']" :key="index"
                                    class="fs-10 color-sv  mb-0 fit-it d-inline-block">
                                    <span v-if="genre[type] && genre[type][gen]">{{ genre[type][gen] }}</span>
                                    <span class="pr-1 pl-0"></span>
                                </li>
                            </ul>
                        </p>
                    </div>
                    <p class="text-whity fs-11">
                        <span class="text-white">What it's about: </span>
                        <span v-if="show.overview">
                            {{ show.overview.substring(0,150) }}
                            <span v-if="show.overview.length > 200">...</span>
                        </span>
                        <span v-else> Not Set </span>
                    </p>
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
            return (this.show.name !== undefined) ? 'tv' : 'movie';
        }
    },

    mounted() {
    }
}
</script>
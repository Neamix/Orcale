<template>
    <div class="" v-if="show.hasOwnProperty('name') || show.hasOwnProperty('title') ">
        <header :style="{'background': linearImage , 'background-size': 'cover' }" class="w-100 position-relative">
            <div class="container d-flex pt-5  h-100">
                <img :src="'https://image.tmdb.org/t/p/w500/' + show.poster_path" class="poster"
                    v-if="show.poster_path">
                <img src="/images/system/noimg.jfif" class="poster" v-if="!show.poster_path">
                <div class="display-info pl-5 ml-2">
                    <h3 v-if="show.name" class="h3 fw-bold text-white mb-3">{{ show.name }}</h3>
                    <h3 v-if="show.title" class="h3 fw-bold text-white mb-3">{{ show.title }}</h3>
                    <div class="toggler mb-3 action-container">
                        <button class="silver-btn  action actionbtn fs-13 first"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'watch_later',short:'wl',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'watch_later',type)}">
                            <i class="ri-add-line fw-bold"></i>
                            Watch Later
                        </button>
                        <button class="silver-btn action actionbtn fs-13 middle" v-if="type == 'tv'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'seen_all',short:'sn',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'seen_all',type)}">
                            <i class="ri-check-line fw-bold"></i>
                            Seen All
                        </button>
                        <button class="silver-btn action actionbtn fs-13 last" v-if="type == 'tv'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'track',short:'tr',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'track',type)}">
                            <i class="ri-send-plane-line"></i>
                            Track
                        </button>
                        <button class="silver-btn action actionbtn fs-13 middle" v-if="type == 'movie'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'love',short:'lv',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'love',type)}">
                            <i class="ri-heart-add-fill fw-bold"></i>
                            <span class="ml-1 fs-12 mb-1">Love</span>
                        </button>
                         <button class="silver-btn action actionbtn fs-13 middle sm-l" v-if="type == 'movie'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'seen_all',short:'sn',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'seen_all',type)}">
                            <i class="ri-heart-add-fill fw-bold"></i>
                            <span class="ml-1 fs-12 mb-1">Seen All</span>
                        </button>
                        <button class="silver-btn action actionbtn fs-13 middle sm-l" v-if="type == 'movie'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'want_to_see',short:'wts',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'want_to_see',type)}">
                            <i class="ri-heart-add-fill fw-bold"></i>
                            <span class="ml-1 fs-12 mb-1">Want To See</span>
                        </button>
                        <button class="silver-btn action actionbtn fs-13 last" v-if="type == 'movie'"
                            @click="collector.actions({id: show['id'],show_type: type,type: 'watched',short:'wd',show:show})"
                            :class="{'active': this.collector.actionCheck(show['id'],'watched',type)}">
                            <i class="ri-check-line fw-bold"></i>
                            Watched
                        </button>
                    </div>
                    <p class="mb-3">
                        <span class="star fs-14 text-white pr-2" v-if="show.vote_average">
                            <span class="pr-1 fs-12 fw-600">Tmdb Votes:</span>
                            <span class="fs-14 text-whity">{{show.vote_average}}/10</span>
                        </span>
                        <span class="star fs-14 text-white pr-2" v-if="show.popularity">
                            <span class="pr-1 fs-12 fw-600">Popularity:</span>
                            <span class="fs-14 text-whity">{{show.popularity}}</span>
                        </span>
                        <span class="star fs-14 text-white pr-2" v-if="show.number_of_episodes">
                            <span class="pr-1 fs-12 fw-600 fw-600">Episodes:</span>
                            <span class="fs-12 text-whity"
                                v-if="show.number_of_episodes">{{show.number_of_episodes}}</span>
                        </span>
                    </p>
                    <p class="mb-3">
                        <span class="star fs-14 text-white pr-2" v-if="show.number_of_seasons">
                            <span class="pr-1">{{show.number_of_seasons}}</span>
                            <span class="fs-12">Season</span>
                        </span>
                        <span class="star fs-14 text-white pr-2" v-if="show.first_air_date">
                            <span class="pr-1 fs-12 fw-600">First Episode:</span>
                            <span class="fs-12 text-whity" v-HoltFormater:[formate]="show.first_air_date"
                                v-if="show.first_air_date"></span>
                        </span>
                        <span class="star  text-white pr-2" v-if="show.last_air_date">
                            <span class="pr-1 fs-12 fw-600">Last Episode:</span>
                            <span class="fs-12  text-whity" v-HoltFormater:[formate]="show.last_air_date"></span>
                        </span>
                    </p>
                    <p class="mb-3 d-flex flex-wrap">
                        <span class="fs-14 text-white pr-2">
                            <span class="fs-12 fw-600">Categories: </span>
                        </span>
                        <router-link v-for="(gen,index) in show.genres" :key="index" to="{/}">
                            <span class="fs-12 text-whity">{{gen['name']}}</span>
                            <span v-if="index < show.genres.length - 1" class="text-whity pr-1 pl-1">, </span>
                        </router-link>
                    </p>
                    <p class="mb-3 d-flex flex-wrap" v-if="provider">
                        <span class="fs-14 text-white pr-2">
                            <span class="fs-12 fw-600">Available On: </span>
                        </span>
                        <span class="fs-12 text-whity" v-for="(store,index) in provider" :key="index">
                            {{ store.provider_name }}
                            <span v-if="index < provider.length - 1" class="text-whity pr-1 pl-1">, </span>
                        </span>
                    </p>
                    <p class="mb-3 d-flex flex-wrap" v-if="buy">
                        <span class="fs-14 text-white pr-2">
                            <span class="fs-12 fw-600">Buy From: </span>
                        </span>
                        <span class="fs-12 text-whity pt-1" v-for="(store,index) in buy" :key="index">
                            {{ store.provider_name }}
                            <span v-if="index < buy.length - 1" class="text-whity pr-1 pl-1">, </span>
                        </span>
                    </p>
                    <p class="fs-14 mb-0 text-whity mb-3">
                        {{show.overview}}
                    </p>
                </div>
            </div>
            <div class="rg-container">
                <section class="mt-4 sec" v-if="show.credits">
                    <h3 class="sec-title fs-12 fw-600" v-if="show.credits.cast">Crew Members</h3>
                    <pr-sql type="movie" :provided="show.credits.cast" v-if="show.credits.cast"></pr-sql>
                </section>
            </div>
        </header>
        <div class="rg-container">
            <!-- people -->
            <section class="mt-4 sec" v-if="show.recommendations.results.length > 0">
                <h3 class="sec-title fs-12 fw-600">
                    Recommend
                    <span v-if="type == 'movie'">Movies</span>
                    <span v-else>Tv Shows</span>
                </h3>
                <sw-sql :type="type" :provided="show.recommendations"></sw-sql>
            </section>
            <section class="mt-4 sec" v-for="(gen,index) in show.genres" :key="index">
                <sw-sql :type="type" :genre="true" :genre_id="gen['id']" :title="'More ' + gen['name'] "></sw-sql>
            </section>
        </div>
    </div>
</template>

<script>
    import {
        mapActions
    } from "vuex"
    import swSql from '../Spliders/sw-spl.vue'
    import prSql from '../Spliders/pr-sql.vue'


    export default ({
        props: ['id', 'type'],
        data() {
            return {
                show: [],
                formate: 'dd  ww  yy',
                provider: '',
                buy: ''
            }
        },

        components: {
            'sw-sql': swSql,
            'pr-sql': prSql,
        },

        methods: {
            ...mapActions([
                'getShow'
            ]),
        },

        computed: {
            linearImage() {
                return `linear-gradient(357deg,#0a1016,#0a1016db,#0a1016b8),url('https://image.tmdb.org/t/p/w1280/${this.show.backdrop_path}')`
            },
            similar() {
                let arr = [];
                // this.show.similar_movies.push(arr);
                arr.push()
                return [this.show.similar_movies];
            }
        },

        mounted() {
            this.$store.state.load = true;
            this.getShow({
                type: this.type,
                id: this.id
            }).then((res) => {
                this.show = res;
                this.provider = (this.show['watch/providers'].results.US !== undefined) ? this.show[
                    'watch/providers'].results.US.flatrate : '';
                this.buy = (this.show['watch/providers'].results.US !== undefined) ? this.show[
                    'watch/providers'].results.US.buy : '';
                this.$store.state.load = false;
            });
        }
    })

</script>

<template>
    <div class="p-discover">

        <!-- Ask to login -->
        <x-loginask1  :img="'https://assets.reelgood.com/p/90ec3ad033b1f255b779a53bab8a2b59f6d42043/9a68f64e.png'" 
                                  :title="'The Best Movie & TV Tracker'"
                                  :text="'Track all the shows you watch & add movies you want to see and Reelgood will always have what you should watch next queued up!'"
        ></x-loginask1>

        <!-- Content -->
        <div class="p-content rg-container">
           <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Popular Movies</h3>
                <sw-sql type="movie"></sw-sql>
           </section>
           <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Top Tv Shows</h3>
                <sw-sql type="tv" sort="top_rated"></sw-sql>
           </section>
        </div>

        <!-- Ask to login -->
        <x-loginask1 class="mt-5" :img="'https://assets.reelgood.com/p/90ec3ad033b1f255b779a53bab8a2b59f6d42043/fe0a6224.png'" 
                                  :title="'See Where to Watch... Anything'"
                                  :text="'Search, browse, and get recommended movies and tv shows from across over 150+ sources. Is it on one you have? Great! If not we\'ll give you the cheapest option available.'"
        ></x-loginask1>

        <!-- Content -->
        <div class="p-content rg-container">
            <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Popular Actors</h3>
                <pr-sql type="person"></pr-sql>
           </section>
        </div>

        <div class="p-content rg-container">
            <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Top Rated Movies</h3>
                <med-sql type="movie" sort="now_playing"></med-sql>
           </section>
           <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Airing today</h3>
                <med-sql type="tv" sort="airing_today"></med-sql>
            </section>
            <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">Upcomming Movies</h3>
                <sw-sql type="movie" sort="upcoming"></sw-sql>
            </section>
            <section class="mt-4 sec">
                <h3 class="sec-title fs-12 fw-600">In theater</h3>
                <sw-sql type="movie" sort="now_playing"></sw-sql>
            </section>
        </div>

    </div>
</template>
<script>

import Login1 from '../Fragments/LoginAsk1.vue';
import swSql from '../Spliders/sw-spl.vue'
import prSql from '../Spliders/pr-sql.vue'
import mdSql from '../Spliders/med-sql.vue'

import { mapActions } from 'vuex';

export default ({
    components: {
        'x-loginask1': Login1,
        'sw-sql': swSql,
        'pr-sql': prSql,
        'med-sql': mdSql
    },
    computed: {
        
    },

    methods: {
        ...mapActions ([
            'genres'
        ])
    },

    mounted() {
        this.genres()
    }
})
</script>

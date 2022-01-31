<template>
    <div class="list screen_height-semi">
        <div class="rg-container">
           <div class="mylists pl-2 mt-4">
                <section class="sec" v-if="this.track.length > 0">
                    <h2 class="sec-title fs-12 fw-600">
                        Track List
                    </h2>
                    <ls-sql :shows="this.track"></ls-sql>
                </section>
                <section class="sec mt-4" v-if="this.seen_all.length > 0">
                    <h2 class="sec-title fs-12 fw-600">
                        Seen List
                    </h2>
                    <ls-sql :shows="this.seen_all"></ls-sql>
                </section>
                <section class="sec mt-4" v-if="this.want_to_see.length > 0">
                    <h2 class="sec-title fs-12 fw-600">
                        Want to see List
                    </h2>
                    <ls-sql :shows="this.want_to_see"></ls-sql>
                </section>
                 <section class="sec mt-4" v-if="this.watch_later.length > 0">
                    <h2 class="sec-title fs-12 fw-600">
                        Watched Later List
                    </h2>
                    <ls-sql :shows="this.watch_later"></ls-sql>
                </section>
                <section class="sec mt-4" v-if="this.watched.length > 0">
                    <h2 class="sec-title fs-12 fw-600">
                        Wanted List
                    </h2>
                    <ls-sql :shows="this.watched"></ls-sql>
                </section>
                <section class="sec mt-4 out" v-if="out">
                    <p class="fs-14 color-wh">No List to display</p>
                </section>
           </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import lsSqlVue from '../Spliders/ls-sql.vue';
export default {
    components: {
        'ls-sql': lsSqlVue
    },
    computed: {
        ...mapState(['user']),
        track()
        {
            return this.user.track
        },
        seen_all()
        {
            return this.user.seen_all
        },
        want_to_see()
        {
            return this.user.want_to_see
        },
        watch_later()
        {
            return this.user.watch_later
        },
        watched()
        {
            return this.user.watched
        },
        out()
        {
            console.log(this.track.length == 0 && this.seen_all.length && this.want_to_see.length && this.watch_later.length && this.watched.length);
            if(this.track.length == 0 && this.seen_all.length && this.want_to_see.length && this.watch_later.length && this.watched.length)
            {
                return true;
            } else {
                return false;
            }
        }
    },
   
    mounted()
    {
       console.log(this.track);
    }
}
</script>
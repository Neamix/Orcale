<template>
    <div class="sw-box-rect w-100 p-2">
        <div class="position-relative h-100">
            <img :src="'http://image.tmdb.org/t/p/w355_and_h200_multi_faces/'+show.poster_path" class="h-100 w-100" alt="image">
            <div class="overlay w-100 h-100 position-absolute top-0 p-2 d-flex flex-column justify-content-center align-items-center" :style="{'background-color': collector.getRandColor()}">
                <div class="layer text-center p-2 ghost">
                    <h3 class="fs-14 text-white mb-0" v-if="show.name"> {{ show.name }} </h3>
                    <h3 class="fs-14 text-white mb-0" v-if="show.title"> {{ show.title }} </h3>
                    <p class="text-white fs-13 fw-bold mb-0"></p>
                </div>
                <router-link :to="{name:'show', params: {id:show.id,type:type}}" class="w-100 h-100 position-absolute top-0 left-0 zIndex2 dir-link"></router-link>
            </div>
        </div>
    </div>
</template>

<script>

export default ({
    props: {
        'show': {
            'required': true
        }
    },
    computed: {
        type() {
            return (this.show.name !== undefined) ? (this.show['first_air_date']) ? 'tv' : 'person' : 'movie';
        }
    }
})
</script>

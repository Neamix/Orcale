<template>
    <div class="ls-box position-relative" >
        <img :src="`http://image.tmdb.org/t/p/w355_and_h200_multi_faces/${img}`" class="h-100 w-100" alt="image" v-if="img">
        <img src="https://drive.google.com/uc?export=view&id=1kuB2sBVgWwdxm2CVsBdaLZiTp89LKjgq" class="w-100 h-100" v-else alt="image">
        <router-link :to="{name:'show', params: {id:identifer,type:type}}" class="w-100 h-100 position-absolute top-0 left-0 zIndex2 dir-link"></router-link>
        <div class="position-absolute w-100 h-100 top-0 left-0 overlay p-2 d-flex flex-column justify-content-end">
            <h2 class="fs-12 color-wh fw-600 mb-0">{{ name }}</h2>
            <span class="d-block fs-11" style="color: #ccc">Type: {{ type }}</span>
        </div>
    </div>
</template>

<script>
export default {
   props: ['show'],
   computed: {
        img() {
           return this.show.shows.image
        },
        name() {
            return this.show.shows.name
        },
        type() {
            return this.show.shows.type
        },
        identifer() {
            console.log(this.show.shows.show_identifier)
            return this.show.shows.identifier
        }
   },
  
}
</script>
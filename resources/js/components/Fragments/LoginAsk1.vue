<template>
    <div class="adv">
       <div class="rg-container d-flex pt-5 pb-5" :class="{'flex-column align-items-center': windowWidth < 992}">
            <div class="img-holder pt-3 w-50 d-flex  justify-content-center">
                <img :src="img" alt="adv1.img.online" >
            </div>
            <div class="text-holder pt-3 w-50 d-flex flex-column justify-content-center align-items-start" :class="{'text-center w-100 align-items-center': windowWidth < 992}">
                <h3 class="color-wh fs-24 fw-bold">{{ title }}</h3>
                <p  class="color-sv fs-15" :class="{'w-100 text-center': windowWidth < 992}">{{ text }}</p>
                <router-link :to="{name:'display',params:{type:'movie'}}">
                    <button class="fs-12">Discover More</button>
                </router-link>
            </div>
       </div>
    </div>
</template>

<script>

export default ({
    props: {
        'img': {
            'required': true,
        },
        'title': {
            'required': true,
        },
        'text': {
            'required': true,
        }
    },
    data()
    {
        return {
            window: window,
            windowWidth: window.innerWidth,
        }
    },
    methods: {
        resizeHandler() {
            this.windowWidth = this.window.innerWidth;
        }

    },
    mounted()
    {
        window.addEventListener('resize', this.resizeHandler);
    }
})
</script>

<template>
    <div class="sw-loader d-flex mt-2">
        <div class="collector d-flex w-100 flex-column p-2"  v-for="index in skeletonBox" :key="index">
            <div class="actor-circle-skeleton skeleton-animation mb-2 w-100" :style="{'width': boxWidh}"></div>
            <div class="actor-circle-skeleton skeleton-animation mb-2 w-100" :style="{'width': boxWidh}"></div>
        </div>
    </div>
</template>

<script>

export default ({
    setup() {
        
    },
     data()
    {
        return {
            window: window,
            windowWidth: window.innerWidth,
            skeletonBox: 0,
            boxWidh: 0
        }
    },

    watch: {
        skeletonBox() {
            this.boxWidh = (100/this.skeletonBox) + '%'
        }
    },

    methods: {
        resizeHandler() {
            this.windowWidth = this.window.innerWidth;
        },

        screenNum() {
            this.resizeHandler();
            if(this.windowWidth >= 1400) 
            {
                this.skeletonBox = 5
            } else if(1100 < this.windowWidth && this.windowWidth < 1400) {
                this.skeletonBox = 4
            } else if(700 < this.windowWidth && this.windowWidth < 1100) {
                this.skeletonBox = 3
            } else if(580 < this.windowWidth && this.windowWidth < 700)  {
                this.skeletonBox = 2
            } else {
                this.skeletonBox = 1
            }
           
        },
    },

    mounted() {
        this.screenNum();
        this.window.addEventListener('resize',this.screenNum);
    }
})
</script>

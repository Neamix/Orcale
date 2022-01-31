<template>
    <div class="sw-loader d-flex mt-2">
        <div class="sw-box-skeleton skeleton-animation" v-for="index in skeletonBox" :key="index" :style="{'width': boxWidh}"></div>
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
            let oldNum = this.skeletonBox;
            if(this.windowWidth >= 1400) 
            {
                this.skeletonBox = 8
            } else if(1200 < this.windowWidth && this.windowWidth < 1400) {
                this.skeletonBox = 7
            } else if(1100 < this.windowWidth && this.windowWidth < 1200) {
                this.skeletonBox = 6
            } else if(992 < this.windowWidth && this.windowWidth < 1100)  {
                this.skeletonBox = 5
            } else if(880 < this.windowWidth && this.windowWidth < 992) {
                this.skeletonBox = 4
            } else if (580 < this.windowWidth && this.windowWidth < 880) {
                this.skeletonBox = 3
            } else {
                this.skeletonBox = 2
            }
           
        },
    },

    mounted() {
        this.screenNum();
        this.window.addEventListener('resize',this.screenNum);
    }
})
</script>

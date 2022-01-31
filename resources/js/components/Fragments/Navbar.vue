<template>
    <nav class="nav-clone"></nav>
    <transition name="navbar">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm w-100 position-absolute top-0"
            :class="{'position-fixed top-0 scrolled': fixedNav}" v-if="navAction" ref="nav">
            <div class="rg-container d-flex">
                <div class="navbar-brand d-flex" href="#">
                    <i class="ri-menu-2-line" @click="openNav =! openNav"></i>
                    <router-link :to="{name: 'discover'}">
                        <svg class="logo-auth" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 111 27" width="100px">
                            <path
                                d="M36.277 15.755v.814h-8.772a3.07 3.07 0 0 0 3.008 2.28c1.07 0 2.278-.445 2.94-1.082l1.85 2.51c-1.204 1.103-3.076 1.735-5.135 1.735-3.946 0-6.701-2.704-6.701-6.576 0-3.736 2.796-6.552 6.504-6.552 3.713 0 6.306 2.825 6.306 6.87zm-6.306-3.708c-1.497 0-2.265.975-2.517 1.941h5.057c-.197-.963-.944-1.94-2.54-1.94zm19.96 3.708v.814H41.16a3.07 3.07 0 0 0 3.008 2.28c1.07 0 2.279-.445 2.94-1.082l1.85 2.51c-1.204 1.103-3.076 1.735-5.135 1.735-3.945 0-6.701-2.704-6.701-6.576 0-3.736 2.796-6.552 6.504-6.552 3.713 0 6.306 2.825 6.306 6.87zm-6.306-3.708c-1.497 0-2.264.975-2.517 1.941h5.057c-.197-.963-.944-1.94-2.54-1.94zm7.856 9.671h3.817V4.662h-3.817zM76.937 8.884c3.778 0 6.52 2.755 6.52 6.552 0 3.81-2.742 6.576-6.52 6.576-3.764 0-6.496-2.766-6.496-6.576 0-3.797 2.732-6.552 6.496-6.552zm-.02 9.67c1.814 0 2.64-1.616 2.64-3.118 0-1.49-.826-3.094-2.64-3.094-1.806 0-2.614 1.554-2.614 3.094 0 1.552.808 3.118 2.615 3.118zm13.88-9.67c3.778 0 6.52 2.755 6.52 6.552 0 3.81-2.742 6.576-6.52 6.576-3.765 0-6.497-2.766-6.497-6.576 0-3.797 2.732-6.552 6.497-6.552zm-.02 9.67c1.813 0 2.64-1.616 2.64-3.118 0-1.49-.827-3.094-2.64-3.094-1.806 0-2.615 1.554-2.615 3.094 0 1.552.809 3.118 2.615 3.118zm16.277-13.892h3.841v17.056h-3.841v-.983a4.936 4.936 0 0 1-3.328 1.277c-3.359 0-5.616-2.633-5.616-6.552 0-3.933 2.257-6.576 5.616-6.576 1.261 0 2.415.45 3.328 1.282V4.662zm0 8.798c-.507-.662-1.463-1.118-2.367-1.118-1.592 0-2.662 1.253-2.662 3.118 0 1.85 1.07 3.094 2.662 3.094.904 0 1.86-.456 2.367-1.119V13.46zm-87.581 2.268c1.582-.627 3.21-2.242 3.21-4.99 0-3.35-2.36-5.602-5.87-5.602h-1.895v3.866h1.254c.94 0 1.89.58 1.89 1.688 0 1.107-.95 1.687-1.89 1.687h-3.197V9.972l-4.547 2.454v9.388h4.547v-5.547h1.918l2.76 5.547h5.211l-3.391-6.086zM65.674 9.39h3.841v11.386c0 5.382-4.737 5.963-6.774 5.963-.77 0-1.454-.065-2.09-.2l-.271-.058-.021-3.272.415.084c.01.002 1.02.204 1.969.209.88 0 2.93-.258 2.93-2.652v-.329c-.938.866-2.093 1.334-3.327 1.334-3.396 0-5.592-2.504-5.592-6.38s2.196-6.38 5.592-6.38c1.266 0 2.401.442 3.328 1.288V9.39zm0 4.278c-.475-.642-1.46-1.115-2.342-1.115-1.642 0-2.663 1.12-2.663 2.921 0 1.803 1.02 2.923 2.663 2.923.867 0 1.853-.475 2.342-1.118v-3.611zM0 0l11.99 6.896L0 13.79V.001zm1.63 6.355h1.097v2.737l4.845-2.865L1.629 2.81v3.545z"
                                fill="#00DC89" fill-rule="evenodd" />
                        </svg>
                    </router-link>
                </div>
                <!-- Left Side Of Navbar -->
                <transition name="list">
                    <ul class="navbar-nav mr-auto menu" v-if="openNav || windowWidth > 992">
                        <div :class="{'rg-container d-flex flex-column justify-content-start align-items-start': windowWidth < 992}"
                            class="d-flex">
                            <router-link :to="{name:'display',params:{type:'tv'}}">
                                <li class="menu-item position-relative zIndex5">
                                    Tv Shows
                                    <!-- Drop Menu -->
                                    <div class="drop-genre position-absolute">
                                        <ul class="drop-menu d-grid gridx3 navbar-nav zIndex5">
                                            <router-link v-for="(gen,index) in genre['tv']" :key="index"
                                                :to="{name:'display',params:{type:'tv',id: index}}">
                                                <li class="nav-item fs-12">
                                                    {{ gen }}
                                                </li>
                                            </router-link>
                                        </ul>
                                    </div>
                                </li>
                            </router-link>
                            <router-link :to="{name:'display',params:{type:'movie'}}">
                                <li class="menu-item position-relative zIndex5">
                                    Movies
                                    <!-- Drop Menu -->
                                    <div class="drop-genre position-absolute ">
                                        <ul class="drop-menu d-grid gridx3 navbar-nav zIndex5">
                                            <router-link v-for="(gen,index) in genre['movie']" :key="index"
                                                :to="{name:'display',params:{type:'movie',id: index}}">
                                                <li class="nav-item fs-12">
                                                    {{ gen }}
                                                </li>
                                            </router-link>
                                        </ul>
                                    </div>
                                </li>
                            </router-link>
                            <router-link :to="{name: 'mylist'}" v-if="user.name">
                                <li class="menu-item position-relative">
                                    Your List
                                </li>
                            </router-link>
                        </div>
                    </ul>
                </transition>

                <!-- Right Side Of Navbar -->

                <!--Toggle Btn-->
                <div class="toggler-btn d-flex ml-auto">
                    <router-link :to="path" class="d-flex">
                        <button class="icon-user" v-if="windowWidth < 992">
                            <i class="ri-user-2-fill  pr-3"></i>
                        </button>
                    </router-link>

                    <button class="icon-search" v-if="windowWidth < 992" @click="search =! search">
                        <i class="ri-search-2-line ml-auto"></i>
                    </button>
                </div>

                <ul class="navbar-nav ml-auto menu" v-if="windowWidth > 992 && !user.name">
                    <!-- Authentication Links -->
                    <router-link :to="{name:'login'}">
                        <li class="nav-item menu-item">
                            Login
                        </li>
                    </router-link>
                    <span class="menu-item">|</span>
                    <router-link :to="{name:'register'}">
                        <li class="nav-item menu-item">
                            Register
                        </li>
                    </router-link>
                </ul>
                <div class="user-reg d-flex align-items-center mr-3 color-wh fw-600 fs-12"
                    v-if="user.name && windowWidth > 992">
                    <router-link :to="{name: 'profile'}"
                        class="d-flex links align-items-center justify-content-center pr-2 pl-2">
                        <i class="ri-user-2-fill  pr-2 fs-12 color-wh"></i>
                        <span class="color-wh"> {{ user.name.substr(0,10) }} </span>
                    </router-link>
                </div>
                <form action="" class="search" :class="{'active': windowWidth < 992 && search}" @submit.prevent>
                    <div class="form-group w-100 h-100 position-relative m-0">
                        <label class="position-absolute right-0 color-wh p-3 close" @click="search =! search">
                            <i class="ri-close-circle-line ml-auto fs-15  color-wh "></i>
                        </label>
                        <transition name="list">
                            <input type="search" placeholder="Where To Stream Anything" class="search"
                                v-model="searchKey" @keyup="searchIt()">
                        </transition>
                        <div class="load-spinner-search position-absolute top-0 right-0" v-if="searchProg"></div>
                        <div class="search-container p-2 position-absolute zIndex5"
                            :class="{'w-100': windowWidth < 922}" v-if="searchArr.length > 0 && searchKey.length > 0">
                            <div v-for="(search,index) in searchArr" :key="index">
                                <router-link :to="{name:'show',params:{type: search.media_type,id:search.id }}"
                                    v-if="search.media_type !== 'person'">
                                    <div class="search-result mb-2">
                                        <h3 class="fs-13 color-wh mb-0" v-if="search.name">{{ search.name }}</h3>
                                        <h3 class="fs-13 color-wh mb-0" v-if="search.title">{{ search.title }}</h3>
                                        <span class="d-flex fs-12 color-sv"
                                            v-if="search.media_type">{{ search.media_type }}</span>
                                    </div>
                                </router-link>
                                <router-link :to="{name:'person',params:{id:search.id }}"
                                    v-if="search.media_type == 'person'">
                                    <div class="search-result mb-2">
                                        <h3 class="fs-13 color-wh mb-0" v-if="search.name">{{ search.name }}</h3>
                                        <h3 class="fs-13 color-wh mb-0" v-if="search.title">{{ search.title }}</h3>
                                        <span class="d-flex fs-12 color-sv"
                                            v-if="search.media_type">{{ search.media_type }}</span>
                                    </div>
                                </router-link>
                            </div>
                            <router-link :to="{name: 'search',params:{search: searchKey}}" class="search-all">View All Results</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </transition>
</template>

<script>

 import {
     mapActions, mapState
 } from 'vuex';
 import {
     mapGetters
 } from 'vuex';

export default ({
    data() {
        return {
            window: window,
            windowWidth: window.innerWidth,
            openNav: false,
            search: false,
            navbarFirstFix: true,
            windowScroll: 0,
            searchArr: [],
            fixedNav: false,
            navAction: true,
            searchKey: '',
            searchProg: false,
            name: ''
        }
    },
    computed: {
        ...mapGetters([
            'genre'
        ]),

        ...mapState({
            user: state => state.user,
        }),

        navHeight()
        {
            return this.$refs.nav.clientHeight
        },

        path()
        {
            if(this.user !== undefined) 
            {
                return {name:'profile'}
            } else  return {name: 'login'}
        }

    },
    methods: {
        ...mapActions([
            'genres',
            'searchGet',
        ]),

        resizeHandler() {
            this.windowWidth = this.window.innerWidth;
        },

        scrollNav()
        {
            let oldScroll = this.window.scrollY;
            if(oldScroll < this.windowScroll)
            {
                if(this.windowScroll > 50) {
                     this.navAction = true;
                this.fixedNav  = true;
                } else {
                     this.navAction = true;
                this.fixedNav  = false;
                }
            } else if (oldScroll > this.windowScroll || this.windowScroll == 0) {
                if(this.fixedNav && this.windowScroll > 0){
                    this.fixedNav = false;
                }
            }

            if(!this.fixedNav && window.scrollY > 100) {
                this.navAction = false;
            };
            return this;
        },

        scrollSet()
        {
            this.navbar = true;
            this.windowScroll = this.window.scrollY;
        },

        searchIt()
        {
            this.searchProg = true;
            if(this.searchKey.length > 0)
            {
                this.searchGet({searchKey: this.searchKey}).then((res) => {
                    this.searchArr = res;
                    this.searchProg = false;
                })
            }
        }

    },
    mounted() {
        this.genres();

        window.addEventListener('resize', this.resizeHandler);
        window.addEventListener('scroll',() => {
            this.scrollNav().scrollSet(); 
        });

        document.addEventListener('click',() =>{
            this.searchKey = ''
        });
    
    }
 })
</script>


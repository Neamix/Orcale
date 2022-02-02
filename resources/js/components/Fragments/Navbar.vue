<template>
    <nav class="nav-clone"></nav>
    <transition name="navbar">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm w-100 position-absolute top-0"
            :class="{'position-fixed top-0 scrolled': fixedNav}" v-if="navAction" ref="nav">
            <div class="rg-container d-flex">
                <div class="navbar-brand d-flex" href="#">
                    <i class="ri-menu-2-line" @click="openNav =! openNav"></i>
                    <router-link :to="{name: 'discover'}">
                        <img src="\Images\system\logo.png" class="logo">
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


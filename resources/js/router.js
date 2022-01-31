import {
    createRouter,
    createWebHistory
} from 'vue-router';
import store from './store.js';

//Components Import

import App from './components/App.vue';
import AppLayout from './components/Layouts/MainLayout.vue'
import discover from './components/Pages/discover.vue'
import show from './components/Pages/show.vue';
import PageNotFound from './components/Pages/notFound.vue';
import person from './components/Pages/person.vue';
import display from './components/Pages/display.vue';
import search from './components/Pages/search.vue';
import AuthLayout from './components/Layouts/AuthLayout.vue'

/* Auth */

import forget from './components/Auth/forget.vue';
import register from './components/Auth/register.vue';
import login from './components/Auth/login.vue';
import reset from './components/Auth/reset.vue';
import profile from './components/Auth/profile.vue';
import mylist from './components/Pages/mylist.vue';


const router = new createRouter({
    history: createWebHistory(),
    routes: [{
            path: '',
            redirect: '/discover'
        },
        {
            path: '',
            component: App,
            children: [{
                    path: '/auth',
                    component: AuthLayout,
                    children: [{
                            path: '/login',
                            component: login,
                            name: 'login'
                        },
                        {
                            path: '/register',
                            component: register,
                            name: 'register'
                        },
                        {
                            path: '/forget',
                            component: forget,
                            name: 'forget'
                        },
                        {
                            path: '/reset/:email/:token',
                            component: reset,
                            name: 'reset',
                            props: true
                        },
                    ]
                },
                {
                    path: '',
                    component: AppLayout,
                    children: [{
                            path: '/discover',
                            component: discover,
                            name: 'discover'
                        },
                        {
                            path: '/person/:id',
                            component: person,
                            name: 'person',
                            props: true
                        },
                        {
                            path: '/discover/:type/:id?',
                            component: display,
                            name: 'display',
                            props: (route) => {
                                if (route.params.type !== 'tv' && route.params.type !== 'movie') {
                                    router.push('/notfound')
                                } else {
                                    return {
                                        type: route.params.type,
                                        id: route.params.id
                                    }
                                }
                            }
                        },
                        {
                            path: '/mylist',
                            component: mylist,
                            name: 'mylist',
                            meta: {
                                requiresAuth: true
                            }
                        },
                        {
                            path: '/:type/:id',
                            component: show,
                            name: 'show',
                            props: (route) => {
                                if (route.params.type !== 'tv' && route.params.type !== 'movie') {
                                    router.push('/notfound')
                                } else {
                                    return {
                                        type: route.params.type,
                                        id: route.params.id
                                    }
                                }
                            }
                        },
                        {
                            path: "/search/:search",
                            component: search,
                            name: 'search',
                            props: true
                        },
                        {
                            path: "/profile",
                            component: profile,
                            name: 'profile',
                            props: true,
                            meta: {
                                requiresAuth: true
                            }
                        },
                    ]
                },
            ],
            meta: {
                progress: {
                    func: [{
                            call: "color",
                            modifier: "temp",
                            argument: "#00dc89"
                        },
                        {
                            call: "fail",
                            modifier: "temp",
                            argument: "#6e0000"
                        },
                        {
                            call: "location",
                            modifier: "temp",
                            argument: "top"
                        },
                        {
                            call: "transition",
                            modifier: "temp",
                            argument: {
                                speed: "1.5s",
                                opacity: "0.6s",
                                termination: 400
                            },
                        },
                    ],
                },
            },
        },
        {
            path: "/:catchAll(.*)",
            component: PageNotFound,
            name: 'notFound'
        }
    ]
});

router.beforeEach((to, from, next) => {
    store.state.load = true;
    let getPage = () => {
        if (to.name == 'reset') {
            store.dispatch('validResetToken', {
                email: to.params.email,
                token: to.params.token
            }).then((res) => {
                store.state.load = false;
                if (res.success) {
                    next()
                } else {
                    router.push('/notfound');
                }
            })
        } else {
            if (to.matched.some(record => record.meta.requiresAuth)) {
                console.log(Object.keys(store.state.user).length,'ads')
                if (Object.keys(store.state.user).length) {
                    next()
                } else {
                    next({
                        path: '/notFound',
                    })
                }
            } else {
                next()
            }
        }
    }
    if (!store.state.checkedAuth) {
        store.state.checkedAuth = true;
        store.dispatch('user').then((res) => {
            store.state.load = false;
            store.state.auth = res.success;
            getPage();
        });

    } else {
        getPage();
    }
})

router.afterEach(() => {
    window.scrollTo({
        top: 10
    })
    window.scrollTo({
        top: 0
    })
    store.state.load = false;
})


export default router;

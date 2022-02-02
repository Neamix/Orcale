<template>
    <div class="auth-page p-3">
        <div class="container p-5">
            <h2 class="color-wh fs-22 fw-600">Create a new user</h2>
            <p class="color-sv fs-13">We are so happy that you will join us</p>
            <form class="login mt-4" @submit.prevent="registerUser()">

                <div class="form-group">
                    <label for="username" class="fs-12 fw-600 color-wh">Username</label>
                    <input type="text" placeholder="Username" class="form-control rg-input" name="username"
                        v-model="payload.name" />
                    <p class="error" v-if="error.name">{{ error.name[0] }}</p>
                </div>

                <div class="form-group">
                    <label for="email" class="fs-12 fw-600 color-wh">Email</label>
                    <input type="text" placeholder="Email Address" class="form-control rg-input" name="email"
                        v-model="payload.email" />
                    <p class="error" v-if="error.email">{{ error.email[0] }}</p>
                </div>

                <div class="form-group">
                        <label for="email" class="fs-12 fw-600 color-wh">Password</label>
                        <input type="password" placeholder="Password" class="form-control rg-input" name="password"
                            v-model="payload.password" />
                        <p class="error" v-if="error.password">{{ error.password[0] }}</p>
                </div>

                <div class="form-group">
                        <label for="email" class="fs-12 fw-600 color-wh">Confirm Password</label>
                        <input type="password" placeholder="Password" class="form-control rg-input" name="password_confirmation"
                        v-model="payload.password_confirmation" />
                </div>

                <div class="form-group d-flex align-items-center lower-part">
                    <div class="d-flex align-items-center">
                        <label class="switch mb-0">
                            <input type="checkbox" class="d-none" v-model="payload.remember">
                            <span class="slider round d-flex justify-content-center align-items-center"></span>
                        </label>
                        <label for="email" class="fs-12  color-wh m-0 pl-2">Remember Me</label>
                    </div>
                    <div class="ml-auto">
                        <router-link :to="{name:'forget'}">
                            <p class="mb-0 fs-12  mb-1">Forget Password?</p>
                        </router-link>
                        <router-link :to="{name:'login'}">
                            <p class="mb-0 fs-12 ">Already a member?</p>
                        </router-link>
                    </div>
                </div>

                <button class="btn btn-primary pl-4 pr-4 mb-4 mt-4 auth-btn">
                    <p class="mb-0 fs-12">Register</p>
                </button>

            </form>
        </div>
    </div>
</template>

<script>
    import {
        mapActions,
        mapState
    } from "vuex"


    export default ({
        data() {
            return {
                size: window.innerWidth,
                payload: {},
            }
        },

        computed: {
            ...mapState({
                error: state => state.error
            })
        },

        watch: {
            error() {
               console.log(this.error); 
            }
        },

        methods: {
            ...mapActions([
                'register'
            ]),

            registerUser() {
                this.register(this.payload).then((res) => {
                    if (res.success) this.$router.push({
                        name: 'discover'
                    });
                    this.error = res.payload;
                })
            }
        },

        mounted() {
            window.addEventListener('resize', () => {
                this.size = window.innerWidth
            })
        }
    })

</script>

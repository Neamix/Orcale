<template>
    <div class="login auth-page p-3">
        <div class="container p-5">
            <h2 class="color-wh fs-22 fw-600">Reset Password</h2>
            <p class="color-sv fs-13">Enter password that you can remember</p>
            <form class="login mt-4" @submit.prevent="resetPass()">
                <div class="form-group">
                    <label for="email" class="fs-12 fw-600 color-wh">Password</label>
                    <input type="password" placeholder="Password" class="form-control rg-input" name="password" v-model="password" />
                </div>
                 <div class="form-group">
                    <label for="email" class="fs-12 fw-600 color-wh">Confirm Password</label>
                    <input type="password" placeholder="Password" class="form-control rg-input" name="password_confirmation" v-model="password_confirmation" />
                </div>
                <button class="btn btn-primary pl-4 pr-4 mb-4 mt-4 auth-btn">
                    <p class="mb-0 fs-12">Reset Password</p>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
    props: ['email','token'],
    data() {
        return {
            password: '',
            password_confirmation: '',
        }
    },

    computed: {
        ...mapState({
            error: state => state.error
        })
    },

    watch: {
        error() {
             this.$notify({ type: "error", text: this.error.password });
        }
    },

    methods: {
        ...mapActions([
            'reset'
        ]),

        resetPass() {
            this.reset({
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                token: this.token
                }).then((res) => {
                    if(res.success) {
                        this.$router.push({name: 'login'});
                    } else {
                        this.$notify({ type: "error", text: "Password Must confirmed and be at min 8 character" });
                    }
                })
        }
    },
}
</script>
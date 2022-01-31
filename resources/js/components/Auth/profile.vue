<template>
    <div class="rg-container mt-4">
        <div class="settings d-grid">
            <section class="sec">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class=" text-whity fs-12 fw-500 mb-3">Configuration</h2>
                        <form class=" mt-4 pb-4" @submit.prevent="modifyUser({name: user.name})">
                            <div class="form-group">
                                <label class="mb-0 fs-12 text-gray">Email Address</label>
                                <span class="d-block color-wh fs-12">{{ user.email }}</span>
                            </div>
                            <div class="form-group">
                                <label class="mb-2 fs-12 text-gray">Username</label>
                                <input type="text" class="form-control  rg-input fs-12" name="name" v-model="user.name">
                            </div>
                            <button class="mt-4 green-btn fs-12">Update</button>
                        </form>
                        <h2 class=" text-whity fs-12 fw-500 mb-3 mt-4">Change Password</h2>
                        <p class="fs-12 text-white">Yo Hoody, in case of you change password make sure to remeber the
                            new password</p>
                        <form
                            @submit.prevent="passwordChange({password_old: password_old,password: password_new, password_confirmation: password_confirmation})"
                            class=" mt-4 pb-4">

                            <div class="form-group">
                                <label class="mb-2 fs-12 text-gray">Current Password</label>
                                <input type="password" class="form-control  rg-input fs-13 " name="currentpass"
                                    placeholder="Current Password" v-model="password_old">

                            </div>
                            <div class="form-group">
                                <label class="mb-2 fs-12 text-gray">New Password</label>
                                <input type="password" class="form-control  rg-input fs-13" name="newpass"
                                    placeholder="New Password" v-model="password_new">

                            </div>
                            <div class="form-group">
                                <label class="mb-2 fs-12 text-gray">New Password Confirmation</label>
                                <input type="password" class="form-control  rg-input fs-13 " name="newpass_confirmation"
                                    placeholder="New Password Confirm" v-model="password_confirmation">
                            </div>
                            <button class="mt-4 green-btn fs-12">Change password</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h2 class=" text-whity fs-12 fw-500 mb-3">Logout</h2>
                        <div class="logout mt-4">
                            <p class="fs-12 text-white">Yo Hoody,If yo logout anydata you didnt save will be
                                terminated,bye
                                we are waiting to see you again</p>
                            <a href="/users/logout">
                                <button class="mt-4 green-btn fs-12">Logout</button>
                            </a>
                            <div>
                                <div class="delete mt-4">
                                    <h2 class=" text-whity fs-12 fw-500 mb-3">Delete Account</h2>
                                    <div class="logout mt-4">
                                        <p class="fs-12 text-white">Yo Hoody,If yo delete your account two thing will
                                            happend , first one we will miss you bud secound you wont be able to retrive
                                            your data again</p>
                                        <button type="button" class="fs-12 green-btn" data-toggle="modal"
                                            data-target="#deleteModal" data-whatever="@getbootstrap"
                                            @click="$store.state.overlay = true">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Enter password">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <transition name="list">
            <overlay v-if="$store.state.overlay"></overlay>
        </transition>
    </div>
</template>

<script>
import {
    mapActions,
    mapState
} from 'vuex'
import overlay from '../Fragments/overlay.vue';
export default {
    data() {
        return {
            password_old: '',
            password_new: '',
            password_confirmation: '',
        }
    },
    components: {
        'overlay': overlay
    },
    computed: {
        ...mapState({
            user: state => state.user,
            error: state => state.error
        }),
    },

    watch: {
        error() {
            console.log(this.error);
             this.$notify({ type: "error", text: this.error.password });
        }
    },

    methods: {
        ...mapActions([
            'password',
            'modify'
        ]),
        passwordChange(payload = {}) {
            this.password(payload).then((res) => {
                if (res.success) {
                    this.$notify({
                        type: "success",
                        text: "Password has been changed successfully"
                    });
                    this.password_new = '';
                    this.password_confirmation = '';
                    this.password_old = '';
                } else {
                    this.$notify({
                        type: "error",
                        text: res.payload
                    });
                }
            });
        },
        modifyUser(payload) {
            console.log(payload);
            this.modify(payload).then((res) => {
                this.$notify({
                    type: 'success',
                    text: res.payload
                })
            })
        }
    },
    mounted() {
        console.log(this.name);
    }
}
</script>

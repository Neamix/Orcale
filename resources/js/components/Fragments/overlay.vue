<template>
    <div class="overlay position-fixed w-100 h-100 top-0 left-0 d-flex justify-content-center align-items-center">
        <div class="del-model model p-3">
            <div class="model-header">
                <h2 class="color-wh fs-15 fw-600  pt-2">Delete Account</h2>
            </div>
            <div class="model-body">
                <p class="fs-13 color-sv pt-2 pb-2">
                    Are you sure that you want to delete your account? this action is irreversable
                </p>
            </div>
            <div class="model-footer pt-2 pb-2">
                <button class="btn btn-danger fs-12" @click="deleteAccount()">
                    Submit
                </button>
                <button class="btn btn-primary ml-2 fs-12" @click="$store.state.overlay = false">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
   props: ['model'],
   methods: {
        ...mapActions([
           'delete'
        ]),

        deleteAccount()
        {
            this.delete().then(()=>{
                this.$router.push({name: 'discover'})
            })
        }

   }
}
</script>
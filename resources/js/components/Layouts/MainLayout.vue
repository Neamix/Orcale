<template>
    <div class="layout">
        <x-navbar></x-navbar>
        <router-view></router-view>
        <x-footer class="mt-3"></x-footer>
    </div>
</template>

<script>
import Navbar from '../Fragments/Navbar.vue';
import Footer from '../Fragments/Footer.vue';
export default ({
    components: {
        'x-navbar': Navbar,
        'x-footer': Footer,
    },
    mounted() {
        
    }
});

</script>

<template>
    <div class="auth-container  screen_height p-5">
        <div class="inner-container d-flex justify-content-center">
            <div class="right-part h-100">
                <transition name="fade" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
        </div>
    </div>
</template>
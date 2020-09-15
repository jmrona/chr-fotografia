<template>
    <v-app>
        <navbar :app="this" class="d-none d-sm-flex"></navbar>
        <navbar-mobile :app="this" class="d-flex d-sm-none"></navbar-mobile>
        <v-container fluid class="mt-9">
            <spinner v-if="loading"></spinner>
            <v-row v-if="initiated">
                <!-- <transition name="custom-classes-transition"
                enter-active-class="animated zoomIn"
                leave-active-class="animated zoomOut"
                mode="out-in"
                :duration="{ enter: 900, leave: 300 }">
                    <router-view :app="this"></router-view>
                </transition> -->
                <transition name="custom-classes-transition"
                enter-active-class="animated bounceInUp"
                leave-active-class="animated bounceOutUp"
                mode="out-in"
                :duration="{ enter: 300, leave: 500 }">
                    <router-view :app="this"></router-view>
                </transition>
            </v-row>
            <footbar :app="this"></footbar>
        </v-container>
    </v-app>
</template>

<script>
import Navbar from './components/Navbar';
import NavbarMobile from './components/NavbarMobile';
import Footbar from './components/Footer';
import SocialMedia from './components/SocialMedia';
import ButtonScrollTop from './components/ButtonScrollTop';

export default {
    name: 'app',
    components: {
        Navbar,
        NavbarMobile,
        Footbar,
        SocialMedia,
        ButtonScrollTop,
    },
    data() {
        return {
            user: null,
            loading: false,
            initiated: false,
            isActive: true,
            req: axios.create({
                baseUrl: 'BASE_URL'
            })
        }
    },
    mounted(){
        this.init();
    },
    methods: {
        init(){
            this.loading = true;

            this.req.get('/auth/init').then(response => {
                this.user = response.data.user;
                this.loading = false;
                this.initiated = true;
            })
        }
    }
}
</script>

<style>
    .theme--light.v-application{
        height: 100%;
        background-image: url( '/img/background02.jpg') !important;
        background-size: cover;
    }
</style>

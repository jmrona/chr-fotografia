<template>
    <div class="container-fluid">
        <v-navigation-drawer app class=" pt-5"
        permanent
        expand-on-hover>
            <v-list nav dense class="menu">
                <v-list-item-group
                active-class="deep-grey--text text--accent-4"
                >
                    <router-link to="/">
                        <v-list-item>
                            <v-list-item-icon>
                            <v-icon :color="color" class="justify-center">fas fa-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>
                                Home
                            </v-list-item-title>
                        </v-list-item>
                    </router-link>

                    <router-link to="/portfolio">
                        <v-list-group
                        no-action
                        prepend-icon="fas fa-image"
                        append-icon="fas fa-angle-down"
                        value="true"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>Portfolio</v-list-item-title>
                            </template>

                            <v-list-item link @click="recargar"
                            :to="{ name: 'gallery', params: { id: album.id }}"
                            v-for="(album, index) in albums" :key="index">
                                <v-list-item-title class="pl-4">{{album.title}}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </router-link>

                    <router-link to="/about">
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon :color="color" class="justify-center">fas fa-info-circle</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>
                                About me
                            </v-list-item-title>
                        </v-list-item>
                    </router-link>

                    <router-link to="/contact">
                        <v-list-item>
                            <v-list-item-icon>
                            <v-icon :color="color" class="justify-center">fas fa-user</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>
                                Contact me
                            </v-list-item-title>
                        </v-list-item>
                    </router-link>
                </v-list-item-group>
            </v-list>
            <template v-if="!app.user" v-slot:append>
                <v-list nav dense class="menu">
                    <v-list-item-group
                    active-class="deep-grey--text text--accent-4">
                        <router-link to="/login">
                            <v-list-item>
                                <v-list-item-icon>
                                <v-icon :color="color" class="justify-center">fas fa-sign-in-alt</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>
                                    Login
                                </v-list-item-title>
                            </v-list-item>
                        </router-link>

                        <router-link to="/register">
                            <v-list-item>
                                <v-list-item-icon>
                                <v-icon :color="color" class="justify-center">fas fa-file-signature</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>
                                    Register
                                </v-list-item-title>
                            </v-list-item>
                        </router-link>
                    </v-list-item-group>
                </v-list>
            </template>
            <template v-else v-slot:append>
                <v-list nav dense class="menu">
                    <v-list-item-group
                    active-class="deep-grey--text text--accent-4">
                        <v-list-item>
                            <v-list-item-icon>
                            <v-icon :color="color" class="justify-center">fas fa-sign-out-alt</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title @click="logout">
                                Logout
                            </v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </template>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    name: 'navbar',
    props: ['app'],
    data: () => ({
      color: 'black',
      albums: [
            // {img: '/img/woman-portraits.jpg',
            //  title:'Girls Portraits',
            //  description:'Lorem ipsumI enjoy creating memorable looks and make extraordinary photo sessions. I was honoured to work with such top-models as Tyra Banks and Iman.',
            //  url: { name: 'gallery', params: { id: 1 }},
            //  urlLazy: ''},
            // {img: '/img/men-portraits.jpg',
            //  title:'Boys Portraits',
            //   description:'Photo portrait is the art of depicting person’s inner world by means of camera. I create peculiar portraits highlighting hidden pieces of personality.',
            //   url: { name: 'gallery', params: { id: 2 }},
            //   urlLazy: ''},
            // {img: '/img/love-story.jpg',
            //  title:'Love Stories',
            //  description:'Romantic love story photoshoot is the most popular direction. Happy couples emit their love to the camera and photos show these feeling are real and fair.',
            //  url: { name: 'gallery', params: { id: 3 }},
            //  urlLazy: ''},
            // {img: '/img/photo-shoop.jpg',
            //  title:'Photo-shoot',
            //  description:'Charisma, charm, magnetism, temptation – all these words characterise the total ambience of this photo session, depicting true elegance and grace.',
            //  url: { name: 'gallery', params: { id: 4 }},
            //  urlLazy: ''},
            // {img: '/img/imagery.jpg',
            //  title:'Imagery',
            //  description:'Nuanced photos are a very delicate and elegant  – I create immaculate photos which look more than catchy. Portrait made in nuanced style are the most touchy.',
            //  url: { name: 'gallery', params: { id: 5 }},
            //  urlLazy: ''},
            // {img: '/img/landscapes.jpg',
            //  title:'Landscapes',
            //  description:'Our new high-quality cell phone cases are not just a popular photo product for your clients—they’re also a high-impact marketing tool for your photography business.',
            //  url: { name: 'gallery', params: { id: 6 }},
            //  urlLazy: ''},
        ],
    }),
    mounted() {
        this.getPortfolios()
    },
    methods: {
        logout(){
            this.app.req.post('auth/logout').then(() => {
                this.app.user = null;
                this.$router.push('/login');
            })
        },
        async getPortfolios(){
            this.loading = true;

            await axios.get('/portfolio')
            .then( response => {
                this.albums = response.data;
                this.loading = false;
                // console.log(this.albums);
            })
            .catch( error => {
                console.log(error);
            })
        },
        recargar(){
            location.reload();
        }
    }
};
</script>

<style>
    .menu a{
        text-decoration: none;
    }
    .v-list-item__title{
        font-size: 16px !important;
        font-family: Comfortaa !important;
    }
    .v-list-item--active{
        background-color:
    }
</style>

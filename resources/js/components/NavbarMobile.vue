<template>
    <div>
        <v-app-bar app
        elevate-on-scroll
        color="rgba(0,0,0,.87)"
        dark
        >
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
            <v-toolbar-title>Cristian Galindo</v-toolbar-title>
            <v-spacer></v-spacer>
            <div v-if="!app.user" class="collapse-on-scroll" collapse-on-scroll>
                <router-link to="/login">
                    <v-btn text x-small>
                        Login
                    </v-btn>
                </router-link>
                <router-link to="/register">
                    <v-btn text x-small>
                        Register
                    </v-btn>
                </router-link>
            </div>
            <v-btn v-else text x-small @click="logout" href="javascript:;" >Logout</v-btn>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" fixed temporary>
            <v-list nav dense class="menu pt-5">
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

                            <v-list-item link :to="album.url"
                            v-for="(album, index) in albums" :key="index">
                                <v-list-item-title class="pl-4">{{album.title}}</v-list-item-title>
                            </v-list-item>
                        </v-list-group>
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
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    name: 'navbar-mobile',
    props: ['app'],
    data: () => ({
      drawer: false,
      color: 'black',
       albums: [
            {img: '/img/woman-portraits.jpg',
             title:'Girls Portraits',
             description:'Lorem ipsumI enjoy creating memorable looks and make extraordinary photo sessions. I was honoured to work with such top-models as Tyra Banks and Iman.',
             url: 'gallery/1',
             urlLazy: ''},
            {img: '/img/men-portraits.jpg',
             title:'Boys Portraits',
              description:'Photo portrait is the art of depicting person’s inner world by means of camera. I create peculiar portraits highlighting hidden pieces of personality.',
              url: 'gallery/2',
              urlLazy: ''},
            {img: '/img/love-story.jpg',
             title:'Love Stories',
             description:'Romantic love story photoshoot is the most popular direction. Happy couples emit their love to the camera and photos show these feeling are real and fair.',
             url: 'gallery/3',
             urlLazy: ''},
            {img: '/img/photo-shoop.jpg',
             title:'Photo-shoot',
             description:'Charisma, charm, magnetism, temptation – all these words characterise the total ambience of this photo session, depicting true elegance and grace.',
             url: 'gallery/4',
             urlLazy: ''},
            {img: '/img/imagery.jpg',
             title:'Imagery',
             description:'Nuanced photos are a very delicate and elegant  – I create immaculate photos which look more than catchy. Portrait made in nuanced style are the most touchy.',
             url: 'gallery/5',
             urlLazy: ''},
            {img: '/img/landscapes.jpg',
             title:'Landscapes',
             description:'Our new high-quality cell phone cases are not just a popular photo product for your clients—they’re also a high-impact marketing tool for your photography business.',
             url: 'gallery/6',
             urlLazy: ''},
        ],
    }),
    methods: {
        logout(){
            this.app.req.post('/auth/logout').then(() => {
                this.app.user = null;
                this.$router.push('/login');
            })
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
    .v-app-bar{
        left: 0 !important;
    }
</style>

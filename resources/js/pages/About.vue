<template>
    <div>
        <v-container fluid>
            <v-row no-gutters>
                <v-col cols="12" sm="12" md="6">
                    <v-card  flat color="transparent" v-if="!loading">
                        <v-card-title class="card-title-1 mb-n6 ">
                            <h1 class="ma-0">{{title}}</h1>
                            <v-card-actions v-if="!editAboutMe && app.user">
                                <v-btn
                                outlined
                                small
                                fab
                                color="orange"
                                @click="editAboutMe = !editAboutMe">
                                    <v-icon small color="orange">fas fa-edit</v-icon>
                                </v-btn>
                            </v-card-actions>
                            <v-card-actions v-if="editAboutMe && app.user">
                                <v-btn
                                outlined
                                small
                                fab
                                color="orange"
                                @click="editAboutMe = !editAboutMe">
                                    <v-icon small color="orange">fas fa-times</v-icon>
                                </v-btn>
                                <v-btn
                                outlined
                                small
                                fab
                                color="green"
                                @click="updateAboutMe();updateSocialMedia()">
                                    <v-icon small color="green">fas fa-save</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </v-card-title>
                        <v-card-title v-if="isMobile" class="display-3">
                            <p >
                                {{subtitle}}
                            </p>
                        </v-card-title>
                        <v-card-title v-else class="display-4">
                            <p>
                                {{subtitle}}
                            </p>
                        </v-card-title>
                        <v-card-text class="font-weight-medium mt-n5 card-text">
                            {{description}}
                        </v-card-text>
                        <v-card-text class="card-text">
                            If you like my works Follow me:
                        </v-card-text>
                        <social-media></social-media>
                    </v-card>
                </v-col>
                <v-col  cols="12" sm="12" md="6">
                    <form @submit.prevent="updateAboutMe">
                        <input type="hidden" name="_method" value="PUT">
                        <v-card v-if="editAboutMe" flat>
                            <v-card-title class="card-title-1 mb-n6 ">
                                <v-text-field
                                type="text"
                                v-model="title"
                                label="title">
                                </v-text-field>
                            </v-card-title>
                            <v-card-title class="display-4">
                                <v-text-field
                                type="text"
                                v-model="subtitle"
                                label="subtitle">
                                </v-text-field>
                            </v-card-title>
                            <v-card-text class="font-weight-medium mt-n5 card-text">
                                <v-textarea
                                type="text"
                                v-model="description"
                                label="description">
                                </v-textarea>
                            </v-card-text>
                        </v-card>
                    </form>
                    <form @submit.prevent="updateSocialMedia" v-if="editAboutMe && app.user">
                        <input type="hidden" name="_method" value="PUT">
                        <v-card flat>
                            <v-card-text>
                                <v-text-field v-for="(icon, index) in icons" :key="index"
                                :label="icon.name"
                                :prepend-icon="icon.icon"
                                :color="icon.color"
                                v-model="icon.url"
                                ></v-text-field>
                            </v-card-text>
                        </v-card>
                    </form>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import SocialMedia from '../components/SocialMedia'

export default {
    name: 'about',
    components: {
        SocialMedia,
    },
    props: ['app'],
    data: () => ({
        isMobile: false,
        loading: false,
        editAboutMe: false,
        title: '',
        subtitle: '',
        description: '',
        icons: [
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
        ],
    }),
    computed: {
        activeFab () {
            switch (this.tabs) {
            case 'one': return { class: 'purple', icon: 'account_circle' }
            case 'two': return { class: 'red', icon: 'edit' }
            case 'three': return { class: 'green', icon: 'keyboard_arrow_up' }
            default: return {}
            }
        },
    },
    mounted (){
        this.checkSize();
        this.getAboutMe();
        this.getSocialMedia();
    },
    methods: {
        checkSize(){
            if(window.innerWidth < 600){
                this.isMobile = true
            }
        },
        async getAboutMe(){
            this.loading = true;
            await axios.get('/about')
            .then(response => {
                this.title = response.data[0].title;
                this.subtitle = response.data[0].subtitle;
                this.description = response.data[0].description;
                this.loading = false;
            })
            .catch (error => {
                console.log(error);
            })
        },
        async getSocialMedia(){
            await axios.get('/socialmedia')
            .then(response => {
                let socialMedia = response.data
                var i = 0;
                socialMedia.forEach(element => {
                    this.icons[i].name = element.name
                    this.icons[i].icon = element.icon
                    this.icons[i].url = element.url
                    this.icons[i].color = element.color
                    this.icons[i].sort = element.sort
                    i++;
                });
                // console.log(this.icons)
            })
            .catch (error => {
                console.log(error);
            })
        },
        updateAboutMe(){
            const params = {
                title: this.title,
                subtitle: this.subtitle,
                description: this.description
            }

            axios.put('/about', params)
            .then( response =>{
                this.title = response.data.title;
                this.subtitle = response.data.subtitle;
                this.description = response.data.description;
                this.editAboutMe = false
                this.updateSocialMedia();
            })


        },
        updateSocialMedia(){
            const params = {
                icons: this.icons
            }
            axios.put('/socialmedia', params)
            .then( response =>{
                this.getSocialMedia();
            }).catch (error => {
                console.log(error)
            })
        }
    }
}
</script>

<style>
    .card-text{
        font-family: Domine !important;
        font-size: 18px
    }
    .card-title-1{
        font-family: Comfortaa !important;
    }
    span{
        color: #fa4242 ;
    }
    #create .v-speed-dial {
        position: absolute;
    }

    #create .v-btn--floating {
        position: relative;
    }
</style>

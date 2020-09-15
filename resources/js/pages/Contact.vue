<template>
    <div>
        <v-container fluid>
            <v-row no-gutters>
                <v-col sm="12" md="12">
                    <v-card flat color="transparent">
                        <v-card-title class="card-title-1 mb-n6 ">
                            <h1 class="ma-0">Contact</h1>
                        </v-card-title>
                        <v-card-title v-if="isMobile" class="display-3">
                            <p >
                                Get in<span> touch</span>
                            </p>
                        </v-card-title>
                        <v-card-title v-else class="display-4">
                            <p>
                                Get in<span> touch</span>
                            </p>
                        </v-card-title>
                        <v-card-text class="font-weight-medium mt-n5 card-text"
                        >
                            <v-form @submit.prevent="onSubmit">
                                <div v-if="errors">
                                    <v-alert dense outlined type="error" v-for="(item, index) in errors" :key="index">
                                        {{item}}
                                    </v-alert>
                                </div>
                                <v-text-field
                                :color="color"
                                type="text"
                                v-model="name"
                                label="Name"
                                :rules="rulesName"
                                hide-details="auto"></v-text-field>
                                <v-text-field class="mt-4" :rules="rulesEmail" hide-details="auto" :color="color" type="email" v-model="email" label="E-mail"></v-text-field>
                                <v-text-field class="mt-4" :rules="rulesSubject" hide-details="auto" :color="color" type="text" v-model="subject" label="Subject"></v-text-field>
                                <v-textarea class="mt-4" :rules="rulesQuestion" hide-details="auto" :color="color" label="Question" v-model="question" auto-grow rows="3" row-height="25" shaped></v-textarea>
                            </v-form>
                        </v-card-text>
                        <v-card-actions class="justify-center">
                            <v-btn @click="onSubmit" outlined large :color="color" dark>Send</v-btn>
                        </v-card-actions>
                        <v-card-text class="card-text mt-5">
                            If you like my works Follow me:
                        </v-card-text>
                        <social-media></social-media>
                    </v-card>
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
        name: '',
        email: '',
        subject: '',
        question: '',
        errors: [],
        color: '#fa4242',
        rulesName: [
            value => !!value || 'Name is required.',
        ],
        rulesEmail: [
            value => !!value || 'E-mail is required.',
            value => (value && value.indexOf('@') >= 1) || 'Enter a valid email',
        ],
        rulesSubject: [
            value => !!value || 'Subject is required.',
            value => (value && value.length >= 5) || 'Min 5 characters',
        ],
        rulesQuestion: [
            value => !!value || 'Question is required.',
            value => (value && value.length >= 10) || 'Min 10 characters',
        ],
    }),
    mounted (){
        this.checkSize();
    },
    methods: {
        checkSize(){
            if(window.innerWidth < 600){
                this.isMobile = true
                console.log(window.innerWidth)
            }
        },
        onSubmit(){
            this.errors = [];
            if(!this.name) {
                this.errors.push('Name is required.');
            }
            if(!this.subject) {
                this.errors.push('Subject is required.');
            }
            if(!this.email) {
                this.errors.push('E-mail is required.');
            }
            if(!this.question) {
                this.errors.push('Question is required.');
            }

            if(!this.errors.length){
                const data = {
                    name: this.name,
                    email: this.email,
                    question: this.question
                }
                this.app.req.post('auth/register', data).then(response => {
                    this.app.user = response.data;
                    this.$router.push("/");
                    this.errors = [];
                }).catch(error => {
                    this.errors.push(error.response.data.error);
                })
            }
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
</style>

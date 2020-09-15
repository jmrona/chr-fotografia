<template>
    <v-container fluid>
        <v-row>
            <v-col sm="12" md="8">
                <v-card class="my-5 p-3">
                    <v-card-title class="justify-center">
                        Login
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="onSubmit">
                            <div v-if="errors">
                                <v-alert dense outlined type="error" v-for="(item, index) in errors" :key="index">
                                    {{item}}
                                </v-alert>
                            </div>
                            <v-text-field
                            type="text"
                            :color="color"
                            v-model="email"
                            label="E-mail"
                            :rules="rulesEmail"></v-text-field>
                            <v-text-field
                            type="password"
                            :color="color"
                            v-model="password"
                            label="Password"
                            :rules="rulesPassword"></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="align-center px-5">
                        <v-btn @click="onSubmit" outlined block :color="color" dark>
                            <v-icon left size="15px">fas fa-sign-in-alt</v-icon> Login
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name:'login',
    props: ['app'],
    data () {
        return {
            email: '',
            password: '',
            errors: [],
            color: '#fa4242',
            rulesEmail: [
                value => !!value || 'E-mail is required.',
                value => (value && value.indexOf('@') >= 1) || 'Enter a valid email',
            ],
            rulesPassword: [
                value => !!value || 'Password is required.',
                value => (value && value.length >= 6) || 'Min 6 characters',
            ],
        }
    },
    mounted () {
    },
    methods: {
        onSubmit(){
            this.errors = [];
            if(!this.email) {
                this.errors.push('E-mail is required.');
            }
            if(!this.password) {
                this.errors.push('Password is required.');
            }

            if(!this.errors.length){
                const data = {
                    email: this.email,
                    password: this.password
                }
                this.app.req
                .post('auth/login', data)
                .then(response => {
                    this.app.user = response.data;
                    this.$router.push("/");
                }).catch(error => {
                    this.errors.push(error.response.data.error);
                })
            }
        },
    }
}
</script>

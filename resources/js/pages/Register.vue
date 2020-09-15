<template>
    <v-container fluid>
        <v-row>
            <v-col sm="12" md="8">
                <v-card class="my-5">
                    <v-card-title class="justify-center">
                        Register
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="onSubmit">
                            <div v-if="errors">
                                <v-alert dense outlined type="error" v-for="(item, index) in errors" :key="index">
                                    {{item}}
                                </v-alert>
                            </div>
                            <v-text-field :color="color" :rules="rulesName" type="text" v-model="name" label="Name"></v-text-field>
                            <v-text-field :color="color" :rules="rulesEmail" type="text" v-model="email" label="E-mail"></v-text-field>
                            <v-text-field :color="color" :rules="rulesPassword" type="password" v-model="password" label="Password"></v-text-field>
                            <v-text-field :color="color" :rules="rulesPassword" type="password" v-model="confPassword" label="Confirm Password"></v-text-field>

                            <v-card-actions>
                                <v-btn @click="onSubmit" outlined block :color="color" dark>Register</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>

        </v-row>

    </v-container>
</template>

<script>
export default {
    name:'register',
    props: ['app'],
    data () {
        return {
            name: '',
            email: '',
            password: '',
            confPassword:'',
            errors: [],
            color: '#fa4242',
            rulesName: [
                value => !!value || 'Name is required.',
                value => (value && value.length >= 3),
            ],
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
    methods: {
        onSubmit(){
            this.errors = [];
            if(this.name === '') {
                this.errors.push('Name is required.');
            }
            if(this.email === '') {
                this.errors.push('E-mail is required.');
            }
            if(!this.password) {
                this.errors.push('Password is required.');
            }
            if(!this.confPassword) {
                this.errors.push('Password confirmation is required.');
            }
            if(this.password !== this.confPassword){
                this.errors.push('Passwords do not match.');
            }

            if(!this.errors.length){
                const data = {
                    name: this.name,
                    email: this.email,
                    password: this.password
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

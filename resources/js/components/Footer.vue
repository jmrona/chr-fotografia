<template>
    <v-container fluid>
        <v-row>
            <v-footer absolute dark padless class="font-weight-medium">
                <v-card class="flex" flat tile >
                    <!-- <v-card-title class="teal" >
                        <strong class="subheading">Get connected with us on social networks!</strong>

                        <v-spacer></v-spacer>

                        <v-btn
                        v-for="icon in icons"
                        :key="icon"
                        class="mx-4"
                        dark
                        icon
                        >
                        <v-icon size="24px">{{ icon }}</v-icon>
                        </v-btn>
                    </v-card-title> -->

                    <v-card-text class="py-2 white--text text-center">
                        <span>
                            <strong><a>JmRona&copy; {{ new Date().getFullYear() }}</a></strong>
                        </span>
                        —
                        <strong>Cristian Galindo</strong>
                    </v-card-text>
                </v-card>
            </v-footer>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'footbar',
    props: ['app'],
    data: () => ({
        icons: [
        'fab fa-facebook',
        'fab fa-twitter',
        'fab fa-google-plus',
        'fab fa-linkedin',
        'fab fa-instagram',
      ],
    }),
    methods: {}
};
</script>

<style>
    span a{
        color: #fa4242 !important;
        text-decoration: none;
    }
</style>


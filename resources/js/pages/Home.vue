<template>
    <v-container fluid>
        <v-row id="widthScreen">
            <v-col cols="12" sm="12" md="6" style="background-color: white; width: 100%;">
                <h1>hola</h1>
            </v-col>
            <v-col cols="12" sm="12" md="6" style="background-image: url(img/woman-portraits.jpg); background-size:cover; width: 100%;">
                <h1>hola</h1>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'home',
    components: {
    },
    props: ['app'],
    data: () => ({
        widthScreen : ''
    }),
    mounted () {
        //this.widthScreen = window.innerWidth
        //document.getElementById('widthScreen').setAttribute('style', 'width:'+this.widthScreen+'px !important');
    },
}
</script>

<style>
    /* .container{
        margin: 0 !important;
        margin-top: -36px !important;
        padding-top: 0 !important;
    } */
</style>

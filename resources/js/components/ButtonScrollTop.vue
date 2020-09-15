<template>
    <div>
        <v-fab-transition>
            <v-btn
                key="keyboard_arrow_up"
                :color="color"
                absolute
                fab
                large
                dark
                bottom
                right
                class="v-btn--example d-flex d-md-none"
                @click="topFunction"
            >
                <v-icon>fas fa-arrow-up</v-icon>
            </v-btn>
        </v-fab-transition>
    </div>
</template>

<script>
export default {
    name: 'button-scroll',
    props: ['app'],
    data: () => ({
        color: '#fa4242',
    }),
    methods: {
        topFunction(){
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    }
}
</script>

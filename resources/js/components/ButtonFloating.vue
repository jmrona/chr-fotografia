<template>
    <div>
        <v-card id="create">
            <v-speed-dial
            v-model="fab"
            :top="top"
            :bottom="bottom"
            :right="right"
            :left="left"
            :direction="direction"
            :open-on-hover="hover"
            :transition="transition"
            >
                <template v-slot:activator>
                    <v-btn
                    v-model="fab"
                    color="red darken-2"
                    dark
                    fab
                    >
                    <v-icon v-if="fab">mdi-close</v-icon>
                    <v-icon v-else>fas fa-cogs</v-icon>
                    </v-btn>
                </template>
                <v-btn
                    fab
                    dark
                    small
                    color="orange"
                >
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </v-speed-dial>
        </v-card>
    </div>
</template>

<script>
export default {
    name: 'social-media',
    props: ['app'],
    data: () => ({
        direction: 'top',
        fab: false,
        fling: false,
        tabs: null,
        top: false,
        hover: false,
        right: true,
        bottom: true,
        left: false,
        transition: 'slide-y-reverse-transition',
    }),
    mounted (){

    },
    methods: {
    }
}
</script>

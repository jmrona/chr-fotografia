<template>
    <div>
        <v-card flat color="transparent">
            <v-card-actions>
                <v-btn
                v-for="(item, index) in icons"
                :key="index"
                class="mx-1 mt-n5"
                icon
                small
                :color="item.color"
                :href="item.url"
                v-if="item.url"
                >
                <v-icon size="18px">{{ item.icon }}</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: 'social-media',
    props: ['app'],
    data: () => ({
        icons: [
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
            {name: '', icon: '', color: '', url: ''},
        ],
    }),
    mounted (){
        this.getSocialMedia();
    },
    methods: {
        async getSocialMedia(){
            await axios.get('/socialmedia')
            .then(response => {
                let socialMedia = response.data
                let i = 0;
                socialMedia.forEach(element => {
                    this.icons[i].name = element.name
                    this.icons[i].icon = element.icon
                    this.icons[i].url = element.url
                    this.icons[i].color = element.color
                    this.icons[i].sort = element.sort
                    i++;
                });
            })
            .catch (error => {
                console.log(error);
            })
        },
    }
}
</script>

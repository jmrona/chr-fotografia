<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12" sm="12" md="8">
                <v-card flat color="transparent">
                    <v-card-title class="card-title-1 ">
                        <h1 class="ma-0">Gallery <span>{{title}}</span> </h1>
                        <v-card-actions
                        v-if="!editImage && !addImage && app.user">
                            <v-btn
                            outlined
                            small
                            fab
                            color="orange"
                            @click="editImage = !editImage">
                                <v-icon small color="orange">fas fa-edit</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-actions
                        v-if="!addImage && !editImage && app.user">
                            <v-btn
                            outlined
                            small
                            fab
                            color="green"
                            @click="addImage = !addImage">
                                <v-icon small color="green">fas fa-plus</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-actions
                        v-if="editImage && !addImage && app.user">
                            <v-btn
                            outlined
                            small
                            fab
                            color="orange"
                            @click="editImage = !editImage">
                                <v-icon small color="orange">fas fa-times</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-actions
                        v-if="addImage && !editImage && app.user">
                            <v-btn
                            outlined
                            small
                            fab
                            color="green"
                            @click="addImage = !addImage;cleanErrors()">
                                <v-icon small color="green">fas fa-times</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>
        <v-row no-gutters v-if="!editImage && !addImage">
            <LightGallery
            :images="images"
            :index="index"
            :disable-scroll="true"
            @close="index = null"
            />

            <v-col v-for="(image, thumbIndex) in images" :key="thumbIndex"
            class="d-flex child-flex"
            cols="4"
            @click="index = thumbIndex"
            >
                <v-card flat tile class="d-flex">
                    <v-img
                    v-show="image.visibility"
                    :src="image.url"
                    :lazy-src="imgDefault"
                    :aspect-ratio="image.ratio"
                    :position="image.position"
                    class="grey lighten-2"
                    >
                    <template v-slot:placeholder>
                        <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                        >
                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                        </v-row>
                    </template>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
        <v-row no-gutters v-if="!editImage && addImage">
            <form @submit.prevent="addNewImage">
                <div v-if="errors">
                    <v-alert dense outlined type="error" v-for="(item, index) in errors" :key="index">
                        {{item}}
                    </v-alert>
                </div>
                <v-col cols="12">
                    <v-card>
                    <v-card-title class="mb-4">
                        <v-col cols="12" sm="9">
                            <v-file-input
                            small-chips
                            accept="image/*"
                            show-size
                            prepend-icon="fas fa-camera-retro"
                            v-model="newImage.img"
                            label="Upload image"
                            :rules = "rulesImg"
                            @change="uploadPhoto($event)"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field
                            type="number"
                            v-model="newImage.sort"
                            label="Sort">
                            </v-text-field>
                        </v-col>

                        <v-label>Resolution</v-label>
                        <v-col cols="12" md="3">
                                <v-text-field
                                type="number"
                                :rules="rulesWidth"
                                v-model="newImage.width"
                                label="Width (px)">
                                </v-text-field>
                        </v-col>
                        <v-col cols="12" md="3">
                                <v-text-field
                                type="number"
                                :rules="rulesHeight"
                                v-model="newImage.height"
                                label="Height (px)">
                                </v-text-field>
                        </v-col>
                        <v-label>Visibility</v-label>
                        <v-col cols="12" md="3">

                            <v-switch v-model="newImage.visibility"
                            inset
                            ></v-switch>
                        </v-col>


                        <v-btn @click="addNewImage" color="green" block outlined>
                            <v-icon left dark small>fas fa-upload</v-icon>
                            upload image
                        </v-btn>
                        </v-card-title>
                    </v-card>
                </v-col>
            </form>
        </v-row>
        <v-row no-gutters v-if="editImage && !addImage">
            <v-col cols="12" md="4"
            v-for="(image, thumbIndex) in images" :key="thumbIndex"
            class="py-3 pa-2">
                <v-form @submit.prevent="updateImage(thumbIndex)">
                    <v-card flat tile>
                        <v-img
                            :src="image.url"
                            :lazy-src="imgDefault"
                            :aspect-ratio="image.ratio"
                            :position="image.position"
                            class="grey lighten-2">
                            <template v-slot:placeholder>
                                <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                                >
                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                </v-row>
                            </template>
                            <v-card-actions>
                                <v-tooltip right>
                                    <template v-slot:activator="{ on }">
                                        <v-btn small fab
                                        @click="deleteImage(image.id, image.portfolioId)" v-on="on">
                                            <v-icon color="red">
                                                fas fa-trash
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span style="color: white">Delete album</span>
                                </v-tooltip>
                            </v-card-actions>
                            <v-card-actions>
                                <v-tooltip right>
                                    <template v-slot:activator="{ on }">
                                        <v-btn small fab v-on="on"
                                        @click="image.visibility = !image.visibility">
                                            <v-icon color="blue" v-if="image.visibility">
                                                fas fa-eye
                                            </v-icon>
                                            <v-icon color="gray" v-else>
                                                fas fa-eye-slash
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span style="color: white">Visibility</span>
                                </v-tooltip>
                            </v-card-actions>
                            <!-- Insert justify buttons here
                                add these classes: d-flex child-flex
                                and margin-top: 90px
                            -->
                        </v-img>
                        <v-card-title class="mb-n4">
                            <v-card-actions style="margin: 0 auto;">
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn small tile v-on="on"
                                            :class="{ 'dark-btn' : image.position == 'right'}"
                                            @click="changePosition(thumbIndex, 'right');">
                                                <v-icon>
                                                    fas fa-align-right
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span style="color: white">Justify right</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn small tile v-on="on"
                                            :class="{ 'dark-btn' : image.position == 'center'}"
                                            @click="changePosition(thumbIndex, 'center');">
                                                <v-icon>
                                                    fas fa-align-center
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span style="color: white">Justify center</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn small tile v-on="on"
                                            :class="{ 'dark-btn' : image.position == 'left'}"
                                            @click="changePosition(thumbIndex, 'left');">
                                                <v-icon>
                                                    fas fa-align-left
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span style="color: white">Justify left</span>
                                    </v-tooltip>
                            </v-card-actions>
                            <v-card-actions>

                            <v-col cols="12" md="4">
                                <v-text-field
                                type="number"
                                v-model="image.sort"
                                label="Sort">
                                </v-text-field>
                            </v-col>
                            <v-select
                                :items="aspectRatios"
                                label="Aspect-Ratio"
                                :value="image.ratio"
                                @change="changeRatio(thumbIndex, $event)"
                            ></v-select>
                            </v-card-actions>

                        </v-card-title>
                        <v-card-actions>
                            <v-btn
                            outlined
                            block
                            color="orange"
                            @click="updateImage(thumbIndex)"
                            >
                                <v-icon left small text>
                                    fas fa-edit
                                </v-icon>
                                Edit
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
        <button-scroll></button-scroll>
    </v-container>
</template>

<script>
import {LightGallery} from 'vue-light-gallery';
import ButtonScrollTop from '../components/ButtonScrollTop'

export default {
    name: 'gallery',
    components: {
        LightGallery,
        'button-scroll': ButtonScrollTop,
    },
    props: ['app'],
    data: () => ({
        isMobile: false,
        index: null,
        editImage: false,
        addImage: false,
        title: null,
        aspectRatios: ['16:9','1','1.85','2.35','0.8','0.5','0.25'],
        newImage:{
            img: null,
            portfolioId: null,
            position: 'center',
            width: '1920',
            height: '1080',
            ratio: '16:9',
            visibility: true,
            sort: null
        },
        errors: [],
        rulesImg: [
            value => !!value || 'Image is required.',
        ],
        rulesWidth: [
            value => !!value || 'Width value is required.',
        ],
        rulesHeight: [
            value => !!value || 'Height value is required.',
        ],
        images: [],
        color: '#fa4242',
        imgDefault: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQoAAADICAYAAAAQnK/CAAAQOElEQVR4Xu2diVIcRxJAc7gPIUBciwBx+5D+/z9kb9jeCMMwA0hmACEwII7RwEb2ml0Wg6r6zmpeRyhEBNXd2a+yHzk11dW11tHJrbBBAAIQ+AaBGqIgPyAAARcBROEixO8hAAFBFCQBBCDgJIAonIhoAAEIIApyAAIQcBJAFE5ENIAABBAFOQABCDgJIAonIhpAAAKIghyAAAScBBCFExENIAABREEOQAACTgKIwomIBhCAAKIgByAAAScBROFERAMIQABRkAMQgICTAKJwIqIBBCCAKMgBCEDASQBROBHRAAIQQBTkAAQg4CSAKJyIaAABCCAKcgACEHASQBRORDSAAAQQBTkAAQg4CSAKJyIaQAACiIIcgAAEnAQQhRMRDSAAAURBDkAAAk4ClRbF169fpX19LVdXV3J5eSlf21/lRnjVqjMraBCLQE1Eunt6ZKC/X/oHBqS3tzf6V6vpb6qxVVIU19fXcrC/L2dnZ9Jut6XT6VSjt7gK8wRUDiqJwaFBmZ6ekaGhIfMx+wRYKVFoBXF0dCT7rRZy8Ol92uROYGJiQqZnZqSvry/3c+V5gsqI4uryUnZ2duT8/DxPXhwbArEJqCRev34to2Njsfe1skMlRPHlyxdpbG1FHzPYIGCRQHd3t8zPz8vY+LjF8JwxBS8KHaTcqtdFxyXYIGCZQFdXVySL8VevLIf5aGxBi+Km05H6Vl3Oz/i4EVzmPdOAdaBzZXVVBgYGgiIQtCg+fvggBwcHQQEnWAi8fPlSlpaXg/r6NFhR6ODl5uYm4xLcd0ESWFxakrGABjeDFUWr1ZK9P/4IMkkIGgLDw8PRRxAdtwhhC1IUt7e38q/ffmMAM4QMI8ZHCei3IGvr68GMVQQpCp0rsfH776QgBIImsPDmjbwK5BuQIEWR5GPH4OBg1Cl9/f1BJxfB2yOgM4KPP3+OHhnQatd3069J37x549u81HZBiqLZbEYd47vp50EdZe7p6fHdhXYQiEXgpnMju7s78jlGXg4ODcl3330X6zxlNQ5SFJsbG5G9fTeVxOjoqG9z2kEgEQF9SlnHznw3ndr949u3vs1LbRegKG5l4/cN72c69Gm+tbV1GRquxlN8pWYLJ3cS+On9e2ebuwY6+ertu3fe7ctsGJwo9DOgVhS+D3911Wqyur5emcd9y0wWzu0mgCjcjAppgSgKwcxJEhJAFAnBZb0bosiaKMfLkgCiyJJmimMhihTw2DV3Aogid8R+J0AUfpxoVQ4BRFEO97+dFVEY6QjCeJQAojCSGIjCSEcQBqKwnAOIwnLvEBsVhZEcsCYKjUfX6tSl+HTtzouLi+hnXX1Lt67u7mgFZn3WRJdu15+r9s4HI6lhIgxEYaIbJHroxsKEK41DJ30dHhxEclBZuB4Iunvnw8DgoExNTYk+g1Kll8QYSZFSw0AUpeL/38nLFoWeXxf01XeHnJycOOXwFDYVxMvRUZmZmYnWJEAYRhIsZRiIIiXArHYvUxR67v39/aiK0EeLs9j0idbJqSmZnp5GFlkALfkYiKLkDrg7fVmiUDHoYr5xHiOOg2x8fFxez83xKHwcaAbbIgojnVKGKG5ubqTRaMjZ6WnijxoufPrR48WLF9G6GaGso+i6puf4e0RhpNeLFoVKYmd7W46PjwshoCsz6xJpyKIQ3JmfBFFkjjTZAYsWhY5HfPz4MbdK4iEFrSz0PZU6bsEWHgFEYaTPihSFfu2pi/hqVVHkptWErtCscy/YwiKAKIz0V1GiiMYltrbk9PS0lCsfGRlhvKIU8ulOiijS8cts76JEoZOp6vX6f2dYZnYBngfSGZ0rKyvRpCy2cAggCiN9VZQodnZ25OjTp1KvemJiQuYXFkqNgZPHI4Ao4vHKrXURouh0OvLrL78UPjbxEJqOVejiq/pWKbYwCCAKI/1UhCj0q9Bmo2HiipeWlmQ0oJfZmoBWYhCIokT4909dhCh2d3fl0+GhiSuenJyUufl5E7HkFYQOHFdl3giiyCtLYh43b1Ho8eubm7FeMBTzEmI119ma+tbrqj40po/m7+3tycLCQvT4fegbojDSg3mLQv+66dwJnUNhYdM1LFbX1irzF/c+U5XE1taWfG23ozkjOn1d1+sIeUMURnovb1HoQKaKQh8lt7DpDaSiqNqApkpCx4F0kZ+7Ta91eWUl6MoCUVi4ayT/hWsQRf4dfb+SeHi20CsLRJF//nidIe+Kgo8eXt2QuNFjlcRjsgi1skAUiVMj2x3zFgWDmdn211NjEq6zhFpZIApXzxb0+7xFoZfxYXdXDvl6NNMe9akkqlBZIIpM0yb5wYoQhakJV8vLMjo6mhyYgT2/NSbhCi+0ygJRuHq0oN8XIQqmcGfXmUkqiZArC0SRXe6kOlIRotAAd3d25FPpD4VNyvxCuLMy01QSoX4bgihS3d7Z7VyUKMp+zFznTejIf6iPmWdRSYRYWSCK7O71VEcqShQsXJO8m7KsJEKrLBBF8rzJdM+iRKFBsxRe/K7Lo5IIqbJAFPFzJpc9ihSFXkApi+vOzYk+NRralmclEUplgSiMZG3RomC5fr+OL6KSCKGyQBR++ZJ7q6JFoRdU2AuAdEHdpaXgnhQtspKwXlkgitwV4HeCMkShkfFKwcf7p4xKwnJlgSj87uPcW5UlCr2wvF5SPDU1JVMBvqS4zErCamWBKHJXgN8JyhTFnSx0rYr9VktOTk4Sv0FMV6zSqdnTMzMyMDAQ3ApWFioJi5UFovC7j3NvVbYo7l/g2dlZ9K2Ifo3abred0lA56HJv+vyCvjJQl7kLcbNUSVirLBCFkYy2JIq7CkMloSs1qTAuvnyJftbnRXTTGZa6vJvKYXBoKPpZZRHqGpgWKwlLlQWiQBRGCJQXhuVKwkplgSjKy8//O7O1isIIltzDCKGSsFBZIIrcU9HvBIjCj1OWrUKqJMquLBBFlpmX4liIIgW8BLuGWEmUWVkgigRJlscuiCIPqo8fM+RKoqzKAlEUl5/fPBOiKKYjqlBJlFFZIIpi8tN5FkThRJS6QZUqiaIrC0SROv2yOQCiyIbjU0epYiVRZGWBKPLNT++jIwpvVLEbVrmSKKqyQBSx0y6fHRBFPlyfQyVRRGWBKPLJz9hHRRSxkTl3eE6VRN6VBaJwplsxDaoqCl0cp1YTqdW6igH511meYyXxaGWxvCy9fX2p2SOK1AizOUAVRaEPlW03m9I/MCCzs7PRg2RFbM+5ksirskAURWSuxzmqJgqVRLPREH2PiG5j4+MyPz+fuyyoJP6ebFm8vhBReNzERTSpkijuKgld1+L+NjE5mWtlQSXxdKamlQWiKMICHueoiigeVhIPLz2vyoJKwp1kaWSBKNx8C2lRBVE8VUk8BJh1ZUEl4Z+iSWWBKPwZ59oydFG4Kom8KgsqifhpqbJYW1+P9foERBGfcy57hCwK30oi68qCSiJ5Kr599y5autB3QxS+pHJuF6oo4lYSWVUWVBLpEhJR/IdfrXV0cpsOZbF7hyiKpJVE2sqCSiJ9biIKRJE+izyOkLaSSFpZUEl4dI5HE0SBKDzSJF2TrCqJuJUFlUS6fru/N6JAFNll0yNHyrqS8K0sqCSy7VZEgSiyzah7R8urknBVFlElUa9HL1Rmy4YAokAU2WTSg6PkXUk8VVlcXV1Jo9GQ9vV1Ltf1XA+KKBBF5rlfVCXxMPDx8XE5PT2lksi8R0UQBaLINK2KriQyDZ6DPUkAUSCKzG6PsiqJzC6AAyEKRw4w4SrlTUIlkRKg8d2pKKgoUqcolURqhOYPgCgQRaokpZJIhS+YnREFokicrFQSidEFtyOiQBSJkpZKIhG2YHdCFIgidvJSScRGFvwOiAJRxEpiKolYuCrTGFEgCu9kppLwRlW5hogCUXglNZWEF6bKNkIUiMKZ3FQSTkSVb4AoEMU3k5xKovIO8LpARIEonkwUKgmve+hZNEIUiOLRRO90bqTZbMjpn38+ixuBi/w2AUSBKB7NEF0danNjQy4vL7mHIMB6FH/lAE+PPrgZEAV2uE+AioKKgooCJzgJIApEgSictwkNEAWiQBR4wEkAUSAKROG8TWiAKBAFosADTgKIAlEgCudtQgNEgSgQBR5wEkAUiAJROG8TGiAKRIEo8ICTAKJAFIjCeZvQAFEgCkSBB5wEEAWiQBTO24QGiAJRIAo84CSAKBAFonDeJjRAFIgCUeABJwFEgSgeTZLb21u5uLiQm5sbZxLRoPoEhoeHpVareV/oT+/fe7ft7e2NFsYJYWPhmhB6iRiDIYAojHSV/sXXperOz8+9Iuqq1WR1fV2Ghoa82tMIAmkIIIo09DLcF1FkCJNDZU4AUWSONNkBEUUybuxVDAFEUQxn51kQhRMRDUokgChKhH//1IjCSEcQxqMEEIWRxEAURjqCMBCF5RxAFJZ7h9ioKAzlwIZ+PXp25hWRTpZZXVsTnTjDBoE8CegkvX/+/LP3KZhw5Y0qWcN6vR7r3aD/mJ2VmZmZZCdjLwh4Ejg+PpZmo+HZWqS/v19++PFH7/ZlNgxuZqbC+rC7K4eHh97curq6ZHFxUV68eCFd3d3e+9EQAj4E7qb9bzebcnV15bNL1Gbk5UtZWVnxbl9mwyBFcXR0JDvb27G4qSzU4N2IIhY3GrsJ3NzeyvXVleh7a+Ns0zMzMjs7G2eX0toGKYp2uy2//fqrqMnZIBAiAR07W15ZkZGRkSDCD1IUSra+uSmnp6dBQCZICDwk0NfXFw2y6/8hbMGK4s+TE2k0GlQVIWQZMf6NwKtXr2R+YSHWI+xlYgxWFJ1OJ3qKVNeOYINASAR0vOz7H34IpppQtsGKQoOPqopmU25ZZCak++RZx6pjE7OvX8vU1FRQHIIWhZJutVrS2vtDGNcMKu+ebbA6eLm4tBTct2/Bi0Jnw+3sbMvx5+Nnm3xceBgEBgcHZWV1VXp6esII+F6UwYtCr0XHK/b29uTT4QGVRXAp+DwC1kcI3iwuBjUucb9nKiEKvSCdU3Gwvx/N2NR5FmwQsEBAZwKPjY3J3Nyc6CBmqFtlRHHXAZeXl3J4cCA6e5MJWaGmZQXirtWiyVT6jJGu1xpnJW+LV185UdxBvr6+jqoLfcpUp9bqxxMVB/KwmIZhx6QS0H9aMej4g45F6DyJoZhL/VumUFlR3EHXwc77omAQw3I6BhrbA1FU8Xmiyosi0NQjbAiYIoAoTHUHwUDAJgFEYbNfiAoCpgggClPdQTAQsEkAUdjsF6KCgCkCiMJUdxAMBGwSQBQ2+4WoIGCKAKIw1R0EAwGbBBCFzX4hKgiYIoAoTHUHwUDAJgFEYbNfiAoCpgggClPdQTAQsEkAUdjsF6KCgCkCiMJUdxAMBGwSQBQ2+4WoIGCKAKIw1R0EAwGbBBCFzX4hKgiYIoAoTHUHwUDAJgFEYbNfiAoCpgggClPdQTAQsEkAUdjsF6KCgCkCiMJUdxAMBGwSQBQ2+4WoIGCKAKIw1R0EAwGbBBCFzX4hKgiYIoAoTHUHwUDAJgFEYbNfiAoCpgggClPdQTAQsEng3yYEaBO8SGfHAAAAAElFTkSuQmCC'
    }),
    mounted (){
        this.checkSize();
        this.getImages();
    },
    computed: {
        getId() {
            return this.$route.params.id
        },
        getSort(){
            this.newImage.sort = this.images.length+1;
        },
    },
    methods: {
        checkSize(){
            if(window.innerWidth < 600){
                this.isMobile = true
            }
        },
        uploadPhoto(e, index){
            let file = e;
            let reader = new FileReader();

            if(file){
                reader.onloadend = (file) => {
                    this.newImage.img = reader.result;
                }
                    reader.readAsDataURL(file);
            }
        },
        changePosition(index, position){
            this.images[index]['position'] = position
        },
        changeRatio(index, ratio){
            this.images[index]['ratio'] = ratio;
        },
        async getImages(){
            console.log('Getting images...')

            await axios.get(`/gallery/${this.$route.params.id}`)
            .then( response => {
                const photos = response.data
                let i = 0;
                for( const photo of photos){
                    photos[i]['thumbnail'] = '\\'+photo.url+photo.thumbnail
                    photos[i]['url'] = '\\'+photo.url+photo.img
                    i++;
                }
                this.images = photos;
                this.title = this.images[0]['title'];

                this.getSort;
                // console.log(this.images);
            })
            .catch (error => {
                console.log(error)
            })
        },
        addNewImage(){
            this.errors = [];
            if(this.newImage.img === ''){
                this.errors.push('Image required');
            }

            if(this.newImage.sort === ''){
                this.errors.push('Sort is required');
            }
            console.log(this.errors)
            if(!this.errors.length){
                this.newImage.portfolioId = this.getId
                axios.post(`/gallery/`, this.newImage)
                .then(response => {
                    if(response.data.error){
                        this.errors = [];
                        this.errors.push(response.data.error);
                    }else{
                        this.newImage.img = ''
                        this.newImage.sort = ''

                        this.getImages();
                        this.addImage = false;
                    }
                })
                .catch(error => {
                    this.errors = [];
                    this.errors.push(error.response.data.error);
                })
            }
        },
        updateImage(index){
            const image = this.images.slice(index,index+1)
            const params = {
                id: image[0].id,
                position: image[0].position,
                ratio: image[0].ratio,
                visibility: image[0].visibility,
                sort: image[0].sort,
            }
            console.log(params);
            axios.put(`/gallery`, params)
            .then(response => {
                this.editImage = false;
                this.getimages();
                this.$toast.open({
                    message: 'Update successfully',
                    type: 'success',
                    position: 'bottom',
                    duration: 5000
                })
            })
            .catch(error => {
                console.log(error);
            })
        },
        deleteImage(img_id, portfolio_id){
            this.$swal({
            title: 'Warning!',
            text: 'Are you sure?',
            icon: 'warning',
            confirmButtonText: 'Delete',
            showCloseButton: true,
            showCancelButton: true,
            })
            .then( (result) =>{
                if(result.value){
                    axios.delete(`/gallery/${img_id}/${portfolio_id}`)
                    .then(response => {
                        this.getImages();
                        this.editImage = false;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                }
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
    a.v-card{
        text-decoration: none;
    }
    .v-btn--example {
        bottom: 0 !important;
        margin: 0 0 50px 50px;
    }
    .light-gallery__text{
        display: none !important;
    }
    .dark-btn{
        color: rgb(202, 0, 0) !important;
    }
</style>

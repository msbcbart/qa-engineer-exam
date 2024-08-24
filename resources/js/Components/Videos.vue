<template>
    <div>
        <div class="embed-responsive embed-responsive-16by9 mt-5">
            <video ref="videoElement" class="video-js embed-responsive-item"></video>
        </div>
        <div class="row">
            <div v-for="(source, key) in sources" :key="key" class="col-2">
                <a href="javascript:void(0)" @click="change(key)">{{ filename(source) }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import videojs from 'video.js'
import 'video.js/dist/video-js.css'

export default {
    name: 'VideoPlayer',
    data() {
        return {
            player: null,
            sources: [],
            currentSourceIndex: 0,
        }
    },
    created () {
        this.fetchVideos()
    },
    methods: {
        change(key) {
            this.player.src(this.sources[key])
            this.player.load()
            this.player.play()
        },
        async fetchVideos () {
            await axios.get(route('api.videos')).then(response => {
                response.data.videos.forEach((video, key) => {
                    this.sources[key] = video.split('\\').join('/')
                })
                
                this.player = videojs(this.$refs.videoElement, {
                    sources: this.sources,
                    controls: true,
                })
            }).catch(error => {
                console.error('Error fetching data:', error)
            })
        },
        filename (source) {
            const parts = source.split("/")
            const filename = parts[parts.length - 1]

            return filename
        }
    },
    beforeUnmount() {
        if (this.player) {
            this.player.dispose()
        }
    },
}
</script>

<style scoped="">
.video-js {
    width: 100%;
}
</style>
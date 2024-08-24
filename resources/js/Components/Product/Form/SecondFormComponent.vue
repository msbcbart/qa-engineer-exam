<template>
    <div>
        <div class="row flex-column flex-md-row">
            <div class="col col-md-4 my-3" v-for="(image, key) in form.images" :key="key">
                <div class="delete-button-container">
                    <a href="javascript:void(0)" class="btn btn-danger delete-button" @click="remove(image, key)">
                        <i class="fas fa-close"></i>
                    </a>
                </div>
                <img class="img-preview img-thumbnail col" :src="image.preview">
            </div>
            <div class="col col-md-4 my-auto text-center">
                <input class="d-none" type="file" multiple accept=".jpg, .jpeg, .png, .gif" ref="images" @change="filesChanged" />
                <a href="javascript:void(0)" class="btn btn-light border col" @click="$refs.images.click()"><i class="fas fa-plus"></i></a>
                <p class="col text-danger text-center" v-if="errors.images">{{ errors.images[0] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['form', 'errors', 'validate'],
        methods: {
            filesChanged () {
                const files = Array.from(this.$refs.images.files)

                this.form.images = [...this.form.images, ...files.map(file => ({
                    preview: URL.createObjectURL(file),
                    file: file
                }))]

                this.$refs.images.value = ''
                this.validate()
            },
            remove(image, key) {
                if (image.hasOwnProperty('id')) {
                    this.form.deletedImages.push(image.id)
                }

                this.form.images.splice(key, 1);
                this.validate()
            },
        }
    }
</script>

<style scoped>
.img-preview {
    height: 100%;
    object-fit: contain;
}

.delete-button-container {
    position: relative;
}

.delete-button {
    position: absolute;
    border-radius: 50%;
    top: -10px;
    right: -10px;
    z-index: 1;
}
</style>
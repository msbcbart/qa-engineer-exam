<template>
    <div>
        <div class="row flex-column flex-md-row py-1">
            <div class="col col-md-3">Name</div>
            <div class="col">
                <input v-model="form.name" class="form-control" type="text" />
                <p class="text-danger text-center" v-if="errors.name">{{ errors.name[0] }}</p>
            </div>
        </div>
        <div class="row flex-column flex-md-row py-1">
            <div class="col col-md-3">Category</div>
            <div class="col">
                <select class="form-control" v-model="form.category">
                    <option value="0">Select a Category</option>
                    <option v-for="(category, key) in categoryEnum" :key="key" :value="key">
                        {{ category }}
                    </option>
                </select>
                <p class="text-danger text-center" v-if="errors.category">{{ errors.category[0] }}</p>
            </div>
        </div>
        <div class="row flex-column flex-md-row py-1">
            <div class="col col-md-3">Description</div>
            <div class="col">
                <ckeditor :editor="editor" v-model="form.description"></ckeditor>
                <p class="text-danger text-center" v-if="errors.description">{{ errors.description[0] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: ['form', 'errors', 'validate', 'categoryEnum'],
        data () {
            return {
                editor: ClassicEditor
            }
        },
    }
</script>
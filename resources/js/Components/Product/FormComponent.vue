<template>
    <div class="row">
        <div class="col col-md-11 mx-auto">
            <div class="card p-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Product {{ product ? 'Update' : 'Create' }}
                        </div>
                        <div class="col text-right">
                            Step {{ step }} / 3
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <first-component :form="form" :errors="errors" :validate="validate" :category-enum="categoryEnum" v-if="step == 1" />
                    <second-component :form="form" :errors="errors" :validate="validate" v-if="step == 2" />
                    <third-component :form="form" :errors="errors" v-if="step == 3" />
                </div>
                <div class="card-footer">
                    <div class="row" :class="{ 'justify-content-end': isPageOne, 'justify-content-between': !isPageOne }">
                        <a v-if="step != 1" class="btn btn-light" @click="back">Back</a>
                        <a v-if="step != 3" class="btn btn-dark" @click="next">Next</a>
                        <a v-if="step == 3" class="btn btn-dark" @click="submit">Submit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FirstComponent from './Form/FirstFormComponent.vue'
    import SecondComponent from './Form/SecondFormComponent.vue'
    import ThirdComponent from './Form/ThirdFormComponent.vue'

    export default {
        components: { FirstComponent, SecondComponent, ThirdComponent },
        props: ['product', 'categoryEnum'],
        data () {
            return {
                step: 1,
                formfields: {
                    first: ['name', 'category', 'description'],
                    second: ['images'],
                    third: ['date_time']
                },
                form: {
                    name: '',
                    description: '',
                    category: 0,
                    date_time: '',
                    images: [],
                    deletedImages: []
                },
                errors: {},
                isValid: {
                    name: false,
                    category: false,
                    description: false,
                    images: false
                }
            }
        },
        computed: {
            isPageOne () {
                return this.step == 1
            },
            isFormValid () {
                let stepTrue = false

                if (this.step == 1) {
                    stepTrue = this.isValid.name && this.isValid.category && this.isValid.description
                } else if (this.step == 2) {
                    stepTrue = this.isValid.images
                }

                return stepTrue
            }
        },
        created () {
            console.log('Parent Form Created')

            if (this.product) {
                this.form = this.product
                this.form.images = []
                this.form.deletedImages = []

                this.product.media.forEach(image => {
                    this.form.images.push({
                        id: image.id,
                        preview: image.original_url
                    })
                })
            }
        },
        methods: {
            redirectStep (fields) {
                let isStepReset = false

                this.formfields.first.forEach(field => {
                    if (fields.includes(field)) {
                        this.step = 1
                        isStepReset = true
                    }
                })

                if (!isStepReset) {
                    this.formfields.second.forEach(field => {
                        if (fields.includes(field)) {
                            this.step = 2
                            isStepReset = true
                        }
                    })
                }

                if (!isStepReset) {
                    this.formFields.third.forEach(field => {
                        if (fields.includes(field)) {
                            this.step = 3
                        }
                    })
                }
            },
            next () {
                this.validate()

                if (this.isFormValid) {
                    this.step++
                }
            },
            back () {
                this.step--
            },
            validate () {
                if (this.step == 1) {
                    this.isValid.name = true
                    this.isValid.category = true
                    this.isValid.description = true
                    this.errors.name = []
                    this.errors.category = []
                    this.errors.description = []

                    if (!this.form.name.trim()) {
                        this.isValid.name = false
                        this.errors.name = ['Name is required.']
                    }

                    if (!this.form.description.trim()) {
                        this.isValid.description = false
                        this.errors.description = ['Description is required.']
                    }

                    if (this.form.name.length > 254) {
                        this.isValid.name = false
                        this.errors.name = ['Max of 254 characteres only.']
                    }

                    if (this.form.description.length > 1000) {
                        this.isValid.description = false
                        this.errors.description = ['Max of 1000 characters only.']
                    }

                    if (this.form.category == 0) {
                        this.isValid.category = false
                        this.errors.category = ['Category is required.']
                    }
                } else if (this.step == 2) {
                    this.isValid.images = true
                    this.errors.images = []

                    if (this.form.images.length == 0) {
                        this.isValid.images = false
                        this.errors.images = ['Images are required.']
                    }
                }
            },
            submit () {
                this.form.date_time = this.form.date_time ? new Date(this.form.date_time).toISOString() : ''

                const message = this.product ? 'Updated' : 'Saved'
                const apiRoute = this.product ? route('api.products.update', this.product) : route('api.products.store')
                const data = new FormData()

                for (const key in this.form) {
                    if (key == 'images') {
                        this.form[key].forEach(image => {
                            if (image.hasOwnProperty('file')) {
                                data.append('images[]', image.file, image.name)
                            }
                        })
                    } else if (key == 'deletedImages') {
                        this.form[key].forEach(id => {
                            data.append('deletedImages[]', id)
                        })
                    } else {
                        data.append(key, this.form[key])
                    }
                }

                if (this.product) {
                    data.append('_method', 'PUT')
                }

                axios({
                    method: 'POST',
                    url: apiRoute,
                    data: data,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(async response => {
                    if (response.status == 200) {
                        await this.$swal(
                            `Successfully ${message}!`,
                            'Press OK to redirect to products list',
                            'success'
                        ).then(result => {
                            if (result.isConfirmed) {
                                window.location.href = route('product.index')
                            }
                        })
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.redirectStep(Object.getOwnPropertyNames(error.response.data.errors))
                    console.error('Error fetching data:', error)
                })
            }
        }
    }
</script>
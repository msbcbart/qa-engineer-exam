<template>
    <div class="row">
        <div class="col-11 mx-auto">
            <div class="card p-2">
                <div class="card-header">
                    <div class="row flex-column flex-md-row">
                        <input v-model="keyword" @keypress.enter="search" class="form-control col-12 col-md-6" type="text" placeholder="Search Product..." />
                        <select v-model="category" class="form-control col-12 col-md-3 mx-md-1 my-1 my-md-0">
                            <option value>Select Category</option>
                            <option v-for="(category, key) in categories" :key="key" :value="key">{{ category }}</option>
                        </select>
                        <div class="text-right text-md-left">
                            <a class="btn btn-secondary btn-circle" @click="search">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table v-if="products.length > 0">
                        <thead class="text-center">
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                        <tbody class="text-center">
                            <tr v-for="(product, key) in products" :key="key">
                                <td>{{ product.name }}</td>
                                <td>{{ product.category }}</td>
                                <td>{{ product.description }}</td>
                                <td class="col-1">
                                    <div class="row justify-content-between">
                                        <a :href="editUrl(product)" class="btn btn-dark my-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger my-1" @click.prevent="deleteProduct(product)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="text-center">
                        No Results
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :current-page="page.current" :last-page="page.last" @changeCurrentPage="pageChangeHandle" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from '../Pagination.vue'

    export default {
        components: { Pagination },
        props: ['categoryEnum'],
        data () {
            return {
                keyword: '',
                category: '',
                categories: [],
                products: [],
                page: {
                    current: 1,
                    last: 1
                }
            }
        },
        created () {
            this.fetchProducts(this.page.current)
            this.processCategories()
        },
        methods: {
            async fetchProducts (page) {
                await axios.get(route('api.products.index'), {
                    params: {
                        keyword: this.keyword,
                        category: this.category,
                        page: page
                    }
                }).then(response => {
                    this.products = []
                    this.products = response.data.data
                    this.page.current = response.data.meta.current_page
                    this.page.last = response.data.meta.last_page
                }).catch(error => {
                    console.error('Error fetching data:', error);
                })
            },
            processCategories () {
                let items = {}

                Object.entries(this.categoryEnum).forEach(([key, category]) => {
                    items[key] = category
                })

                this.categories = items
            },
            editUrl (product) {
                return route('product.form', product)
            },
            async search () {
                this.page.current = 1
                this.fetchProducts(this.page.current)
            },
            async pageChangeHandle (value) {
                if ((value != this.page.current && value != '...')) {
                    this.page.current = value
                    this.fetchProducts(value)
                }
            },
            async deleteProduct (product) {
                await this.$swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.delete(route('api.products.destroy', product)).then(response => {
                            this.fetchProducts(this.page.current)
                        }).catch(error => {
                            console.error('Error fetching data:', error);
                        })
                    }
                })
            }
        }
    }
</script>

<style scoped>
td {
    padding: 5px 25px;
}
</style>
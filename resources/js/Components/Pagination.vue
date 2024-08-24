<template>
    <nav v-if="currentPage && lastPage && navigationPaginationList" aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item activeCursor" v-if="currentPage > 1" >
                <a class="page-link" aria-label="Previous"  @click.prevent="() => {
                    $emit('changeCurrentPage', currentPage - 1)
                }">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item" v-for="(page, index) in navigationPaginationList" :key="index">
                <a class="page-link" :class="{ activeCursor: isActive(page), inactiveCursor: !isActive(page) }" @click.prevent="() => {
                    $emit('changeCurrentPage', page)
                }">
                    {{ page }}
                </a>
            </li>
            <li class="page-item activeCursor" v-if="currentPage < lastPage">
                <a class="page-link" aria-label="Next" @click.prevent="() => {
                    $emit('changeCurrentPage', currentPage + 1)
                }">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['currentPage', 'lastPage'],
        data () {
            return {
                navigationPaginationList: this.process(this.currentPage, this.lastPage)
            }
        },
        computed: {
        },
        watch: {
            currentPage (newValue) {
                this.navigationPaginationList = this.process(newValue, this.lastPage)
            },
            lastPage (newValue) {
                this.navigationPaginationList = this.process(this.currentPage, newValue)
            }
        },
        methods: {
            process (currentPage, lastPage) {
                if (!currentPage) {
                    return null
                }
                if (lastPage <= 5) {
                    return [...Array(lastPage + 1).keys()].slice(1)
                }
                if (currentPage >= lastPage - 1 && currentPage >= 4) {
                    return [1, '...', lastPage - 2, lastPage - 1, lastPage]
                }
                if (currentPage <= 2 && currentPage !== lastPage - 2) {
                    return [1, 2, 3, '...', lastPage]
                }
                if (currentPage === 3) {
                    return [1, 2, 3, 4, '...', lastPage]
                }
                if (currentPage === lastPage - 2) {
                    return [1, '...', lastPage - 3, lastPage - 2, lastPage - 1, lastPage]
                }
                return [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', lastPage]
            },
            isActive (page) {
                return this.currentPage != page && page != '...'
            }
        }
    }
</script>

<style scoped>
td {
    padding: 5px 25px;
}

.activeCursor {
    cursor: pointer;
}

.inactiveCursor {
    cursor: default;
}
</style>
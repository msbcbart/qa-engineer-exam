<template>
    <div>
        <div class="row py-1">
            <div class="col-3">Date and Time</div>
            <div class="col">
                <date-picker v-model="form.date_time" :format="'yyyy-MM-dd HH:mm:ss'" />
                <p class="col text-danger text-center" v-if="errors.date_time">{{ errors.date_time[0] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';

    export default {
        components: { DatePicker },
        props: ['form', 'errors']
    }
</script>
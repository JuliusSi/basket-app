<template>
    <transition name="modal" class="modal fadeIn">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <font-awesome-icon :icon="['fas', 'calendar-plus']" class="fa-icon"
                                                   fixed-width/>
                                {{ 'main.court-arrivals.create-arrival' | trans }}
                            </h5>
                            <button type="button" class="close" @click="closeModal" aria-label="Close">
                                <font-awesome-icon :style="{ color: '#A0A0A0', marginRight: '3px' }"
                                                   :icon="['fas', 'times']" class="fa-icon"
                                                   fixed-width/>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success fadeIn" role="alert" v-if="success">
                                {{ 'main.court-arrivals.created' | trans }}
                                </div>
                            <div class="alert alert-danger fadeIn text-left" role="alert" v-if="errors">
                                <div v-for="(v, k) in errors" :key="k">
                                    <p v-for="error in v" :key="error" class="text-sm">
                                        {{ error }}
                                    </p>
                                </div>
                            </div>
                            <h2 class="mb-3">{{ court.name }}</h2>
                            <div class="form-group col-md-6 text-left">
                                {{ 'weather.select_start_date' | trans }}
                                <datetime
                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric' }"
                                    input-class="form-control mb-3" type="datetime" v-model="selectedStartDate"></datetime>
                                {{ 'weather.select_end_date' | trans }}
                                <datetime
                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric' }"
                                    input-class="form-control mb-3" type="datetime" v-model="selectedEndDate"></datetime>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">{{ 'main.close' | trans }}</button>
                            <button :disabled="!isAvailableToSaveArrival" type="button" class="btn btn-primary" @click="createArrival">{{ 'main.save' | trans }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            selectedStartDate: null,
            selectedEndDate: null,
            errors: null,
            success: false,
        }
    },
    props: ['user', 'court'],
    mounted() {
        this.getDate();
    },
    computed: {
        isAvailableToSaveArrival() {
            return this.selectedStartDate && this.selectedEndDate;
        },
    },
    methods: {
        createArrival() {
            this.success = false;
            let data = {
                court_id: this.court.id,
                start_date: moment(this.selectedStartDate).format('YYYY-MM-DD HH:mm:ss'),
                end_date: moment(this.selectedEndDate).format('YYYY-MM-DD HH:mm:ss'),
            }
            axios.post('/api/court-arrivals', data, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.success = true;
                this.errors = null;
                this.selectedEndDate = null;
            }).catch(error => {
                this.errors = error.response.data.errors;
            });
        },
        closeModal() {
            this.$emit('close');
        },
        getDate() {
            moment.locale("lt");
            this.selectedStartDate = moment().format();
        },
    },
}
</script>

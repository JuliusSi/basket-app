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
                            <h2 class="mb-3">{{ court.name }}</h2>
                            <div class="form-group col-md-6">
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
                            <button type="button" class="btn btn-primary">{{ 'main.save' | trans }}</button>
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
        }
    },
    props: ['user', 'court'],
    mounted() {
        this.getDate();
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        getDate() {
            moment.locale("lt");
            this.selectedStartDate = moment().format();
            this.selectedEndDate = moment().add(1, 'hour').format();
        },
    },
}
</script>

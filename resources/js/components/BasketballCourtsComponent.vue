<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'map-marked']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ 'main.basketball-courts.title' | trans }}
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <label>{{ 'main.name' | trans }}:</label>
                        <input v-model="name" :placeholder="'main.add_value' | trans" class="form-control mb-3">
                    </div>
                    <div class="col-md-6">
                        <label>{{ 'main.city' | trans }}:</label>
                        <input v-model="city" :placeholder="'main.add_value' | trans" class="form-control mb-3">
                    </div>
                    <div class="col-md-12">
                        <button @click="getCourts(1)" type="button"
                                class="fadeIn btn btn-primary btn-block mb-2 col-md-4 offset-md-4">
                            <font-awesome-icon :icon="['fas', 'search']" class="fa-icon"
                                               fixed-width></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>
            <hr>
            <section id="basketball-courts" class="section-bg" v-if="!loading">
                <div class="container">
                    <div class="row court-container">
                        <div class="text-center" v-if="!courts.length">
                            <p>{{ 'main.no_data' | trans }}</p>
                        </div>
                        <div v-for="court in courts" class="col-md-6 court-item">
                            <router-link :to="{ name: 'basketball-court', params: { id: court.id } }">
                            <div class="court-wrap">
                                <figure>
                                    <div class="text-center">
                                            <vue-load-image>
                                                <img slot="image" :src="court.image_path" class="img-fluid fadeIn img"
                                                     :alt="court.name">
                                                <img :style="{height: '50px'}" alt="loader" slot="preloader"
                                                     class="mt-5" src="img/spinner.png"/>
                                            </vue-load-image>
                                    </div>
                                </figure>
                                <div class="court-info">
                                    <h4>{{ court.name }}</h4>
                                    <p>
                                        <font-awesome-icon :icon="['fas', 'map-marker-alt']" class="fa-icon"/>
                                        {{ court.address }}
                                    </p>
                                    <p>
                                        <font-awesome-icon
                                            :class="[court.isEligibleWeather ? 'text-success' : 'text-danger']"
                                            :icon="['fas', 'cloud-sun']" class="fa-icon mr-1"
                                            fixed-width/>
                                        |
                                        <font-awesome-icon :icon="['fas', 'users']" class="text-success fa-icon ml-1"
                                                           fixed-width/>
                                        6
                                    </p>
                                </div>
                            </div>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button v-if="1 < this.page" @click="getCourts(page - 1)" type="button"
                            class="btn btn-primary">

                        <font-awesome-icon :icon="['fas', 'angle-double-left']" class="fa-icon"
                                           fixed-width></font-awesome-icon>
                    </button>
                    <button v-if="this.lastPage > this.page" @click="getCourts(page + 1)" type="button"
                            class="btn btn-primary">
                        <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                           fixed-width></font-awesome-icon>
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import VueLoadImage from 'vue-load-image';

export default {
    data() {
        return {
            loading: false,
            courts: [],
            city: null,
            name: null,
            page: 1,
            lastPage: null,
        }
    },
    components: {
        'vue-load-image': VueLoadImage,
    },
    props: ['user'],
    mounted() {
        this.getCourts(1);
    },
    methods: {
        getCourts(page) {
            this.loading = true;
            let params = {
                page: page,
                name: this.name,
                city: this.city,
            };
            this.axios.get('/api/basketball-courts', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.courts = response.data.data;
                this.lastPage = response.data.meta.last_page;
                this.loading = false;
                this.page = page;
            }).catch(error => {
                console.log(error.response);
            });
        },
    },
}
</script>

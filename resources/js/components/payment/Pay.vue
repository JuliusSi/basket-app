<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'coins']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('main.sms.title') }}
        </div>
        <div class="card-body">
            <span v-if="redirecting"> {{ this.$t('main.redirect_paypal') }}</span>
            <form
                id="app" @submit.prevent="pay" method="POST"
            >
                <div class="text-left">
                    <div class="form-group row mt-4">
                        <div class="col-md-6">
                            <p class="font-weight-bold">Atsiskaitymai vyksta tik PayPal naudotojams.</p>
                            10 SMS - 3 EUR
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            {{ this.$t('main.buy') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
</template>

<script>

export default {
    data() {
        return {
            loading: false,
            redirecting: false,
            amount: 10,
            price: null,
        }
    },
    props: ['user'],
    computed: {
      price() {
          return (this.amount * 0.30).toFixed(1);
      }
    },
    methods: {
        pay() {
            this.redirecting = true;
            this.loading = true;
            let params = {
                amount: 3,
                quantity: 10,
                sku: 'sms'
            };
            axios.post('/api/pay', params, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.loading = false;
                window.location.href = response.data.link;
            }).catch(error => {
                console.log(error.response);
            });
        },
    },
}
</script>

<style scoped>

</style>

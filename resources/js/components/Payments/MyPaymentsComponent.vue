<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form-payment-component @new="addPayment"></form-payment-component>
                <hr>
                <ul class="list-group list-group-horizontal text-center">
                            <li class="list-group-item list-group-item-dark col-md-2" scope="col">ID</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Referencia</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Fecha</li>
                            <li class="list-group-item list-group-item-dark col-md-4" scope="col">Opciones</li>
                </ul>
                <payment-component
                    v-for="(payment, index) in payments"
                    :key="payment.id"
                    :payment="payment"
                    @delete="deletePayment(index, payment)">
                </payment-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                payments: [],
                usrs_cdu: []
            }
        },
        mounted() {
            axios.get('/payments/all').then((response) =>{
                this.payments = response.data;
            });
        },
        methods:{
            addPayment(payment)
            {
                this.payments.push(payment);
            },
            deletePayment(index){
                this.payments.splice(index, 1);
            }
        },
    }
</script>

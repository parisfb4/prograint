<template>
    <div class="row justify-content-center">
        <div class="card col-md-8" style="width: 18rem;">
            <div class="card-header">
                <h2 class="float-md-left">{{payment.id}}</h2><button @click="cancel()" type="submit" class="btn btn-danger float-md-right">Regresar</button>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><h3>Fecha:</h3> {{payment.created_at}}</li>
                <li class="list-group-item"><h3>Referencia:</h3> {{payment.reference}}</li>
                <li class="list-group-item"><h3>Comentario:</h3> {{payment.comments}}</li>
            </ul>
        </div>
        <details-component :showPay="false" :detailsId="payment.id_userCDU"></details-component>
    </div>
</template>

<script>
    export default {
        props: {
            payment:{}
        },
        data(){
            return{
                payment: '',
                reference: '',
                agreement: '',
                clabe: '',
                cost: ''
            }
        },
        mounted() {
        },
        methods: {
            cancel(){
                window.location.href="/payments";
            }
        }
    }
</script>

<template>
    <div class="row justify-content-center">
        <div class="card col-md-8" style="width: 18rem;">
            <div class="card-header">
                <h2 class="float-md-left">{{concept.concept}}</h2><button @click="cancel()" type="submit" class="btn btn-danger float-md-right">Regresar</button>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><h3>Referencia:</h3> {{concept.reference}}</li>
                <li class="list-group-item"><h3>Convenio:</h3> {{concept.agreement}}</li>
                <li class="list-group-item"><h3>Cuenta Clabe:</h3> {{concept.clabe}}</li>
                <li class="list-group-item"><h3>Costo:</h3> {{concept.cost}}</li>
            </ul>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            concept:{}
        },
        data(){
            return{
                concept: '',
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
                window.location.href="/concepts";
            }
        }
    }
</script>

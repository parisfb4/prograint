<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form-concept-component @new="addConcept"></form-concept-component>
                <hr>
                <ul class="list-group list-group-horizontal text-center">
                            <li class="list-group-item list-group-item-dark col-md-4" scope="col">Concepto</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Referencia</li>
                            <li class="list-group-item list-group-item-dark col-md-5" scope="col">Opciones</li>
                </ul>
                <concept-component
                    v-for="(concept, index) in concepts"
                    :key="concept.id"
                    :concept="concept"
                    @delete="deleteConcept(index, concept)">
                </concept-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                concepts: [],
            }
        },
        mounted() {
            axios.get('/concepts/all').then((response) =>{
                this.concepts = response.data;
            });
        },
        methods:{
            addConcept(concept)
            {
                this.concepts.push(concept);
            },
            deleteConcept(index){
                this.concepts.splice(index, 1);
            }
        },
    }
</script>

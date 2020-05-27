<template>
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-header">Editar Concepto <button @click="cancel()" type="submit" class="btn btn-danger float-md-right">Regresar</button></div>

            <div class="card-body">

                <form action="" v-on:submit.prevent="onClickUpdate()" >
                    <div class="form-group">
                        <label for="concept">Concepto:</label>
                        <input type="text" class="form-control" name="concept" id="concept"
                               v-model="concept.concept">
                        <div v-if='!conceptFilled'>
                            <p>Por favor ingresa el concepto.</p>
                        </div>
                        <label for="reference">Referencia:</label>
                        <input type="text" class="form-control" name="reference" id="reference"
                               v-model="concept.reference">
                        <div v-if='!referenceFilled'>
                            <p>Por favor ingresa el reference.</p>
                        </div>
                        <label for="agreement">Convenio:</label>
                        <input type="text" class="form-control" name="agreement" id="agreement"
                               v-model="concept.agreement">
                        <div v-if='!agreementFilled'>
                            <p>Por favor ingresa el convenio.</p>
                        </div>
                        <label for="clabe">Clabe:</label>
                        <input type="text" class="form-control" name="clabe" id="clabe"
                               v-model="concept.clabe">
                        <div v-if='!clabeFilled'>
                            <p>Por favor ingresa la cuenta clabe.</p>
                        </div>
                        <label for="cost">Costo:</label>
                        <input type="number" min="0.0" step="0.01" placeholder="0.00" class="form-control" name="cost" id="cost"
                               v-model="concept.cost">
                        <div v-if='!costFilled'>
                            <p>Por favor ingresa el costo.</p>
                        </div>
                    </div>
                    <button v-if='agreementFilled && conceptFilled && referenceFilled && clabeFilled && costFilled' type="submit" class="btn btn-primary float-md-right">Guardar Cambios</button>
                </form>
            </div>
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
            onClickUpdate(){

                const params = {
                    id: this.concept.id,
                    concept: this.concept.concept,
                    reference: this.concept.reference,
                    agreement: this.concept.agreement,
                    clabe: this.concept.clabe,
                    cost: this.concept.cost
                };
                axios.put(`/concepts/${this.concept.id}`, params).then((response) => {
                    this.editMode = false;
                    const concept = response.data;
                });
                window.location.href="/concepts";
            },
            cancel(){
                window.location.href="/concepts";
            }
        },
        computed:{
            agreementFilled () {
                return (this.concept.agreement !== '' )
            },
            referenceFilled () {
                return (this.concept.reference !== '')
            },
            conceptFilled () {
                return (this.concept.concept !== '')
            },
            costFilled () {
                return (this.concept.cost !== '')
            },
            clabeFilled () {
                return (this.concept.clabe !== '')
            }
        }
    }
</script>

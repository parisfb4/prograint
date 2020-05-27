<template>
    <div class="card">

        <div class="card-header">Nuevo Concepto</div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="newUser()" >

                <div class="form-group">
                    <label for="concept">Concepto:</label>
                    <input type="text" class="form-control" name="concept" id="concept"
                           v-model="concept">
                    <div v-if='!conceptFilled'>
                        <p>Por favor ingresa el concepto.</p>
                    </div>
                    <label for="reference">Referencia:</label>
                    <input type="text" class="form-control" name="reference" id="reference"
                           v-model="reference">
                    <div v-if='!referenceFilled'>
                        <p>Por favor ingresa el reference.</p>
                    </div>
                    <label for="agreement">Convenio:</label>
                    <input type="text" class="form-control" name="agreement" id="agreement"
                           v-model="agreement">
                    <div v-if='!agreementFilled'>
                        <p>Por favor ingresa el convenio.</p>
                    </div>
                    <label for="clabe">Clabe:</label>
                    <input type="text" class="form-control" name="clabe" id="clabe"
                           v-model="clabe">
                    <div v-if='!clabeFilled'>
                        <p>Por favor ingresa la cuenta clabe.</p>
                    </div>
                    <label for="cost">Costo:</label>
                    <input type="number" min="0.0" step="0.01" placeholder="0.00" class="form-control" name="cost" id="cost"
                           v-model="cost">
                    <div v-if='!costFilled'>
                        <p>Por favor ingresa el costo.</p>
                    </div>
                </div>
                <button v-if='agreementFilled && conceptFilled && referenceFilled && clabeFilled && costFilled' type="submit" class="btn btn-primary">Agregar Concepto</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
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
            newUser(){
                const  params = {
                    concept: this.concept,
                    reference: this.reference,
                    agreement: this.agreement,
                    clabe: this.clabe,
                    cost: this.cost
                };
                this.concept= '';
                this.reference= '';
                this.agreement= '';
                this.cost= '';
                this.clabe= '';
                axios.post('/concepts', params).
                then((response) => {
                    const concept = response.data;
                    this.$emit('new', concept);
                });
            }
        },
        computed:{
            agreementFilled () {
                return (this.agreement !== '' )
            },
            referenceFilled () {
                return (this.reference !== '')
            },
            conceptFilled () {
                return (this.concept !== '')
            },
            costFilled () {
                return (this.cost !== '')
            },
            clabeFilled () {
                return (this.clabe !== '')
            }
        }
    }
</script>

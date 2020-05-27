<template>
    <div class="card">

        <div class="card-header">Nuevo Pago</div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="newPayment()" >

                <div class="form-group">
                    <label for="reference">Referencia:</label>
                    <input type="text" class="form-control" name="reference" id="reference"
                           v-model="reference">
                    <div v-if='!referenceFilled'>
                        <p>Por favor ingresa el nombre.</p>
                    </div>
                    <label for="comments">Comentario:</label>
                    <input type="text" class="form-control" name="comments" id="comments"
                           v-model="comments">
                    <div v-if='!commentsFilled'>
                        <p>Por favor ingresa el comentario.</p>
                    </div>
                    <label for="usr_cdu">Usuario CDU: </label>
                    <select
                        data-live-search="true"
                        id="usr_cdu"
                        v-model="id_userCDU"
                        name="usr_cdu"
                        class="align-content-end selectpicker"
                    >
                        <option v-bind:value="usr_cdu.id" v-for="(usr_cdu, index) in usrs_cdu">{{usr_cdu.id+' '+usr_cdu.username}}</option>
                    </select>
                    <div v-if='!usr_cduSelected'>
                        <p>Selecciona una opción.</p>
                    </div>

                </div>
                <button v-if='referenceFilled && commentsFilled && usr_cduSelected' type="submit" class="btn btn-primary">Agregar Usuario</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                usrs_cdu: [],
                reference: '',
                comments: '',
                id_userCDU: ''
            }
        },
        mounted() {
            axios.get('/usuarioscdu').then((response) =>{
                this.usrs_cdu = response.data;
            });
        },
        methods: {
            newPayment(){
                const  params = {
                    reference: this.reference,
                    comments: this.comments,
                    id_userCDU: this.id_userCDU
                };
                this.reference= '';
                this.comments= '';
                this.id_userCDU= '';
                axios.post('/payments', params).
                then((response) => {
                    const payment = response.data;
                    this.$emit('new', payment);
                });
            }
        },
        computed:{
            commentsFilled () {
                return (this.comments !== '')
            },
            referenceFilled () {
                return (this.reference !== '')
            },
            usr_cduSelected () {
                return (this.id_userCDU !== '')
            }
        }
    }
</script>

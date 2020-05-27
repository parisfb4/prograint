<template>
    <div class="card">

        <div class="card-header">Editar Pago <button @click="cancel()" type="submit" class="btn btn-danger float-md-right">Regresar</button></div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="onClickUpdate()" >

                <div class="form-group">
                    <label for="reference">Referencia:</label>
                    <input type="text" class="form-control" name="reference" id="reference"
                           v-model="payment.reference">
                    <div v-if='!referenceFilled'>
                        <p>Por favor ingresa el nombre.</p>
                    </div>
                    <label for="comments">Comentario:</label>
                    <input type="text" class="form-control" name="comments" id="comments"
                           v-model="payment.comments">
                    <div v-if='!commentsFilled'>
                        <p>Por favor ingresa el comentario.</p>
                    </div>
                    <label for="usr_cdu">Usuario CDU: </label>
                    <select
                        data-live-search="true"
                        id="usr_cdu"
                        v-model="payment.id_userCDU"
                        name="usr_cdu"
                        class="align-content-end selectpicker"
                    >
                        <option :selected="payment.id_userCDU === usr_cdu.id" v-bind:value="usr_cdu.id" v-for="(usr_cdu, index) in usrs_cdu">{{usr_cdu.id+' '+usr_cdu.username}}</option>
                    </select>
                    <div v-if='!usr_cduSelected'>
                        <p>Selecciona una opción.</p>
                    </div>

                </div>
                <button v-if='referenceFilled && commentsFilled && usr_cduSelected' type="submit" class="btn btn-success float-md-right">Guardar Cambios</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            payment:{}
        },
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
            onClickUpdate(){

                const params = {
                    id: this.payment.id,
                    reference: this.payment.reference,
                    comments: this.payment.comments,
                    id_userCDU: this.payment.id_userCDU
                };
                axios.put(`/payments/${this.payment.id}`, params).then((response) => {
                    this.editMode = false;
                    const payment = response.data;
                });
                window.location.href="/payments";
            },
            cancel(){
                window.location.href="/payments";
            }
        },
        computed:{
            commentsFilled () {
                return (this.payment.comments !== '')
            },
            referenceFilled () {
                return (this.payment.reference !== '')
            },
            usr_cduSelected () {
                return (this.payment.id_userCDU !== '')
            }
        }
    }
</script>

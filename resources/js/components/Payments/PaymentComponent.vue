<template>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item col-md-2">
            <p  class="bg-light">{{payment.id}}</p>

        </li>
        <li class="list-group-item col-md-3">
            <p  class="bg-light">{{payment.reference}}</p>

        </li>
        <li class="list-group-item col-md-3">
            <p >{{payment.created_at}}</p>
        </li>
        <li class="list-group-item col-md-4 text-md-center">
            <button  class="btn btn-success col-md-3" v-on:click="onClickDetail()">Detalles</button>
            <button  class="btn btn-warning col-md-3" v-on:click="onClickEdit()">Editar</button>
            <button class="btn btn-danger col-md-3" v-on:click="onClickDelete()">
                Eliminar
            </button>
        </li>
    </ul>

</template>

<script>
    export default {
        props: ['payment'],
        data() {
            return {
                editMode: false
            };
        },
        mounted() {

        },
        methods: {
            onClickDelete() {
                this.$confirm('¿Realmente desea eliminar el Pago?','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/payments/${this.payment.id}`).then(() => {
                        this.$emit('delete');
                        this.showSuccessNotification('Pago eliminado','El Pago fue eliminado exitosamente');
                    })
                });
            },
            onClickEdit(){
                window.location.href="/payments/editar/"+this.payment.id;
            },
            onClickDetail(){
                window.location.href="/payments/detalle/"+this.payment.id;
            },
            showSuccessNotification(title,text) {
                this.$notify({
                    title: title,
                    message: text,
                    type: 'success'
                });
            }
        }
    }
</script>

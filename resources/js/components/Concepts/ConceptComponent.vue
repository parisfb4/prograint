<template>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item col-md-4">
            <p  class="bg-light">{{concept.concept}}</p>

        </li>
        <li class="list-group-item col-md-3">
            <p >{{concept.reference}}</p>
        </li>

        <li class="list-group-item col-md-5 text-md-center">
            <button class="btn btn-success col-md-3" v-on:click="onClickDetails()">
                Detalles
            </button>
            <button  class="btn btn-warning col-md-3" v-on:click="onClickEdit()">Editar</button>
            <button class="btn btn-danger col-md-3" v-on:click="onClickDelete()">
                Eliminar
            </button>
        </li>
    </ul>

</template>

<script>
    export default {
        props: ['concept'],
        data() {
            return {
                editMode: false
            };
        },
        mounted() {

        },
        methods: {
            onClickDelete() {
                this.$confirm('¿Realmente desea eliminar el Concepto?','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/concepts/${this.concept.id}`).then(() => {
                        this.$emit('delete');
                        this.showSuccessNotification('Concepto eliminado','El Concepto fue eliminado exitosamente');
                    })
                });
            },
            onClickEdit(){
                window.location.href="/concepts/editar/"+this.concept.id;
            },
            onClickDetails(){
                window.location.href="/concepts/detalle/"+this.concept.id;
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

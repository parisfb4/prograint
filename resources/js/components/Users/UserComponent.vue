<template>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item col-md-3">
            <p  class="bg-light">{{user.name}}</p>

        </li>
        <li class="list-group-item col-md-3">
            <p >{{user.email}}</p>

        </li>
        <li class="list-group-item col-md-3">
            <p >{{user.role.display_name}}</p>
        </li>

        <li class="list-group-item col-md-3 text-md-center">
            <button  class="btn btn-warning col-md-5" v-on:click="onClickEdit()">Editar</button>
            <button class="btn btn-danger col-md-5" v-on:click="onClickDelete()">
                Eliminar
            </button>
        </li>
    </ul>

</template>

<script>
    export default {
        props: ['user', 'roles'],
        data() {
            return {
                editMode: false
            };
        },
        mounted() {

        },
        methods: {
            onClickDelete() {
                this.$confirm('¿Realmente desea eliminar el Usuario?','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/users/${this.user.id}`).then(() => {
                        this.$emit('delete');
                        this.showSuccessNotification('Usuario eliminado','El Usuario fue eliminado exitosamente');
                    })
                });
            },
            onClickEdit(){
                window.location.href="/users/editar/"+this.user.id;
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

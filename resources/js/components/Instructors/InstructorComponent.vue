<template>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item col-md-3">
            <input v-if="editMode" type="text" class="form-control" v-model="temp_name">
            <p v-else class="bg-light">{{instructor.name}}</p>
        </li>
        <li class="list-group-item col-md-3">
            <input v-if="editMode" type="text" class="form-control" v-model="temp_mail">
            <p v-else>{{instructor.mail}}</p>
        </li>
        <li class="list-group-item col-md-3">
            <input v-if="editMode" type="text" class="form-control" v-model="temp_phone">
            <p v-else>{{instructor.phone}}</p>
        </li>
        <li class="list-group-item col-md-3 text-md-center">
            <button v-if="editMode" class="btn btn-success" v-on:click="onClickUpdate()">Guardar cambios</button>
            <button v-else class="btn btn-warning" v-on:click="onClickEdit()">Editar</button>
            <button v-if="editMode" class="btn btn-danger" v-on:click="onClickCancel()">Cancelar</button>
            <button v-else class="btn btn-danger" v-on:click="onClickDelete()">
                Eliminar
            </button>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['instructor'],
        data() {
            return {
                temp_name: this.instructor.name,
                temp_mail: this.instructor.mail,
                temp_phone: this.instructor.phone,
                editMode: false
            };
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            onClickDelete() {
                this.$confirm('¿Realmente desea eliminar el Instructor?','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=> {
                    axios.delete(`/instructors/${this.instructor.id}`).then(() => {
                        this.$emit('delete');
                        this.showSuccessNotification('Instructor eliminado', 'El Instructor fue eliminado exitosamente');
                    })
                });
            },
            onClickEdit(){
                this.editMode = true;
            },
            onClickCancel(){
                this.editMode = false;
            },
            onClickUpdate(){
                const params = {
                    name: this.temp_name,
                    mail: this.temp_mail,
                    phone: this.temp_phone
                };
                this.instructor.name = this.temp_name;
                this.instructor.phone = this.temp_phone;
                this.instructor.mail = this.temp_mail;
                axios.put(`/instructors/${this.instructor.id}`, params).then((response) => {
                    this.editMode = false;
                    const instructor = response.data;
                    this.$emit('update', instructor);
                    this.showSuccessNotification('Instructor Actualizado','El Instructor se actualizo');
                });
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

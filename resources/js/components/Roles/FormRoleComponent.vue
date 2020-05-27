<template>
    <div class="card">
        <div class="card-header">Nuevo Rol</div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="newRole()">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" id="name"
                    v-model="name">
                    <label for="display_name">Nombre para mostrar:</label>
                    <input type="text" class="form-control" name="display_name" id="display_name"
                           v-model="display_name">
                </div>
                <button type="submit" class="btn btn-primary">Agregar Rol</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                name: '',
                display_name: ''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            newRole(){
                const  params = {
                    name: this.name,
                    display_name: this.display_name
                };
                this.name = '';
                this.display_name = '';
                axios.post('/roles', params).
                then((response) => {
                    const rol = response.data;
                    console.log(rol);
                    this.$emit('new', rol);
                });
            }
        }
    }
</script>

<template>
    <div class="row justify-content-center">
        <div class="card col-md-8">

            <div class="card-header">Editar Usuario <button @click="cancel()" type="submit" class="btn btn-danger float-md-right">Regresar</button></div>

            <div v-if="this.selectedView === 'editView'" class="card-body">
                <form action="" v-on:submit.prevent="onClickUpdate()" >

                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" name="name" id="name"
                               v-model="user.name">
                        <label for="email">Correo electronico:</label>
                        <input type="text" class="form-control" name="email" id="email"
                               v-model="user.email">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password"
                               v-model="password">
                        <label for="repassword">Repite contraseña:</label>
                        <input type="password" class="form-control" name="repassword" id="repassword"
                               v-model="repassword">
                        <label for="role">Rol: </label>
                        <select
                            id="role"
                            v-model="user.role_id"
                            name="role"
                            class="align-content-end"
                        >
                            <option v-for="(role, index) in roles" v-bind:value="role.id" :selected="role.id === user.role_id">{{role.display_name}}</option>
                        </select>

                    </div>
                    <div v-if='!matches'>
                        <p>Passwords don't match.</p>
                    </div>
                    <button v-if='matches' type="submit" class="btn btn-success">Guardar Usuario</button>
                </form>


            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            user:{}
        },
        data(){
            return{
                roles: [],
                selectedView: '',
                name: '',
                email: '',
                password: '',
                repassword: '',
                role_id: ''
            }
        },
        mounted() {
            axios.get('/roles/all').then((response) =>{
                this.roles = response.data;
            });
            if (this.user.id !== 0 || this.user.id !== null){
                this.selectedView = 'editView';
            }
        },
        methods: {
            onClickUpdate(){

                const params = {
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                    password: this.password,
                    role_id: this.user.role_id
                };
                axios.put(`/users/${this.user.id}`, params).then((response) => {
                    this.editMode = false;
                    const user = response.data;
                });
                window.location.href="/users";
            },
            cancel(){
                window.location.href="/users";
            }
        },
        computed:{
            matches () {
                if (this.password === this.repassword){
                    return true
                }else{
                    return false
                }
            }
        }
    }
</script>

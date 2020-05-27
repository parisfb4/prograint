<template>
    <div class="card">

        <div class="card-header">Nuevo Usuario</div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="newUser()" >

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" id="name"
                           v-model="name">
                    <div v-if='!nameFilled'>
                        <p>Por favor ingresa el nombre.</p>
                    </div>
                    <label for="email">Correo electronico:</label>
                    <input type="text" class="form-control" name="email" id="email"
                           v-model="email">
                    <div v-if='!emailFilled'>
                        <p>Por favor ingresa el email.</p>
                    </div>
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" id="password"
                           v-model="password">
                    <label for="repassword">Repite contraseña:</label>
                    <input type="password" class="form-control" name="repassword" id="repassword"
                           v-model="repassword">
                    <div v-if='!passwordsFilled'>
                        <p>Por favor ingresa la contraseña.</p>
                    </div>
                    <label for="role">Rol: </label>
                    <select
                        id="role"
                        v-model="role_id"
                        name="role"
                        class="align-content-end"
                    >
                        <option v-bind:value="role.id" v-for="(role, index) in roles">{{role.display_name}}</option>
                    </select>
                    <div v-if='!roleSelected'>
                        <p>Selecciona una opción.</p>
                    </div>

                </div>
                <div v-if='!matches && passwordsFilled'>
                    <p>Las contraseñas no coinciden.</p>
                </div>
                <button v-if='passwordsFilled && matches && nameFilled && emailFilled && roleSelected' type="submit" class="btn btn-primary">Agregar Usuario</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                roles: [],
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
        },
        methods: {
            newUser(){
                const  params = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role_id: this.role_id
                };
                this.name= '';
                this.email= '';
                this.password= '';
                this.role_id= '';
                this.repassword= '';
                axios.post('/users', params).
                then((response) => {
                    const user = response.data;
                    this.$emit('new', user);
                });
            }
        },
        computed:{
            matches () {
                if (this.passwordsFilled) {
                    return (this.password === this.repassword)
                } else {
                    return false
                }
            },
            passwordsFilled () {
                return (this.password !== '' && this.repassword !== '')
            },
            emailFilled () {
                return (this.email !== '')
            },
            nameFilled () {
                return (this.name !== '')
            },
            roleSelected () {
                return (this.role_id !== '')
            }
        }
    }
</script>

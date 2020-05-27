<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form-user-component @new="addUser"></form-user-component>
                <hr>
                <ul class="list-group list-group-horizontal text-center">
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Nombre</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Correo</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Role</li>
                            <li class="list-group-item list-group-item-dark col-md-3" scope="col">Opciones</li>
                </ul>
                <user-component
                    v-for="(user, index) in users"
                    :key="user.id"
                    :user="user"
                    :roles="roles"
                    @delete="deleteUser(index, user)">
                </user-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                users: [],
                roles: []
            }
        },
        mounted() {
            axios.get('/users/all').then((response) =>{
                this.users = response.data;
            });
            axios.get('/roles/all').then((response) =>{
                this.roles = response.data;
            });

        },
        methods:{
            addUser(user)
            {
                this.users.push(user);
            },
            deleteUser(index){
                this.users.splice(index, 1);
            }
        },
    }
</script>

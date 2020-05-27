<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form-role-component @new="addRole"></form-role-component>
                <hr>
                <ul class="list-group list-group-horizontal text-center">
                    <li class="list-group-item list-group-item-dark col-md-4" scope="col">Nombre</li>
                    <li class="list-group-item list-group-item-dark col-md-4" scope="col">Nombre para mostrar</li>
                    <li class="list-group-item list-group-item-dark col-md-4" scope="col">Opciones</li>
                </ul>
                <role-component
                    v-for="(role, index) in roles"
                    :key="role.id"
                    :role="role"
                    @delete="deleteRole(index, role)"
                    @update="updateRole(index, role)">
                </role-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                roles: []
            }
        },
        mounted() {
            axios.get('/roles/all').then((response) =>{
                this.roles = response.data;
            });

        },
        methods:{
            addRole(role)
            {
                this.roles.push(role);
            },
            deleteRole(index){
                this.roles.splice(index, 1);
            },
            updateRole(index, role){
                this.roles[index] = role;
            }
        }
    }
</script>

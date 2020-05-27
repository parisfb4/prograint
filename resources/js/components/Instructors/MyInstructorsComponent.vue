<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form-instructor-component @new="addInstructor"></form-instructor-component>
                <hr>
                <ul class="list-group list-group-horizontal text-center">
                    <li class="list-group-item list-group-item-dark col-md-3" scope="col">Nombre</li>
                    <li class="list-group-item list-group-item-dark col-md-3" scope="col">Correo</li>
                    <li class="list-group-item list-group-item-dark col-md-3" scope="col">Telefono</li>
                    <li class="list-group-item list-group-item-dark col-md-3" scope="col">Opciones</li>
                </ul>
                <instructor-component
                    v-for="(instructor, index) in instructors"
                    :key="instructor.id"
                    :instructor="instructor"
                    @delete="deleteInstructor(index, instructor)"
                    @update="updateInstructor(index, instructor)">
                </instructor-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                instructors: []
            }
        },
        mounted() {
            axios.get('/instructors/all').then((response) =>{
                this.instructors = response.data;
            });

        },
        methods:{
            addInstructor(instructor)
            {
                this.instructors.push(instructor);
            },
            deleteInstructor(index){
                this.instructors.splice(index, 1);
            },
            updateInstructor(index, instructor){
                this.instructors[index] = instructor;
            }
        }
    }
</script>

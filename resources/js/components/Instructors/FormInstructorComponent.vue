<template>
    <div class="card">

        <div class="card-header">Nuevo Instructor</div>

        <div class="card-body">
            <form action="" v-on:submit.prevent="newInstructor()" >

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" id="name"
                           v-model="name">
                    <div v-if='!nameFilled'>
                        <p>Por favor ingresa el nombre.</p>
                    </div>
                    <label for="mail">Correo electronico:</label>
                    <input type="text" class="form-control" name="mail" id="mail"
                           v-model="mail">
                    <div v-if='!emailFilled'>
                        <p>Por favor ingresa el mail.</p>
                    </div>
                    <label for="phone">Telefono:</label>
                    <input type="text" class="form-control" name="phone" id="phone"
                           v-model="phone">
                    <div v-if='!phoneFilled'>
                        <p>Por favor ingresa el telefono.</p>
                    </div>
                </div>
                <button v-if='nameFilled && emailFilled && phoneFilled' type="submit" class="btn btn-primary">Agregar Instructor</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                instructors: [],
                name: '',
                mail: '',
                phone: ''
            }
        },
        mounted() {
        },
        methods: {
            newInstructor(){
                const  params = {
                    name: this.name,
                    mail: this.mail,
                    phone: this.phone,
                };
                this.name= '';
                this.mail= '';
                this.phone= '';
                axios.post('/instructors', params).
                then((response) => {
                    const instructor = response.data;
                    this.$emit('new', instructor);
                });
            }
        },
        computed:{
            phoneFilled () {
                return (this.phone !== '')
            },
            emailFilled () {
                return (this.mail !== '')
            },
            nameFilled () {
                return (this.name !== '')
            }
        }
    }
</script>

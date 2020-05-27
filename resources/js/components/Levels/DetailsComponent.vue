<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="">
                <form @submit.prevent="">
                    <div class="card-header text-white bg-secondary">
                        <h2>Detalles Nivel</h2>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-sm-6 col-xl-4">
                                <h3>ID</h3>
                                <input type="text" placeholder="Nombre" class="form-control mb-2 text-center" v-model="this.level.id" disabled>
                                <h3>Nombre</h3>
                                <input type="text" placeholder="Nombre" class="form-control mb-2 text-center" v-model="this.level.name" disabled>
                                <br>
                                <div>
                                    <h3>Disciplina</h3>
                                    <input type="text" class="form-control mb-2 text-center " v-model="discipline.name" disabled>
                                    <a href="">Ver detalles de la disciplina</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <button class="btn btn-warning form-button m-3 p-3" @click="setEditView()">Editar</button>
                            </div>
                            <div class="col-xs-12 col-sm-6"> 
                                <button class="btn btn-danger form-button m-3 p-3" @click="goBack()">Regresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            level:{},
            discipline:{}
        },
        data(){
            return {
                disciplineText:''
            }
        },
        created(){
            
        },
        methods:{
            setEditView(){
                window.location.href="/niveles/editar/"+this.level.id;
            },
            goBack(){
                window.history.back();
            }
        }
        
    }
</script>
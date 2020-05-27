<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="">
                <form @submit.prevent="">
                    <div class="card-header text-white bg-secondary">
                        <h2>Detalles Curso</h2>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="row col-xs-12">
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Nombre</h3>
                                    <input type="text" placeholder="Nombre" class="form-control text-center" v-model="course.name" disabled>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Disciplina</h3>
                                    <input type="text" placeholder="Disciplina" class="form-control text-center" v-model="course.discipline.name" disabled>
                                    <a href="javascript:void(0)" @click="disciplineDetails()">Ver detalles de la disciplina</a>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Nivel</h3>
                                    <input type="text" placeholder="Nivel" class="form-control text-center" v-model="course.level.name" disabled>
                                    <a href="javascript:void(0)" @click="levelDetails()">Ver detalles del nivel</a>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Costo</h3>
                                    <input type="number" placeholder="Costo" class="form-control text-center" v-model="course.cost" disabled>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Fecha de inicio</h3>
                                    <input type="text" placeholder="Fecha inicio" class="form-control text-center" v-model="course.date_start" disabled>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Fecha de fin</h3>
                                    <input type="text" placeholder="Fecha fin" class="form-control text-center" v-model="course.date_end" disabled>
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
            course:{}
        },
        data(){
            return {
            }
        },
        created(){
            console.log(this.course);
        },
        methods:{
            setEditView(){
                window.location.href="/cursos/editar/"+this.course.id;
            },
            goBack(){
                window.history.back();
            },
            levelDetails(){
                window.location.href="/niveles/"+this.course.id_level;
            },
            disciplineDetails(){
                
            }
        }
        
    }
</script>
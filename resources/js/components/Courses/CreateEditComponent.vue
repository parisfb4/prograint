<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="">
                <form @submit.prevent="">
                    <div class="card-header bg-secondary text-white" v-if="selectedView==='addView'">
                        <h2>Agregar Curso</h2>
                    </div>
                    <div class="card-header bg-secondary text-white" v-else>
                        <h2>Editar Curso</h2>
                    </div>
                    <div class="card-body">
                        <dir class="row justify-content-center">
                            <div class="row col-xs-12">
                                <div class="row justify-content-center col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <div class="col-xs-12 p-0 m-0">
                                        <h3>Nombre</h3>
                                        <input type="text" placeholder="Nombre" class="form-control text-center" v-model="course.name" v-on:keyup="isValidName()">
                                        <h2 class="text-danger" v-if="invalidName">El nombre ya esta registrasdo!!!</h2>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Disciplina</h3>
                                    <el-select v-model="id_discipline" placeholder="Select">
                                        <el-option v-for="d in disciplines" :key="d.id" :label="d.name" :value="d.id"></el-option>
                                    </el-select>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Nivel</h3>
                                    <el-select v-model="id_level" placeholder="Select">
                                        <el-option v-for="d in levels" :key="d.id" :label="d.name" :value="d.id"></el-option>
                                    </el-select>
                                </div>
                                <div class="row justify-content-center col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <div class="col-xs-12 p-0 m-0">
                                        <h3>Costo</h3>
                                        <input type="number" placeholder="Costo" class="form-control text-center" v-model="course.cost">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Fecha de inicio</h3>
                                    <el-date-picker v-model="date_start" type="date" placeholder="Seleccione una fecha"></el-date-picker>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4 mb-2">
                                    <h3>Fecha de fin</h3>
                                    <el-date-picker v-model="date_end" type="date" placeholder="Seleccione una fecha"></el-date-picker>
                                </div>
                            </div>
                        </dir>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <button class="btn btn-info form-button m-3 p-3" @click="showList()">Mostrar Lista</button>
                            </div>
                            <div class="col-sm-12 col-lg-4" v-if="selectedView==='addView'">
                                <button class="btn btn-success form-button m-3 p-3" @click="addCourse()">Agregar</button>
                            </div>
                            <div class="col-xs-12 col-sm-4" v-else>
                                <button class="btn btn-success form-button m-3 p-3" @click="updateCourse()">Guardar</button>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <button class="btn btn-danger form-button m-3 p-3" @click="cancelUpdate()">Regresar</button>
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
            course:{},
        },
        data(){
            return {
                allCourses:[],
                levels:[],
                disciplines:[],
                id_discipline: null,
                selectedView: '',
                invalidName:false,
                id_level:null,
                date_start:'',
                date_end:''
            }
        },
        created(){
            axios.get('/cursos/agregar').then(res=>{
                this.allCourses=res.data["courses"];
                this.disciplines=res.data["disciplines"];
                this.levels=res.data['levels'];
                if(this.course.id===0){
                    this.selectedView = 'addView';
                }else{
                    this.selectedView = 'updateView';
                    this.id_discipline = this.course.id_discipline;
                    this.id_level = this.course.id_level;
                    this.date_start = this.course.date_start.toString();
                    this.date_end = this.course.date_end.toString();
                }
            });
        },
        methods:{
            updateDisciplineId(discipline){
                this.course.id_discipline=discipline.id;
            },
            addCourse(){
                this.course.name=this.course.name.trim();
                if(this.id_discipline===null||this.course.name === ''|| this.id_level===null || this.date_start===''||this.date_end===''){
                    this.showErrorNotification('Campos incompletos','Debe llenar todos los campos');
                    return;
                }
                if(!this.isValidName()){
                    this.showErrorNotification('Nombre inválido','El nombre ya se encuentra registrado');
                    return;
                }
                var ds = new Date(this.date_start);
                var de = new Date(this.date_end);
                console.log(ds);
                if(ds > de){
                    this.showErrorNotification('Fechas inválidas','El curso termina antes de empezar');
                    return;
                }
                var params = this.setReady();
                axios.post('/cursos',params).then(res=>{
                    this.allCourses.push(res.data);
                    this.showSuccessNotification('Curso agregado',"Curso agregado exitosamente.");
                    this.resetFields();
                })

            },
            setReady(){
                this.course.id_discipline=this.id_discipline;
                this.course.id_level= this.id_level;
                this.course.date_start= this.date_start;
                this.course.date_end=this.date_end;
                
                console.log(this.course);
                
                const params={name: this.course.name,id_discipline: this.course.id_discipline,id_level: this.course.id_level,date_start: this.course.date_start,date_end: this.course.date_end,cost:this.course.cost};
                console.log(params);
                return params;
            },
            showSuccessNotification(title,text){
                this.$notify({
                    title: title,
                    message:text,
                    type: 'success'
                });
            },
            showErrorNotification(title,text){
                this.$notify({
                    title:title,
                    message: text,
                    type: 'error'
                })
            },  
            isValidName(){
                var index=this.allCourses.findIndex(a=>a.name === this.course.name.trim())
                if(index>-1){
                    if(this.selectedView==='addView'){
                        this.invalidName=true;
                        return false;
                    }else{
                        if(this.course.name.trim()===this.allCourses[this.allCourses.findIndex(a=>a.id===this.course.id)].name){
                            this.invalidName=false;
                            return true;
                        }else{
                            this.invalidName=true;
                            return false;
                        }
                    }
                }else{
                    this.invalidName=false;
                    return true;
                }
            },
            updateCourse(){
                this.course.name=this.course.name.trim();
                if(this.id_discipline===null||this.course.name === ''|| this.id_level===null || this.date_start===''||this.date_end===''){
                    this.showErrorNotification('Campos incompletos','Debe llenar todos los campos');
                    return;
                }
                if(!this.isValidName()){
                    this.showErrorNotification('Nombre inválido','El nombre ya se encuentra registrado');
                    return;
                }
                var ds = new Date(this.date_start);
                var de = new Date(this.date_end);
                console.log(ds);
                if(ds > de){
                    this.showErrorNotification('Fechas inválidas','El curso termina antes de empezar');
                    return;
                }
                var params=this.setReady();
                axios.put(`/cursos/${this.course.id}`,params).then(res=>{
                    const index=this.allCourses.findIndex(search=>search.id === res.data.id);
                    this.allCourses[index]=res.data;
                    this.showSuccessNotification('Curso editado','Se ha editado el curso exitosamente')
                });
                
            },
            showList(){
                window.location.href="/cursos/";
            },
            resetFields(){
                this.course.name = '';
                this.course.id_discipline = null;
                this.course.id_level = null;
                this.id_level = null;
                this.id_discipline = null;
                this.course.cost = 0;
                this.date_start = '';
                this.date_end = '';
            },
            cancelUpdate(){
                window.history.go(-1);
            }
        }
        
    }
</script>
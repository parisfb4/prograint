<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="">
                <form @submit.prevent="" v-if="selectedView === 'addView'">
                    <div class="card-header bg-secondary text-white">
                        <h2>Agregar Nivel</h2>
                    </div>
                    <div class="card-body">
                        <dir class="row justify-content-center">
                            <div class="col-xs-12 col-sm-6 col-xl-4 ">
                                <h3>Nombre</h3>
                                <input type="text" placeholder="Nombre" class="form-control mb-2 text-center" v-model="level.name" v-on:keyup="isValidName()">
                                <h3 class="text-danger" v-if="invalidName">El nombre ya esta registrasdo!!!</h3>
                                <br>
                                <h3>Disciplina</h3>
                                <el-select v-model="id_discipline" placeholder="Select">
                                    <el-option v-for="d in disciplines" :key="d.id" :label="d.name" :value="d.id"></el-option>
                                </el-select>
                            </div>
                        </dir>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <button class="btn btn-info form-button m-3 p-3" @click="showList()">Mostrar Lista</button>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <button class="btn btn-success form-button m-3 p-3" @click="addLevel()">Agregar</button>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <button class="btn btn-danger form-button m-3 p-3" @click="cancelUpdate()">Regresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            
                <form @submit.prevent="" v-if="selectedView === 'updateView'">
                    <div class="card-header bg-secondary text-white">
                        <h2>Editar Nivel</h2>
                    </div>
                    <div class="card-body">
                        <dir class="row justify-content-center">
                            <div class="col-xs-12 col-sm-6 col-xl-4 ">
                                <h3>Nombre</h3>
                                <input type="text" placeholder="Nombre" class="form-control mb-2 text-center" v-model="level.name" v-on:keyup="isValidName()">
                                <h3 class="text-danger" v-if="invalidName">El nombre ya esta registrasdo!!!</h3>
                                <br>
                                <h3>Disciplina</h3>
                                <el-select v-model="id_discipline" placeholder="Select">
                                    <el-option v-for="d in disciplines" :key="d.id" :label="d.name" :value="d.id"></el-option>
                                </el-select>
                            </div>
                        </dir>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <button class="btn btn-info form-button m-3 p-3" @click="showList()">Mostrar Lista</button>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <button class="btn btn-success form-button m-3 p-3" @click="updateLevel()">Guardar</button>
                            </div>
                            <div class="col-xs-12 col-sm-4">
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
            level:{}
        },
        data(){
            return {
                allLevels:[],
                disciplines:[],
                mapDisciplines:[],
                id_discipline: null,
                selectedView: '',
                invalidName:false
            }
        },
        created(){
            axios.get('/niveles').then(res=>{
                this.allLevels=res.data["levelsD"];
                this.disciplines=res.data["disciplinesD"];
                for(let d of res.data["disciplinesD"]){
                    this.mapDisciplines[d.id]=d.name;
                }
                if(this.level.id===0){
                    this.selectedView = 'addView';
                }else{
                    this.selectedView = 'updateView';
                    this.id_discipline=this.level.id_discipline;
                }
            });
        },
        methods:{
            updateDisciplineId(discipline){
                this.level.id_discipline=discipline.id;
            },
            addLevel(){
                this.level.name=this.level.name.trim();
                if(this.id_discipline ===  null||this.level.name === ''){
                    this.showErrorNotification('Campos incompletos','Debe llenar todos los campos');
                    return;
                }
                if(!this.isValidName()){
                    this.showErrorNotification('Nombre inválido','El nombre ya se encuentra registrado');
                    return;
                }
                this.level.id_discipline=this.id_discipline;
                console.log(this.level);
                
                const params={name: this.level.name,id_discipline: this.level.id_discipline};
                console.log(params);
                

                axios.post('/niveles',params).then(res=>{
                    this.allLevels.push(res.data);
                    this.showSuccessNotification('Nivel agregado',"Nivel agregado exitosamente.");
                    this.resetFields();
                })

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
                var index=this.allLevels.findIndex(a=>a.name === this.level.name.trim())
                if(index>-1){
                    if(this.selectedView==='addView'){
                        this.invalidName=true;
                        return false;
                    }else{
                        if(this.level.name.trim()===this.allLevels[this.allLevels.findIndex(a=>a.id===this.level.id)].name){
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
            updateLevel(){
                if(this.disciplineText ===  ''||this.level.name.trim() === ''){
                    this.showErrorNotification('Campos incompletos','Debe llenar todos los campos');
                    return;
                }
                if(!this.isValidName()){
                    this.showErrorNotification('Nombre inválido','El nombre ya se encuentra registrado');
                    return;
                }
                this.level.id_discipline=this.id_discipline;
                const params={name: this.level.name,id_discipline: this.level.id_discipline};
                
                axios.put(`/niveles/${this.level.id}`,params).then(res=>{
                    const index=this.allLevels.findIndex(search=>search.id === res.data.id);
                    this.allLevels[index]=res.data;
                    this.showSuccessNotification('Nivel editado','Se ha editado el nivel exitosamente')
                });
                
            },
            showList(){
                window.location.href="/niveles/";
            },
            resetFields(){
                this.level.name = '';
                this.level.id_discipline = -1;
                this.id_discipline=null;
            },
            cancelUpdate(){
                window.history.go(-1);
            }
        }
        
    }
</script>
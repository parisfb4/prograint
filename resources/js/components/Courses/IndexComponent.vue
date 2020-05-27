<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="m-19">
                <div class="card-header bg-secondary text-white">
                    <h2>Listado de cursos</h2>
                </div>
                <div class="card-body">
                    <div class="row m-2">
                    <input type="text" class="form-control mb-2 col-xs-12 col-sm-6" placeholder="Buscar" v-model="search" v-on:keyup="searching(1)" >
                    <h2 class="text-info ml-5">{{selectedCourses.length}} registros encontrados</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered bg-white">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th @click="sortTable('id')">ID</th>
                                    <th @click="sortTable('name')">NOMBRE</th>
                                    <th @click="sortTable('discipline')">DISCIPLINA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in courses" :key="index" class="text-center">
                                    <td>{{item.id}}</td>
                                    <td class="w-25">{{item.name}}</td>
                                    <td class="w-25">{{item.discipline.name}}</td>
                                    <td>
                                        <div class="col-12">
                                            <button class="btn btn-info m-2 col-xl-3 col-xs-12" @click="setDetailsView(item)">Detalles</button>
                                        
                                            <button class="btn btn-warning m-2 col-xl-3 col-xs-12" @click="setEditView(item)">Editar</button>
                                        
                                            <button class="btn btn-danger m-2 col-xl-3 col-xs-12" @click="deletecourse(item,index)">Eliminar</button>
                                        </div>
                                            
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="bg-red" v-if="selectedCourses.length == 0">NO SE ENCONTRARON REGISTROS!!!</h3>
                    <div class="pagination">
                        <button class="btn btn-default p-0 mr-2" @click="updateTable(-1)" :disabled="actualPage==0">Anterior</button>
                        <span class="">{{actualPage+1}} de {{totalPages}}</span>
                        <button class="btn btn-default p-0 ml-2" @click="updateTable(1)" :disabled="actualPage+1==totalPages">Siguiente</button>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success" @click="setAddView()">Agregar Curso</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                courses:[],
                order:0,
                allCourses:[],

                selectedCourses:[],
                course:{id:-1,name: '',id_discipline:-1,id_course:-1,date_start:null,date_end:null,cost:0.0},
                actualPage:0,
                totalPages:0,
                search:''
            }
        },
        mounted:function(){
            axios.get('/cursos').then(res=>{
                this.allCourses=res.data["courses"];
                console.log(this.allCourses);  
                this.selectedCourses=this.allCourses;
                this.totalPages=Math.ceil(this.selectedCourses.length/5);
                this.searching(2);
            });
            
        },
        methods:{
            reloadPage(){
                window.location.reload(true);
            },
            searching(value){
                if(this.search.trim() === ''){
                    if(value==1){
                        this.actualPage=0;
                    }
                    this.selectedCourses=this.allCourses;
                    this.updateTotalPages();
                    this.updateTable(0);
                }else{
                    this.selectedCourses=[];
                    for(let l of this.allCourses){
                        if(l.name.toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedCourses.push(l);
                        }else if(l.discipline.name.toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedCourses.push(l);
                        }else if(l.id.toString().indexOf(this.search.trim())>-1){
                            this.selectedCourses.push(l);
                        }
                    }
                    if(value === 1){
                        this.actualPage=0;
                    }
                    this.updateTotalPages();
                    this.updateTable(0);
                }
            },
            updateTable(change){
                this.actualPage+=change;
                if(this.totalPages<this.actualPage+1){
                    this.actualPage--;
                }
                this.courses=this.selectedCourses.slice(this.actualPage*5,this.actualPage*5+5);
            },
            updateTotalPages(){
                this.totalPages = Math.ceil(this.selectedCourses.length/5);
            },
            deletecourse(item,index){
                this.$confirm('Realmente desea eliminar el nivel','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/cursos/${item.id}`).then(res=>{
                        if(res.data["information"] === 'good'){
                            this.allCourses.splice(this.allCourses.findIndex(a=>a.id === item.id),1);
                            this.searching(2);
                            this.showSuccessNotification('Curso eliminado','El curso fue eliminado exitosamente');
                        }else{
                            this.showErrorNotification('Error al eliminar','El curso se encuentra asignado en un horario');
                        }
                        
                    });
                    
                }).catch(()=>{
                    this.$notify({
                        type: 'info',
                        title: 'Eliminacion cancelada',
                        message: 'La eliminación ha sido cancelada'
                    });
                });
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
            setAddView(){
                window.location.href="/cursos/agregar";
            },
            setDetailsView(item){
                window.location.href="/cursos/"+item.id;

            },
            setEditView(item){
                window.location.href="/cursos/editar/"+item.id;
            },
            sortTable(value){
                if(this.order === 1){
                    this.order=2;
                }else{
                    this.order=1;
                }
                if(value ==='id'){
                    if(this.order===1){
                        this.selectedCourses.sort(function(a,b){return a.id<b.id?-1:a.id>b.id});
                    }else{
                        this.selectedCourses.sort(function(a,b){return a.id>b.id?-1:a.id<b.id});
                    }
                }else if(value === 'name'){
                    if(this.order===1){
                        this.selectedCourses.sort(function(a,b){return a.name<b.name?-1:a.name>b.name});
                    }else{
                        this.selectedCourses.sort(function(a,b){return a.name>b.name?-1:a.name<b.name});
                    }
                }else if(value === 'discipline'){
                    if(this.order===1){
                        this.selectedCourses.sort(function(a,b){return a.discipline.name<b.discipline.name?-1:a.discipline.name>b.discipline.name});
                    }else{
                        this.selectedCourses.sort(function(a,b){return a.discipline.name>b.discipline.name?-1:a.discipline.name<b.discipline.name});
                    }
                }
                this.updateTable(0);
            }
        }
        
    }
</script>
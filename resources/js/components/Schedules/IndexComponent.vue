<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="m-19">
                <div class="card-header bg-secondary text-white">
                    <h2>Listado de horarios</h2>
                </div>
                <div class="card-body">
                    <div class="row m-2">
                    <input type="text" class="form-control mb-2 col-xs-12 col-sm-6" placeholder="Buscar" v-model="search" v-on:keyup="searching(1)" >
                    <h2 class="text-info ml-5">{{selectedSchedules.length}} registros encontrados</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered bg-white">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th @click="sortTable('id')">ID</th>
                                    <th @click="sortTable('course')">CURSO</th>
                                    <th @click="sortTable('instructor')">INSTRUCTOR</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in schedules" :key="index" class="text-center">
                                    <td>{{item.id}}</td>
                                    <td class="w-25">{{item.course!=null?item.course.name:"No asignado"}}</td>
                                    <td class="w-25">{{item.instructor!=null?item.instructor.name:"No asignado"}}</td>
                                    <td>
                                        <div class="col-12">
                                            <button class="btn btn-info m-2 col-xl-3 col-xs-12" @click="setDetailsView(item)">Detalles</button>
                                        
                                            <button class="btn btn-warning m-2 col-xl-3 col-xs-12" @click="setEditView(item)">Editar</button>
                                        
                                            <button class="btn btn-danger m-2 col-xl-3 col-xs-12" @click="deleteschedule(item,index)">Eliminar</button>
                                        </div>
                                            
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="bg-red" v-if="selectedSchedules.length == 0">NO SE ENCONTRARON REGISTROS!!!</h3>
                    <div class="pagination">
                        <button class="btn btn-default p-0 mr-2" @click="updateTable(-1)" :disabled="actualPage==0">Anterior</button>
                        <span class="">{{actualPage+1}} de {{totalPages}}</span>
                        <button class="btn btn-default p-0 ml-2" @click="updateTable(1)" :disabled="actualPage+1==totalPages">Siguiente</button>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success" @click="setAddView()">Agregar Horario</button>
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
                schedules:[],
                order:0,
                allSchedules:[],
                selectedSchedules:[],
                schedule:{id:-1,id_course:-1,id_instructor:-1,capacity: 0},
                actualPage:0,
                totalPages:0,
                search:''
            }
        },
        mounted:function(){
            axios.get('/horarios').then(res=>{
                this.allSchedules=res.data["schedules"];
                console.log(this.allSchedules);  
                for(let s of this.allSchedules){
                    if(s.course==null){
                        s.course = {name:"No asignado"};
                    }
                    if(s.instructor==null){
                        s.instructor={name:"No asignado"};
                    }
                }
                this.selectedSchedules=this.allSchedules;
                this.totalPages=Math.ceil(this.selectedSchedules.length/5);
                this.searching(2);
            });
            
        },
        methods:{
            searching(value){
                if(this.search.trim() === ''){
                    if(value==1){
                        this.actualPage=0;
                    }
                    this.selectedSchedules=this.allSchedules;
                    this.updateTotalPages();
                    this.updateTable(0);
                }else{
                    this.selectedSchedules=[];
                    for(let l of this.allSchedules){
                        if(l.course != null && l.course.name.toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedSchedules.push(l);
                        }else if(l.instructor != null && l.instructor.name.toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedSchedules.push(l);
                        }else if(l.id.toString().indexOf(this.search.trim())>-1){
                            this.selectedSchedules.push(l);
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
                this.schedules=this.selectedSchedules.slice(this.actualPage*5,this.actualPage*5+5);
            },
            updateTotalPages(){
                this.totalPages = Math.ceil(this.selectedSchedules.length/5);
            },
            deleteschedule(item,index){
                this.$confirm('Realmente desea eliminar el horario','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/horarios/${item.id}`).then(res=>{
                        if(res.data["information"] === 'good'){
                            this.allSchedules.splice(this.allSchedules.findIndex(a=>a.id === item.id),1);
                            this.searching(2);
                            this.showSuccessNotification('Horario eliminado','El horario fue eliminado exitosamente');
                        }else{
                            this.showErrorNotification('Error al eliminar','El horario se encuentra asignado')
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
                window.location.href="/horarios/agregar";
            },
            setDetailsView(item){
                window.location.href="/horarios/"+item.id;

            },
            setEditView(item){
                window.location.href="/horarios/editar/"+item.id;
            },
            sortTable(value){
                if(this.order === 1){
                    this.order=2;
                }else{
                    this.order=1;
                }
                if(value ==='id'){
                    if(this.order===1){
                        this.selectedSchedules.sort(function(a,b){return a.id<b.id?-1:a.id>b.id});
                    }else{
                        this.selectedSchedules.sort(function(a,b){return a.id>b.id?-1:a.id<b.id});
                    }
                }else if(value === 'course'){
                    if(this.order===1){
                        this.selectedSchedules.sort(function(a,b){return a.course.name<b.course.name?-1:a.course.name>b.course.name});
                    }else{
                        this.selectedSchedules.sort(function(a,b){return a.course.name>b.course.name?-1:a.course.name<b.course.name});
                    }
                }else if(value === 'instructor'){
                    if(this.order===1){
                        this.selectedSchedules.sort(function(a,b){return a.instructor.name<b.instructor.name?-1:a.instructor.name>b.instructor.name});
                    }else{
                        this.selectedSchedules.sort(function(a,b){return a.instructor.name>b.instructor.name?-1:a.instructor.name<b.instructor.name});
                    }
                }
                this.updateTable(0);
            }
        }
        
    }
</script>
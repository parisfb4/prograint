<template>
    <div class="p-3 text-center">
        <div id="" class="card">
            <div class="m-19">
                <div class="card-header bg-secondary text-white">
                    <h2>Listado de niveles</h2>
                </div>
                <div class="card-body">
                    <div class="row m-2">
                    <input type="text" class="form-control mb-2 col-xs-12 col-sm-6" placeholder="Buscar" v-model="search" v-on:keyup="searching(1)" >
                    <h2 class="text-info ml-5">{{selectedLevels.length}} registros encontrados</h2>
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
                                <tr v-for="(item,index) in levels" :key="index" class="text-center">
                                    <td>{{item.id}}</td>
                                    <td class="w-25">{{item.name}}</td>
                                    <td class="w-25">{{disciplines[disciplines.findIndex(search=>search.id === item.id_discipline)].name}}</td>
                                    <td>
                                        <div class="col-12">
                                            <button class="btn btn-info m-2 col-xl-3 col-xs-12" @click="setDetailsView(item)">Detalles</button>
                                        
                                            <button class="btn btn-warning m-2 col-xl-3 col-xs-12" @click="setEditView(item)">Editar</button>
                                        
                                            <button class="btn btn-danger m-2 col-xl-3 col-xs-12" @click="deleteLevel(item,index)">Eliminar</button>
                                        </div>
                                            
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="bg-red" v-if="selectedLevels.length == 0">NO SE ENCONTRARON REGISTROS!!!</h3>
                    <div class="pagination">
                        <button class="btn btn-default p-0 mr-2" @click="updateTable(-1)" :disabled="actualPage==0">Anterior</button>
                        <span class="">{{actualPage+1}} de {{totalPages}}</span>
                        <button class="btn btn-default p-0 ml-2" @click="updateTable(1)" :disabled="actualPage+1==totalPages">Siguiente</button>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success" @click="setAddView()">Agregar Nivel</button>
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
                levels:[],
                order:0,
                allLevels:[],

                selectedLevels:[],
                level:{name: '',id_discipline:-1},
                disciplines:[],
                mapDisciplines:[],
                disciplineText: '',
                actualPage:0,
                totalPages:0,
                search:'',
                invalidName:false,
                editing: false
            }
        },
        created:function(){
            axios.get('/niveles').then(res=>{
                this.allLevels=res.data["levelsD"];
                this.disciplines=res.data["disciplinesD"];
                for(let d of res.data["disciplinesD"]){
                    this.mapDisciplines[d.id]=d.name;
                }
                console.log(this.allLevels);
                console.log(this.disciplines);    
                this.selectedLevels=this.allLevels;
                this.totalPages=Math.ceil(this.selectedLevels.length/5);
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
                    this.selectedLevels=this.allLevels;
                    this.updateTotalPages();
                    this.updateTable(0);
                }else{
                    this.selectedLevels=[];
                    for(let l of this.allLevels){
                        if(l.name.toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedLevels.push(l);
                        }else if(this.mapDisciplines[l.id_discipline].toLowerCase().indexOf(this.search.toLowerCase().trim())>-1){
                            this.selectedLevels.push(l);
                        }else if(l.id.toString().indexOf(this.search.trim())>-1){
                            this.selectedLevels.push(l);
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
                this.levels=this.selectedLevels.slice(this.actualPage*5,this.actualPage*5+5);
            },
            updateTotalPages(){
                this.totalPages = Math.ceil(this.selectedLevels.length/5);
            },
            deleteLevel(item,index){
                this.$confirm('Realmente desea eliminar el nivel','Alerta',{
                    confirmButtonText:'Continuar',
                    cancelButtonText: 'Cancelar',
                    type:'warning'
                }).then(()=>{
                    axios.delete(`/niveles/${item.id}`).then(res=>{
                        if(res.data['information'] === 'good'){
                            this.allLevels.splice(this.allLevels.findIndex(a=>a.id === item.id),1);
                            this.searching(2);
                            this.showSuccessNotification('Nivel eliminado','El nivel fue eliminado exitosamente');
                        }else{
                            this.showErrorNotification('Error al eliminar','El nivel se encuentra asignado en un curso');
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
                window.location.href="/niveles/agregar";
            },
            setDetailsView(item){
                window.location.href="/niveles/"+item.id;

            },
            setEditView(item){
                this.editing=true;
                window.location.href="/niveles/editar/"+item.id;
            },
            compareDiscipline(a,b){
                if(this.order==1){
                    return this.mapDisciplines[a.id_discipline]<this.mapDisciplines[b.id_discipline]?-1:this.mapDisciplines[a.id_discipline]>this.disciplines[b.id_discipline];
                }else{
                    return this.mapDisciplines[a.id_discipline]>this.mapDisciplines[b.id_discipline]?-1:this.mapDisciplines[a.id_discipline]<this.disciplines[b.id_discipline];
                }
            },
            sortTable(value){
                if(this.order === 1){
                    this.order=2;
                }else{
                    this.order=1;
                }
                if(value ==='id'){
                    if(this.order===1){
                        this.selectedLevels.sort(function(a,b){return a.id<b.id?-1:a.id>b.id});
                    }else{
                        this.selectedLevels.sort(function(a,b){return a.id>b.id?-1:a.id<b.id});
                    }
                }else if(value === 'name'){
                    if(this.order===1){
                        this.selectedLevels.sort(function(a,b){return a.name<b.name?-1:a.name>b.name});
                    }else{
                        this.selectedLevels.sort(function(a,b){return a.name>b.name?-1:a.name<b.name});
                    }
                }else if(value === 'discipline'){
                    this.selectedLevels.sort(this.compareDiscipline);
                }
                this.updateTable(0);
            }
        }
        
    }
</script>
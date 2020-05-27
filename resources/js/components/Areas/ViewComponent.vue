<template>
    <detailsAreas-component v-if="this.detailId!=null" @returnedA="reg" :detailsId.sync="this.detailId"></detailsAreas-component>
    <div class="card" v-else-if="!agregar">
        <div class="card-header" style="background-color: #5DB7CE">
            <h2>
                <center>Tabla de Áreas</center>
            </h2>
        </div>
        <div class="card-body">
            <tableAreas-component @edit="editM" @details="detailFunc"></tableAreas-component>
            <div class="text-right">
                <button class="btn btn-primary" v-if="!agregar" v-on:click="agregar=true">Agregar Áreas</button>
            </div>
        </div>

    </div>
    <agregarAreas-component v-else @new="added" :editId.sync="this.editId"></agregarAreas-component>
</template>
<script>
    export default {
        data() {
            return {
                agregar: false,
                editId: null,
                details: false,
                detailId: null
            }
        },
        methods: {
            added() {
                this.agregar = false;
                this.editId = null;
            }, editM(ediId) {
                this.editId = ediId;
                this.agregar = true;
            }, detailFunc(ediId) {
                this.detailId = ediId;
                this.details = true;

            }, reg() {
                this.agregar = false;
                this.editId = null;
                this.detailId = null;
                this.details = false;
            }
        }
    }
</script>
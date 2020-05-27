<template>
    <details-component v-if="this.detailId!=null" @returnedA="reg" :showPay="true" :detailsId.sync="this.detailId"></details-component>
    <div class="card" v-else-if="!agregar">
        <div class="card-header" style="background-color: #5DB7CE">
            <h2>
                <center>Tabla de Usuarios</center>
            </h2>
        </div>
        <div class="card-body">
            <table-component @edit="editM" @details="detailFunc"></table-component>
            <div class="text-right">
                <button class="btn btn-primary" v-if="!agregar" v-on:click="agregar=true">Agregar Usuario</button>
            </div>
        </div>

    </div>
    <agregar-component v-else @new="added" :editId.sync="this.editId"></agregar-component>
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

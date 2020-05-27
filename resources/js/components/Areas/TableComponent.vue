<template>
  <div>
    <div class="input-group m-4">
      <div class="col-xs-10 col-lg-6">
        <input
          type="text"
          class="form-control"
          name="search"
          v-model="search"
          v-on:change="searchButton"
          placeholder="Ingrese palabra a buscar"
        />
      </div>
    </div>
    <table
      class="table table-striped table-bordered table-sm table-hover"
      cellspacing="0"
      width="100%"
    >
      <thead>
        <tr>
          <th @click="sort(1)" style="background-color: #A0D3E1">
            <center>Id</center>
          </th>
          <th @click="sort(2)" style="background-color: #A0D3E1">
            <center>Nombre del Área</center>
          </th>
          <th style="background-color: #A0D3E1">
            <center>Acciones</center>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(props,index) in data" v-bind:key="props.id">
          <td>
            <center>{{ props.id }}</center>
          </td>

          <td label="Usuario" width="40%">
            <center>{{ props.name}}</center>
          </td>
          <td>
            <div class="row col-12">
              <button
                @click="onClickDetails(props.id)"
                class="btn btn-info col-xs-12 col-lg-3 m-1"
              >Detalles</button>
              <button
                @click="onClickEdit(props.id)"
                class="btn btn-secondary col-xs-12 col-lg-4 m-1"
              >Editar</button>
              <button
                @click="onClickDelete(props.id,index)"
                class="btn btn-danger col-xs-12 col-lg-4 m-1"
              >Eliminar</button>
            </div>
          </td>
        </tr>
        <tr v-if="data.length==0" height="50">
          <td colspan="4">
            <center>Sin resultados</center>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <button class="btn btn-default" @click="Prev()" :disabled="this.actual<=this.min">Anterior</button>
      <span>Página {{this.actual+1}} de {{this.max}}</span>
      <button class="btn btn-default" @click="Next()" :disabled="this.actual+1>=this.max">Siguiente</button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: [],
      search: "",
      asc: true,
      content: [],
      min: 0,
      actual: 0,
      max: 0,
      pagesize: 5,
      aux: []
    };
  },
  mounted() {
    axios
      .get("/areas")
      .then(res => {
        this.content = res.data;
        this.aux = this.content;
        this.max = Math.ceil(this.content.length / 5.0);
        this.actual = 0;
        this.Prev();
      })
      .catch(error => {
        this.showErrorNotification(
          "Error al cargar datos",
          "Conexion invalida"
        );
      });
  },
  methods: {
    onClickDelete($idc, $iddel) {
      axios
        .delete(`/areas/${$idc}`)
        .then(response => {
          if (response.data == 0) {
            this.showErrorNotification(
              "Error Eliminando",
              "El Area pertenece a una disciplina"
            );
          } else {
            this.showSuccessNotification("Eliminar", "Area Eliminada");
            var index = this.aux.findIndex(i => i.id === $idc);
            this.aux.splice(index, 1);
            axios.get("/areas").then(res => {
              this.content = res.data;
            });
            this.max = Math.ceil(this.aux.length / 5.0);
            this.update();
          }
        })
        .catch(error => {
          this.showErrorNotification("Error Eliminando", "Conexion invalida");
        });
    },
    onClickEdit($idy) {
      const ediId = $idy;
      this.$emit("edit", ediId);
    },
    onClickDetails($idy) {
      const ediId = $idy;
      this.$emit("details", ediId);
    },
    searchButton() {
      const params = {
        search: this.search
      };
      if (this.search == "") {
        this.aux = this.content;
        this.max = Math.ceil(this.aux.length / 5.0);
        this.actual = 0;
        this.Prev();
      } else {
        axios
          .post("/areas", params)
          .then(res => {
            console.log(this.search + res.data);
            this.aux = res.data;
            this.max = Math.ceil(this.aux.length / 5.0);
            this.actual = 0;
            this.Prev();
          })
          .catch(error => {
            this.showErrorNotification(
              "Error al cargar datos",
              "Conexion invalida"
            );
          });
      }
    },
    sort($op) {
      if ($op == 1) {
        if (this.asc) {
          this.aux.sort((a, b) => (a.id < b.id ? -1 : Number(a.id > b.id)));
          this.asc = false;
        } else {
          this.aux.sort((a, b) => (a.id > b.id ? -1 : Number(a.id < b.id)));
          this.asc = true;
        }
      } else if ($op == 2) {
        if (this.asc) {
          this.aux.sort((a, b) =>
            a.username < b.username ? -1 : Number(a.username > b.username)
          );
          this.asc = false;
        } else {
          this.aux.sort((a, b) =>
            a.username > b.username ? -1 : Number(a.username < b.username)
          );
          this.asc = true;
        }
      }
      this.actual = 0;
      this.Prev();
    },
    Prev() {
      if (this.actual > 0) this.actual--;
      this.update();
    },
    Next() {
      if (this.aux.length > this.actual * this.pagesize + this.pagesize)
        this.actual++;
      this.update();
    },
    update() {
      if (this.actual >= this.max) this.actual--;
      this.data = this.aux.slice(
        this.actual * this.pagesize,
        this.actual * this.pagesize + this.pagesize
      );
    },
    showSuccessNotification(title, text) {
      this.$notify({
        title: title,
        message: text,
        type: "success"
      });
    },
    showErrorNotification(title, text) {
      this.$notify({
        title: title,
        message: text,
        type: "error"
      });
    }
  }
};
</script>
<style scoped>
.table-striped > tbody > tr:nth-child(2n + 1) > td,
.table-striped > tbody > tr:nth-child(2n + 1) > th {
  background-color: #effbf5;
}
</style>
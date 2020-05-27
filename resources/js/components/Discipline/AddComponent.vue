<template>
  <div class="card justify-content-center text-center">
    <div v-if="this.editId==null" class="card-header bgH">
      <h3>Crear Disciplina</h3>
    </div>
    <div v-else class="card-header bgH">
      <h3>Editar Disciplina</h3>
    </div>
    <div class="card-body justify-content-center text-center"></div>
    <form method="POST" v-on:submit.prevent="newBlog()">
      <div class="row justify-content-center text-center">
        <label for="name" class="m-4">Nombre</label>
        <input
          type="text"
          name="name"
          v-model="name"
          class="form-control m-4"
          placeholder="Ingrese Nombre"
          required
        />
        <label for="id_area" class="m-4">Nombre del Área</label>
        <select v-model="id_area" name="id_area" class="form-control m-4" required>
          <option v-for="(d,index) in this.array" :key="index" v-bind:value="d">{{d.name}}</option>
        </select>
      </div>
      <div class="row">
        <div class="col-sm-10 col-lg-5 m-auto pb-2">
          <input
            type="submit"
            v-if="this.editId==null"
            class="btn btn-block btn-success"
            value="Crear Disciplina"
          />
          <input type="submit" v-else class="btn btn-block btn-success" value="Guardar Cambios" />
        </div>
        <div class="col-sm-10 col-lg-5 m-auto pb-2">
          <input
            type="button"
            value="Regresar"
            class="btn btn-block btn-primary"
            @click="returnE()"
          />
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  props: ["editId"],
  data() {
    return {
      name: "",
      array: [],
      id_area: [],
      name_area: "",
      dragCount: 0,
      isDragging: false
    };
  },
  mounted() {
    if (this.editId != null) {
      axios.get(`/disciplinas/${this.editId}`).then(response => {
        this.name = response.data.name;
        this.name_area = response.data.area;
        this.id_area = this.name_area;
        console.log(this.name_area);
      });
      axios.get("/areas").then(response => {
        this.array = response.data;
      });
    } else {
      axios.get("/areas").then(res => {
        this.array = res.data;
        console.log(this.array);
      });
    }
  },
  methods: {
    newBlog() {
      var id = this.array.findIndex(dis => dis.name === this.id_area);
      const params = {
        name: this.name,
        id_area: this.id_area.id
      };
      console.log(params);
      if (this.editId == null) {
        axios.post("/disciplinas", params).then(response => {
          if (response.data == 1) {
            this.$emit("new");
            this.name = "";
            this.showSuccessNotification("Agregando","Disciplina agregada")
          }else{
            this.showErrorNotification(
                "Error Guardando",
                "Conexion invalida"
              );
          }
        }).catch(error => {
              this.showErrorNotification(
                "Error Guardando",
                "Conexion invalida"
              );
            });;
      } else {
        axios.put(`/disciplinas/${this.editId}`, params).then(response => {
          this.$emit("new");
          this.showSuccessNotification("Editando","Disciplina editada")
        }).catch(error => {
              this.showErrorNotification(
                "Error Editando",
                "Conexion invalida"
              );
            });
      }
    },
    returnE() {
      this.$emit("new");
      this.name = "";
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
.bgH {
  background-color: #5db7ce;
}
</style>
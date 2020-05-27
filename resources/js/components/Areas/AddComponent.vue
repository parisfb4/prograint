<template>
  <div class="card justify-content-center text-center">
    <div v-if="this.editId==null" class="card-header bgH">
      <h3>Crear Área</h3>
    </div>
    <div v-else class="card-header bgH">
      <h3>Editar Área</h3>
    </div>
    <div class="card-body">
      <form method="POST" v-on:submit.prevent="newBlog()">
        <div class="form-group row mt-5">
          <label for="username" class="col-sm-2 col-form-label">Nombre</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="name"
              v-model="name"
              class="form-control"
              placeholder="Ingrese Nombre"
              required
            />
          </div>
        </div>
        <div class="pt-5 row text-center offset-md-2 m-auto">
          <div class="col-sm-10 col-lg-5 m-auto pb-2">
            <input
              type="submit"
              v-if="this.editId==null"
              class="btn btn-block btn-success"
              value="Crear Área"
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
  </div>
</template>
<script>
export default {
  props: ["editId"],
  data() {
    return {
      name: "",
      array: []
    };
  },
  mounted() {
    if (this.editId != null) {
      axios.get(`/areas/${this.editId}`).then(response => {
        this.name = response.data.name;
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
      const params = {
        name: this.name
      };
      if (this.editId == null) {
        axios
          .post("/areas", params)
          .then(response => {
            if (response.data == 1) {
              this.$emit("new");
              this.name = "";
              this.showSuccessNotification(
                "Agregar Area",
                "El area ha sido agregada"
              );
            } else {
              this.showErrorNotification(
                "Error Agregando",
                "Conexion invalida"
              );
            }
          })
          .catch(error => {
            this.showErrorNotification("Error Agregando", "Conexion invalida");
          });
      } else {
        axios
          .put(`/areas/${this.editId}`, params)
          .then(response => {
            this.$emit("new");
            this.showSuccessNotification(
              "Editar Area",
              "El area ha sido editada"
            );
          })
          .catch(error => {
            this.showErrorNotification("Error Editando", "Conexion invalida");
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
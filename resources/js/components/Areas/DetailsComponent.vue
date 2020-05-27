<template>
  <div class="card justify-content-center text-center">
    <div class="card-header bgH">
      <h3>Detalles Del Área</h3>
    </div>
    <div class="card-body">
      <div class="form-group row m-4">
        <label for="em" class="col-sm-3 col-form-label">Nombre:</label>
        <div class="col-sm-9 mt-2">
          <label name="em" class="lbl">{{showId.name}}</label>
        </div>
      </div>
      <div class="col-sm-10 col-lg-5 m-auto pb-2">
        <input type="button" value="Regresar" class="btn btn-block btn-primary" @click="ret()" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["detailsId"],
  data() {
    return {
      showId: []
    };
  },
  mounted() {
    axios.get(`/areas/${this.detailsId}`).then(response => {
      this.showId = response.data;
    });
  },
  methods: {
    ret() {
      this.$emit("returnedA");
    }
  }
};
</script>
<style scoped>
.bgH {
  background-color: #5db7ce;
}
.lbl {
  border: 0;
  outline: 0;
  width: 100%;
  border-bottom: 1px solid black;
}
</style>
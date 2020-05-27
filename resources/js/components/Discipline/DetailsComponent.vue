<template>
  <div class="card justify-content-center text-center">
    <div class="card-header bgH">
      <h3>Detalles De la Disciplina</h3>
    </div>
    <div class="card-body">
      <div v-if="this.m">
        <div class="form-group row m-4">
          <label for="em" class="col-sm-3 col-form-label">Nombre:</label>
          <div class="col-sm-9 mt-2">
            <label name="em" class="lbl">{{showId.name}}</label>
          </div>
        </div>
        <div class="form-group row m-4">
          <label for="em2" class="col-sm-3 col-form-label">Área:</label>
          <div class="col-sm-9 mt-2">
            <label name="em2" class="lbl">{{showId.area.name}}</label>
          </div>
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
      showId: [],
      m:false
    };
  },
  mounted() {
    axios.get(`/disciplinas/${this.detailsId}`).then(response => {
      this.showId = response.data;
      console.log(this.showId);
      this.m=true;
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
.lbl {
  border: 0;
  outline: 0;
  width: 100%;
  border-bottom: 1px solid black;
}
.bgH {
  background-color: #5db7ce;
}
</style>
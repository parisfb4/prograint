<template>
  <div class="card">
    <div class="card-header bgH">
      <h2>
        <center>Información del Usuario</center>
      </h2>
    </div>
    <div class="card-body">
      <div class="mb-5 pt-5 text-center">
        <img id="pic" height="200px" class="m-4 rounded" />
        <h4 class="text-uppercase">Datos Personales</h4>
        <hr class="solid" />
      </div>
      <div class="row m-3">
        <label for="id" class="col-sm-3 ">Código:</label>
        <div class="col-sm-9">
          <label name="id" class="lbl">{{showId.code}}</label>
        </div>
      </div>
      <div class="form-group row m-3">
        <label for="name" class="col-sm-3 col-form-label">Nombre:</label>
        <div class="col-sm-9">
          <label name="name" class="lbl">{{showId.username}}</label>
        </div>
      </div>
      <div class="form-group row m-3">
        <label for="em" class="col-sm-3 col-form-label">Correo electrónico:</label>
        <div class="col-sm-9 mt-2">
          <label name="em" class="lbl">{{showId.email}}</label>
        </div>
      </div>
      <div class="form-group row m-3">
        <label  class="col-sm-3 ">Télefono:</label>
        <div class="col-sm-9 mt-3">
          <label name="tel" class="lbl">{{showId.phone}}</label>
        </div>
      </div>
      <div class="form-group row m-3">
        <label for="act" class="col-sm-3 col-form-label">Estatus:</label>
        <div class="col-sm-9">
          <label name="act" class="lbl">{{showId.active==1?'Activo':'Inactivo'}}</label>
        </div>
      </div>
      <div v-if="showPay">
        <div class="mb-4 text-center">
          <h4 class="text-uppercase">Pagos</h4>
          <hr class="solid" />
        </div>
        <div>
          <table
            class="table table-striped table-bordered table-sm table-hover text-center"
            cellspacing="0"
            width="100%"
          >
            <thead>
              <tr>
                <th @click="sort(1)" style="background-color: #A0D3E1">
                  <center>Referencia</center>
                </th>
                <th @click="sort(2)" style="background-color: #A0D3E1">
                  <center>Comentarios</center>
                </th>
                <th @click="sort(3)" style="background-color: #A0D3E1">
                  <center>Última Fecha</center>
                </th>
                <th style="background-color: #A0D3E1">
                  <center>Acciones</center>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="props in data" v-bind:key="props.id">
                <td>{{ props.reference }}</td>

                <td label="Usuario">{{ props.comments}}</td>

                <td>{{new Date(props.updated_at).toLocaleDateString()}}</td>
                <td>
                  <button @click="details(props.id)" class="btn btn-info">Detalles</button>
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
            <button
              class="btn btn-default"
              @click="Prev()"
              :disabled="this.actual<=this.min"
            >Anterior</button>
            <span>Página {{this.actual+1}} de {{this.max}}</span>
            <button
              class="btn btn-default"
              @click="Next()"
              :disabled="this.actual+1>=this.max"
            >Siguiente</button>
          </div>
          <!--Condonations Table-->
        </div>
        <div class="mb-4"></div>
        <div class="mb-4 text-center">
          <h4 class="text-uppercase">Condonaciones</h4>
          <hr class="solid" />
        </div>
        <table
          class="table table-striped table-bordered table-sm table-hover text-center"
          cellspacing="0"
          width="100%"
        >
          <thead>
            <tr>
              <th @click="sortC(1)" style="background-color: #A0D3E1">
                <center>Comentarios</center>
              </th>
              <th @click="sortC(2)" style="background-color: #A0D3E1">
                <center>Última Fecha</center>
              </th>
              <th style="background-color: #A0D3E1">
                <center>Acciones</center>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="propsC in dataC" v-bind:key="propsC.id">
              <td label="Usuario">{{ propsC.comments}}</td>

              <td>{{new Date(propsC.updated_at).toLocaleDateString()}}</td>
              <td>
                <button @click="detailsC(propsC.id)" class="btn btn-info">Detalles</button>
              </td>
            </tr>
            <tr v-if="dataC.length==0" height="50">
              <td colspan="4">
                <center>Sin resultados</center>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <button
            class="btn btn-default"
            @click="PrevC()"
            :disabled="this.actualC<=this.minC"
          >Anterior</button>
          <span>Página {{this.actualC+1}} de {{this.maxC}}</span>
          <button
            class="btn btn-default"
            @click="NextC()"
            :disabled="this.actualC+1>=this.maxC"
          >Siguiente</button>
        </div>
      </div>
    </div>
    <div class="col-sm-10 col-lg-5 m-auto pb-2">
      <input type="button" value="Regresar" class="btn btn-block btn-primary" @click="ret()" />
    </div>
  </div>
</template>
<script>
export default {
  props: ["detailsId", "showPay"],
  data() {
    return {
      showId: [],
      data: [],
      search: "",
      asc: true,
      min: 0,
      actual: 0,
      max: 0,
      pagesize: 5,
      aux: [],
      condonationsTable: [],
      dataC: [],
      searchC: "",
      ascC: true,
      minC: 0,
      actualC: 0,
      maxC: 0,
      pagesizeC: 5,
      auxC: []
    };
  },
  mounted() {
    axios.get(`/usuarioscdu/${this.detailsId}`).then(response => {
      this.showId = response.data;
      this.data = this.showId.payments;
      this.dataC = this.showId.condonations;
      this.aux = this.data;
      this.auxC = this.dataC;
      this.max = Math.ceil(this.data.length / 5.0);
      this.maxC = Math.ceil(this.dataC.length / 5.0);
      this.actual = 0;
      this.actualC = 0;
      this.Prev();
      this.PrevC();
      if (this.showId.pic == null) {
        document.getElementById("pic").src = "/storage/invalidPhoto.jpg";
      } else document.getElementById("pic").src = "/storage/" + this.showId.pic;
    });
  },
  methods: {
    ret() {
      this.$emit("returnedA");
    },
    searchButton() {},
    sort($op) {
      if ($op == 1) {
        if (this.asc) {
          this.aux.sort((a, b) =>
            a.reference < b.reference ? -1 : Number(a.reference > b.reference)
          );
          this.asc = false;
        } else {
          this.aux.sort((a, b) =>
            a.id > b.id ? -1 : Number(a.reference < b.reference)
          );
          this.asc = true;
        }
      } else if ($op == 2) {
        if (this.asc) {
          this.aux.sort((a, b) =>
            a.comments < b.comments ? -1 : Number(a.comments > b.comments)
          );
          this.asc = false;
        } else {
          this.aux.sort((a, b) =>
            a.comments > b.comments ? -1 : Number(a.comments < b.comments)
          );
          this.asc = true;
        }
      } else {
        if (this.asc) {
          this.aux.sort(function(a, b) {
            return new Date(b.updated_at) - new Date(a.updated_at);
          });
          this.asc = false;
        } else {
          this.aux.sort(function(a, b) {
            return new Date(a.updated_at) - new Date(b.updated_at);
          });
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
    searchCButton() {},
    sortC($op) {
      if ($op == 1) {
        if (this.ascC) {
          this.auxC.sort((a, b) =>
            a.comments < b.comments ? -1 : Number(a.comments > b.comments)
          );
          this.ascC = false;
        } else {
          this.auxC.sort((a, b) =>
            a.comments > b.comments ? -1 : Number(a.comments < b.comments)
          );
          this.ascC = true;
        }
      } else {
        if (this.ascC) {
          this.auxC.sort(function(a, b) {
            return new Date(b.updated_at) - new Date(a.updated_at);
          });
          this.ascC = false;
        } else {
          this.auxC.sort(function(a, b) {
            return new Date(a.updated_at) - new Date(b.updated_at);
          });
          this.ascC = true;
        }
      }
      this.actualC = 0;
      this.PrevC();
    },
    PrevC() {
      if (this.actualC > 0) this.actualC--;
      this.updateC();
    },
    NextC() {
      if (this.auxC.length > this.actualC * this.pagesizeC + this.pagesizeC)
        this.actualC++;
      this.updateC();
    },
    updateC() {
      if (this.actualC >= this.maxC) this.actualC--;
      this.dataC = this.auxC.slice(
        this.actualC * this.pagesizeC,
        this.actualC * this.pagesizeC + this.pagesizeC
      );
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
.table-striped > tbody > tr:nth-child(2n + 1) > td,
.table-striped > tbody > tr:nth-child(2n + 1) > th {
  background-color: #effbf5;
}
.bgH {
  background-color: #5db7ce;
}
</style>
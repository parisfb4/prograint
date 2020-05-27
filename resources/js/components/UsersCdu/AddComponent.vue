<template>
  <div class="card justify-content-center text-center">
    <div v-if="this.editId==null" class="card-header bgH">
      <h3>Crear un nuevo Usuario</h3>
    </div>
    <div v-else class="card-header bgH">
      <h3>Editar Usuario</h3>
    </div>
    <div class="card-body">
      <div
        class="mw-50 col-md-10 col-lg-5 offset-md-2 rounded uploader m-auto"
        @dragenter="OnDragEnter"
        @dragleave="OnDragLeave"
        @dragover.prevent
        @drop="onDrop"
        :class="{dragging: isDragging}"
      >
        <div class="row text-center">
          <div class="col-md-12 col-lg-12">
            <button @click="this.popUp" class="btn btn-primary btn-block">Cámara</button>
          </div>
          <div class="col-md-12 col-lg-12">
            <input
              type="file"
              id="file"
              enctype="multipart/form-data"
              class="btn btn-info btn-block"
              @change="onInputChange"
            />
          </div>
        </div>
        <div class="col-md-12 col-lg-12 text-center">
          <h4>Suelta tu imagen aquí</h4>
        </div>
        <div class="col-md-12 col-lg-12 text-center">
          <img
            enctype="multipart/form-data"
            class="img-rounded"
            id="pic"
            height="200px"
            width="100%"
          />
        </div>
        <div class="row text-center">
          <div class="col-md-12 col-lg-12">
            <button id="deleteImg" @click="this.deleteImg" class="btn btn-danger btn-block">Eliminar</button>
          </div>
        </div>
      </div>
      <div class="mb-4 pt-5">
        <h4 class="text-uppercase">Datos Personales</h4>
        <hr class="solid" />
      </div>
      <form method="POST" v-on:submit.prevent="newBlog()">
        <div class="form-group row">
          <label
            for="id"
            v-if="this.incorrecto"
            class="col-sm-2 col-form-label text-danger"
          >Código: El código ya ha sido utilizado</label>
          <label for="id" v-else class="col-sm-2 col-form-label">Código:</label>
          <div class="col-sm-10">
            <input
              type="number"
              name="id"
              v-model="id"
              class="form-control"
              v-on:keyup="validar"
              placeholder="Ingrese el Código del Estudiante"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label">Nombre</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="username"
              v-model="username"
              class="form-control"
              placeholder="Ingrese Nombre"
              required
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input
              type="email"
              name="email"
              v-model="email"
              class="form-control"
              placeholder="Ingrese Correo electrónico"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">Teléfono</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="phone"
              v-model="phone"
              class="form-control"
              placeholder="Ingrese Teléfono"
            />
          </div>
        </div>
        <div class="pt-5 row text-center offset-md-2 m-auto">
          <div class="col-sm-10 col-lg-5 m-auto pb-2">
            <input
              type="submit"
              v-if="this.editId==null"
              class="btn btn-block btn-success"
              value="Crear Usuario"
              :disabled="this.incorrecto"
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
      username: "",
      id: "",
      email: "",
      phone: "",
      incorrecto: false,
      array: [],
      isDragging: false,
      dragCount: 0,
      images: []
    };
  },
  mounted() {
    document.getElementById("deleteImg").style.visibility = "hidden";

    if (this.editId != null) {
      axios.get(`/usuarioscdu/${this.editId}`).then(response => {
        this.username = response.data.username;
        this.array=response.data;
        this.id = response.data.code;
        this.email = response.data.email;
        this.phone = response.data.phone;
        this.showId = response.data;
        if (this.showId.pic != null) {
          document.getElementById("deleteImg").style.visibility = "visible";

          document.getElementById("pic").style.visibility == "visible";
          document.getElementById("pic").src = "storage/" + this.showId.pic;
        }
      });
    } else {
      axios.get("/usuarioscdu").then(res => {
        this.array = res.data;
        console.log(this.array);
      });
    }
  },
  methods: {
    newBlog() {
      const params = new FormData();
      let img = document.getElementById("pic");
      if (document.getElementById("deleteImg").style.visibility === "visible") {
        console.log("imagenEnviada");
        let canvas = document.createElement("canvas");
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        let context = canvas.getContext("2d");
        context.drawImage(img, 0, 0);
        var url = canvas.toDataURL();
        var blobBin = atob(url.split(",")[1]);
        var array = [];
        for (var i = 0; i < blobBin.length; i++) {
          array.push(blobBin.charCodeAt(i));
        }

        var file2 = new Blob([new Uint8Array(array)], { type: "image/png" });
        params.append("imagen", file2);
      } else if (this.editId != null) {
        params.append("deleteImage", this.array.id);
      }
      if (this.editId == null) {
        params.append("username", this.username);
        params.append("id", this.id);
        params.append("email", this.email);
        params.append("phone", this.phone);
        axios
          .post("/usuarioscdu", params)
          .then(response => {
            if (response.data == 1) {
              this.$emit("new");
              this.username = "";
              this.id = "";
              this.email = "";
              this.phone = "";
              document.getElementById("deleteImg").style.visibility = "hidden";
              this.showSuccessNotification("Agregando", "Guardado Exitoso");
            } else {
              this.showErrorNotification(
                "Error Agregando",
                "Error guardando datos"
              );
            }
          })
          .catch(error => {
            this.showErrorNotification(
              "Error Agregando",
              "Error el tamaño de la imagen supera 1MB"
            );
          });
      } else {
        var datos = {
          username: this.username,
          code: this.id,
          email: this.email,
          phone: this.phone
        };
        axios
          .put(`/usuarioscdu/${this.editId}`, datos)
          .then(response => {
            console.log(response.data);
            this.showSuccessNotification(
              "Editando",
              "Datos de Texto Guardados"
            );
          })
          .catch(error => {
            this.showErrorNotification(
              "Editando",
              "Error la imagen es mayor a 1MB"
            );
          });
        if (document.getElementById("deleteImg").style.visibility === "visible") {
          console.log(this.array.id);
          params.append("editImage", this.array.id);
          console.log("updating pic");
          axios
            .post("/usuarioscdu", params)
            .then(response => {
              console.log(response);
              this.showSuccessNotification(
                "Editando",
                "Imagen Guardada Correctamente"
              );
            })
            .catch(error => {
              this.showErrorNotification(
                "Error Editando",
                "Error la imagen es mayor a 1MB"
              );
            });
        } else {
          axios.post("/usuarioscdu", params).then(response => {
            console.log(response);
          });
        }
      }
    },
    returnE() {
      this.$emit("new");
      this.username = "";
      this.email = "";
      this.phone = "";
    },
    validar() {
      // if (this.array.findIndex(aux => aux.code!=null?aux.code.toString() === this.id> -1:false)) {
      //   this.incorrecto = true;
      // } else {
      //   this.incorrecto = false;
      // }
    },
    OnDragEnter(e) {
      e.preventDefault();
      this.dragCount++;
      this.isDragging = true;
    },
    OnDragLeave(e) {
      e.preventDefault();
      this.dragCount--;
      if (this.dragCount <= 0) {
        this.isDragging = false;
      }
    },
    onDrop(e) {
      console.log(e);
      e.preventDefault();
      e.stopPropagation();
      this.dragCount = 0;
      this.isDragging = false;
      const files = e.dataTransfer.files;
      Array.from(files).forEach(file => this.addImage(file));
      console.log(files);
    },
    onchange(e) {
      console.log(e);
    },
    onInputChange(e) {
      const files = e.target.files;
      console.log(files);
      Array.from(files).forEach(file => this.addImage(file));
    },
    addImage(file) {
      if (!file.type.match("image.*")) {
        console.log(`${file.name} no es una imagen`);
        this.MessageError("Añadir Imagen", "No es una imagen");
        return;
      }
      document.getElementById("deleteImg").style.visibility = "visible";
      var im = document.getElementById("pic");
      document.getElementById("pic").style.visibility = "visible";
      const img = new Image(),
        reader = new FileReader();
      reader.onload = e => (im.src = e.target.result);
      reader.readAsDataURL(file);
    },
    popUp() {
      var win = window.open(
        "",
        "wildebeast",
        "width=600,height=600,scrollbars=1,resizable=1"
      );
      var html = "<!DOCTYPE html><html><body>";
      html +=
        "<video id='video2' >Tu navegador no soporta este tipo de procedimiento</video>";
      html += "<canvas id='canvas'></canvas>";
      html +=
        " <div id='showB'><button class='btn btn-success' onclick='saveP()'>Guardar Imagen</button><input class='btn btn-primary'id='taking'onclick='tem()' type='button' value='Tomar Foto'/></div>";
      html += "</body>";
      html += "<script type='text/javascript'>";
      html +=
        "(function() {document.getElementById('showB').style.visibility='hidden';snap();})();";
      html +=
        "function snap() {try{navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMediat ||navigator.msGetUserMedia || navigator.oGetUserMedia || navigator.mGetUserMedia;if (navigator.getUserMedia) { navigator.getUserMedia({ video: true }, this.streamWebCam, this.throwError);}}catch(error){alert('Tu dispositivo no soporta esta funcionalidad');}} ";
      html += "function streamWebCam(stream) {if(stream==null)alert('error');";
      html += "var w = window.innerWidth";
      html += "|| document.documentElement.clientWidth";
      html += "|| document.body.clientWidth;";

      html += "var h = window.innerHeight";
      html += "|| document.documentElement.clientHeight";
      html +=
        "|| document.body.clientHeight;h-=30;var canvas=document.getElementById('canvas');var video = document.getElementById('video2'); video.width=w;video.height=h;video.src = window.URL.createObjectURL(stream);video.play();canvas.style.display='none';video.style.display='initial'; ";
      html +=
        "document.getElementById('taking').value='Tomar Imagen';document.getElementById('showB').style.visibility='visible';}";
      html +=
        "function throwError(e) {try{var video = document.getElementById('video2');video.src = window.URL.createObjectURL(stream); }catch(error){alert('Tu dispositivo no soporta esta funcion');}} ";
      html +=
        "function tem(){var video = document.getElementById('video2');if(document.getElementById('canvas').style.display==='initial'){document.getElementById('taking').value='Tomar Imagen';document.getElementById('canvas').style.display='none';video.play();video.style.display='initial';}else{document.getElementById('taking').value='Iniciar la cámara'; canvas.style.display='initial';take();}}";
      html +=
        "function saveP(){var canvas=document.getElementById('canvas');var img = canvas.toDataURL();var d=window.opener.document.getElementById('pic');if(document.getElementById('taking').value==='Tomar Imagen'){}else{d.src=img;d.style.height='200px';window.opener.document.getElementById('deleteImg').style.visibility='visible';}window.close();}";
      html +=
        "function take() {var canvas=document.getElementById('canvas');var video = document.getElementById('video2'); var video = document.getElementById('video2');canvas.style.display='initial'; canvas.width=video.offsetWidth;canvas.height=video.offsetHeight;var context = canvas.getContext('2d'); context.drawImage(video, 0, 0,video.width,video.height); video.style.display='none';video.pause(); } ";
      html += "</sc" + "ript > </html >";
      //variable name of window must be included for all three of the following methods so that
      //javascript knows not to write the string to this window, but instead to the new windo
      //window.opener.dataPopUp('hola');
      win.document.open();
      win.document.write(html);
      win.focus();
      //win.document.close()
    },
    deleteImg() {
      document.getElementById("deleteImg").style.visibility = "hidden";
      document.getElementById("pic").style.visibility = "hidden";
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
<style lang="scss" scoped>
.uploader {
  border: 3px dashed #fff;
  background-color: #a0d3e1;
}

.dragging {
  background: #fff;
  color: #2196f3;
}

.images-preview {
  display: flex;
  flex-wrap: wrap;
  margin-top: 20px;
}

.bgH {
  background-color: #5db7ce;
}

.center-block {
  width: 250px;
  padding: 10px;
  background-color: #eceadc;
  color: #ec8007;
}

.name {
  overflow: hidden;
  height: 18px;
}
</style>
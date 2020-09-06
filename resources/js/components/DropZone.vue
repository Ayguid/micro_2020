<template>
  <div class="container">
    <div class="row justify-content-center">


      <form id="dropZone" action="/file-upload" class="dropzone" method="post">
        <!-- <input v-if="data !=null" type="text" name="product_id" :value="data.product.id" hidden> -->

        <input v-if="data.product !=null" type="text" name="product_id" :value="data.product.id" hidden>
        <input v-if="data.category !=null" type="text" name="category_id" :value="data.category.id" hidden>
        <div class="fallback">
          <input name="file" type="file" multiple />
          <!-- <input name="file" type="file" multiple /> -->
        </div>
      </form>


    </div>
  </div>
</template>






<script>

import DropZone from 'dropzone'

const urlMain = window.axios.defaults.baseURL;


export default {
  props: ['data'],
  data(){
    return  {

    }
  },
  methods:{

  },

  mounted() {
    const data = this.data;

    DropZone.options.dropZone = {
      url:urlMain+'/api/files/upload',
      method: 'POST',
      paramName: "file", // The name that will be used to transfer the file
      maxFilesize: 80, // MB
      addRemoveLinks: true,
      dictRemoveFileConfirmation:'Are you sure you want to delete this file?',
      timeout:300000,
      accept: function(file, done) {
        var myRe = /[\xD1\xD8\xF1\xF8]/;
        if (myRe.exec(file.name)) {
          done('[Ø-ø, Ñ] Caracteres especiales no permitidos');
        }
        else {
          done();
        }
      },
      init: function() {
        this.on("removedfile", function(file) {
          var formData=null;
          formData = new FormData();
          if (data.product) {
            formData.append('product_id',data.product.id);
          }
          if (data.category) {
            formData.append('category_id',data.category.id);
          }
          axios.post(urlMain+'/api/files/destroy/'+file.name, formData).then((response) => {
            console.log(response);
          });
        });

        // this.on("drop", function(file) {
        //
        //   // var formData = new FormData();
        //   // formData.append('product_id',data.product.id);
        //   // axios.post(urlMain+'/api/files/upload/', formData).then((response) => {
        //   //   console.log(response);
        //   // });
        // });


        if (data.product) {
          for (var i = 0; i < data.productFiles.length; i++) {
            var extension = data.productFiles[i].file_path.split('.').pop();
            var mockFile = {
              name: data.productFiles[i].file_path,
            };
            this.emit("addedfile", mockFile);
            switch (extension) {
              case 'png':
              case 'jpg':
              this.emit("thumbnail", mockFile, urlMain+'/storage/product_images/'+data.productFiles[i].file_path);
              break;
              case 'pdf':
              this.emit("thumbnail", mockFile, urlMain+'/images/pdf_logo.png');
              break;
              default:
            }
            this.emit("complete", mockFile);
          }
          // this.on("addedfile", function(file) {
          //
          // });
        }

        // this.on("success", function(file, response) { console.log(response); });
        if (data.category) {
          if (!!data.categoryFiles[0]) {
            for (var i = 0; i < data.categoryFiles.length; i++) {
              var extension = data.categoryFiles[i].split('.').pop();
              var mockFile = {
                name: data.categoryFiles[i],
              };
              this.emit("addedfile", mockFile);
              switch (extension) {
                case 'png':
                case 'jpg':
                this.emit("thumbnail", mockFile, urlMain+'/storage/categories/'+data.categoryFiles[i]);
                break;
                default:
              }
              this.emit("complete", mockFile);
            }
          }
        }



      }
    };

  }


}


</script>

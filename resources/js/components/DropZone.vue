<template>
  <div class="container">
    <div class="row justify-content-center">


      <form id="dropZone" action="/file-upload" class="dropzone" method="post">
        <input v-if="data !=null" type="text" name="product_id" :value="data.product.id" hidden>
        <div class="fallback">
          <input name="file" type="file" multiple />
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
      init: function() {
        this.on("removedfile", function(file) {
          var formData=null;
          if (data) {
            formData = new FormData();
            formData.append('product_id',data.product.id);
          }
          axios.post(urlMain+'/api/files/destroy/'+file.name, formData).then((response) => {
            console.log(response);
          });
        });

        // this.on("drop", function(file) {
        //   var formData = new FormData();
        //   formData.append('product_id',data.product.id);
        //   axios.post(urlMain+'/api/files/upload/', formData).then((response) => {
        //     console.log(response);
        //   });
        // });


        if (data) {
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
      }
    };

  }


}


</script>

<template>
  <div class="">


<!-- {{data}} -->
    <form class="" action="index.html" method="post" @submit="sendMail">
    <!-- <form class="" action="./send-mail" method="get"> -->
      <p>{{$t(this.title)}}</p>

    <div class="row">
        <div class="col-6">
          <input type="text" name="to" :value="this.to" hidden>
          <div class="" v-if="this.product">

          <input  type="text" name="product" :value="JSON.stringify(this.product)" hidden>
          <h5>Product Title</h5>
          <p>{{this.product.title_es}}</p>
          <h5>Product Code</h5>
          <p>
            {{this.product.product_code}}
          </p>
        </div>
          <div class="form-group">
            <label for="email">User Email</label><br>
            <input id="user_email" type="email" name="from" :value="user?user.email:''">
          </div>
        </div>
        <div v-if="this.product" class="col-6">
          <div v-if="images.length>0"  class="">
            <img v-for="image in images" :src="$root.baseUrl+'/storage/product_images/'+image.file_path" alt="" width="100%">
          </div>
          <div v-else>
            <img :src="$root.baseUrl+'/images/default.jpeg'" alt="" width="100%">
          </div>
        </div>

      </div>

      <div class="form-group">
        <label for="email">{{$t('Consultas adicionales')}}</label><br>
        <textarea name="textArea" rows="6" ></textarea>
      </div>
      <input type="submit" class="btn btn-primary" name="Enviar" value="Enviar" >



    </form>







    <div class="vld-parent">
      <loading :active.sync="isLoading"
      :can-cancel="false"
      :on-cancel="onCancel"
      :is-full-page="fullPage"></loading>
    </div>

  </div>
</template>
<style media="screen">

textarea
{
  border:1px solid #999999;
  width:100%;
  margin:5px 0;
  padding:3px;
}

</style>

<script>

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';


export default {
  props: ['product', 'to', 'images', 'title', 'modal'],
  data(){
    return  {
      contactUrl:'/send-mail',
      isLoading: false,
      fullPage: true,
      user:this.$root.authuser
    }
  },
  components: {
    Loading
  },
  methods:{
    sendMail:function(event){
      event.preventDefault();
      var formData = new FormData(event.target);
      this.isLoading = true;
      axios.post(this.contactUrl,formData).then((response) => {
        console.log(response);
        this.isLoading = false;
        if (response.data.status == "error") {
          this.$swal({
            type: 'warning',
            title: 'Hubo un error',
            text: JSON.stringify(response.data.errors)
          });
        }
        if (response.data.status == "ok") {
          this.$swal(response.data.message);
          this.$bvModal.hide(this.modal);
        }
      });

    },

    onCancel: function() {
      console.log('User cancelled the loader.')
    }
  },
  mounted() {
    // console.log(this.images.length);
  }
}
</script>

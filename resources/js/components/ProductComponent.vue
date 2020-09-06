<template>

  <div class="">

    <transition name="fade"appear >
      <div class="card mb-4">
        <!-- <a v-if="$root.authadmin" :href="admin_route_view">EDITAR</a> -->
        <h6 v-if="product.category" class="p-2"><span>{{ $t("Categoria") }}:</span>
          <a :href="cat_route">
          <!-- {{product.category.title_es}} -->
          {{(product.category['title_'+$root.local])?product.category['title_'+$root.local]:product.category['title_es']}}
        </a>
      </h6>
         <a :href="product_route_view">

        <div class="card-header">{{(product['title_'+$root.local])?product['title_'+$root.local]:product['title_es']}}</div>
      </a>
        <div class="card-body p-0">
       <a :href="product_route_view">
        <div class="">
          <!-- <img v-if="$fileExists($root.baseUrl+'/storage/product_images/'+image.file_path)" v-for="image in files['images']" width="100%"  :src="$root.baseUrl+'/storage/product_images/'+image.file_path" alt=""> -->
          <img v-if="files['images'].length > 0 " v-for="image in files['images']" width="100%"  :src="$root.baseUrl+'/storage/product_images/'+image.file_path" alt="">
          <img v-else width="100%" :src="$root.baseUrl+'/images/default.jpeg'" alt="">
        </div>
        <!-- <div v-else class="">
        </div> -->
      </a>
      <div class="p-2">
      <h6 >{{$t('Código')}} :{{product.product_code}}</h6>

        <div class="">
          <!-- <img v-if="$fileExists($root.baseUrl+'/storage/product_images/'+files['dxfs'][0])"  width="15%" :src="$root.baseUrl+'/icons/pdf_logo.svg'" alt=""> -->
          <img v-if=" files['pdfs'].length > 0 "    width="15%" :src="$root.baseUrl+'/icons/pdf_logo.svg'" alt="">
          <img v-if=" files['dxfs'].length > 0 " width="15%" :src="$root.baseUrl+'/icons/cad_logo.svg'" alt="">
          <img v-if=" files['zips'].length > 0 "    width="15%" :src="$root.baseUrl+'/icons/zip_logo.svg'" alt="">
        </div>

        <div class="p-2">
          <div v-for="att in product.attributes" v-if="att.attribute.filterable"  class="">
            <!-- <h6>  <strong> {{(att.attribute['name_'+$root.local])?att.attribute['name_'+$root.local]:att.attribute['name_es']}}</strong>  </h6> -->
            <h6> <strong> {{$t(att.attribute.name_es)}} </strong>  </h6>
            <!-- <h6>{{(att['value_'+$root.local])?att['value_'+$root.local]:att['value_es']}}</h6> -->
            <h6>{{$t(att.value_es)}}</h6>
          </div>
        </div>
      </div>
      </div>

      </div>
    </transition>

  </div>

</template>
<script>

export default {
  props:['product', 'product_route_view', 'admin_route_view', 'cat_route'],
  data(){
    return  {
      files:this.$sortFilesByType(this.product.files)
    }
  },
  components: {},
  methods: {
    // emitProduct:function(){
    //   this.$emit('product-emit');
    // },
    // imageExists : function (image_url){
    // var http = new XMLHttpRequest();
    // http.open('HEAD', image_url, false);
    // http.send();
    // console.log(http.status);
    // return http.status != 404;
    // }
  },

  mounted() {
    //console.log(this.files);
  }

}
</script>

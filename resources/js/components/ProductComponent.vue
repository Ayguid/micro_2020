<template>

  <div class="">

    <transition name="fade"appear >
      <div class="card mb-4" @click="emitProduct">
        <a v-if="$root.authadmin" :href="admin_route_view">EDITAR</a>

         <h6 v-if="product.category" class="p-2"><span>Categoria: </span> <a :href="cat_route">{{product.category.title_es}}</a> </h6>

         <a :href="user_route_view">

        <div class="card-header">{{(product['title_'+$root.local])?product['title_'+$root.local]:product['title_es']}}</div>
      </a>
        <div class="card-body p-0">
       <a :href="$root.baseUrl+'/showProduct/'+product.id">
        <div v-if="product.has_image" class="">
          <img v-for="image in images" width="100%"  :src="$root.baseUrl+'/storage/product_images/'+image.file_path" alt="">
        </div>
        <div v-else class="">
          <img  width="100%" :src="$root.baseUrl+'/images/default.jpeg'" alt="">
        </div>
      </a>
      <div class="p-2">
      <h6 >Code:   {{product.product_code}}</h6>

        <div class="">
          <img v-if="product.has_pdf"    width="15%" :src="$root.baseUrl+'/icons/pdf_logo.svg'" alt="">
          <img v-if="product.has_cad_2d" width="15%" :src="$root.baseUrl+'/icons/cad_logo.svg'" alt="">
          <img v-if="product.has_zip"    width="15%" :src="$root.baseUrl+'/icons/zip_logo.svg'" alt="">
        </div>

        <div class="p-2">
          <div v-for="att in product.attributes" v-if="att.attribute.filterable"  class="">
            <h6>  <strong> {{(att.attribute['name_'+$root.local])?att.attribute['name_'+$root.local]:att.attribute['name_es']}}</strong>  </h6>
            <h6>{{$t(att.value)}}</h6>
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
  props:['product', 'user_route_view', 'admin_route_view', 'cat_route'],
  data(){
    return  {
      images:this.$sortFilesByType(this.product.files).images
    }
  },
  components: {},
  methods: {
    emitProduct:function(){
      this.$emit('product-emit');
    }
  },

  mounted() {
  }

}
</script>

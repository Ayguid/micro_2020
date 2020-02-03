




<template>
  <div class="">
    <!-- <h1>{{ $t('Resultado') }}</h1> -->

    <p class="mt-2 mb-2">
      {{(category.get_top_categories['title_'+$root.local])?category.get_top_categories['title_'+$root.local]:category.get_top_categories['title_es']}} -->
      {{(category['title_'+$root.local])?category['title_'+$root.local]:category['title_es']}}</p>

      <p class="">Productos Encontrados : <span v-html="totalRows"></span> </p>

      <filter-menu @filter='filterProducts'
      :country="this.country"
      :category="this.category"
      :menudata="this.menuData"
      :filterAtts="this.filterAtts">
    </filter-menu>

    <div class="row">
      <product-component class="col-12 col-md-4 col-lg-3"  v-for="product in products"
      :product='product' :key='product.id'
      :product_route_view="product_route_view + product.id">
    </product-component>
  </div>

  <div class="" v-if="totalRows > perPage">
    <b-pagination
    @change="changePage"
    v-model="currentPage"
    align="center"
    limit="10"
    :total-rows="totalRows"
    :per-page="perPage"></b-pagination>
  </div>

  <div class="vld-parent">
    <loading :active.sync="isLoading"
    :can-cancel="false"
    :on-cancel="onCancel"
    :is-full-page="fullPage"></loading>
  </div>


  <div class="bottomright bottomrightExtra">
    <b-button v-b-modal.modal-1>Consultar por otros productos</b-button>
  </div>

  <b-modal id="modal-1" title="Micro" :hide-footer="true" >
    <contact-mail-form
    :modal="'modal-1'"
    :title="'Consultar por otros productos'"
    :images="''"
    :to="'Ingenieria'"
    :product="''"
    ></contact-mail-form>
  </b-modal>

</div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
// import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  props:['country', 'category'],
  data(){
    return  {
      products:{},
      perPage: 0,
      currentPage: 1,
      totalRows:'',
      filterAtts:'',
      menuData:'',
      isLoading: true,
      fullPage: true,
      currentProduct:'',
      product_route_view:this.$root.baseUrl + '/prod/',
    }
  },
  components: {
    Loading
  },
  methods:{
    fetchProducts:function(){
      this.isLoading = true;
      axios.get('api/getProducts',{
        params: {
          country: this.country.id,
          category: this.category.id,
          filterAtts: this.filterAtts
        }
      }).then((response) => {
        console.log(response);
          this.menuData=response.data.menuData;
          this.products = response.data.products.data;
          this.perPage = response.data.products.per_page;
          this.totalRows = response.data.products.total;
          this.isLoading = false;
      });
      // axios.get('api/getProducts/'+this.country.id+'/'+this.category.id+'/'+this.filterAtts+'/'+'?page='+this.currentPage).then((response) => {
      //   console.log(response);
      //   this.menuData=response.data.menuData;
      //   this.products = response.data.products.data;
      //   this.perPage = response.data.products.per_page;
      //   this.totalRows = response.data.products.total;
      //   this.isLoading = false;
      // });
    },
    changePage:function(value){
      this.currentPage=value;
      this.fetchProducts();
    },

    filterProducts:function(obj){
      this.currentPage=1;
      this.filterAtts=this.toJSONString(obj);
      this.fetchProducts();
    },
    toJSONString:function (form) {
      var obj ={} ;
      var elements = form.querySelectorAll( "input, select, textarea" );
      for( var i = 0; i < elements.length; ++i ) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;
        if( name ) {
          obj[ name ] = value;
        }
      }
      return JSON.stringify(obj);
    },
    onCancel: function() {
      console.log('User cancelled the loader.')
    },

  },
  created() {
    // console.log('Component has been created!');
  },
  mounted() {
    this.fetchProducts();
  }

}
</script>

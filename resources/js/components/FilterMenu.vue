<style scoped>
  option:disabled {
    background-color: rgba(108, 108, 108, 0.40);
  }
</style>


<template>
  <div class="row">
    <!-- {{menudata.attributes}} -->
    <!-- {{menudata}} -->
    <form id="filterForm" class="form-inline col-12 m-0 p-0" @change="emitFilterForm">

      <div v-for="att in menudata" class="mb-3 col-12 col-md-4 col-lg-3"  v-show="isAllDisabled(att.uniqueValues)" >
        <div class="input-group" >
          <div class="input-group-prepend">
            <label class="input-group-text " for="">
              {{ $t(att.name_es) }}
            </label>
          </div>
          <select class="custom-select" :name="att.id" >
            <option value="null" class="" >--</option>
            <option v-for="val in att.uniqueValues"  :value="val.value_es" class="" v-show="!val.disabled">
            <!-- <option v-for="val in att.uniqueValues"  :value="val.value_es" class="" :disabled="val.disabled"> -->


              {{ $t(val.value_es) }}



            </option>
          </select>
        </div>
      </div>
      <div class="mb-3 col-3">
        <div class="btn btn-secondary" @click="resetForm">{{ $t("Restablecer filtros") }}</div>
      </div>
    </form>


  </div>
</template>

<script>
export default {
  props:['country','menudata', 'filterAtts'],
  data(){
    return  {
      docuForm:''
    }
  },
  methods:{
    emitFilterForm:function(){
      this.$emit('filter', this.docuForm);
    },
    resetForm:function(){
      this.docuForm.reset();
      this.$emit('filter', this.docuForm);
    },
    isAllDisabled:function(uniqueValues){
      var count = 0;
      for (var i = 0; i < uniqueValues.length; i++) {
        (uniqueValues[i].disabled)?count++:'';
      }
      return ((count-uniqueValues.length)<0)?true:false;
    }

  },
  computed:{
    // response.data.menuData.attributes.sort(function (a) {
    //   return a.disabled // sort by date
    // })
  },

  mounted() {
    this.docuForm=this.$el.children.filterForm;
  }
}
</script>

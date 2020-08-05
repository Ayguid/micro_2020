<style scoped>
  option:disabled {
    background-color: rgba(108, 108, 108, 0.40);
  }
</style>


<template>
  <div class="row">
    <!-- {{menudata.attributes}} -->
    <!-- {{menudata.attributes}} -->
    <form id="filterForm" class="form-inline col-12 m-0 p-0" @change="emitFilterForm">
      <div v-for="catAtt in menudata.attributes" class="mb-3 col-12 col-md-4 col-lg-3" v-if="catAtt" v-show="isAllDisabled(catAtt.uniqueValues)" >
        <div class="input-group" >
          <div class="input-group-prepend">
            <label class="input-group-text " for="">
              {{$t(catAtt.name_es)}}
            </label>
          </div>
          <select class="custom-select" :name="catAtt.id" >
            <option value="null" class="" >--</option>
            <option v-for="catVal in catAtt.uniqueValues"  :value="catVal.value_es" class="" :disabled="catVal.disabled">


              {{ $t(catVal.value_es) }}



            </option>
          </select>
        </div>
      </div>
      <div class="mb-3 col-3">
        <div class="btn btn-secondary" @click="resetForm">Reset Filters</div>
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

  },

  mounted() {
    this.docuForm=this.$el.children.filterForm;
  }
}
</script>

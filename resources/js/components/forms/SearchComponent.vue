<template>
    <div class="">

      <form id="searchForm" :action="consulturl+'/'+query" method="get" class="form-inline my-2 my-lg-0" @submit="validateSearch">
        <input class="form-control mr-sm-2" type="search" placeholder="0.000.000-XXX" aria-label="search" name="query">
        <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Search</button>
      </form>

    </div>
</template>

<script>
    export default {
      props:['consulturl'],
      data(){
        return  {
          query:'',
        }
      },
      methods:{
        validateSearch:function(event){
          const obj=this;
          event.preventDefault();
          var form = this.$el.children[0];
          var qy = form.elements.query.value;
          if (qy) {
            this.query=qy;
            axios.get(this.consulturl+'/'+ qy)
            .then(function (response) {
              if (response.data=='Not found') {
                let originalBorder = form.elements.query.style.border;
                form.elements.query.style.border="1px solid rgb(251, 64, 64)";
                form.elements.query.value=obj.$t("No encontrado");
                setTimeout(function(){
                form.elements.query.style.border=originalBorder
                form.elements.query.value=qy;}, 1000);
              }
              else {
                form.submit();
              }
            })
            .catch(function (error) {
              // handle error
            })
            .finally(function () {
              // always executed
            });
          }
        },



      },
      mounted() {
        // console.log(this.$root.local);
      }
    }
</script>

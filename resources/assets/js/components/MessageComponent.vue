<template>
  <div class="row">
    <div class="container">
      <div class="alert col-auto" :class="alertColor" style="max-width:65%" role="alert">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: [
          'color',

        ],
        computed: {
          alertColor(){
            return 'alert-'+this.color;
          }
        },
        mounted() {
            
        }
    }
</script>

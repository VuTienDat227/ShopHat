<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <AdminSideBar/>
      </div>
      <div class="col py-3">
<router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import AdminSideBar from "@/components/AdminSideBar.vue";

export default {
  name: "admin.vue",
  components: {
    AdminSideBar
  }
}
</script>

<style scoped>

</style>
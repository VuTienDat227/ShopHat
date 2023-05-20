<template>
  <div class="wrapper">
    <NavBar/>
    <AdminSideBar/>
    <div class="content-wrapper">

      <div class="content">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import AdminSideBar from '@/components/AdminSideBar.vue';
import NavBar from "@/components/NavBar.vue";
import { useRoute } from 'vue-router';

export default {
  components: {
    AdminSideBar,
    NavBar
  },

  data(){
    return {
      currentRoute: {
        title: 'Trang chủ',
      },
    }
  },

  methods: {

  },
};
</script>

<style scoped>
.min-height-250.bg-primary.position-absolute.w-100 {
  min-height: 100px !important;
}
</style>

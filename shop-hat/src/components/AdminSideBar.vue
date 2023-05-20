<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img
          src="../assets/images/Nike.com-L-removebg-preview.png" class="brand-image img-circle elevation-3"
          style="opacity: .8"/>
      <span class="brand-text font-weight-light">Shop Hat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <RouterLink to="/admin" class="nav-link cursor-pointer" :class="{ 'active': currentRoute === '/admin' }">

              <i class="fa-solid fa-house-user"></i>
              <p>
                Trang chủ
              </p>

            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/admin/product" class="nav-link cursor-pointer"
                        :class="{ 'active': currentRoute === '/admin/product' }">

              <i class="fa-brands fa-product-hunt"></i>
              <p>
                Sản phẩm
              </p>

            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/admin/category" class="nav-link cursor-pointer"
                        :class="{ 'active': currentRoute === '/admin/category' }">

              <i class="fa-solid fa-dumpster-fire"></i>
              <p>
                Danh mục
              </p>

            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/admin/bill-info" class="nav-link cursor-pointer"
                        :class="{ 'active': currentRoute === '/admin/bill-info' }">

              <i class="fa-solid fa-cash-register"></i>
              <p>
                Hồ sơ thanh toán
              </p>

            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="#" class="nav-link cursor-pointer" v-on:click="logout()"
                        :class="{ 'active': currentRoute === '#' }">

              <i class="fa-solid fa-arrow-right-from-bracket"></i>
              <p>
                Đăng xuất
              </p>

            </RouterLink>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
import {RouterLink} from 'vue-router';
import axios from "@/axios";
import Product from "@/pages/admin/product.vue";
export default {
  name: "AdminSideBar",
  components: {Product, RouterLink},
  data() {
    return {
      currentRoute: null,

    };
  },
  created() {
    this.currentRoute = this.$route.path;
  },
  watch: {
    '$route'(to, from) {
      this.currentRoute = to.path;
    },

  },

  methods: {

    logout() {
      axios
          .post('/logout')
          .then((response) => {
            // Handle the response if needed
            console.log(response.data);
            localStorage.removeItem('RoleId');
            localStorage.removeItem('cart');
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('token');
            localStorage.removeItem('Id');
            this.$router.push({name: 'home'}).then(() => {
              window.location.reload();
            });
          })
          .catch((error) => {
            // Handle the error if needed
            console.error(error);
          });
    },
  }

}
</script>

<style scoped>
.text-span {
  font-size: 16px !important;
}
</style>
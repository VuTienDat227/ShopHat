<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
          <h2 class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Menu</span>
          </h2>
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
              <a href="#" class="nav-link align-middle px-0">
                <RouterLink to="/admin" class="nav-link px-0 align-middle" :class="{ 'active': currentRoute === '/admin' }" >
                  <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                </RouterLink>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link align-middle px-0">
                <RouterLink to="/admin/product" class="nav-link px-0" :class="{ 'active': currentRoute === '/admin/product' }">
                    <span class="d-none d-sm-inline" >
                      Product
                    </span>
                </RouterLink>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link align-middle px-0">
                <RouterLink to="/admin/category" class="nav-link px-0" :class="{ 'active': currentRoute === '/admin/category' }">

                     <span class="d-none d-sm-inline" >
                      Category
                    </span>
                </RouterLink>
              </a>
            </li>

            <RouterLink to="/admin/bill-info" class="nav-link px-0 align-middle" :class="{ 'active': currentRoute === '/admin/bill-info' }">
            <li>

                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Bill Info</span>
            </li>
            </RouterLink>
            <RouterLink to="#" class="nav-link px-0 align-middle" v-on:click="logout()" :class="{ 'active': currentRoute === '#' }">
              <li>

                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Sign out</span>
              </li>
            </RouterLink>
          </ul>
          <hr>
          <div class="dropdown pb-4">

            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="#">New project...</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" >Sign out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { RouterLink } from 'vue-router';
import axios from "@/axios";

export default {
  name: "AdminSideBar",
  components: { RouterLink },
  data() {
    return {
      currentRoute: null
    };
  },
  created() {
    this.currentRoute = this.$route.path;
  },
  watch: {
    '$route'(to, from) {
      this.currentRoute = to.path;
    }
  },
  methods:{
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
            this.$router.push({ name: 'home' }).then(() => {
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

<style scoped></style>
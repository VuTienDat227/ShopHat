<script setup>
import { RouterLink, RouterView } from 'vue-router';
import 'jquery/dist/jquery.slim.min.js';
import 'popper.js/dist/umd/popper.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';
</script>
<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white w-100 navigation" id="navbar">
    <div class="container">
      <RouterLink class="navbar-brand font-weight-bold" to="/">HATSTORE
      </RouterLink>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
        aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-navbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item active">
            <RouterLink class="nav-link" to="/">Trang chủ
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/AboutUs">Về chúng tôi
            </RouterLink>

          </li>

          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button" data-delay="350"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Trang
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown4">
              <li><a href="#">Về chúng tôi</a></li>
              <li><a href="#">Tin tức</a></li>
              <li><a href="#">Liên hệ</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-delay="350"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Cửa hàng
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
              <li>
                <RouterLink class="nav-link" to="/shop">Danh mục
                </RouterLink>
              </li>
              <li>
                <RouterLink class="nav-link" to="/checkout">Thanh toán
                </RouterLink>
              </li>
              <li>
                <RouterLink class="nav-link" to="/CartView">Giỏ hàng
                </RouterLink>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown5" role="button" data-delay="350"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tài khoản
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown5" v-if="!isLoggedIn">
              <li>
                <RouterLink class="nav-link" :to="{ name: 'Login' }">Đăng nhập
                </RouterLink>
              </li>
              <li>
                <RouterLink class="nav-link" to="/signup">Đăng ký
                </RouterLink>
              </li>
              <li>
                <RouterLink class="nav-link" to="/forgotpassword">Quên mật khẩu
                </RouterLink>
              </li>
            </ul>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown5" v-else>
              <li>
                <a class="nav-link logout" @click="logout">Đăng xuất</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>

      <ul class="top-menu list-inline mb-0 d-none d-lg-block" id="top-menu">
        <li class="list-inline-item">
          <a href="#" class="search_toggle" id="search-icon" @click="toggleSearch"><i
              class="tf-ion-android-search"></i></a>
        </li>

        <div class="search-popup" v-if="isSearchOpen">
          <div class="popup-content">
            <div class="d-flex justify-content-center position-relative">
              <input type="text" v-model="keyword" placeholder="Nhập tên sản phẩm" style="width: 52%" />
              <a href="#" class="remove position-absolute top-0 end-0" @click="toggleSearch"
                style="top: 20%; left: 71%"><i class="tf-ion-close"></i></a>
            </div>

            <div class="search-results">
              <div v-for="result in filteredResults" :key="result.id" class="search-item">
                <router-link :to="{ name: 'ProductDetailsView', params: { id: result.id } }"
                  class="d-inline-flex align-items-center" @click="reloadPage()">
                  <img :src="result.image" alt="Product Image" />
                  <div class="item-details">
                    <h3>{{ result.NameProducts }}</h3>
                    <p>Giá: {{ formatCurrency(result.Price) }}</p>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <li class="dropdown cart-nav dropdown-slide list-inline-item">
          <a href="#" class="dropdown-toggle cart-icon" data-toggle="dropdown" data-hover="dropdown">
            <i class="tf-ion-android-cart"></i>
            <span class="cart-count">{{ cart.length }}</span>
          </a>
          <div class="dropdown-menu cart-dropdown">
            <div class="media" v-for="(product, index) in cart" :key="index">
              <a href="#">
                <img class="media-object img- mr-3" :src="product.image" alt="image" />
              </a>

              <div class="media-body">
                <h6>{{ product.NameProducts }}</h6>
                <div class="cart-price">
                  <span>{{ product.quantity }} x</span>
                  <span>{{ formatCurrency(product.Price) }}</span>
                </div>
              </div>
              <a href="#" class="remove" @click="removeFromCart(index)"><i class="tf-ion-close"></i></a>
            </div>

            <div class="cart-summary">
              <span class="h6">Total</span>
              <span class="total-price h6">{{ formatCurrency(calculateTotalPrice()) }}</span>
              <div class="text-center cart-buttons mt-3">
                <a class="btn btn-small btn-transparent btn-block" @click="ViewCart" :disabled="isEmptyCart">
                  Xác nhận
                </a>
                <router-link :to="{ name: 'CartView' }" class="btn btn-small btn-transparent btn-block"
                  :disabled="isEmptyCart">
                  <a href="#" class="btn btn-small btn-main btn-block" :disabled="isEmptyCart">Thanh toán</a>
                </router-link>

              </div>
            </div>
          </div>
        </li>
        <li class="list-inline-item">
          <a href="#" @click="getUser()"><i class="tf-ion-ios-person mr-3"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import { defineProps } from 'vue';
import Swal from 'sweetalert2';
import axios from '@/axios';

export default {
  props: {
    cart: {
      type: Array,
      required: true,
    },
    isLoggedIn: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      keyword: '',
      results: [],
      isSearchOpen: false,
      isEmptyCart: false,
    };
  },
  created() {
    const token = localStorage.getItem('token');
    axios
      .get('/checkLogin', {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        console.log(response.data.isLoggedIn);
      })
      .catch((error) => {
        console.log(error.response.data.error);
      });
  },
  computed: {
    filteredResults() {
      if (this.results && this.results.data) {
        return this.results.data.filter((result) => result.NameProducts.toLowerCase().includes(this.keyword.toLowerCase()));
      } else {
        return [];
      }
    },
  },

  mounted() {
    axios
      .get('/getProducts')
      .then((response) => {
        this.results = response.data;
        console.log('this.results', this.results);
      })
      .catch((error) => {
        console.error(error);
      });
  },

  methods: {
    reloadPage() {
      this.$router.afterEach((to, from) => {
        if (to.name === 'ProductDetailsView') {
          location.reload();
        }
      });
    },
    toggleSearch() {
      this.isSearchOpen = !this.isSearchOpen;
      if (this.isSearchOpen) {
        document.body.classList.add('overlayBody');
      } else {
        document.body.classList.remove('overlayBody');
      }
    },

    removeFromCart(index) {
      this.$emit('remove-from-cart', index);
    },
    calculateTotalPrice() {
      let total = 0;
      for (const item of this.cart) {
        total += item.Price * item.quantity;
      }
      return total.toFixed(2); // Adjust the formatting of the total price as needed
    },
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },

    ViewCart() {
      const isLoggedIn = localStorage.getItem('isLoggedIn');
      if (!isLoggedIn) {
        // Chuyển hướng đến trang đăng nhập
        this.$router.push('/Login');
        return;
      }
      const idUser = localStorage.getItem('Id');
      const formData = new FormData();

      this.cart.forEach((item) => {
        formData.append('ProductId[]', item.ProductId);
        formData.append('Quantity[]', item.quantity);
      });

      formData.append('TotalPay', this.calculateTotalPrice());
      formData.append('Status', 1);
      formData.append('user_id', idUser);
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });

      Toast.fire({
        title: 'Loading...',
      });
      axios
        .post('/createOrderTest', formData)
        .then((response) => {
          localStorage.removeItem('cart');

          console.log(response.data);
          setTimeout(() => {
            Toast.close();
          }, 3000);
          Toast.fire({
            icon: 'success',
            title: 'Đã tạo thành công',
          });
          this.$router.push({ name: 'CartView' }).then(() => {
            window.location.reload();
          });
        })
        .catch((error) => {
          // Handle the error if needed
          console.error(error);
          setTimeout(() => {
            Toast.close();
          }, 3000);

          Toast.fire({
            icon: 'error',
            title: 'Bạn chưa có đơn hàng nào',
          });
        });
    },
    logout() {
      axios
        .post('/logout')
        .then((response) => {
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
          console.error(error);
        });
    },
    getUser() {
      const token = localStorage.getItem('token');

      axios
        .get('/getUserNameById', {
          headers: {
            Authorization: 'Bearer ' + token,
          },
        })
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
  watch: {
    cart: {
      handler(newCart) {
        this.isEmptyCart = newCart.length === 0;
      },
      deep: true
    }
  }
};
</script>
<style scoped>
.cart-count {
  position: absolute;
  top: -18px;
  right: -1px;
  background-color: #eee;
  color: #000;
  font-size: 12px;
  padding: 4px;
  border-radius: 50%;
}
</style>

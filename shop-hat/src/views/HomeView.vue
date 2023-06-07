<template>
  <div className="home-container">
    <div className="main-slider slider slick-initialized slick-slider">
      <div
        class="slider-item"
        style="background-image: url('src/assets/images/banner-hat.png'); background-position: 50%; background-repeat: no-repeat">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-12 offset-lg-6 offset-md-6">
              <div class="slider-caption">
                <span class="lead"></span>
                <h1 class="mt-2 mb-5"><span class="text-color">Bộ sưu tập mùa đông </span></h1>
                <a
                  href="/shop"
                  class="btn btn-main"
                  >Mua ngay</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="category section pt-3 pb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-sm-12 col-md-6" v-for="cate in categories">
            <div class="cat-item mb-4 mb-lg-0">
              <img
                :src="cate.image"
                alt=""
                class="img-fluid" style="width: 50%"/>
              <div class="item-info">
                <p class="mb-0">{{cate.CateName}}</p>
                <h4 class="mb-4">Giảm <strong>50% </strong></h4>

                <a
                  href="http://localhost:800/shop"
                  class="read-more"
                  >Mua ngay</a
                >
              </div>
            </div>
          </div>


        </div>
      </div>
    </section>

    <section class="section products-main">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="title text-center">
              <h2>Tất cả sản phẩm</h2>
              <p>Sản phẩm tốt nhất</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div
            class="col-lg-3 col-12 col-md-6 col-sm-6 mb-5"
            v-for="(item, index) in products"
            :key="item.id">
            <div class="product">
              <div class="product-wrap">
                <a href="#">
                  <router-link :to="{ name: 'ProductDetailsView', params: { id: item.id } }">
                    <img
                      class="img-fluid w-100 mb-3 img-first"
                      :src="item.image"
                      alt="product-img" />
                  </router-link>
                </a>
                <a href="#">
                  <router-link :to="{ name: 'ProductDetailsView', params: { id: item.id } }">
                    <img
                      class="img-fluid w-100 mb-3 img-second"
                      :src="item.image"
                      alt="product-img" />
                  </router-link>
                </a>
              </div>

             
              <div class="product-hover-overlay">
                <a
                  class="text-white"
                  @click="addToCart(item, Quantity)"
                  ><i class="tf-ion-android-cart"></i
                ></a>
                <a
                  class="text-white"
                  @click="addToCart(item, Quantity)"
                  ><i class="tf-ion-ios-heart"></i
                ></a>
              </div>

              <div class="product-info">
                <h2 class="product-title h5 mb-0">
                  <a href="#">
                    <router-link :to="{ name: 'ProductDetailsView', params: { id: item.id } }">
                      {{ item.NameProducts }}
                    </router-link>
                  </a>
                </h2>
                <span class="price"> {{ formatCurrency(item.Price) }} </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ads section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 offset-lg-6">
            <div class="ads-content">
              <span class="h5 deal">Giảm giá đến 50%</span>
              <h2 class="mt-3 text-white">Sản phẩm chất </h2>
              <p class="text-md mt-3 text-white">Hãy nhanh chân đến với cửa hàng chúng tôi!</p>

              <div
                id="simple-timer"
                class="syotimer mb-5"></div>
              <a
                href="/shop"
                class="btn btn-main"
                ><i class="ti-bag mr-2"></i>Mua ngay
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section products-list">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-sm-12 col-md-12">
            <img
              src="src/assets/images/banner4.jpg"
              alt="Product big thumb"
              class="img-fluid w-100" />
          </div>

          <div class="col-lg-4 col-sm-6 col-md-6">
            <div class="widget-featured-entries mt-5 mt-lg-0">
              <h4 class="mb-4 pb-3">Bán chạy</h4>

              <div class="media mb-3" v-for="(hot,index) in isSeller" :key="index">
                <router-link :to="{ name: 'ProductDetailsView', params: { id: hot.id } }">
                  <a
                      class="featured-entry-thumb"
                      href="#">
                    <img
                        :src="hot.image"
                        alt="Product thumb"
                        width="64"
                        class="img-fluid mr-3" />
                  </a>

                </router-link>
                <div class="media-body">
                  <h6 class="featured-entry-title mb-0"><router-link :to="{ name: 'ProductDetailsView', params: { id: hot.id } }">{{hot.NameProducts}}</router-link></h6>
                  <p class="featured-entry-meta">{{formatCurrency(hot.Price)}}</p>
                </div>
              </div>


            </div>
          </div>

          <div class="col-lg-4 col-sm-6 col-md-6">
            <div class="widget-featured-entries mt-5 mt-lg-0">
              <h4 class="mb-4 pb-3">Sản phẩm mới nhất</h4>

              <div class="media mb-3" v-for="(newPr,index) in newProducts" :key="index">
                <router-link :to="{ name: 'ProductDetailsView', params: { id: newPr.id } }">

                <a
                  class="featured-entry-thumb"
                  href="/productdetails">
                  <img
                    :src="newPr.image"
                    alt="Product thumb"
                    width="64"
                    class="img-fluid mr-3" />
                </a>
                </router-link>

                <div class="media-body">
                  <h6 class="featured-entry-title mb-0"><router-link :to="{ name: 'ProductDetailsView', params: { id: newPr.id } }">{{newPr.NameProducts}}</router-link></h6>
                  <p class="featured-entry-meta">{{formatCurrency(newPr.Price)}}</p>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="features border-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="feature-block">
              <i class="tf-ion-android-bicycle"></i>
              <div class="content">
                <h5>Miễn phí đơn hàng</h5>
                <p>Cho tất cả đơn hàng</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="feature-block">
              <i class="tf-wallet"></i>
              <div class="content">
                <h5>30 ngày hoàn trả</h5>
                <p>Tiền hoàn trả</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="feature-block">
              <i class="tf-key"></i>
              <div class="content">
                <h5>Bảo mật thông tin</h5>
                <p>100% bảo mật</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-md-6">
            <div class="feature-block">
              <i class="tf-clock"></i>
              <div class="content">
                <h5>24/7 Hỗ trợ</h5>
                <p>Hỗ trợ toàn thời gian</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Swal from 'sweetalert2';
import axios from "@/axios";
export default {
  data() {
    return {
      products: [],
      cart: [],
      newProducts:[],
      isSeller:[],
      categories:[],
      Quantity: 1,
    };
  },
  mounted() {
    axios.get('/getCategory').then((response) => {
      this.categories = response.data.data;
      console.log(this.categories);
    });
    axios.get('/getProducts').then((response) => {
      this.products = response.data.data;
    });
    axios.get('/getProductsNew').then((response) => {
      this.newProducts = response.data.data;
    });
    axios.get('/getProductsHotHit').then((response) => {
      this.isSeller = response.data.data;
    });
  },
  methods: {
    addToCart(product,quantity) {
      const isLoggedIn = localStorage.getItem('isLoggedIn');
      if (!isLoggedIn) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
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
          icon: 'error',
          title: 'Bạn chưa đăng nhập',
        }).then(() => {
          this.$router.push('/Login');
        });

        return;
      }
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
        icon: 'success',
        title: 'Order placed successfully',
      });
      quantity = this.Quantity;
      this.$emit('add-to-cart', product,quantity);
    },
    removeFromCart(product) {
      var cartItem = this.cart.find((item) => item.NameProducts === product.NameProducts);
      if (cartItem.quantity > 1) {
        cartItem.quantity--;
      } else {
        this.cart.splice(this.cart.indexOf(cartItem), 1);
      }
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
          icon: 'error',
          title: 'Bạn chưa đăng nhập',
        }).then(() => {
          this.$router.push('/Login');
        });

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
        timer: 0,
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
      this.$axios
        .post('http://127.0.0.1:8000/api/ordersAdd', formData)
        .then((response) => {
          console.log(response.data);
          Toast.close();

          Toast.fire({
            icon: 'success',
            title: 'Order placed successfully',
          });
        })
        .catch((error) => {
          console.error(error);
          Toast.close();

          Toast.fire({
            icon: 'error',
            title: 'An error occurred while placing the order',
          });
        });
    },
    clearCart() {
      this.cart = [];
    },
  },
  created() {},
  computed: {},
};
</script>

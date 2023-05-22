<template>
  <div className="single-product-container" key="$route.fullPath">
    <section class="page-header">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="content text-center">
              <h1 class="mb-3">Sản phẩm</h1>
              <p>Nơi thách thức mọi giới hạn</p>

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center">
                  <li class="breadcrumb-item"><a routerLink="/">Trang chủ</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    {{ product.NameProducts }}
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="single-product">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="single-product-slider">
              <div class="carousel slide" data-ride="carousel" id="single-product-slider">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </div>
                  <div class="carousel-item">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </div>
                  <div class="carousel-item">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </div>
                </div>

                <ol class="carousel-indicators">
                  <li data-target="#single-product-slider" data-slide-to="0" class="active">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </li>
                  <li data-target="#single-product-slider" data-slide-to="1">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </li>
                  <li data-target="#single-product-slider" data-slide-to="2">
                    <img :src="product.image" alt="" class="img-fluid" />
                  </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="single-product-details mt-5 mt-lg-0">
              <input type="hidden" :value="product.id" />
              <h2>{{ product.NameProducts }}</h2>
              <div class="sku_wrapper mb-4">SKU: <span class="text-muted">{{product.id}} </span></div>

              <hr />

              <h3 class="product-price">{{ formatCurrency(product.Price) }} <del></del></h3>

              <p class="product-description my-4" v-html="product.Details">
              </p>

              <div class="cart" action="#" method="post">
                <div class="quantity d-flex align-items-center">
                  <button @click="decrement()" class="btnQuantity">-</button>
                  <input type="text" class="quantityFl" v-model="Quantity"  readonly />
                  <button @click="increment()" class="btnQuantity">+</button>
                  <a href="#" class="btn btn-main btn-small ml-4" @click="addToCart(product, Quantity)">Thêm vào giỏ hàng</a>
                </div>
              </div>

              <div class="products-meta mt-4">


                <div class="product-share mt-5">
                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <a href="#"><i class="tf-ion-social-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="#"><i class="tf-ion-social-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="#"><i class="tf-ion-social-linkedin"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="#"><i class="tf-ion-social-pinterest"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <nav class="product-info-tabs wc-tabs mt-5 mb-5">
              <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                  aria-controls="nav-home" aria-selected="true">Mô tả sản phẩm</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                  aria-controls="nav-contact" aria-selected="false">Phản hồi(2)</a>
              </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                v-html="product.Details">



              </div>
              <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="row">
                  <div class="col-lg-7">
                    <div class="media review-block mb-4">
                      <img src="../assets/images/avater-1.jpg" alt="reviewimg" class="img-fluid mr-4" />
                      <div class="media-body">
                        <div class="product-review">
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                        </div>
                        <h6>Người bình luận  <span class="text-sm text-muted font-weight-normal ml-3">2023</span></h6>
                        <p>
                          Mũ rất đẹp, chất vải tốt nên mua!
                        </p>
                      </div>
                    </div>

                    <div class="media review-block">
                      <img src="../assets/images/avater-2.jpg" alt="reviewimg" class="img-fluid mr-4" />
                      <div class="media-body">
                        <div class="product-review">
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star"></i></span>
                          <span><i class="tf-ion-android-star-outline"></i></span>
                        </div>
                        <h6>Người bình luận  <span class="text-sm text-muted font-weight-normal ml-3">2023</span></h6>
                        <p>
                          Mũ rất đẹp sẽ ủng hộ lâu dài!
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-5">
                    <div class="review-comment mt-5 mt-lg-0">
                      <h4 class="mb-3">Thêm bình luận</h4>

                      <form action="#">
                        <div class="starrr"></div>
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="Tên của bạn" />
                        </div>
                        <div class="form-group">
                          <input type="email" class="form-control" placeholder="Email của bạn" />
                        </div>
                        <div class="form-group">
                          <textarea name="comment" id="comment" class="form-control" cols="30" rows="4"
                            placeholder="Đánh giá"></textarea>
                        </div>

                        <a routerLink="#" class="btn btn-main btn-small">Đồng ý</a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="products related-products section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="title text-center">
              <h2>Có thể bạn thích</h2>
              <p>Sản phẩm được bán nhiều nhất</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-6" v-for="hot in isSeller">
            <div class="product">
              <div class="product-wrap">


                  <img style="cursor: pointer;" class="img-fluid w-100 mb-3 img-first" :src="hot.image" alt="product-img" @click="goToProductDetails(hot.id)" />


                  <img style="cursor: pointer;" class="img-fluid w-100 mb-3 img-second" :src="hot.image" alt="product-img" @click="goToProductDetails(hot.id)" />

              </div>

              <span class="onsale">Giảm 50%</span>

              <div class="product-info">
                <h2 class="product-title h5 mb-0">
                  <a>
                    <router-link :to="{ name: 'ProductDetailsView', params: { id: hot.id } }">
                      {{ hot.NameProducts }}
                    </router-link>

                  </a>
                </h2>
                <span class="price"> {{ formatCurrency(hot.Price) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<style scoped>
.quantityFl {
  -webkit-appearance: none;
  border: none;
  text-align: center;
  width: 30px;
  font-size: 16px;
  color: #43484D;
  font-weight: 300;
  border: 1px solid #E1E8EE;
  height: auto !important;
  background-color: #ffffff;
}

.btnQuantity {
  border: 1px solid #E1E8EE;
  width: 30px;
  background-color: #E1E8EE;
  /*   border-radius: 6px; */
  cursor: pointer;
}
btnQuantity:focus,
input:focus {
  outline:0;
}
</style>
<script>
import axios from "@/axios";
import Swal from "sweetalert2";
export default {
  name: 'ProductDetailsView',
  props: ['id'],
  data() {
    return {
      product: '',
      isSeller: [],
      reloadFlag: false,
      Quantity: 1,
    };
  },
  mounted() {
    const id = this.$route.params.id;

    axios.get(`/productsDetails/${id}`).then((rs) => {
      this.product = rs.data.data;
      console.log(this.product.Price);
    });
    axios.get('/getProductsHotHit').then((response) => {
      this.isSeller = response.data.data;
      this.isSeller = this.isSeller.filter(item => item.id !== this.product.id);
    });

  },
  methods: {
    increment() {
      this.Quantity++;
    },
    decrement() {
      if (this.Quantity > 0) {
        this.Quantity--;
      }
    },
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
      this.$emit('add-to-cart', product, quantity);
    },
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
    reloadComponent() {
      this.$router.push({ name: 'ProductDetailsView', params: { id: this.$route.params.id } });
      this.reloadFlag = true;
    },
    async goToProductDetails(productId) {
      await this.$router.push({ name: 'ProductDetailsView', params: { id: productId } });
      window.location.reload()
    }


  },
  watch: {
    reloadFlag: {
      immediate: true,
      handler(newValue) {
        if (newValue) {
          window.location.reload();
        }
      },
    },
  },

};
</script>

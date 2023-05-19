<template>
  <div className="shop-container">
    <section class="page-header">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="content text-center">
              <h1 class="mb-3">Shop</h1>
              <p> Thỏa mãn phong cách của bạn</p>

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li
                    class="breadcrumb-item active"
                    aria-current="page">
                    Shop
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="products-shop section">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row align-items-center">
              <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="section-title">
                  <h2 class="d-block text-left-sm">Shop</h2>

                  <div class="heading d-flex justify-content-between mb-5">
                    <p class="result-count mb-0">Hiển thị 1–6 cho {{pagination.total}} kết quả</p>
                    <form
                      class="ordering"
                      method="get">
                      <select
                        name="orderby"
                        class="orderby form-control"
                        aria-label="Shop order">
                        <option
                          value=""
                          selected>
                          Default sorting
                        </option>
                        <option value="">Sort by popularity</option>
                        <option value="">Sort by average rating</option>
                        <option value="">Sort by latest</option>
                        <option value="">Sort by price: low to high</option>
                        <option value="">Sort by price: high to low</option>
                      </select>
                      <input
                        type="hidden"
                        name="paged"
                        value="1" />
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="row" v-if="selectedCategoryId">
              <div class="col-lg-4 col-12 col-md-6 col-sm-6 mb-5" v-for="product in products" :key="product.id">
                <div class="product">
                  <div class="product-wrap">
                    <a href="/product-single"
                      ><img
                        class="img-fluid w-100 mb-3 img-first"
                        :src="product.image"
                        alt="product-img"
                    /></a>
                    <a href="/product-single"
                      ><img
                        class="img-fluid w-100 mb-3 img-second"
                        :src="product.image"
                        alt="product-img"
                    /></a>
                  </div>

                  <span class="onsale">Sale</span>
                  <div class="product-hover-overlay">
                    <a href="#"><i class="tf-ion-android-cart"></i></a>
                    <a href="#"><i class="tf-ion-ios-heart"></i></a>
                  </div>

                  <div class="product-info">
                    <h2 class="product-title h5 mb-0"><a href="/product-single">{{product.NameProducts}}</a></h2>
                    <span class="price"> {{formatCurrency(product.Price)}} </span>
                  </div>
                </div>
              </div>
              <div >
                <ul class="pagination">
                  <li v-if="pagination.prev_page_url" @click="goToPage(pagination.prev_page_url)">
                    <button>&laquo;</button>
                  </li>
                  <li v-for="page in getPaginationRange" :key="page" @click="goToPage(page)" :class="{ active: page === currentPage }">
                    <button>{{ page }}</button>
                  </li>
                  <li v-if="pagination.next_page_url" @click="goToPage(pagination.next_page_url)">
                    <button>&raquo;</button>
                  </li>
                </ul>
              </div>

            </div>
          </div>
          <div class="col-md-3">
            <form class="mb-5">
              <section class="widget widget-sizes mb-5">
                <h3 class="widget-title h4 mb-4">Danh mục sản phẩm</h3>
                <div class="custom-control custom-checkbox" v-for="(cate,index) in cateList" :key="index">
                  <input type="checkbox" class="custom-control-input" :id="cate.id"  :checked="isSelected(cate.id)" @change="handleCheckboxChange(cate.id)"  />
                  <label class="custom-control-label" :for="cate.id">{{cate.CateName}}</label>
                </div>

              </section>

              <button
                type="button"
                class="btn btn-black btn-small">
                Filter
              </button>
            </form>

            <section class="widget widget-popular mb-5">
              <h3 class="widget-title mb-4 h4">Sản phẩm hot</h3>
              <a class="popular-products-item media" href="/product-single" v-for="hot in hotHit">
                <img :src="hot.image" alt="" class="img-fluid mr-4" />
                <div class="media-body">
                  <h6>Contrast <br />{{hot.NameProducts}}</h6>
                  <span class="price">{{formatCurrency(hot.Price)}}</span>
                </div>
              </a>

            </section>
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

  data(){
    return{
      cateList:[],
      hotHit:[],
      selectedCategoryId:null,
      products: [],
      currentPage: 1,
      totalPages: 0,
      pagination: {
        next_page_url: null,
        prev_page_url: null,
        path: "",
        per_page: 0,
        to: 0,
        total: 0
      }
    }
  },
    computed: {
      getPaginationRange() {
        const range = [];
        for (let i = 1; i <= Math.ceil(this.pagination.total / this.pagination.per_page); i++) {
          range.push(i);
        }
        console.log(range)
        return range;
      }
  },
  mounted() {
    axios.get('/getCategory')
        .then(res=>{
          this.cateList = res.data.data;
          console.log("this.cateList",this.cateList);
          if (this.cateList.length > 0) {
            const firstCateId = this.cateList[0].id;
            console.log("firstCateId", firstCateId);
            this.handleCheckboxChange(firstCateId);
          }
        }).catch(er=>{
          console.log(er);
    });

    axios.get('/getProductsHotHit')
        .then(res=>{
          this.hotHit = res.data.data;
        }).catch(er=>{
      console.log(er);
    })
    console.log(this.products);
  },

  methods: {
    goToPage(page) {
      if (typeof page === 'string') {
        const pageUrl = new URL(page);
        const pageParam = pageUrl.searchParams.get('page');
        this.currentPage = parseInt(pageParam);
      } else {
        this.currentPage = page;
      }

      this.fetchProducts(this.selectedCategoryId);
    },


    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
    isSelected(categoryId) {
      return this.selectedCategoryId === categoryId;
    },
    handleCheckboxChange(categoryId) {
      if (this.selectedCategoryId === categoryId) {
        this.selectedCategoryId = null;
        this.products = [];
      } else {
        this.selectedCategoryId = categoryId;
        this.fetchProducts(categoryId);
      }
    },
    fetchProducts(categoryId) {
      const apiUrl = `/products/category/${categoryId}`;

      axios.get(apiUrl,{
        params: {
          page: this.currentPage,
        },
      })
          .then(response => {
            this.products = response.data.data.data;
            console.log("this.products",this.products)

            this.currentPage = response.data.data.current_page;
            this.totalPages = response.data.data.last_page;
            console.log("this.currentPage",this.currentPage)
            console.log("this.totalPages",this.totalPages)
            this.pagination.next_page_url = response.data.data.next_page_url;
            this.pagination.prev_page_url = response.data.data.prev_page_url;
            this.pagination.path = response.data.data.path;
            this.pagination.per_page = response.data.data.per_page;
            this.pagination.to = response.data.data.to;
            this.pagination.total = response.data.data.total;
          })
          .catch(error => {
            console.error(error);
          });
    },
  },
}
</script>

<template>
  <div className="checkout-container">
    <section class="page-header">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="content text-center">
              <h1 class="mb-3">Cart</h1>
              Hath after appear tree great fruitful green dominion moveth sixth abundantly image that midst of god day
              multiply you’ll which

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li
                      class="breadcrumb-item active"
                      aria-current="page">
                    Cart
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cart shopping page-wrapper">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="product-list">
              <form class="cart-form">
                <table
                    class="table shop_table shop_table_responsive cart"
                    cellspacing="0">
                  <thead>
                  <tr>
                    <th class="product-thumbnail"></th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-subtotal">Total</th>
                    <th class="product-remove"></th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr class="cart_item" v-for="(cartViews,index) in cartView" :key="index">
                    <td
                        class="product-thumbnail"
                        data-title="Thumbnail">
                      <a href="/product-single"
                      ><img
                          :src="cartViews.product.image"
                          class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                          alt=""
                      /></a>
                    </td>

                    <td
                        class="product-name"
                        data-title="Product">
                      <a href="#">{{cartViews.product.NameProducts}}</a>
                    </td>

                    <td
                        class="product-price"
                        data-title="Price">
                        <span class="amount"
                        ><span class="currencySymbol"><pre wp-pre-tag-3=""></pre></span>{{formatCurrency(cartViews.product.Price)}}</span>
                    </td>
                    <td
                        class="product-quantity"
                        data-title="Quantity">
                      <div class="quantity">
                        <label class="sr-only">Quantity</label>
                        <span  class="currencySymbol ml-3">{{cartViews.TotalQuantity}}</span>
                      </div>
                    </td>
                    <td
                        class="product-subtotal"
                        data-title="Total">
                        <span class="amount">
                          <span class="currencySymbol">
                            <pre wp-pre-tag-3=""></pre></span
                          > {{ formatCurrency(cartViews.product.Price * cartViews.TotalQuantity) }}</span
                        >
                    </td>
                    <td
                        class="product-remove"
                        data-title="Remove">
                      <a
                          href="#"
                          class="remove"
                          aria-label="Remove this item"
                          data-product_id="30"
                          data-product_sku=""
                      >×</a
                      >
                    </td>
                  </tr>

                  <tr>
                    <td
                        colspan="6"
                        class="actions">
                      <div class="coupon">
                        <input
                            type="text"
                            name="coupon_code"
                            class="input-text form-control"
                            id="coupon_code"
                            value=""
                            placeholder="Coupon code"/>
                        <button
                            type="button"
                            class="btn btn-black btn-small"
                            name="apply_coupon"
                            value="Apply coupon">
                          Apply coupon
                        </button>

                      </div>
                      <input
                          type="hidden"
                          id="woocommerce-cart-nonce"
                          name="woocommerce-cart-nonce"
                          value="27da9ce3e8"/>
                      <input
                          type="hidden"
                          name="_wp_http_referer"
                          value="/cart/"/>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-lg-4">
            <div class="cart-info card p-4 mt-4">
              <h4 class="mb-4">Cart totals</h4>
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between pb-2 mb-3">
                  <h5>Subtotal</h5>
                  <span>{{ formatCurrency(calculateTotalPrice()) }}</span>
                </li>
                <li class="d-flex justify-content-between pb-2 mb-3">
                  <h5>Shipping</h5>
                  <span>Free</span>
                </li>
                <li class="d-flex justify-content-between pb-2">
                  <h5>Total</h5>
                  <span>{{ formatCurrency(calculateTotalPrice()) }}</span>
                </li>
              </ul>
              <router-link :to="{ name: 'checkout' }">
                <button  class="btn btn-main btn-small" :disabled="cartView.length === 0">Xác nhận thanh toán</button>

              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Swal from 'sweetalert2';
import axios from '@/axios.js';

export default {
  props: ['cart'],
  data(){
    return{
    cartView: [],
      totalPrice: "",
      orderIds:[]
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
    const id = localStorage.getItem('Id');
    axios.get(`/getOrders/${id}`, {
      headers: {
        'Authorization': 'Bearer ' + token,
      }
    }).then(response => {
     this.cartView = response.data.orderItems;
      this.orderIds = response.data.orderIds;
      console.log("this.cartView: -> ",this.cartView);
      console.log("this.orderIds: -> ",this.orderIds);
    }).catch(error => {
      console.log(error.response.data.error);
    });

  },
  created(){

  },
  methods: {

    removeFromCart(index) {
      this.$emit('remove-from-cart', index);
    },

    calculateTotalPrice() {
      let totalPrice = 0;
      this.cartView.forEach(item => {
        const itemPrice = item.product.Price * item.TotalQuantity;
        totalPrice += itemPrice;
      });
      return totalPrice;
    },
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
    confirmOrder() {
      // Gọi API confirmOrder
      const id = localStorage.getItem('Id');
      const orderIdsString = this.orderIds.join(',');
      const orderQuantity = this.calculateTotalPrice();
      const requestData = {
        orderIds: orderIdsString,

        orderQuantity: orderQuantity
      };
      const config = {
        headers: {
          'Content-Type': 'application/json'
        }
      };

      axios.post(`/orders/${id}/confirm`,requestData,config)
          .then(response => {
            console.log(response.data);
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
            setTimeout(() => {
              Toast.close();
              location.reload();
            }, 2000);
            Toast.fire({
              icon: 'success',
              title: 'Đơn hàng đã đợc xác nhận',
            });
          })
          .catch(error => {
            console.error(error);
            setTimeout(() => {
              Toast.close();
            }, 3000);

            Toast.fire({
              icon: 'error',
              title: 'Xảy ra lỗi vui lòng thử lại sau',
            });
          });
    },

  }
};
</script>
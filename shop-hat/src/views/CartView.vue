<template>
  <div className="checkout-container">
    <section class="page-header">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="content text-center">
              <h1 class="mb-3">Giỏ hàng</h1>
              Nơi thanh toán những món đồ của bạn

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center">
                  <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Giỏ hàng
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
        <div v-if="cartItems && cartItems.length > 0" class="text-center">

          <marquee class="text-danger">Bạn đang còn đơn hàng chưa xác nhận ở giỏ.Vui lòng kiểm tra giỏ hàng
            phía trên để chắc chắn đã xác nhận!!</marquee>

        </div>
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="product-list">
              <div class="cart-form">
                <table class="table shop_table shop_table_responsive cart" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="product-thumbnail"></th>
                      <th class="product-name">Sản phẩm</th>
                      <th class="product-price">Giá</th>
                      <th class="product-quantity">Số lượng</th>
                      <th class="product-subtotal">Tổng tiền</th>
                      <th class="product-remove"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr class="cart_item" v-for="(cartViews, index) in cartView" :key="index">
                      <td class="product-thumbnail" data-title="Thumbnail">
                        <a href="/product-single"><img :src="cartViews.product.image"
                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" /></a>
                      </td>

                      <td class="product-name" data-title="Product">
                        <a href="#">{{ cartViews.product.NameProducts }}</a>
                      </td>

                      <td class="product-price" data-title="Price">
                        <span class="amount"><span
                            class="currencySymbol"></span>{{ formatCurrency(cartViews.product.Price) }}</span>
                      </td>
                      <td class="product-quantity" data-title="Quantity">
                        <div class="quantity">
                          <label class="sr-only">Quantity</label>
                          <button @click="decrement(index)" class="btnQuantity">-</button>
                          <input type="text" class="quantityFl" v-model="cartViews.Quantity"
                            @input="updateQuantity($event, index)" readonly />
                          <button @click="increment(index)" class="btnQuantity">+</button>
                          <!-- <input type="number" class="form-control" v-model="cartViews.Quantity" min="0"  /> -->
                        </div>
                      </td>
                      <td class="product-subtotal" data-title="Total">
                        <span class="amount">
                          <span class="currencySymbol">
                          </span> {{ formatCurrency(cartViews.product.Price * cartViews.Quantity) }}</span>
                      </td>
                      <td class="product-remove" data-title="Remove">
                        <a href="#" class="remove" aria-label="Remove this item" data-product_id="30" data-product_sku=""
                          @click="removeFromCartView(cartViews.ProductId)">×</a>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="6" class="actions">
                        <div class="coupon">
                          <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value=""
                            placeholder="Mã giảm giá" />
                          <button type="button" class="btn btn-black btn-small" name="apply_coupon" value="Apply coupon">
                            Nhập mã
                          </button>

                        </div>
                        <input type="hidden" id="woocommerce-cart-nonce" name="woocommerce-cart-nonce"
                          value="27da9ce3e8" />
                        <input type="hidden" name="_wp_http_referer" value="/cart/" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-lg-4">
            <div class="cart-info card p-4 mt-4">
              <h4 class="mb-4">Tổng tiền</h4>
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between pb-2 mb-3">
                  <h5>Tạm tính</h5>
                  <span>{{ formatCurrency(calculateTotalPrice()) }}</span>
                </li>
                <li class="d-flex justify-content-between pb-2 mb-3">
                  <h5>Giao hàng</h5>
                  <span>Miễn phí</span>
                </li>
                <li class="d-flex justify-content-between pb-2">
                  <h5>Tổng</h5>
                  <span>{{ formatCurrency(calculateTotalPrice()) }}</span>
                </li>
              </ul>
              <button class="btn btn-main btn-small" @click="updateCart()" :disabled="cartView.length === 0">Xác nhận
                thanh toán</button>

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
  outline: 0;
}
</style>
<script>
import Swal from 'sweetalert2';
import axios from '@/axios.js';

export default {
  props: ['cart'],
  data() {
    return {
      cartView: [],
      totalPrice: "",
      orderIds: [],
      cartItems: [],

    }
  },
  mounted() {
    this.cartItems = localStorage.getItem('cart');
    const token = localStorage.getItem('token');
    const id = localStorage.getItem('Id');
    axios.get(`/getOrdersID/${id}`, {
      headers: {
        'Authorization': 'Bearer ' + token,
      }
    }).then(response => {
      this.cartView = response.data.orderItems;
      this.orderIds = response.data.orderIds;
    }).catch(error => {
      console.log(error.response.data.error);
    });

  },
  created() {

  },
  methods: {
    increment(index) {
      this.cartView[index].Quantity++;
    },
    decrement(index) {
      if (this.cartView[index].Quantity > 0) {
        this.cartView[index].Quantity--;
      }
    },
    updateQuantity(event, index) {
      this.cartView[index].Quantity = parseInt(event.target.value);
    },
    async updateCart() {
      try {
        const current = this;
        for (const item of this.cartView) {
          await axios.post(`/orderEdit/${item.id}`, { Quantity: item.Quantity });
          console.log(`THÀNH CÔNG ${item.id}`);
        }
        current.$router.push("/checkout");
      } catch (error) {
        console.log(error);
      }
    },
    async removeFromCartView(productId) {
      const id = localStorage.getItem('Id');
      try {
        const result = await Swal.fire({
          title: 'Xác nhận',
          text: 'Bạn có chắc chắn muốn xoá mặt hàng này?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Xoá',
          cancelButtonText: 'Hủy',
          reverseButtons: true
        });

        if (result.isConfirmed) {

          const response = await axios.get(`/deleteCart/${productId}/${id}`);
          Swal.fire({
            title: 'Đang xử lý...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            },
          });
          console.log(response.data.message);
          Swal.fire({
            icon: 'success',
            title: 'Mặt hàng đã xoá thành công',
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire('Hủy', 'Đã hủy xoá mặt hàng', 'info');
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Có lỗi xảy ra',
          text: 'Đã có lỗi',
        }).then(() => {
          window.location.reload();
        });
      }

    },
    removeFromCart(index) {
      this.$emit('remove-from-cart', index);
    },

    calculateTotalPrice() {
      let totalPrice = 0;
      this.cartView.forEach(item => {
        const itemPrice = item.product.Price * item.Quantity;
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

      axios.post(`/orders/${id}/confirm`, requestData, config)
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
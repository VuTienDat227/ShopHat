<template>
  <div className="checkout-container">
    <section class="page-header">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="content text-center">
              <h1 class="mb-3">Thủ tục thanh toán</h1>
              <p>Cảm ơn bạn đã đồng hành cùng chúng mình trên con đường trở thành người thành công!</p>

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center">
                  <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                  <li
                      class="breadcrumb-item active"
                      aria-current="page">
                    Chi tiết đơn hàng
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="page-wrapper">
      <div class="checkout shopping">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 pr-5">
              <div
                  class="coupon-notice"
                  data-toggle="modal"
                  data-target="#coupon-modal">
                <div class="bg-light p-3">
                  Bạn có mã giảm giá
                  <a
                      href="/checkout"
                      class="showcoupon"
                  >Ấn vào đây để lấy code</a
                  >
                </div>
              </div>

              <div class="billing-details mt-5">
                <h4 class="mb-4">Hóa đơn chi tiết</h4>
                <form class="checkout-form">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label for="first_name">Tên của bạn</label>
                        <input type="text" v-model="FullName" class="form-control" id="first_name" placeholder="" readonly/>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label for="first_name">Email</label>
                        <input type="text" v-model="Email" class="form-control" id="first_name" placeholder=""/>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <label for="company_name">Chọn tỉnh thành </label>
                        <select class="form-control" v-model="selectedCity" @change="getDistricts">
                          <option value="" selected>Chọn tỉnh thành</option>
                          <option v-for="city in cities" :value="city.code" :key="city.code">{{ city.name }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <label>Chọn quận huyện </label>
                        <select class="form-control" v-model="selectedDistrict" @change="getWards">
                          <option value="" selected>Chọn quận huyện</option>
                          <option v-for="district in districts" :value="district.code" :key="district.code">
                            {{ district.name }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <label>Chọn phường xã </label>
                        <select class="form-control" v-model="selectedWard" @change="printResult">
                          <option value="" selected>Chọn phường xã</option>
                          <option v-for="ward in wards" :value="ward.code" :key="ward.code">{{ ward.name }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <label for="first_name">Số điện thoại </label>
                        <input
                            type="text"
                            class="form-control"
                            id="phone"
                            placeholder=""
                        v-model="PhoneNumber" readonly/>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <label for="first_name">Chi tiết địa chỉ</label>
                        <textarea class="form-control" id="msg" cols="30" rows="5"
                                  placeholder="Chi tiết địa chỉ" v-model="DetailsAddress"></textarea>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="product-checkout-details mt-5 mt-lg-0">
                <h4 class="mb-4 border-bottom pb-4">Đơn hàng chính</h4>

                <div class="media product-card" v-for="cartCheck in cartView">
                  <p>{{ cartCheck.product.NameProducts }}</p>
                  <div class="media-body text-right">
                    <p class="h5">{{ cartCheck.TotalQuantity }} x {{ formatCurrency(cartCheck.product.Price) }}</p>
                  </div>
                </div>

                <ul class="summary-prices list-unstyled mb-4">
                  <li class="d-flex justify-content-between">
                    <span>Tạm tính:</span>
                    <span class="h5">{{ formatCurrency(calculateTotalPrice()) }}</span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <span>Giao hàng:</span>
                    <span class="h5">Miễn phí</span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <span>Tổng</span>
                    <span class="h5">{{ formatCurrency(calculateTotalPrice()) }}</span>
                  </li>
                </ul>

                <form action="#">
                  <div class="form-check mb-3">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="exampleRadios"
                        id="exampleRadios1"
                        value="option1"
                        checked/>
                    <label
                        class="form-check-label"
                        for="exampleRadios1">
                      Thanh toán chuyển khoản
                    </label>

                    <div
                        class="alert alert-secondary mt-3"
                        role="alert">
                      Thực hiện thanh toán của bạn trực tiếp vào tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng ID
                      đơn đặt hàng của bạn làm tham chiếu thanh toán. Đơn đặt hàng của bạn sẽ không được vận chuyển cho
                      đến khi
                      chúng tôi nhận được tiền.
                    </div>
                  </div>

                  <div class="form-check mb-3">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="exampleRadios"
                        id="exampleRadios2"
                        value="option2" v-model="paymentMethod"/>
                    <label
                        class="form-check-label"
                        for="exampleRadios2" >
                      Trả tiền mặt
                    </label>
                  </div>

                  <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="exampleCheck3"/>
                    <label
                        class="form-check-label"
                        for="exampleCheck3"
                    >Tôi đồng ý với các điều khoản ở trên</label
                    >
                  </div>
                </form>

                <div class="info mt-4 border-top pt-4 mb-5">
                  Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn đặt hàng của bạn, hỗ trợ trải nghiệm của bạn trên
                  trang web này và cho các mục đích khác được mô tả trong phần của chúng tôi. <a href="#">Chính sách
                  bảo mật</a>.
                </div>
                <button class="btn btn-main btn-small" @click="confirmOrder()" :disabled="cartView.length === 0">Xác
                  nhận thanh toán
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
        class="modal fade"
        id="coupon-modal"
        tabindex="-1"
        role="dialog">
      <div
          class="modal-dialog"
          role="document">
        <div class="modal-content py-5">
          <div class="modal-body">
            <form>
              <div class="form-group">
                <input
                    class="form-control"
                    type="text"
                    placeholder="Nhập mã code"/>
              </div>
              <button
                  type="button"
                  class="btn btn-main btn-small"
                  data-dismiss="modal">
                Xác nhận
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

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
      cities: [],
      districts: [],
      wards: [],
      selectedCity: '',
      selectedDistrict: '',
      selectedWard: '',
      result: '',
      host: 'https://provinces.open-api.vn/api/',
      FullName: '',
      PhoneNumber: '',
      Email: '',
      paymentMethod:'',
      NameDetails: '',
      EmailDetails: '',
      selectedCityDetails: '',
      selectedDistrictDetails: '',
      selectedWardDetails: '',
      PhoneNumberDetails: '',
      DetailsAddress: '',

    }
  },
  mounted() {
    this.callAPI(this.host + '?depth=1');
    const token = localStorage.getItem('token');
    const id = localStorage.getItem('Id');
    axios.get(`/getOrders/${id}`, {
      headers: {
        'Authorization': 'Bearer ' + token,
      }
    }).then(response => {
      this.cartView = response.data.orderItems;
      this.orderIds = response.data.orderIds;
      console.log("this.cartView: -> ", this.cartView);
      console.log("this.orderIds: -> ", this.orderIds);
    }).catch(error => {
      console.log(error.response.data.error);
    });
    axios.get(`/getAllFillById/${id}`)
        .then((re) => {
          this.FullName = re.data.data.FullName;
          this.PhoneNumber = re.data.data.PhoneNumber;
          this.Email = re.data.data.Email;
        }).catch(error => {
      console.log(error);
    });

  },
  created() {

  },
  methods: {
    async sendEmail() {
      let paymentMethodData = '';
      if (this.paymentMethod === 'option2') {
        paymentMethodData = 'Trả tiền mặt';
      } else {
        paymentMethodData = 'Trả thẻ';
      }

      const emailData = {
        email: 'dattienvu242@gmail.com', //
        subject: 'Đơn đặt hàng',
        content: `Họ và tên: ${this.FullName}
            Số điện thoại: ${this.PhoneNumber}
            Tổng giá trị đơn hàng: ${this.formatCurrency(this.calculateTotalPrice())}
            Order IDs: ${this.orderIds}
            Địa chỉ nhận hàng: ${this.result}
            Phương thức thanh toán: ${paymentMethodData}`,

      };

      try {
        const response = await axios.post('/send-email', emailData);
        console.log(response.data.message); // Email sent successfully
      } catch (error) {
        console.error('Error sending email:', error);
      }
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
    async confirmOrder() {
      const id = localStorage.getItem('Id');

      if(this.Email.length > 0){
        try {
          await axios.post(`/users/${id}/email`,{Email: this.Email});
          console.log('Cập nhật email thành công');
        }
        catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Đã tồn tại email!!',
          })
          console.log('Lỗi khi cập nhật email:', error);
          return;
        }

      }
      Swal.fire({
        title: 'Đang xác nhận đơn hàng...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
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
            this.sendEmail();
            console.log(response.data);
            let timerInterval;
                Swal.fire({
                  title: 'Đơn hàng của bạn đang được xử lý!',
                  html:
                      'Bạn vui lòng chờ trong <strong></strong> giây.<br/><br/>',
                  timer: 10000,
                  showCancelButton: false,
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  didOpen: () => {
                    timerInterval = setInterval(() => {
                      Swal.getHtmlContainer().querySelector('strong')
                          .textContent = (Swal.getTimerLeft() / 1000)
                          .toFixed(0)
                    }, 100)
                  }
                }).then(() => {
                  window.location.reload();
                });


          })
          .catch(error => {
            console.error(error);
            Swal.fire('Lỗi', 'Đã xảy ra lỗi khi xác nhận đơn hàng', 'error').then(() => {
              window.location.reload();
            });
          }).finally(() => {
        Swal.hideLoading();
      });
    },
    callAPI(api) {
      fetch(api)
          .then(response => {
            return  response.json()
          })
          .then(data=>{
            this.cities = data;
            console.log("this.cities ->",data);
          })
          .catch(error => {
            console.error(error);
          });
    },
    getDistricts() {
      if (this.selectedCity) {
        const api = this.host + 'p/' + this.selectedCity + '?depth=2';
        fetch(api)
            .then(response => {
              return  response.json()

            }).then((data)=>{
          this.districts = data.districts;
          this.selectedDistrict = '';
          this.wards = [];
          this.selectedWard = '';
          this.result = '';
        })
            .catch(error => {
              console.error(error);
            });
      } else {
        this.districts = [];
        this.wards = [];
        this.result = '';
      }
    },
    getWards() {
      if (this.selectedDistrict) {
        const api = this.host + 'd/' + this.selectedDistrict + '?depth=2';
        fetch(api)
            .then(response => {
              return  response.json()
            }).then(data=>{
          this.wards = data.wards;
          this.selectedWard = '';
          this.result = '';
        })
            .catch(error => {
              console.error(error);
            });
      } else {
        this.wards = [];
        this.result = '';
      }
    },
    printResult() {
      if (this.selectedCity && this.selectedDistrict && this.selectedWard) {
        const city = this.cities.find(c => c.code === this.selectedCity);
        const district = this.districts.find(d => d.code === this.selectedDistrict);
        const ward = this.wards.find(w => w.code === this.selectedWard);

        this.result = `Thành phố: ${city.name} , Quận/Huyện: ${district.name} , Phường/Xã: ${ward.name}`;
      } else {
        this.result = '';
      }
    }
  }

};
</script>
<template>
  <div class="row mb-4 align-items-center">
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Tổng tất cả sản phẩm</p>
                <h5 class="font-weight-bolder">
                  {{ totalProducts }}
                </h5>
                <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">Nằm trong {{ categoryCounts }}</span>
                  danh mục sản phẩm
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="fa-solid fa-list-ol iconList"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Khách hàng đã đăng ký</p>
                <h5 class="font-weight-bolder">
                  {{ getUserAllAuth }}
                </h5>
                <p class="mb-0" v-if="percentageChangeUser > 0">
                  <span class="text-success text-sm font-weight-bolder">+{{percentageChangeUser}} thành viên</span>
                  so với lần cuối
                </p>
                <p class="mb-0" v-else>
                  <span class="text-danger text-sm font-weight-bolder">{{percentageChangeUser}} thành viên</span>
                  so với lần cuối
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="fa-solid fa-users text-lg opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Đơn hàng</p>
                <h5 class="font-weight-bolder">
                  {{ countGetOrders }}
                </h5>
                <p class="mb-0" v-if="this.percentageChangeCart > 0">
                  <span class="text-success text-sm font-weight-bolder">+{{percentageChangeCart}}</span>
                 tăng tổng tuần trước
                </p>
                <p class="mb-0" v-else>
                  <span class="text-danger text-sm font-weight-bolder">{{percentageChangeCart}}</span>
                 giảm tổng tuần trước
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                <i class="fa-solid fa-cart-arrow-down text-lg opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row ">

    <div class="col-xl-4 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Doanh thu hôm nay</p>
                <h5 class="font-weight-bolder">
                  {{formatCurrency(calculateTotal)}}
                </h5>

                <p class="mb-0" v-if="this.percentageChangeToday > 0">
                  <span class="text-success text-sm font-weight-bolder">+{{percentageChangeToday}}%</span> tăng so với hôm qua
                </p>
                <p class="mb-0" v-else-if="this.percentageChangeToday === 0">
                  <span class="text-success text-sm font-weight-bolder">+100%</span> tăng so với hôm qua
                </p>
                <p class="mb-0" v-else>
                  <span class="text-danger text-sm font-weight-bolder">{{percentageChangeToday}}%</span> giảm so với hôm qua
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="fa-solid fa-coins text-lg opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Doanh thu tuần này</p>
                <h5 class="font-weight-bolder">
                  {{formatCurrency(calculateTotalPayThisWeek)}}
                </h5>
                <p class="mb-0" v-if="this.percentageChangeWeek > 0">
                  <span class="text-success text-sm font-weight-bolder">+{{percentageChangeWeek}}%</span> tăng so với tuần qua
                </p>
                <p class="mb-0" v-else-if="this.percentageChangeWeek === 0">
                  <span class="text-success text-sm font-weight-bolder">+100%</span> tăng so với tuần qua
                </p>
                <p class="mb-0" v-else>
                  <span class="text-success text-sm font-weight-bolder">-{{percentageChangeWeek}}%</span> giảm so với tuần qua
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="fa-solid fa-money-check-dollar text-lg opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row align-items-center">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Doanh thu tháng này</p>
                <h5 class="font-weight-bolder">
                  {{formatCurrency(calculateTotalPayThisMonth)}}
                </h5>

                <p class="mb-0" v-if="this.percentageChangeMonth > 0">
                  <span class="text-success text-sm font-weight-bolder">+{{percentageChangeMonth}}%</span> tăng so với tháng qua
                </p>
                <p class="mb-0" v-else-if="this.percentageChangeMonth === 0">
                  <span class="text-success text-sm font-weight-bolder">+100%</span> tăng so với tuần qua
                </p>
                <p class="mb-0" v-else>
                  <span class="text-danger text-sm font-weight-bolder">-{{percentageChangeMonth}}%</span> giảm so với tháng qua
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="fa-solid fa-sack-dollar text-lg opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  name: "index",
  data() {
    return {
      totalProducts: null,
      categoryCounts: null,
      getUserAllAuth: null,
      countGetOrders: null,
      calculateTotal: null,
      calculateTotalPayThisWeek: null,
      percentageChangeWeek: null,
      percentageChangeToday: null,
      percentageChangeMonth: null,
      percentageChangeCart: null,
      percentageChangeUser: null,
      calculateTotalPayThisMonth: null,
    }
  },
  mounted() {
    axios.get("/getCount")
        .then((res) => {
          this.totalProducts = res.data.totalProducts;
          this.categoryCounts = res.data.categoryCounts;
        });
    axios.get("/getUserAllAuth")
        .then((res) => {
          this.getUserAllAuth = res.data.userCount;
          this.percentageChangeUser = res.data.changeCount;
        });
    axios.get("/countGetOrders")
        .then((res) => {
          this.countGetOrders = res.data.count;
          this.percentageChangeCart = res.data.percentageChange;
        });
    axios.get("/calculateTotal")
        .then((res) => {
          this.calculateTotal = res.data.totalPayToday;
          this.percentageChangeToday = res.data.percentageChange;

        });
    axios.get("/calculateTotalPayThisWeek")
        .then((res) => {
          this.calculateTotalPayThisWeek = res.data.totalPayThisWeek;
          this.percentageChangeWeek = res.data.percentageChange;
          console.log(this.percentageChangeWeek);
        });
    axios.get("/calculateTotalPayThisMonth")
        .then((res) => {
          this.calculateTotalPayThisMonth = res.data.totalPay;
          this.percentageChangeMonth = res.data.percentageChange;
        });
  },
  methods:{
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
  }
}
</script>

<style scoped>
i{
  font-size: 3em;
  opacity: 0.5;
}
.iconList{
  font-size: 1em;

}
</style>
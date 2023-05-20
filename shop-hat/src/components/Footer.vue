<template>
  <div className="footer-container">
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 col-sm-6 mb-5 mb-lg-0 text-center text-sm-left mr-auto">
            <div class="footer-widget">
              <h4 class="mb-4">HATSTORE</h4>
              <p class="lead">Nơi thể hiển theo phong cách của bạn!</p>

              <div class="">
                <p class="mb-0"><strong>Địa chỉ : </strong>Số 1111, Đống Đa, Hà Nội</p>
                <p><strong>Email hỗ trợ : </strong> support@email.com</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-2 col-sm-6 mb-5 mb-lg-0 text-center text-sm-left">
            <div class="footer-widget">
              <h4 class="mb-4">Danh mục</h4>
              <ul class="pl-0 list-unstyled mb-0">
                <li v-for="cate in categories">
                  <a href="#">{{cate.CateName}}</a>
                </li>

              </ul>
            </div>
          </div>

          <div class="col-md-6 col-lg-2 col-sm-6 mb-5 mb-lg-0 text-center text-sm-left">
            <div class="footer-widget">
              <h4 class="mb-4">Có thể bạn cần</h4>
              <ul class="pl-0 list-unstyled mb-0">
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Our Shop</a></li>
              </ul>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 col-sm-6 text-center text-sm-left">
            <div class="footer-widget">
              <h4 class="mb-4">Giờ mở cửa</h4>
              <ul class="pl-0 list-unstyled mb-5">
                <li class="d-lg-flex justify-content-between">Thứ 2- 6 <span>8.00h-20.00</span></li>
                <li class="d-lg-flex justify-content-between">Thứ 7 <span>10.00h-20.00</span></li>
                <li class="d-lg-flex justify-content-between">Chủ nhật <span>12h-20.00</span></li>
              </ul>

              <h5>Gọi ngay : +(84) 000-000</h5>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <div class="footer-btm py-4">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <p class="copyright mb-0">made by <a href="#">HATSTORE</a></p>
          </div>
          <div class="col-lg-6">
            <ul class="list-inline mb-0 footer-btm-links text-lg-right mt-2 mt-lg-0">
              <li class="list-inline-item"><a href="#">Facebook</a></li>
              <li class="list-inline-item"><a href="#">Instagram</a></li>
              <li class="list-inline-item"><a href="#">Twitter</a></li>
              <li class="list-inline-item"><a href="#">Email</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "@/axios";
export default {
  data(){
    return{
      categories: []
    }
  },
  mounted() {
    axios.get('/getCategory').then((response) => {
      this.categories = response.data.data;
      console.log(this.categories);
    });
  }
}
</script>

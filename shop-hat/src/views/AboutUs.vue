<template>
  <div class="container-fluid">
    <div class="auto-slide">

      <Carousel :autoplay="2000" :wrap-around="true">
        <Slide v-for="slide in images" :key="slide">
          <div class="carousel__item">
            <img :src="slide" class="slider-item"/>
          </div>
        </Slide>

        <template #addons>
          <Pagination />
        </template>
      </Carousel>
    </div>
  </div>
  <section class="section_all bg-light" id="about">

    <div class="container">

      <div class="row">
        <div class="col-lg-12">
          <div class="section_title_all text-center">
            <h3 class="font-weight-bold">Chào mừng đến với  <span class="text-custom">Shop Hat</span></h3>
            <p class="section_subtitle mx-auto text-muted">Thỏa sức đam mê với sự lựa chọn của bạn <br/>Cam kết chất lượng, uy tín tạo thương hiệu</p>
            <div class="">
              <i class=""></i>
            </div>
          </div>
        </div>
      </div>

      <div class="row vertical_content_manage mt-5">
        <div class="col-lg-6">
          <div class="about_header_main mt-3">
            <div class="about_icon_box">
              <p class="text_custom font-weight-bold">Thương hiệu Nike của nước nào?</p>
            </div>
            <h4 class="about_heading text-capitalize font-weight-bold mt-4">Nike là một trong những thương hiệu thời trang thể thao cao cấp lớn nhất thế giới hiện nay</h4>
            <p class="text-muted mt-3">Nike là một tập đoàn đa quốc gia của Mỹ. Thương hiệu này phát triển đa dạng trong nhiều lĩnh vực như: Trang thiết bị thể thao, quần áo và giày dép phục vụ các môn thể thao, dịch vụ tương tác liên quan đến thể thao. Đặc biệt, Nike luôn ứng dụng khoa học công nghệ cao vào các sản phẩm của hãng</p>
            <p class="text-muted mt-3">Nike Air Jordan: Đây là mẫu giày thể thao được lấy theo tên của huyền thoại bóng rổ Michael Jordan sau khi anh ký hợp đồng với thương hiệu. Mẫu giày này được ra mắt vào năm 1985 và nhanh chóng trở thành cái tên nổi tiếng trong giới trẻ ở Mỹ.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="img_about mt-3">
            <img src="../assets/images/aboutus.jpg" alt="" class="img-fluid mx-auto d-block"/>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-lg-4">
          <div class="about_content_box_all mt-3">
            <div class="about_detail text-center">
              <div class="about_icon">
                <i class="fas fa-pencil-alt"></i>
              </div>
              <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Cam kết</h5>
              <p class="edu_desc mt-3 mb-0 text-muted">Cam kết chất lượng và uy tín! </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="about_content_box_all mt-3">
            <div class="about_detail text-center">
              <div class="about_icon">
                <i class="fab fa-angellist"></i>
              </div>
              <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Mẫu mã thời trang</h5>
              <p class="edu_desc mb-0 mt-3 text-muted">Mẫu mã hợp thời đại và phù hợp với giới trẻ </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="about_content_box_all mt-3">
            <div class="about_detail text-center">
              <div class="about_icon">
                <i class="fas fa-paper-plane"></i>
              </div>
              <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Giao hàng</h5>
              <p class="edu_desc mb-0 mt-3 text-muted">Giao hàng nhanh chóng, chỉ 3 ngày làm việc</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <hr/>
</template>

<script>
import { Carousel, Slide } from 'vue3-carousel'
import { defineComponent } from 'vue'

import 'vue3-carousel/dist/carousel.css'
export default {
  name: "AboutUs",
  components: {
    Slide,
    Carousel,
    defineComponent
  },

  data() {
    return {
      images: [
        './1ecca45b2f4cf112a85d.jpg',
        './aa18128f999847c61e89.jpg',
      ],
    };
  },
}
</script>

<style scoped>
h1, h2, h3, h4, h5, h6 {
  color: #2c3145;
}
a, a:hover, a:focus, a:active {
  text-decoration: none;
  outline: none;
}
ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.section_all {
  position: relative;
  padding-top: 80px;
  padding-bottom: 80px;
  min-height: 100vh;
}
.section-title {
  font-weight: 700;
  text-transform: capitalize;
  letter-spacing: 1px;
}

.section-subtitle {
  letter-spacing: 0.4px;
  line-height: 28px;
  max-width: 550px;
}

.section-title-border {
  background-color: #000;
  height: 13px;
  width: 44px;
}

.section-title-border-white {
  background-color: #fff;
  height: 2px;
  width: 100px;
}
.text_custom {
  color: #00bd2a;
}

.about_icon i {
  font-size: 22px;
  height: 65px;
  width: 65px;
  line-height: 65px;
  display: inline-block;
  background: #fff;
  border-radius: 35px;
  color: #00bd2a;
  box-shadow: 0 8px 20px -2px rgba(158, 152, 153, 0.5);
}

.about_header_main .about_heading {
  max-width: 450px;
  font-size: 24px;
}

.about_icon span {
  position: relative;
  top: -10px;
}

.about_content_box_all {
  padding: 28px;
}
.carousel__item {
  width: 100%;
  height: auto;
}

.slider-item {
  width: 60%;
  height: auto;
  object-fit: contain; /* Để giữ tỷ lệ hình ảnh */
}
</style>
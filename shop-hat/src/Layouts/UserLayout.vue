<template>
  <Header
    v-if="routeName !== 'login'"
    :isLoggedIn="isLoggedIn"
    :cart="cart"
    @remove-from-cart="removeFromCart" />
  <RouterView
    @add-to-cart="addToCart"
    :cart="cart" />
  <Footer />
  <div class="nb-form">
    <p class="title">Gửi liên hệ cho chúng tôi</p>
    <img src="https://lh3.googleusercontent.com/-LvTWzTOL4c0/V2yhfueroyI/AAAAAAAAGZM/Ebwt4EO4YlIc03tw8wVsGrgoOFGgAsu4wCEw/w140-h140-p/43bf8578-86b8-4c1c-86a6-a556af8fba13" alt="" class="user-icon">
    <p class="message">Nếu có thắc mắc hãy guửi liên hệ cho chúng tôi</p>

    <form @submit.prevent="sendEmail">
      <input v-model="name" type="text" name="cpname" placeholder="Tên của bạn" required>
      <input v-model="email" type="email" name="cpemail" placeholder="Email của bạn" required>
      <input v-model="phone" type="tel" name="cpphone" placeholder="Số điện thoại" required>
      <textarea v-model="message" name="cpmessage" placeholder="Lời nhắn" required></textarea>
      <input type="submit" value="Xác nhận">
    </form>
  </div>
</template>

<script>
import Header from '../components/Header.vue';
import HomeView from '../views/HomeView.vue';
import Footer from '../components/Footer.vue';
import CartView from '../views/CartView.vue';
import LoginView from '@/views/LoginView.vue';
import { onMounted, ref } from 'vue';
import { onBeforeRouteUpdate, useRoute } from 'vue-router';
import Swal from 'sweetalert2';
import axios from "@/axios";

export default {
  components: {
    Header,
    HomeView,
    Footer,
    CartView,
    LoginView,
  },
  setup() {
    const cart = ref([]);
    const storedCart = localStorage.getItem('cart');
    if (storedCart) {
      cart.value = JSON.parse(storedCart);
    }

    const addToCart = (product,quantity) => {
      const cartItem = cart.value.find((item) => item.NameProducts === product.NameProducts);
      if (cartItem) {
        cartItem.quantity += quantity;
      } else {
        cart.value.push({
          NameProducts: product.NameProducts,
          Price: product.Price,
          quantity: quantity,
          image: product.image,
          ProductId: product.id,
        });
      }
      console.log(cart.value);
      localStorage.setItem('cart', JSON.stringify(cart.value));
    };

    const removeFromCart = (index) => {
      const cartItem = cart.value[index];
      if (cartItem.quantity > 1) {
        cartItem.quantity--;
      } else {
        cart.value.splice(index, 1);
      }
      localStorage.setItem('cart', JSON.stringify(cart.value));
    };

    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const route = useRoute();
    let routeName = '';

    const name = ref('');
    const email = ref('');
    const phone = ref('');
    const message = ref('');

    const sendEmail = async () => {
      const emailData = {
        email: 'dattienvu242@gmail.com',
        subject: 'Gửi liên hệ',
        content: `Họ và tên: ${name.value}
            Số điện thoại: ${phone.value}
            Lời nhắn: ${message.value}
            Email khách hàng: ${email.value}`,
      };

      try {
        Swal.fire({
          title: 'Đang gửi email...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          },
        });
        const response = await axios.post('/send-email', emailData);
        console.log(response.data.message);
        Swal.fire({
          icon: 'success',
          title: 'Email đã được gửi thành công',
        });
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Có lỗi xảy ra',
          text: 'Đã có lỗi khi gửi email',
        });
        console.error('Error sending email:', error);
      }
    };
    return {
      cart,
      addToCart,
      removeFromCart,
      isLoggedIn,
      routeName,
      name,
      email,
      phone,
      message,
      sendEmail,
    };
  },
};
</script>
<style scoped>
/*------------- Form ---------------*/

.nb-form {
  position: fixed;
  z-index: 9999;
  width: 300px;
  background: #FFF;
  right: 20px;
  bottom: -400px;
  transition: all .8s cubic-bezier(.22, .67, .43, 1.22) .2s;
  border-radius: 10px 10px 0 0;
  box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14),0 1px 5px 0 rgba(0,0,0,0.12),0 3px 1px -2px rgba(0,0,0,0.2);
}
.nb-form:hover {
  bottom: 0px;
}

/*-- User Icon --*/

.nb-form .user-icon {
  position: absolute;
  top: -49px;
  right: 12px;
  display: block;
  width: 58px;
  margin: 20px auto 15px;
  border-radius: 100%;
}

/*-- Title --*/

.nb-form .title {
  background: #03a9f4;
  font-size: 16px !important;
  padding: 20px 18px !important;
  color: #fff !important;
  border-radius: 10px 10px 0 0;
}

/*-- Text --*/

.nb-form p {
  font-size: 13px;
  margin: 0;
  padding: 15px;
  color: #666;
}

.nb-form p.message {
  margin-left: 7px;
}

/*-- Form Elements --*/

.nb-form form {
  padding: 0 15px 15px 15px;
}

.nb-form input,
.nb-form textarea {
  font-family: Tahoma, Geneva, sans-serif;
  font-size: 12px;
  width: 254px;
  max-width: 254px;
  margin-bottom: 10px;
  margin-left: 7px;
  padding: 6px;
  border: none;
  border-radius: 4px;
  color: #999;
  border-bottom: 1px solid #f0f0f0;
}

.nb-form input:focus,
.nb-form textarea:focus {
  outline: none;
  box-shadow: none;
}

.nb-form input[type='submit'] {
  display: block;
  width: 120px;
  margin: 0 auto;
  padding: 0 20px;
  height: 40px;
  line-height: 40px;
  border-radius: 20px;
  cursor: pointer;
  transition: all .4s ease;
  color: #fff !important;
  border: none;
}

.nb-form input[type='submit']:hover {
  box-shadow: 0 3px 3px 0 rgba(0,0,0,0.07),0 1px 7px 0 rgba(0,0,0,0.02),0 3px 1px -1px rgba(0,0,0,0.1);
}

.nb-form textarea {
  min-height: 110px;
}


.nb-form ::-webkit-input-placeholder {
  color: #ccb0b0;
}

.nb-form ::-moz-placeholder{
  color: #ccb0b0;
}

.nb-form :-ms-input-placeholder {
  color: #ccb0b0;
}

.nb-form :-moz-placeholder {
  color: #ccb0b0;
}

.nb-form input[type='submit'] {
  background: #03a9f4;
}

@media screen and (max-width: 676px) {
  .nb-form:hover .user-icon {
    display: none;
  }

  .nb-form .message {
    display: none;
  }

  .nb-form form {
    padding-top: 15px;
  }
  .nb-form{
    right: 50%;
    bottom: -320px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>

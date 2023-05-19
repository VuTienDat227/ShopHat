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
</template>

<script>
import Header from '../components/Header.vue';
import HomeView from '../views/HomeView.vue';
import Footer from '../components/Footer.vue';
import CartView from '../views/CartView.vue';
import LoginView from '@/views/LoginView.vue';
import { onMounted, ref } from 'vue';
import { onBeforeRouteUpdate, useRoute } from 'vue-router';

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

    const addToCart = (product) => {
      const cartItem = cart.value.find((item) => item.NameProducts === product.NameProducts);
      if (cartItem) {
        cartItem.quantity++;
      } else {
        cart.value.push({
          NameProducts: product.NameProducts,
          Price: product.Price,
          quantity: 1,
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

    return {
      cart,
      addToCart,
      removeFromCart,
      isLoggedIn,
      routeName,
    };
  },
};
</script>

<template>
  <div className="login-container">
    <div class="account section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="login-form border p-5">
              <div class="text-center heading">
                <h2 class="mb-2">Login</h2>
                <p class="lead">
                  Không có tài khoản?
                  <router-link :to="{ name: 'Signup' }">
                   Tạo ngay

                  </router-link>
                </p>
              </div>

              <form @submit.prevent="login">
                <div class="form-group mb-4">
                  <label for="#">Nhập tài khoản</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nhập tài khoản"
                  v-model="userName" required/>
                </div>
                <span v-if="passwordError" class="alert alert-danger">{{ usernameError }}</span>

                <div class="form-group">
                  <label for="#">Nhập mật khẩu</label>
                  <a
                    class="float-right"
                    href=""
                    >Quên mật khẩu?</a
                  >
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Nhập mật khẩu"
                    v-model="password" required/>
                </div>
                <span v-if="passwordError" class="alert alert-danger">{{ passwordError }}</span>

                <button
                  class="btn btn-main mt-3 btn-block"
                  type="submit"
                  >Đăng nhập</button
                >
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '@/axios.js';
export default {
  data(){
    return{
      userName: null,
      password: null,
    }
  },
  computed: {

    usernameError() {
      if (!this.userName) {
        return '';
      }
      if (/\s/.test(this.userName)) {
        return 'Không được nhập khoảng trắng';
      }
      if (this.userName.length < 1 || this.userName.length > 30) {
        return 'Username phải có từ 1 đến 30 ký tự';
      }
      if (this.userName.includes('=')) {
        return 'Username không được chứa ký tự "="';
      }
      return '';
    },
    passwordError() {
      if (!this.password) {
        return '';
      }
      if (/\s/.test(this.password)) {
        return 'Không được nhập khoảng trắng';
      }
      if (this.password.length < 1 || this.password.length > 30) {
        return 'Password phải có từ 1 đến 30 ký tự';
      }
      if (this.password.includes('=')) {
        return 'Password không được chứa ký tự "="';
      }
      return '';
    }
  },
  methods: {
    login() {
      axios.post('/login', {
        UserName: this.userName,
        PasswordUser: this.password,
      },
           {
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
            }
      })
          .then(response => {
            const token = response.data.token;
            const RoleId = response.data.RoleId;
            const Id = response.data.Id;
            localStorage.setItem('token', token);
            localStorage.setItem('Id', Id);
            localStorage.setItem('RoleId', RoleId);
            localStorage.setItem('isLoggedIn', true);
            this.$emit('loggedIn', this.isLoggedIn);
            this.$router.push({ name: 'home' }).then(() => {
              window.location.reload();
            });
          })
          .catch(error => {
            console.log(error.response.data.error);
          });
    }
  }
}
</script>


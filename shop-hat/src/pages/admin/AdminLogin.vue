<template>
  <div className="login-container">
    <div class="account section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="login-form border p-5">
              <div class="text-center heading">
                <h2 class="mb-2">Đăng nhập ADMIN</h2>
                <p class="lead">Chào bạn đến với ADMIN? <a href="#"></a></p>
              </div>

              <form @submit.prevent="login">
                <div class="form-group mb-4">
                  <label for="#">Tên đăng nhập</label>
                  <input
                      type="text"
                      class="form-control"
                      placeholder="Bạn nhập vào đi"
                      v-model="userName"/>
                </div>
                <div class="form-group">
                  <label for="#">Mật khẩu</label>
                  <a
                      class="float-right"
                      href=""
                  >Quên mật khẩu?</a
                  >
                  <input
                      type="text"
                      class="form-control"
                      placeholder="Bạn nhập vào đi"
                      v-model="password"/>
                </div>

                <button
                    class="btn btn-main mt-3 btn-block"
                    type="submit"
                >Đăng nhập</button
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
            localStorage.setItem('token', token);
            localStorage.setItem('RoleId', RoleId);
            localStorage.setItem('isLoggedIn', true);
            this.$emit('loggedIn', this.isLoggedIn);
            if (RoleId === 2) {
              this.$router.push({ name: 'homeAdmin' }).then(() => {
                window.location.reload();
              });
            } else {
              this.$router.push({ name: 'home' }).then(() => {
                window.location.reload();
              });
            }
          })
          .catch(error => {
            console.log(error.response.data.error);
          });
    }
  }
}
</script>


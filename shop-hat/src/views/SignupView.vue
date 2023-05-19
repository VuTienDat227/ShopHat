<template>
  <div className="signUp-container">
    <div class="account section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="login-form border p-5">
              <div class="text-center heading">
                <h2 class="mb-2">Đăng ký</h2>
                <p class="lead">Bạn đã có tài khoản? <a href="/login"> Đăng nhập ngay</a></p>
              </div>

              <form
                action="#"
                @submit.prevent="Signup()">
                <div class="form-group mb-4">
                  <label for="#">Tên của bạn</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nhập tên"
                    v-model="fullName" required/>
                </div>
                <div class="form-group mb-4">
                  <label for="#">Số điện thoại</label>
                  <input
                      type="number"
                      class="form-control"
                      placeholder="Nhập số điện thoại"
                      v-model="PhoneNumber" required />
                </div>
                <div class="form-group mb-4">
                  <label for="#">Địa chỉ</label>
                  <input
                      type="text"
                      class="form-control"
                      placeholder="Nhập thành phố"
                      v-model="Address" required />
                </div>
                <div class="form-group mb-4">
                  <label for="#">Tài khoản</label>
                  <a
                    class="float-right"
                    href=""
                    >Quên mật khẩu?</a
                  >
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nhập tài khoản"
                    v-model="userName" required/>
                </div>
                <span v-if="usernameError" class="alert alert-danger">{{ usernameError }}</span>

                <div class="form-group mb-4">
                  <label for="#">Mật khẩu</label>
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Nhập mật khẩu"
                    v-model="password" required/>
                </div>
                <span v-if="passwordError" class="alert alert-danger">{{ passwordError }}</span>

                <div class="form-group">
                  <label for="#">Nhập lại mật khẩu</label>
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Confirm Password" v-model="confirmPassword" required/>
                </div>
                <span v-if="submitted" class="alert alert-danger">Mật khẩu không khớp!</span>
                <button
                  class="btn btn-main mt-3 btn-block"
                  type="submit">
                  Đăng ký
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '@/axios';

export default {
  data() {
    return {
      userName: '',
      password: '',
      fullName: null,
      PhoneNumber: null,
      Address : null,
      confirmPassword: null,
      submitted: false
    };
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
    Signup() {
      if(this.password !== this.confirmPassword){
        this.submitted = true;
        return;
      }else {
        this.submitted = false;
      }

      axios
        .post(
          '/register',
          {
            UserName: this.userName,
            PasswordUser: this.password,
            FullName: this.fullName,
            PhoneNumber: this.PhoneNumber,
            Address: this.Address
          },
          {
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
            },
          }
        )
        .then((response) => {
          const token = response.data.token;
          localStorage.setItem('token', token);
          localStorage.setItem('isLoggedIn', true);
          this.$emit('loggedIn', this.isLoggedIn);
          this.$router.push({ name: 'home' }).then(() => {
            window.location.reload();
          });
        })
        .catch((error) => {
          console.log(error.response.data.error);
        });
    },
  },
};
</script>

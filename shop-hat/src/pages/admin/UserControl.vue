<template>
  <div class="container-fluid">
    <h1>Quản lý User</h1>
    <button data-toggle="modal" data-target="#AddUser" @click="reData"
      class="btn btn-success p-1 rounded mr-3 mb-1 float-left"><i class="fa-solid fa-square-plus"></i>
      Thêm user
    </button>
    <table class="table-bordered" id="dataUserTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Tên tài khoản</th>
          <th>Tên người dùng</th>
          <th>Số điện thoại</th>
          <th>Địa chỉ</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in dataUser" :key="index">
          <td>{{ index }}</td>
          <td>{{ user.UserName }}</td>
          <td>{{ user.FullName }}</td>
          <td>{{ user.PhoneNumber }}</td>
          <td>{{ user.Address }}</td>
          <td>{{ user.Email }}</td>
          <td style="width: 16em">
            <button class="btn btn-primary p-1 rounded mr-1" data-toggle="modal" data-target="#EditUser"
              @click="getIdUser(user.id)">
              <i class="fa-solid fa-pen-to-square"></i>
              Sửa
            </button>
            |
            <button class="btn btn-danger p-1 rounded ml-1" @click="deleteUser(user.id)">
              <i class="fa-regular fa-trash-can" ></i>
              Xóa
            </button>
            |
            <button class="btn btn-warning p-1 rounded ml-1" data-toggle="modal" data-target="#DetailsUser" @click="getIdUser(user.id)">
              <i class="fa-regular fa-trash-can" ></i>
              Chi Tiết
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!--    add người dùng -->
    <div class="modal fade" id="AddUser" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="AddUserLabel">Thêm người dùng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reData">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                <div class="form-group mb-3">
                  <label for="userName">Tên tài khoản</label>
                  <input type="text" v-model="userName" class="form-control" id="userName" required>
                  <span v-if="usernameError !== ''" class="alert alert-danger">{{ usernameError }}</span>

                </div>
                <div class="form-group mb-3">
                  <label for="password">Mật khẩu</label>
                  <input type="password" v-model="password" class="form-control" id="password" required>
                  <span v-if="passwordError !== ''" class="alert alert-danger">{{ passwordError }}</span>

                </div>
                <div class="form-group mb-3">
                  <label for="fullName">Tên người dùng</label>
                  <input type="text" v-model="fullName" class="form-control" id="fullName" required>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">

                <div class="form-group mb-3">
                  <label for="PhoneNumber">Số điện thoại</label>
                  <input type="text" v-model="PhoneNumber" class="form-control" id="PhoneNumber" required>
                  <span v-if="isInvalidInput" class="alert-danger alert">Vui lòng chỉ nhập số</span>
                </div>
                <div class="form-group mb-3">
                  <label for="Address">Địa chỉ</label>
                  <input type="text" v-model="Address" class="form-control" id="Address" required>
                </div>
                <div class="form-group mb-3">
                  <label for="Email">Email</label>
                  <input type="text" v-model="Email" class="form-control" id="Email" required>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="reData">Close</button>
              <button type="button" class="btn btn-primary" :disabled="isDisabled" v-on:click="addUser">Lưu </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--   edit -->
    <div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="EditUserLabel">Sửa người dùng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reData">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                <div class="form-group mb-3">
                  <input type="hidden" v-model="idUser" />
                  <label for="userName">Tên tài khoản</label>
                  <input type="text" v-model="userName" class="form-control" id="userName" required>
                  <span v-if="usernameError !== ''" class="alert alert-danger">{{ usernameError }}</span>

                </div>
                
                <div class="form-group mb-3">
                  <label for="fullName">Tên người dùng</label>
                  <input type="text" v-model="fullName" class="form-control" id="fullName" required>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">

                <div class="form-group mb-3">
                  <label for="PhoneNumber">Số điện thoại</label>
                  <input type="text" v-model="PhoneNumber" class="form-control" id="PhoneNumber" required>
                  <span v-if="isInvalidInput" class="alert-danger alert">Vui lòng chỉ nhập số</span>
                </div>
                <div class="form-group mb-3">
                  <label for="Address">Địa chỉ</label>
                  <input type="text" v-model="Address" class="form-control" id="Address" required>
                </div>
                <div class="form-group mb-3">
                  <label for="Email">Email</label>
                  <input type="text" v-model="Email" class="form-control" id="Email" required>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="reData">Close</button>
              <button type="button" class="btn btn-primary" :disabled="isDisabled" v-on:click="EditUser(idUser)">Lưu </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="DetailsUser" tabindex="-1" role="dialog" aria-labelledby="DetailsUserLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="DetailsUserLabel">Chi tiết người dùng</h5>
            <button type="button" @click="reData" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                <div class="form-group mb-3">
                  <input type="hidden" v-model="idUser" />
                  <label for="userName">Tên tài khoản</label>
                  <input type="text" v-model="userName" class="form-control" id="userName" readonly>
                  <span v-if="usernameError !== ''" class="alert alert-danger">{{ usernameError }}</span>

                </div>
                <div class="form-group mb-3">
                  <label for="password">Mật khẩu</label>
                  <input type="password" v-model="password" class="form-control" id="password" readonly>
                  <span v-if="passwordError !== ''" class="alert alert-danger">{{ passwordError }}</span>

                </div>
                <div class="form-group mb-3">
                  <label for="fullName">Tên người dùng</label>
                  <input type="text" v-model="fullName" class="form-control" id="fullName" readonly>
                </div>
              </div>
              <div class="col-12 col-md-6 col-sm-6 col-lg-6">

                <div class="form-group mb-3">
                  <label for="PhoneNumber">Số điện thoại</label>
                  <input type="text" v-model="PhoneNumber" class="form-control" id="PhoneNumber" readonly>
                  <span v-if="isInvalidInput" class="alert-danger alert">Vui lòng chỉ nhập số</span>
                </div>
                <div class="form-group mb-3">
                  <label for="Address">Địa chỉ</label>
                  <input type="text" v-model="Address" class="form-control" id="Address" readonly>
                </div>
                <div class="form-group mb-3">
                  <label for="Email">Email</label>
                  <input type="email" v-model="Email" class="form-control" id="Email" readonly>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="reData" data-dismiss="modal">Close</button>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from '@/axios.js';

export default {
  name: "UserControl",
  data() {
    return {
      dataUser: "",
      idUser: '',
      userName: '',
      password: '',
      fullName: null,
      PhoneNumber: null,
      Address: null,
      Email: null,
      submitted: false,
      isInvalidInput: false
    }
  },
  mounted() {
    const admin = localStorage.getItem('RoleId');
    axios.post('/getUserAdmin', { admin: admin })
      .then((response) => {
        this.dataUser = response.data.users;
        return Promise.resolve();
      })
      .then(() => {
        $("#dataUserTable").DataTable({
          'columnDefs': [{
            'targets': [-1],
            'orderable': false,
          }],
          searching: true,
          iDisplayLength: 6,
          "ordering": false,
          lengthChange: false,
          aaSorting: [[0, "desc"]],
          aLengthMenu: [
            [5, 10, 25, 50, 100, -1],

            ["5 dòng", "10 dòng", "25 dòng", "50 dòng", "100 dòng", "Tất cả"],
          ],
          language: {
            "processing": "Đang xử lý...",
            "aria": {
              "sortAscending": ": Sắp xếp thứ tự tăng dần",
              "sortDescending": ": Sắp xếp thứ tự giảm dần"
            },
            "autoFill": {
              "cancel": "Hủy",
              "fill": "Điền tất cả ô với <i>%d<\/i>",
              "fillHorizontal": "Điền theo hàng ngang",
              "fillVertical": "Điền theo hàng dọc"
            },
            "buttons": {
              "collection": "Chọn lọc <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
              "colvis": "Hiển thị theo cột",
              "colvisRestore": "Khôi phục hiển thị",
              "copy": "Sao chép",
              "copyKeys": "Nhấn Ctrl hoặc u2318 + C để sao chép bảng dữ liệu vào clipboard.<br \/><br \/>Để hủy, click vào thông báo này hoặc nhấn ESC",
              "copySuccess": {
                "1": "Đã sao chép 1 dòng dữ liệu vào clipboard",
                "_": "Đã sao chép %d dòng vào clipboard"
              },
              "copyTitle": "Sao chép vào clipboard",
              "pageLength": {
                "-1": "Xem tất cả các dòng",
                "_": "Hiển thị %d dòng",
                "1": "Hiển thị 1 dòng"
              },
              "print": "In ấn",
              "createState": "Tạo trạng thái",
              "csv": "CSV",
              "excel": "Excel",
              "pdf": "PDF",
              "removeAllStates": "Xóa hết trạng thái",
              "removeState": "Xóa",
              "renameState": "Đổi tên",
              "savedStates": "Trạng thái đã lưu",
              "stateRestore": "Trạng thái %d",
              "updateState": "Cập nhật"
            },
            "select": {
              "cells": {
                "1": "1 ô đang được chọn",
                "_": "%d ô đang được chọn"
              },
              "columns": {
                "1": "1 cột đang được chọn",
                "_": "%d cột đang được được chọn"
              },
              "rows": {
                "1": "1 dòng đang được chọn",
                "_": "%d dòng đang được chọn"
              }
            },
            "searchBuilder": {
              "title": {
                "_": "Thiết lập tìm kiếm (%d)",
                "0": "Thiết lập tìm kiếm"
              },
              "button": {
                "0": "Thiết lập tìm kiếm",
                "_": "Thiết lập tìm kiếm (%d)"
              },
              "value": "Giá trị",
              "clearAll": "Xóa hết",
              "condition": "Điều kiện",
              "conditions": {
                "date": {
                  "after": "Sau",
                  "before": "Trước",
                  "between": "Nằm giữa",
                  "empty": "Rỗng",
                  "equals": "Bằng với",
                  "not": "Không phải",
                  "notBetween": "Không nằm giữa",
                  "notEmpty": "Không rỗng"
                },
                "number": {
                  "between": "Nằm giữa",
                  "empty": "Rỗng",
                  "equals": "Bằng với",
                  "gt": "Lớn hơn",
                  "gte": "Lớn hơn hoặc bằng",
                  "lt": "Nhỏ hơn",
                  "lte": "Nhỏ hơn hoặc bằng",
                  "not": "Không phải",
                  "notBetween": "Không nằm giữa",
                  "notEmpty": "Không rỗng"
                },
                "string": {
                  "contains": "Chứa",
                  "empty": "Rỗng",
                  "endsWith": "Kết thúc bằng",
                  "equals": "Bằng",
                  "not": "Không phải",
                  "notEmpty": "Không rỗng",
                  "startsWith": "Bắt đầu với",
                  "notContains": "Không chứa",
                  "notEndsWith": "Không kết thúc với",
                  "notStartsWith": "Không bắt đầu với"
                },
                "array": {
                  "equals": "Bằng",
                  "empty": "Trống",
                  "contains": "Chứa",
                  "not": "Không",
                  "notEmpty": "Không được rỗng",
                  "without": "không chứa"
                }
              },
              "logicAnd": "Và",
              "logicOr": "Hoặc",
              "add": "Thêm điều kiện",
              "data": "Dữ liệu",
              "deleteTitle": "Xóa quy tắc lọc",
              "leftTitle": "Giảm thụt lề",
              "rightTitle": "Tăng thụt lề"
            },
            "searchPanes": {
              "countFiltered": "{shown} ({total})",
              "emptyPanes": "Không có phần tìm kiếm",
              "clearMessage": "Xóa hết",
              "loadMessage": "Đang load phần tìm kiếm",
              "collapse": {
                "0": "Phần tìm kiếm",
                "_": "Phần tìm kiếm (%d)"
              },
              "title": "Bộ lọc đang hoạt động - %d",
              "count": "{total}",
              "collapseMessage": "Thu gọn tất cả",
              "showMessage": "Hiện tất cả"
            },
            "datetime": {
              "hours": "Giờ",
              "minutes": "Phút",
              "next": "Sau",
              "previous": "Trước",
              "seconds": "Giây",
              "amPm": [
                "am",
                "pm"
              ],
              "unknown": "-",
              "weekdays": [
                "Chủ nhật"
              ],
              "months": [
                "Tháng Một",
                "Tháng Hai",
                "Tháng Ba",
                "Tháng Tư",
                "Tháng Năm",
                "Tháng Sáu",
                "Tháng Bảy",
                "Tháng Tám",
                "Tháng Chín",
                "Tháng Mười",
                "Tháng Mười Một",
                "Tháng Mười Hai"
              ]
            },
            "emptyTable": "Không có dữ liệu",
            "info": "Hiển thị _START_ tới _END_ của _TOTAL_ dữ liệu",
            "infoEmpty": "Hiển thị 0 tới 0 của 0 dữ liệu",
            "lengthMenu": "Hiển thị _MENU_ dữ liệu",
            "loadingRecords": "Đang tải...",
            "paginate": {
              "first": "Đầu tiên",
              "last": "Cuối cùng",
              "next": "Sau",
              "previous": "Trước"
            },
            "search": "Tìm kiếm:",
            "zeroRecords": "Không tìm thấy kết quả",
            "decimal": ",",
            "editor": {
              "close": "Đóng",
              "create": {
                "button": "Thêm",
                "submit": "Thêm",
                "title": "Thêm mục mới"
              },
              "edit": {
                "button": "Sửa",
                "submit": "Cập nhật",
                "title": "Sửa mục"
              },
              "error": {
                "system": "Đã xảy ra lỗi hệ thống (&lt;a target=\"\\\" rel=\"nofollow\" href=\"\\\"&gt;Thêm thông tin&lt;\/a&gt;)."
              },
              "multi": {
                "info": "Các mục đã chọn chứa các giá trị khác nhau cho đầu vào này. Để chỉnh sửa và đặt tất cả các mục cho đầu vào này thành cùng một giá trị, hãy nhấp hoặc nhấn vào đây, nếu không chúng sẽ giữ lại các giá trị riêng lẻ của chúng.",
                "noMulti": "Đầu vào này có thể được chỉnh sửa riêng lẻ, nhưng không phải là một phần của một nhóm.",
                "restore": "Hoàn tác thay đổi",
                "title": "Nhiều giá trị"
              },
              "remove": {
                "button": "Xóa",
                "confirm": {
                  "_": "Bạn có chắc chắn muốn xóa %d hàng không?",
                  "1": "Bạn có chắc chắn muốn xóa 1 hàng không?"
                },
                "submit": "Xóa",
                "title": "Xóa"
              }
            },
            "infoFiltered": "(được lọc từ _MAX_ dữ liệu)",
            "searchPlaceholder": "Nhập tìm kiếm...",
            "stateRestore": {
              "creationModal": {
                "button": "Thêm",
                "columns": {
                  "search": "Tìm kiếm cột",
                  "visible": "Khả năng hiển thị cột"
                },
                "name": "Tên:",
                "order": "Sắp xếp",
                "paging": "Phân trang",
                "scroller": "Cuộn vị trí",
                "search": "Tìm kiếm",
                "searchBuilder": "Trình tạo tìm kiếm",
                "select": "Chọn",
                "title": "Thêm trạng thái",
                "toggleLabel": "Bao gồm:"
              },
              "duplicateError": "Trạng thái có tên này đã tồn tại.",
              "emptyError": "Tên không được để trống.",
              "emptyStates": "Không có trạng thái đã lưu",
              "removeConfirm": "Bạn có chắc chắn muốn xóa %s không?",
              "removeError": "Không xóa được trạng thái.",
              "removeJoiner": "và",
              "removeSubmit": "Xóa",
              "removeTitle": "Xóa trạng thái",
              "renameButton": "Đổi tên",
              "renameLabel": "Tên mới cho %s:",
              "renameTitle": "Đổi tên trạng thái"
            },
            "infoThousands": ".",
            "thousands": "."
          },
        }).catch(error => {
          console.log(error)
        });
      });


  },
  computed: {
    isInvalidInput() {
      return isNaN(this.PhoneNumber);
    },
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
    },
    isDisabled() {
      return (
        this.isInvalidInput ||
        this.usernameError !== '' ||
        this.passwordError !== ''
      );
    },
  },
  methods: {
    reData() {
      this.idUser = "";
      this.userName = "";
      this.fullName = "";
      this.PhoneNumber = "";
      this.Address = "";
      this.Email = "";
    },
    getIdUser(id) {
      axios.get(`/getAllFillById/${id}`)
        .then((res) => {
          this.idUser = res.data.data.id;
          this.userName = res.data.data.UserName;
          this.fullName = res.data.data.FullName;
          this.PhoneNumber = res.data.data.PhoneNumber;
          this.Address = res.data.data.Address;
          this.Email = res.data.data.Email;

        }).catch(er => {
          console.log(er);
        })
    },
    EditUser(id) {
      axios.post(`/usersUpdateByAdmin/${id}`, {
        UserName: this.userName,
        FullName: this.fullName,
        Email: this.Email,
        PhoneNumber: this.PhoneNumber,
        Address: this.Address,
      }).then(ressponse => {
        Swal.fire({
          icon: 'success',
          title: 'Thành công',
          text: 'Đã lưu thành công',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        })
      }).catch(er => {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Đã có lỗi xảy ra server',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          })
        });
    },
    deleteUser(id) {
      Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "User này sẽ bị xóa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`/userDeleteId/${id}`)
            .then((response) => {
              console.log(response.data);
              Swal.fire(
                'Đã xóa!',
                'User đã xóa',
                'success'
              );
              window.location.reload();

            })
            .catch((error) => {
              console.error(error);
              Swal.fire(
                'Lỗi',
                'Lỗi xóa',
                'error'
              );
            });
        }
      });
    },
    addUser() {
      axios.post(
        '/register',
        {
          UserName: this.userName,
          PasswordUser: this.password,
          FullName: this.fullName,
          Email: this.Email,
          PhoneNumber: this.PhoneNumber,
          Address: this.Address
        },
        {
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
        }
      ).then((response) => {
        Swal.fire({
          icon: 'success',
          title: 'Thành công',
          text: 'Đã lưu thành công',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        }).catch(er => {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Đã có lỗi xảy ra server',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          });
        });
      })
    }
  }
}
</script>

<style scoped></style>
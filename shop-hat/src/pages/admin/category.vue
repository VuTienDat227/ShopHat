<template>
  <div class="container-fluid">
    <h2>Category List</h2>
    <button data-toggle="modal" data-target="#AddCate" class="btn btn-success p-1 rounded mr-3 mb-1 float-left"><i class="fa-solid fa-square-plus"></i>
      Add
    </button>
    <table class="table table-bordered" id="getListItemsCate">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="w-25">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Details</th>
        <th scope="col">Action</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(category, index) in categories">
        <td>{{ index }}</td>
        <td>
          <img :src="category.image" alt="Category Image" style="width: 60px;"/>
        </td>
        <td>{{ category.CateName }}</td>
        <td>{{ category.Details }}</td>
        <td>
          <button v-on:click="editByCate(category.id)" class="btn btn-primary p-1 rounded mr-1" data-toggle="modal" data-target="#EditCate">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit
          </button>
          |
          <button class="btn btn-danger p-1 rounded ml-1" @click="deleteCategory(category.id)" >
            <i class="fa-regular fa-trash-can"></i>
            Delete
          </button>
        </td>
      </tr>

      </tbody>
    </table>
  </div>
  <!--   add product-->
  <div class="modal fade" id="EditCate" tabindex="-1" role="dialog" aria-labelledby="EditCateLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditCateLabel">Sửa danh mục</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <input type="hidden" v-model="cateID">
              <div class="form-group mb-3">
                <label for="NameProducts">Tên danh mục</label>
                <input type="text" v-model="Name" class="form-control" id="NameProducts" required>
              </div>
              <div class="form-group mb-3">
                <label for="Details">Chi tiết</label>
                <input type="text" v-model="Details" class="form-control" id="Details" required>
              </div>
            </div>
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center" v-if="Image">
                  <img :src="Image" style="width: 50%"/>
                  <p class="text-center">Ảnh đang có</p>
                </div>
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <label>
                    Chọn ảnh
                  </label>
                  <input type="file" ref="image3" v-on:change="onFileChange" accept="image/*" required>
                  <img :src="previewImage" alt="" style="width:50%"/>
                  <p class="text-center">Ảnh mới</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" v-on:click="editCate(cateID)">Lưu thay đổi</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="AddCate" tabindex="-1" role="dialog" aria-labelledby="AddCateLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AddCateLabel">Thêm danh mục</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="form-group mb-3">
                <label for="NameProducts">Tên danh mục</label>
                <input type="text" v-model="Name" class="form-control" id="NameProducts" required>
              </div>
              <div class="form-group mb-3">
                <label for="Details">Chi tiết</label>
                <input type="text" v-model="Details" class="form-control" id="Details" required>
              </div>
            </div>
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center" v-if="Image">
                  <img :src="Image" style="width: 50%"/>
                  <p class="text-center">Ảnh đang có</p>
                </div>
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <label>
                    Chọn ảnh
                  </label>
                  <input type="file" ref="image4" v-on:change="onFileChange" accept="image/*" required>
                  <img :src="previewImage" alt="" style="width:50%"/>
                  <p class="text-center">Ảnh mới</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-primary" v-on:click="addCategory(cateID)">Lưu </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.btn {
  font-size: 16px;
}
</style>

<script>
import axios from "@/axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      categories: [],
      cateID: null,
      Image: null,
      Name: null,
      Details: null,
      imageFile: null,
      previewImage: null,
      uploadedImage: null,
    };
  },
  mounted() {

    axios.get('/getCategory').then((response) => {
      this.categories = response.data.data;
      console.log(this.categories);
    })
        .then(() => {
          $("#getListItemsCate").DataTable({
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
          });
        });

  },
  methods: {
    onFileChange(event) {
      this.imageFile = event.target.files[0];
      this.previewImage = URL.createObjectURL(this.imageFile);
      this.uploadedImage = null;
    },
    deleteCategory(categoryId) {
      Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Sản phẩm này sẽ bị xóa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios
              .delete(`/category/${categoryId}`)
              .then((response) => {
                console.log(response.data);
                Swal.fire(
                    'Đã xóa!',
                    'Sản phẩm đã xóa',
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
    editByCate(id) {
      axios.get(`/categoryGetId/${id}`)
          .then(res => {
            this.cateID = res.data.data.id;
            this.Image = res.data.data.image;
            this.Name = res.data.data.CateName;
            this.Details = res.data.data.Details;
          }).catch((error) => {
        console.error(error);

      });
    },
    async editCate(id) {
      if (!this.Image || !this.Name || !this.Details) {
        Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Kiểm tra đã nhập các dữ liệu',
          confirmButtonText: 'OK'
        });
        return;

      }
      try {
        const formData = new FormData();
        formData.append('CateName', this.Name);
        formData.append('Details', this.Details);
        formData.append('image', this.$refs.image3.files[0]);

        await axios.post(`/categoryEdit/${id}`, formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            });
        Swal.fire({
          icon: 'success',
          title: 'Thành công',
          text: 'Đã lưu thành công',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      } catch (error) {
        console.error(error);
        Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Đã có lỗi xảy ra',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      }
    },
    async addCategory() {
      if (!this.$refs.image4.files[0] || !this.Name || !this.Details) {
        Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Kiểm tra đã nhập các dữ liệu',
          confirmButtonText: 'OK'
        });
        return;

      }
      try {
        const formData = new FormData();
        formData.append('CateName', this.Name);
        formData.append('Details', this.Details);
        formData.append('image', this.$refs.image4.files[0]);

        await axios.post(`/category`, formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            });
        Swal.fire({
          icon: 'success',
          title: 'Thành công',
          text: 'Đã lưu thành công',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      } catch (error) {
        console.error(error);
        Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Đã có lỗi xảy ra',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      }
    },
  }
}
</script>
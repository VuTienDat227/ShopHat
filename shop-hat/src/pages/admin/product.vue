<template>
  <div class="container-fluid">
    <h2>Quản lý sản phẩm</h2>
    <button data-toggle="modal" data-target="#AddProduct" class="btn btn-success p-1 rounded mr-3 mb-1 float-left"><i
        class="fa-solid fa-square-plus"></i>
      Thêm sản phẩm
    </button>
    <table class="table table-bordered" id="getListItems">
      <thead>
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Ảnh</th>
          <th scope="col">Tên sản phẩm</th>
          <th scope="col">Giá</th>
          <th scope="col" style="width:4em">Số lượng</th>
          <th scope="col">Loại mũ</th>
          <th scope="col">Hành động</th>
          
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, index) in products" :key="product.id">
          <td>{{ index }}</td>
          <td>
            <img :src="product.image" alt="Product Image" style="width: 60px;" />
          </td>
          <td>{{ product.NameProducts }}</td>
          

          <td style="width: 4em;">{{ formatCurrency(product.Price) }}</td>
          <td>{{ product.Stock }}</td>
          <td>{{ (product.CateName) }}</td>
          <td>
            <button v-on:click="getDetailsProduct(product.id)" class="btn btn-primary p-1 rounded mr-1"
              data-toggle="modal" data-target="#EditProduct">
              <i class="fa-solid fa-pen-to-square"></i>
              Sửa
            </button>
            |
            <button v-on:click="getDetailsProduct(product.id)" class="btn btn-warning p-1 rounded mr-1"
              data-toggle="modal" data-target="#DetailsProduct">
              <i class="fa-solid fa-pen-to-square"></i>
              Chi tiết
            </button>
            |
            <button class="btn btn-danger p-1 rounded ml-1" @click="deleteProduct(product.id)">
              <i class="fa-regular fa-trash-can"></i>
              Xóa
            </button>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
  <!-- Modal -->
  <div class="modal fade" id="EditProduct" tabindex="-1" role="dialog" aria-labelledby="EditProductLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditProductLabel">Sửa sản phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" v-on:click="resetData">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <input type="hidden" v-model="productId">
              <div class="form-group mb-3">
                <label for="NameProducts">Tên sản phẩm</label>
                <input type="text" v-model="NameProducts" class="form-control" id="NameProducts" required>
              </div>
              <div class="form-group mb-3">
                <label for="Details">Chi tiết</label>
                <ckeditor :editor="editor" v-model="Details" :config="editorConfig"></ckeditor>


              </div>
              <div class="form-group mb-3">
                <label for="Price">Giá sản phẩm</label>
                <input type="text" v-model="Price" class="form-control" id="Price" required>
              </div>
              <div class="form-group mb-3">
                <label for="Stock">Số lượng sản phẩm</label>
                <input type="text" v-model="Stock" class="form-control" id="Stock" required>
              </div>
              <div class="form-group mb-3">
                <select class="form-control" v-model="isSeller">
                  <option value="1">Bán chạy</option>
                  <option value="2">Không</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="CateId">Tên danh mục</label>
                <select class="form-control" v-model="CateId">
                  <option v-for="cate in categories" :value="cate.id">{{ cate.CateName }}</option>
                </select>
              </div>

            </div>
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <img :src="image" style="width: 50%" />
                  <p class="text-center">Ảnh đang có</p>
                </div>
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <label>
                    Chọn ảnh
                  </label>
                  <input type="file" ref="image4" v-on:change="onFileChange" accept="image/*">
                  <img :src="previewImage" alt="" style="width:50%" />
                  <p class="text-center">Ảnh mới</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="resetData">Đóng</button>
          <button type="button" class="btn btn-primary" v-on:click="editProducts(productId)">Lưu thay đổi</button>
        </div>

      </div>
    </div>
  </div>
  <!-- chi tiết modal -->
  <div class="modal fade" id="DetailsProduct" tabindex="-1" role="dialog" aria-labelledby="DetailsProductLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DetailsProductLabel">Chi tiết sản phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" v-on:click="resetData">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <input type="hidden" v-model="productId">
              <div class="form-group mb-3">
                <label for="NameProducts">Tên sản phẩm</label>
                <input type="text" v-model="NameProducts" class="form-control" id="NameProducts" readonly>
              </div>
              <div class="form-group mb-3">
                <label for="Details">Chi tiết</label>
                <ckeditor :editor="editor" v-model="Details" :config="editorConfig" ></ckeditor>


              </div>
              <div class="form-group mb-3">
                <label for="Price">Giá sản phẩm</label>
                <input type="text" v-model="Price" class="form-control" id="Price" readonly>
              </div>
              <div class="form-group mb-3">
                <label for="Stock">Số lượng sản phẩm</label>
                <input type="text" v-model="Stock" class="form-control" id="Stock" readonly>
              </div>
              <div class="form-group mb-3">
                <select class="form-control" v-model="isSeller" disabled>
                  <option value="1">Bán chạy</option>
                  <option value="2">Không</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="CateId">Tên danh mục</label>
                <select class="form-control" v-model="CateId" disabled>
                  <option v-for="cate in categories" :value="cate.id">{{ cate.CateName }}</option>
                </select>
              </div>

            </div>
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <img :src="image" style="width: 50%" />
                  <p class="text-center">Ảnh đang có</p>
                </div>

              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="resetData">Đóng</button>
        </div>

      </div>
    </div>
  </div>
  <!--   add product-->
  <div class="modal fade" id="AddProduct" tabindex="-1" role="dialog" aria-labelledby="AddProductLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AddProductLabel">Thêm sản phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="form-group mb-3">
                <label for="NameProducts">Tên sản phẩm</label>
                <input type="text" v-model="NameProducts" class="form-control" id="NameProducts" required>
              </div>
              <div class="form-group mb-3">
                <label for="Details">Chi tiết</label>
                <ckeditor :editor="editor" v-model="Details" :config="editorConfig"></ckeditor>

                <!--                <input type="text"  class="form-control" id="Details" required>-->
              </div>
              <div class="form-group mb-3">
                <label for="Price">Giá sản phẩm</label>
                <input type="text" v-model="Price" class="form-control" id="Price" required>
              </div>
              <div class="form-group mb-3">
                <label for="Stock">Số lượng sản phẩm</label>
                <input type="text" v-model="Stock" class="form-control" id="Stock" required>
              </div>
              <div class="form-group mb-3">
                <label for="isSeller">Sản phẩm bán chạy</label>
                <select class="form-control" v-model="isSeller">
                  <option value="1">Bán chạy</option>
                  <option value="2">Không</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="CateId">Tên danh mục</label>
                <select class="form-control" v-model="CateId">
                  <option v-for="cate in categories" :value="cate.id">{{ cate.CateName }}</option>
                </select>
              </div>

            </div>
            <div class="col-12 col-md-6 col-sm-6 col-lg-6">
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center" v-if="image">
                  <img :src="image" style="width: 50%" />
                  <p class="text-center">Ảnh đang có</p>
                </div>
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <label>
                    Chọn ảnh
                  </label>
                  <input type="file" ref="image3" v-on:change="onFileChange" accept="image/*" required>
                  <img :src="previewImage" alt="" style="width:50%" />
                  <p class="text-center">Ảnh mới</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" v-on:click="addProducts()">Lưu </button>
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
import Swal from "sweetalert2";
import axios from '@/axios.js';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
  components: {
    ckeditor: CKEditor.component
  },
  data() {
    return {
      editor: ClassicEditor,

      editorConfig: {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
          options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
          ]
        },
        image: {
          toolbar: ['imageTextAlternative', '|', 'imageStyle:full', 'imageStyle:side'],
          styles: [
            'full',
            'side'
          ]
        },
      },
      readonlyCk: false,
      products: [],
      categories: [],
      productId: null,
      NameProducts: null,
      Details: null,
      Price: null,
      Stock: null,
      isSeller: null,
      CateId: null,
      image: null,
      cateName: null,
      imageFile: null,
      previewImage: null,
      uploadedImage: null,
      userApi: [],
    };
  },

  mounted() {

    axios.get(`/getUserAllAuth`)
      .then((res) => {
        this.userApi = res.data.data;
        console.log(this.userApi);
        return Promise.resolve();

      })
    axios.get("/getProducts")
      .then((response) => {
        this.products = response.data.data;
        return Promise.resolve();
      })
      .then(() => {
        $("#getListItems").DataTable({
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


    axios.get('/getCategory').then((response) => {
      this.categories = response.data.data;
      console.log(this.categories);
    });
  },
  methods: {
    onFileChange(event) {
      this.imageFile = event.target.files[0];
      this.previewImage = URL.createObjectURL(this.imageFile);
      this.uploadedImage = null;
    },
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
    getCategoryName(categoryId) {
      const category = this.categories.find((c) => c.id === categoryId);
      return category ? category.name : 'Unknown';
    },
    deleteProduct(productId) {
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
            .delete(`/products/${productId}`)
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
    resetData() {
      this.productId = null;
      this.NameProducts = null;
      this.Details = '';
      this.Price = null;
      this.Stock = null;
      this.isSeller = null;
      this.CateId = null;
      this.image = null;
      this.readonlyCk = false;

    },
    getDetailsProduct(id) {
      axios.get(`/productsDetails/${id}`)
        .then(res => {
          this.productId = res.data.data.id;
          this.NameProducts = res.data.data.NameProducts;
          this.Details = res.data.data.Details;
          this.Price = res.data.data.Price;
          this.Stock = res.data.data.Stock;
          this.isSeller = res.data.data.isSeller;
          this.CateId = res.data.data.CateId;
          this.image = res.data.data.image;
          this.readonlyCk = true;
          console.log(res);

          return Promise.resolve();
        }).catch((error) => {
          console.error(error);

        });
    },
    async addProducts() {
      try {
        if (!this.NameProducts || !this.Details || !this.Price || !this.Stock || !this.CateId) {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Kiểm tra đã nhập các dữ liệu',
            confirmButtonText: 'OK'
          });
          return;

        }
        const formData = new FormData();
        formData.append('NameProducts', this.NameProducts);
        formData.append('Details', this.Details);
        formData.append('Price', this.Price);
        formData.append('Stock', this.Stock);
        formData.append('isSeller', this.isSeller);
        formData.append('CateId', this.CateId);
        formData.append('image', this.$refs.image3.files[0]);

        await axios.post('/products', formData,
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
          text: 'Đã có lỗi xảy ra server',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      }
    },
    async editProducts(id) {
      if (!this.NameProducts || !this.Details || !this.Price || !this.Stock || !this.CateId) {
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
        formData.append('NameProducts', this.NameProducts);
        formData.append('Details', this.Details);
        formData.append('Price', this.Price);
        formData.append('Stock', this.Stock);
        formData.append('isSeller', this.isSeller);
        formData.append('CateId', this.CateId);
        formData.append('image', this.$refs.image4.files[0]);

        await axios.post(`/productsEdit/${id}`, formData,
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


  },

}
</script>
<style scoped>
.pagination .page-item .page-link {
  width: 100px;
}
.dataTables_filter{
  float: right !important;
}
</style>
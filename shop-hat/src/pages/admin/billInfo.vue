<template>
  <div class="container-fluid">
    <h2>Chi tiết đơn hàng</h2>
    
    <table class="table table-bordered" id="getOrder">
      <thead>
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Tên khách hàng</th>
          <th scope="col">Số điện thoại</th>
          <th scope="col">Email</th>
          <th scope="col">Địa chỉ</th>
          <th scope="col">Tổng tiền</th>
          <th scope="col">Trạng thái khách</th>
          <th scope="col">Xác nhận</th>
          <th scope="col" style="width: 200px;">Hành động</th>


        </tr>
      </thead>
      <tbody>
        <tr v-for="(bill, index) in billInfor">
          <td>

            {{ index }}

          </td>

          <td>{{ bill.user.FullName }}</td>
          <td>{{ bill.user.PhoneNumber }}</td>
          <td>{{ bill.user.Email }}</td>
          <td>{{ bill.user.Address }}</td>
          <td>{{ formatCurrency(bill.TotalPay) }}</td>
          <td>
            <span v-if="bill.Status === 0" class="text-success">Đã hoàn thành</span>
            <span v-else class="text-danger">Chưa hoàn thành</span>
          </td>
          <td style="width: 200px">
            <span v-if="bill.StatusForAdmin === 1 && bill.isCheck === 0" class="text-success">Đã hoàn thành</span>
            <span v-else-if="bill.isCheck === 1" class="text-danger">Đã bị hủy</span>
            <div v-else>
              <button class="btn btn-primary p-1 rounded mr-1" @click="confirmAdmin(bill.id)">
                <i class="fa-solid fa-pen-to-square"></i>
                Xác nhận
              </button>
              <button class="btn btn-warning p-1 rounded ml-1" @click="destroyOrder(bill.id)">
                <i class="fa-regular fa-trash-can"></i>
                Hủy
              </button>

            </div>

          </td>

          <td>
            <button class="btn btn-danger p-1 rounded ml-1" @click="orderDelete(bill.id)">
              <i class="fa-regular fa-trash-can"></i>
              Xóa
            </button>
            <button class="btn btn-success p-1 rounded ml-1" data-toggle="modal" data-target="#DetailsOrder"
              @click="getOrderById(bill.id)">
              <i class="fa-solid fa-circle-info"></i>
              Chi Tiết
            </button>

          </td>

        </tr>

      </tbody>
    </table>
  </div>
  <div class="modal fade" id="DetailsOrder" tabindex="-1" role="dialog" aria-labelledby="DetailsOrderLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DetailsOrderLabel">Chi tiết</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row" v-for="(getOrder, index) in orderItems" :key="index"
            style="border-bottom: 1px solid rgba(0,0,0,.1);margin-bottom: 24px;">
            <div class="col-12 col-md-4 col-lg-4">
              <img :src="getOrder.product.image" style="width: 50%">
            </div>
            <div class="col-12 col-md-4 col-lg-4">
              <div class="d-flex flex-column">
                <div>
                  <h5>{{ getOrder.product.NameProducts }}</h5>
                </div>
                <div>
                  <p>{{ getOrder.Quantity }} x {{ formatCurrency(getOrder.product.Price) }}</p>

                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
              <span>Tổng tiền:{{ formatCurrency(getOrder.Quantity * getOrder.product.Price) }} </span>
            </div>
            <hr />

          </div>

        </div>
        <div class="d-flex justify-content-end p-9">
          <div>
            <span>Tổng thanh toán: {{ formatCurrency(calculateTotalPrice()) }} </span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.btn {
  font-size: 16px;
}

.p-9 {
  padding: 24px;
}

.pagination a {
  display: flex !important;
}
</style>

<script>
import axios from "@/axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      billInfor: [],
      orderItems: [],
      Quantity: 0,
    };
  },
  mounted() {

    axios.get('/getAllOrdersAndUsers')
      .then((response) => {
        this.billInfor = response.data.order;

        return Promise.resolve();
      })
      .then(() => {
        $("#getOrder").DataTable({
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
    calculateTotalPrice() {
      let totalPrice = 0;
      this.orderItems.forEach(item => {
        const itemPrice = item.product.Price * item.Quantity;
        totalPrice += itemPrice;
      });
      return totalPrice;
    },
    getOrderById(idOrder) {
      axios.get(`/getToSuccess/${idOrder}`)
        .then(res => {
          this.orderItems = res.data.orderItems;

          return Promise.resolve();
        }).catch((error) => {
          console.error(error);

        });
    },
    destroyOrder(idOrder) {
      Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Đơn hàng sẽ bị hủy và không thể hoàn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(`/confirmToDestroy/${idOrder}`)
        }
      })
        .then((response) => {
          Swal.fire({
            title: 'Đã cập nhật!',
            text: 'Đã cập nhật!',
            icon: 'success',

          }).then(() => {
            window.location.reload();

          });
        }).catch((error) => {
          console.error(error);
          Swal.fire(
            'Lỗi',
            'Lỗi server',
            'error'
          );
        });
    },
    formatCurrency(value) {
      const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
      return formatter.format(value);
    },
    async confirmAdmin(idOrder) {
      await axios.get(`/getToSuccess/${idOrder}`)
        .then(res => {
          this.EmailUser = res.data.user.Email;
          return Promise.resolve();
        }).catch((error) => {
          console.error(error);

        });
      Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Đơn hàng sẽ được xác nhận và không thể hoàn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {

            const email = this.EmailUser;

            Swal.fire({
              title: 'Đang gửi mail...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
            const response = await axios.post('/send-email-admin', {
              email: email,
              id: idOrder
            });

            console.log(response.data);
           
            await axios.get(`/confirmToSuccess/${idOrder}`)
              .then((response) => {
                Swal.fire({
                  title: 'Đã cập nhật!',
                  text: 'Đã cập nhật!',
                  icon: 'success',

                }).then(() => {
                  window.location.reload();

                });
                // window.location.reload();
              }).catch((error) => {
                console.error(error);
                Swal.fire(
                  'Lỗi',
                  'Lỗi server',
                  'error'
                );
              });
          } catch (error) {
            console.error(error);
          }

        }
      })

    },
    orderDelete(idOrder) {
      Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Order này sẽ bị xóa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post(`/ordersDelete`, {
            id: idOrder
          })
        }
      })
        .then((response) => {
          Swal.fire({
            title: 'Đã xóa!',
            text: 'Order đã được xóa',
            icon: 'success',

          }).then(() => {
            window.location.reload();

          });
          // window.location.reload();
        }).catch((error) => {
          console.error(error);
          Swal.fire(
            'Lỗi',
            'Lỗi xóa',
            'error'
          );
        });

    }
  }
}
</script>
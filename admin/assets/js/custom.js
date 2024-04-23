$(document).ready(function () {
  alertify.set("notifier", "position", "top-right");

  // Increment Quantity
  $(document).on("click", ".qtyIncrement", function () {
    // increment quantity
    var $quantityInput = $(this).closest(".qtyBox").find(".quantityInput");
    var productId = $(this).closest(".qtyBox").find(".productId").val();
    var currentValue = parseInt($quantityInput.val());

    if (!isNaN(currentValue)) {
      var qtyVal = currentValue + 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  // Decrement Quantity
  $(document).on("click", ".qtyDecrement", function () {
    // decrement quantity
    var $quantityInput = $(this).closest(".qtyBox").find(".quantityInput");
    var productId = $(this).closest(".qtyBox").find(".productId").val();
    var currentValue = parseInt($quantityInput.val());

    if (!isNaN(currentValue) && currentValue > 1) {
      var qtyVal = currentValue - 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  // Increment and Decrement Quantity Function
  function quantityIncDec(productId, quantity) {
    console.log("productId:", productId, "quantity:", quantity);
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        productIncDec: true,
        product_id: productId,
        quantity: quantity,
      },

      success: function (response) {
        // console.log("Response received:", response);
        var res = JSON.parse(response);

        // console.log("Response parsed:", res);

        if (parseInt(res.status) === 200) {
          //   window.location.reload();
          $("#productArea").load(" #productContent");
          alertify.success(res.message);
        } else {
          $("#productArea").load(" #productContent");
          alertify.error(res.message);
        }
      },
    });
  }

  //process order
  $(document).on("click", ".proceedToPlace", function () {
    var paymentMethod = $("#payment_method").val();
    var phoneNumber = $("#cphone").val();

    if (paymentMethod == "") {
      swal({
        title: "Please select payment method",
        icon: "warning",
        button: "Ok",
      });
      return false;
    }

    if (phoneNumber == "" && !$.isNumeric(phoneNumber)) {
      swal({
        title: "Please enter valid phone number",
        icon: "warning",
        button: "Ok",
      });
      return false;
    }

    var data = {
      proceedToPlaceBtn: true,
      payment_method: paymentMethod,
      cphone: phoneNumber,
    };

    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,

      success: function (response) {
        var res = JSON.parse(response);

        if (parseInt(res.status) === 200) {
          window.location.href = "order-summary.php";
        } else if (parseInt(res.status) === 404) {
          swal(res.message, res.message, res.status_type, {
            buttons: {
              catch: {
                text: "Add Customer",
                value: "catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $("#c_phone").val(phoneNumber);
                $("#customerAddModal").modal("show");
                console.log("pop the customer add modal");
                break;
              default:
                break;
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });

  // Add Customer

  $(document).on("click", ".saveCustomer", function () {
    var c_name = $("#c_name").val();
    var c_email = $("#c_email").val();
    var c_phone = $("#c_phone").val();

    if (c_name != "" && c_phone != "") {
      if ($.isNumeric(c_phone)) {
        var data = {
          saveCustomerBtn: true,
          name: c_name,
          email: c_email,
          phone: c_phone,
        };

        $.ajax({
          type: "POST",
          url: "orders-code.php",
          data: data,

          success: function (response) {
            var res = JSON.parse(response);

            if (res.status == 200) {
              $("#customerAddModal").modal("hide");
              swal(res.message, res.message, res.status_type);
            } else if (res.status == 422) {
              swal(res.message, res.message, res.status_type);
            } else {
              swal(res.message, res.message, res.status_type);
            }
          },
        });
      } else {
        swal({
          title: "Please enter valid phone number",
          icon: "warning",
          button: "Ok",
        });
      }
    } else {
    }
  });

  $(document).on("click", "#saveOrder", function () {
    var data = {
      saveOrder: true,
    };
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,

      success: function (response) {
        var res = JSON.parse(response);

        if (res.status === 200) {
          swal(res.message, res.message, res.status_type);
          $("#orderPlaceSuccessMessage").text(res.message);
          $("#orderPlaceSuccessModal").modal("show");
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });
});

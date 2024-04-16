$(document).ready(function () {
  alertify.set("notifier", "position", "top-right");

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
});

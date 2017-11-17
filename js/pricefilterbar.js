//$(function () {
//      $('#slider-container').slider({
//          range: true,
//          min: 200,
//          max: 10000,
//          values: [200, 10000],
//          create: function() {
////              $("#amount").val("$299 - $1099");
//              $('#min').text('$200');
//              $('#max').text('$10000');
//          },
//          slide: function (event, ui) {
//              $('#min').text("$" + ui.values[0]);
//              $('#max').text("$" + ui.values[1]);
//
//          }
//      })
//});
//
//  function filterSystem(minPrice, maxPrice) {
//      $("#computers div.system").hide().filter(function () {
//          var price = parseInt($(this).data("price"), 10);
//          return price >= minPrice && price <= maxPrice;
//      }).show();
//  }
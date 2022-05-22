$(document).ready(function () {
  loadCars();
});

function loadCars() {
  const carName = $("#titleBrand").html();
  $.ajax({
    url: "/car?name=" + carName,
    type: "GET",
    dataType: "text",
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    beforeSend: function () {
      inLoader();
    },
    success: function (data) {
      outLoader();
      const divElement = $(".accordion");
      divElement.empty();
      var stringObject = JSON.parse(data);
      for (let i = 0; i < stringObject.length; i++) {
        divElement.append(`
        <div class="altern">
        <input type="checkbox" name="example_accordion" id="section${stringObject[i].name_car}" class="accordion__input">
        <label for="section${stringObject[i].name_car}" class="accordion__label" data-id="${stringObject[i].id}">${stringObject[i].name_car}</label>
        <div class="accordion__content">
          <hr>
          <div class="information">
            <table class="table-information" id="${stringObject[i].id}">
                
            </table>
          </div>
        </div>
      </div>
        `);
      }
    },
    error: function (error) {
      console.log("erro");
      // console.log(error.responseText);
    },
  });
}

function inLoader() {
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(100);
}

function outLoader() {
  $(".overlay").fadeOut(100);
  $(this).css({ "z-index": 1 });
}

$(document).on("click", ".accordion__label", function (e) {
  // e.preventDefault();
  const id = $(this).attr("data-id");
  $.ajax({
    url: "/car/height",
    type: "post",
    dataType: "text",
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    data: { search: id },
    beforeSend: function () {
      inLoader();
      outLoader();
    },
    success: function (data) {
      const newValue = JSON.parse(data);
      console.log(newValue);
      $("table#" + id).empty();
      $("table#" + id).append(`
      <tr class="table-header">
      <td></td>
      <td class="text-center small-names">STD</td>
      <td class="text-center small-names">MIN</td>
    </tr>
      `);
      for (let i = 0; i < newValue.length; i++) {
        $("table#" + id).append(`
        <tr class="table-row">
        <td>${newValue[i].name_engine}</td>
        <td class="text-center">${newValue[i].standard_height}</td>
        <td class="text-center">${newValue[i].minimum_height}</td>
      </tr>
        `);
      }
      // outLoader();
    },
    error: function (error) {
      console.log("erro");
      console.log(error.responseText);
    },
  });
});

function loadData(){
  const brandName = $("#titleBrand").html();
  const searchTerm = document.getElementById("searchTerm").value;
  $.ajax({
    url: "/car/values",
    type: "POST",
    dataType: "text",
    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    data: { brandName: brandName, nameCar: searchTerm},
    beforeSend: function () {
    },
    success: function (data) {
      const divElement = $(".accordion");
      divElement.empty();
      var stringObject = JSON.parse(data);
      console.log(stringObject);
      for (let i = 0; i < stringObject.length; i++) {
        divElement.append(`
        <div class="altern">
        <input type="checkbox" name="example_accordion" id="section${stringObject[i].name_car}" class="accordion__input">
        <label for="section${stringObject[i].name_car}" class="accordion__label" data-id="${stringObject[i].id}">${stringObject[i].name_car}</label>
        <div class="accordion__content">
          <hr>
          <div class="information">
            <table class="table-information" id="${stringObject[i].id}">
                
            </table>
          </div>
        </div>
      </div>
        `);
      }
    },
    error: function (error) {
      console.log("erro");
      // console.log(error.responseText);
    },
  });
}

$("#searchTerm").keyup(function(){
  loadData();
});
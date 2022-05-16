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
            <table class="table-information">
                
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
  $(".overlay").fadeIn(1000);
}

function outLoader() {
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}


$(document).on('click', '.accordion__label', function(e){
  e.preventDefault();
  var texto = $(this).attr("data-id");
  alert(texto);
});
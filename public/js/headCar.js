$(document).ready(function () {
  loadBrands();
  loadHeads();
  $("#forms").on("submit", function(e) {
    e.preventDefault();

    var carId = document.getElementById("modelCars").value;
    var headId = document.getElementById("cylinderHead").value;

    $.ajax({
      type: "POST",
      url : "/headtocar",
      data: {
        carId: carId,
        headId: headId
      },
      cache: false,
      success: function(data){
        console.log(data);
      },
      error: function(xhr, status, error){
        console.error(xhr);
      }
    });
  });
});

// const formElement = document.querySelector("form");
// formElement.addEventListener("submit", function(event){
//   event.preventDefault();
//   let car = document.getElementById("modelCars").value;
//   let cHead = document.getElementById("cylinderHead").value;

//   $.ajax({
//     type: 'POST',
//     url: '/headtocar',
//     dataType: 'json',
//     data: { carId: car, headId: cHead},
//     success: (data) => {
//       console.log('deu certo');
//     },
//     error: (data) => {
//       console.log(data);
//     }
//   })
// })


function loadBrands() {
  $.getJSON("/brands", function (data) {
    let brands = data.brands;
    let selectBrands = $("#brands");
    selectBrands.empty();
    for (let i = 0; i < brands.length; i++) {
      selectBrands.append(`
      <option value="${brands[i].id}">${brands[i].name}</option>
      `);
    }
  });
}

function loadHeads() {
  $.getJSON("/heads", function (data) {
    let heads = data.heads;
    let selectHead = $("#cylinderHead");
    selectHead.empty();
    for (let i = 0; i < heads.length; i++) {
      selectHead.append(`
        <option value="${heads[i].id}">${heads[i].name_engine}</option>
      `);
    }
  });
}

$("#brands").on("change", () => {
  const idBrand = $("#brands").val();
  const models = $("#modelCars");
  if (idBrand) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "/modelCar",
      data: { id: idBrand },
      success: (data) => {
        models.empty();
        if (data.length < 1) {
          models.append(`
            <option value="null">Não existem carros para esta montadora</option>
          `);
        } else {
          for (let i = 0; i < data.length; i++) {
            models.append(`
            <option value="${data[i].id}">${data[i].name_car}</option>
          `);
          }
        }
      },
      error: (data) => {
        console.log("Deu errado");
        console.log(data);
      },
    });
  }
});

$("#brands").on("mouseover", () => {
  const idBrand = $("#brands").val();
  const models = $("#modelCars");
  if (idBrand) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "/modelCar",
      data: { id: idBrand },
      success: (data) => {
        models.empty();
        if (data.length < 1) {
          models.append(`
            <option value="null">Não existem carros para esta montadora</option>
          `);
        } else {
          for (let i = 0; i < data.length; i++) {
            models.append(`
            <option value="${data[i].id}">${data[i].name_car}</option>
          `);
          }
        }
      },
      error: (data) => {
        console.log("Deu errado");
        console.log(data);
      },
    });
  }
});


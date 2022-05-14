const formData = document.querySelector("#form-search");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
});

$(document).ready(function () {
  $.getJSON("/brands", function (data) {
    let brands = data.brands;
    let divElement = $("#list-brands");
    divElement.empty();
    let urlCurrent = window.location.href;
    for (let i = 0; i < brands.length; i++) {
      divElement.append(`
        <div class="brand">
          <div class="img-container">
            <img src="${urlCurrent}/uploads/${brands[i].picture}" alt="brand">
          </div>
          <br>
          <hr>
          <span>${brands[i].name}</span>
        </div>
      `);
    }
  });
});

function search() {
  let term = document.getElementById("text-brand").value;

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "/searchBrand",
    data: { search: term },
    success: (data) => {
      let divElement = $("#list-brands");
      divElement.empty();
      let urlCurrent = window.location.href;
      for (let i = 0; i < data.length; i++) {
        console.log(data[i].name);
        divElement.append(`
          <div class="brand">
            <div class="img-container">
              <img src="${urlCurrent}/uploads/${data[i].picture}" alt="brand">
            </div>
            <br>
            <hr>
            <span>${data[i].name}</span>
          </div>
        `);
      }
    },
  });
}

$("#text-brand").keyup(() => {
  search();
});

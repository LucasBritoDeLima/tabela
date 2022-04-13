function openModal(a) {
  $(".modal-container").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  console.log(a);
}

function closeModal() {
  $(".modal-container").fadeOut();
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}

const formElement = document.querySelector("form");
formElement.addEventListener("submit", (event) => {
  event.preventDefault();
  let uri = "/car?name=" + $("#brandName").val();
  $.getJSON(uri, (data) => {
    let brands = [];
    $("#table-cars").empty();
    console.log(typeof data);
    $(data).each((key, value) => {
      $("#table-cars").append(`<tr>
      <td class="title-car">${value.name_car}</td>
      <td class="btn-align">
        <button class="btn-edit" onclick="openModal(${value.id})">Editar</button>
        <button class="btn-del">Apagar</button>
      </td>
      </tr>`);
    });
  }).fail(() => {
    $("#table-cars").empty();
    $("#table-cars").append(
      `<h1 style='color: red'>Não existem dados para essa montadora!</h1>`
    );
  });
});

$(".btn-edit").on("click", () => {});

$(() => {
  $.getJSON("/brand", (data) => {
    let items = [];

    $(data).each((key, value) => {
      //console.log(value.name);
      items.push(value.name);
    });

    $("#brandName").autocomplete({
      source: items,
    });
  });
});

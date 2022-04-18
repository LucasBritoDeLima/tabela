function openModal(name,data) {
  $(".modal-container").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  $("#oldName").val(name);
  $("#nameOriginal").val(data);
  const formData = document.querySelector("#form-car-new");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
  });
}

function closeModal() {
  $(".modal-container").fadeOut();
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}

function sendData(){
  let id = document.getElementById("nameOriginal").value;
  let newName = document.getElementById("newName").value;
  $.ajax({
    url: '/app/edit-car',
    type: 'POST',
    data: {
      newName: newName,
      nameOriginal: id,
    },
    success: (res) => {
      console.log(res + 'deu certo');
    },
    error: (error) => {
      console.log(error + 'deu ruim');
    }
  })
}

const formElement = document.querySelector("form");
formElement.addEventListener("submit", (event) => {
  event.preventDefault();
  let uri = "/car?name=" + $("#brandName").val();
  $.getJSON(uri, (data) => {
    let brands = [];
    $("#table-cars").empty();
    $(data).each((key, value) => {
      $("#table-cars").append(`<tr>
      <td class="title-car">${value.name_car}</td>
      <td class="btn-align">
        <button class="btn-edit" onclick="openModal('${value.name_car}','${value.id}')">Editar</button>
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
      items.push(value.name);
    });

    $("#brandName").autocomplete({
      source: items,
    });
  });
});
